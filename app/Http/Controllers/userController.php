<?php

namespace App\Http\Controllers;
use App\Events\SendMessageToRoom;
use App\Events\SendMessageToPrivate;
use App\Events\SendPrivateNotifications;
use App\Events\SendPrivateBanned;
use Illuminate\Http\Request;
use App\rooms;
use App\messages;
use App\room_users;
use App\privateChat;
use App\privateChatMessage;
use App\privateNotifications;
use App\plans;
use App\payments;
use App\User;
use App\roomsowners;
use App\rooms_ban;
use App\available_users;
use App\available_connections;
use App\badWords;
use App\subscriptions;
use Hash;
use Auth;
use DB;
use \Carbon\Carbon;
use Twilio\Rest\Client;
use Validator;
class userController extends Controller
{
    
    protected $UsersInRoom = 30;
    public function index(){
        if(Auth::check()){
            return view('index');
        }else{
            return view('signup');
        }
    }
    public function badwords(){
        return badWords::all()->pluck('word')->toArray();
    }
    public function registerGuest(Request $request){
           $messages = [
            'name.required' => 'الاسم مطلوب .',
            'name.string' => 'الاسم يجب ان يكون مكون من ارقام واحرف .',
            'terms.required' => 'يجب الموافقة علي الشروط والاحكام .',
        ];
         $validator  = Validator::make($request->all(),[
            'name' => 'required|string',
            'gender' => 'required|in:1,2',
            'terms' => 'required',
        ],$messages);
         if ($validator->fails()) {
            return back()
                        ->withErrors($validator,'guestsignup');
        }
        $guestCheck = User::where('name',$request->name)->where('type','guest')->first();
        if($guestCheck){
          //  $pass = explode('@',$guestCheck->email)[0];
             auth()->login($guestCheck);
          if(auth()->check()){
              return redirect('/');
          }
        }
          $avatar = '';
        if($request->gender == 1){
            $avatar = 'boy.png';
        }else{
              $avatar = 'girl.png';
        }
        $user = new User();
        $user->name = $request->name;
        $user->verified = 1;
        $user->image = $avatar;
        $user->save();
          auth()->login($user);
          if(auth()->check()){
              return redirect('/');
          }
    }
    private function sendMessage($message, $recipients)
    {
       $basic  = new \Nexmo\Client\Credentials\Basic('29f22bff', 'C5Nf0kgyHtgQ4bKU');
       $client = new \Nexmo\Client($basic);
       $message = $client->message()->send([
            'to' => substr($recipients,1),
            'from' => 'Kuwait965',
            'text' => $message
       ]);
    }
    public function register(Request $request){
        $messages = [
            'name.required' => 'الاسم مطلوب .',
            'name.string' => 'الاسم يجب ان يكون مكون من ارقام واحرف .',
            'password.required' => 'كلمة المرور مطلوبة .',
            'password.string' => 'كلمة المرور يجب ان تكون مكونة من ارقام واحرف .',
            'password.min' => 'كلمة المرور يجب الا تقل عن 8 ارقام واحرف .',
            'email.required' => 'البريد الالكتروني مطلوب .',
            'email.string' => 'البريد الالكتروني يجب ان يكون مكون من ارقام واحرف .',
            'email.email' => 'البريد الالكتروني يجب ان يكون مكون من صيغة صحيحة .',
            'email.unique' => 'هذا البريد الالكتروني موجود بالفعل .',
            'full_number.unique' => 'هذا الهاتف مسجل من قبل .',
            'full_number.required' => 'الهاتف مطلوب .',
            'day.in' => 'من فضلك اختر يوم صحيح .',
            'month.in' => 'من فضلك اختر شهر صحيح .',
            'year.in' => 'من فضلك اختر سنة صحيحة .',
            'terms.required' => 'يجب الموافقة علي الشروط والاحكام .',
        ];
        $days = [];
        $months = [];
        $years = [];
        for($i=1;$i<=31;$i++){
            array_push($days,$i);
        }
        for($i=1;$i<=12;$i++){
           array_push($months,$i);
        }
        for($i=\Carbon\Carbon::now()->year - 12;$i>=1900;$i--){
            array_push($years,$i);
        }
        $days = implode(",",$days);
        $months = implode(",",$months);
        $years = implode(",",$years);
         $validator  = Validator::make($request->all(),[
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'full_number' => 'required|string|unique:users,mobile',
             'day' => 'required|in:' . $days,
             'month' => 'required|in:' . $months,
             'year' => 'required|in:' . $years,
             'gender' => 'required|in:1,2,3',
             'terms' => 'required',
        ],$messages);
         if ($validator->fails()) {
            return back()
                        ->withErrors($validator,'signup');
        }
         $avatar = '';
        if($request->gender == 1){
            $avatar = 'boy.png';
        }else{
              $avatar = 'girl.png';
        }
        $code = rand(1000,9999);
        $phone = $request->full_number;
        $birth = Carbon::parse($request->year . '-' . $request->month . '-' . $request->day);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->gender = $request->gender;
        $user->image = $avatar;
        $user->birth = $birth;
        $user->verify = $code;
        $user->verified = 0;
        $user->mobile = $request->full_number;
        $user->type = 'register';
        $user->save();
        $this->sendMessage('Kuwait965.com : your verification code is : ' . $code , $phone);
        auth()->attempt(['email'=>$request->email , 'password' => $request->password]);
          if(auth()->check()){
              return redirect('/');
          }
    }
    public function verify(Request $request){
           $this->validate($request,[
            'code' => 'required|string|exists:users,verify',
        ]);
        if(Auth::user()->verify == $request->code){
            Auth::user()->verified = 1;
            Auth::user()->verify = null;
            Auth::user()->save();
            return redirect('/');
        }
    }
      public function login(Request $request){
          $messages = [
              
              'password.required' => 'كلمة المرور مطلوبة .',
            'password.string' => 'كلمة المرور يجب ان تكون مكونة من ارقام واحرف .',
            'password.min' => 'كلمة المرور يجب الا تقل عن 8 ارقام واحرف .',
            'email.required' => 'البريد الالكتروني مطلوب .',
            'email.string' => 'البريد الالكتروني يجب ان يكون مكون من ارقام واحرف .',
            'email.email' => 'البريد الالكتروني يجب ان يكون مكون من صيغة صحيحة .',
            'email.exists' => 'هذا البريد الالكتروني غير موجود .',
          ];
            $validator  = Validator::make($request->all(),[
            'password' => 'required|string|min:8',
            'email' => 'required|email',
        ],$messages);
            if ($validator->fails()) {
            return back()
                        ->withErrors($validator,'login');
        }
        $user = User::where('email',$request->email)->orWhere('mobile',$request->email)->first();
        if(!$user){
            return back()
                        ->withErrors(['error' => 'البريد الالكتروني او رقم الهاتف غير موجود .'],'login');
        }
        if(!Hash::check($request->password,$user->password)){
             return back()
                        ->withErrors(['error' => 'كلمة المرور غير صحيحة .'],'login');
        }
        auth()->login($user);
        return redirect('/');
          
    }
    public function test(){
        broadcast(new SendPrivateNotifications(["few"=>'few'],17));
        return 'done';
    }
    public function initialRoom(){
         $checkAvailableRoom =   rooms::where('type','random')->get();
        
         if(count($checkAvailableRoom) > 0){
             $availableRoom = null;
             foreach($checkAvailableRoom as $room){
                 $checkban = rooms_ban::where('room',$room->id)->where('user',Auth::id())->orderBy('id','DESC')->first();
                 if($room->allowedUsers == 'limit'){
                      if($room->get_available_users->count() < $this->UsersInRoom && !$checkban){
                    $availableRoom = $room;
                    break;
                }
                 }else{
                       $availableRoom = $room;
                    break;
                 }
               
        }
             if($availableRoom != null){
                 $messages = $availableRoom->messages->where('created_at','>=',Carbon::now()->subHours(6));
                 
                 collect($messages)->map(function ($item) {
              $item['username'] = User::find($item->user_id)->name;
              $item['role'] = User::find($item->user_id)->role;
              $item['userimage'] = url('images/profiles/') .'/'. User::find($item->user_id)->image;
                  if($item->type != 'text'){
                      $item['body'] = url('uploads/').'/'.$item->body;
                  }
          return $item;
        });

        return response()->json(['room_id'=>$availableRoom->id,'messages'=> collect($messages)->values()],200);
             }
             
         }
         
    }
    public function addMessage(Request $request){
        $checkban = rooms_ban::where('room',$request->room)->where('user',Auth::id())->orderBy('id','DESC')->first();
        if($checkban && Carbon::parse($checkban->ban_end_at) > Carbon::now()){
            Carbon::setlocale("ar");
            $message =  '. انت محظور يمكنك الانضمام ' .  Carbon::parse($checkban->ban_end_at)->diffForHumans(Carbon::now()) ;
            return response()->json(['success' => 'failed','reason'=>'banned','enroll_date'=>$message],200);
        }
        $newMessage = new messages();
        $newMessage->body = $request->message;
        $newMessage->user_id = Auth::user()->id;
        $newMessage->room_id = $request->room;
        $newMessage->ip = $request->ip();
        $newMessage->type = 'text';
        $newMessage->save();
        $newMessage->setAttribute('username', Auth::user()->name);
        $newMessage->setAttribute('userimage', url('images/profiles/') .'/'. Auth::user()->image);
        $newMessage->setAttribute('status', 'تم الارسال');
        broadcast(new SendMessageToRoom(['message'=>$newMessage,'user'=>Auth::user(),'room'=>$request->room]))->toOthers();
        return response()->json(['success' => 'done','newMessage'=>$newMessage],200);
    }
    public function getchat(Request $request){
        $chat = 0;
        $another = $request->user;
        $checkPrivate = privateChat::
                where(function ($query) use($another){
            $query->where("parent_id" , Auth::id())
                  ->where("child_id" , $another);
        })->orWhere(function ($query) use($another){
            $query->where("parent_id" ,  $another)
                  ->where("child_id" , Auth::id());
        })->first();
        if($checkPrivate){
            $chat = $checkPrivate->id;
            $chatMessages = privateChatMessage::where('chat',$chat)->get();
            collect($chatMessages)->map(function($item){
                $user = User::find($item->parent_id);
                $user->image = url('images/profiles/') .'/'. $user->image;
                $item->setAttribute('user',$user);
                 if($item->type != 'text'){
                      $item['body'] = url('uploads/').'/'.$item->body;
                  }
                return $item;
            });
            return response()->json(['success' => 'done','messages'=>$chatMessages,'chat'=>$chat],200);
        }else{
            $newprivateChat = new privateChat();
            $newprivateChat->parent_id = Auth::id();
            $newprivateChat->child_id = $another;
            $newprivateChat->save();
            return response()->json(['success' => 'done','messages'=>[],'chat'=>$newprivateChat->id],200);
        }
      
        
       
    }
    public function sendPrivateMessage(Request $request){
         $another = $request->userid;
         $message = $request->message;
         $checkPrivate = privateChat::
                where(function ($query) use($another){
            $query->where("parent_id" , Auth::id())
                  ->where("child_id" , $another);
        })->orWhere(function ($query) use($another){
            $query->where("parent_id" ,  $another)
                  ->where("child_id" , Auth::id());
        })->first();
        $newprivateChatMessage = new privateChatMessage();
        $newprivateChatMessage->body = $message;
        $newprivateChatMessage->chat = $checkPrivate->id;
        $newprivateChatMessage->parent_id = Auth::id();
        $newprivateChatMessage->save();
        $newprivateChatMessage->refresh();
        $notificationid;
        $checkprivateNotifications = privateNotifications::where('chat',$checkPrivate->id)->first();
        if(!$checkprivateNotifications){
                $privateNotificationsnew = new privateNotifications();
                $privateNotificationsnew->chat = $checkPrivate->id;
                $privateNotificationsnew->save();
                $notificationid = $privateNotificationsnew->id;
        }
           else{
               $notificationid = $checkprivateNotifications->id;
           }
        $getAnotherunreadMessages = privateChatMessage::where(['parent_id'=>Auth::id(),'chat'=>$checkPrivate->id,'read'=>0])->count();
        Auth::user()->image =  url('images/profiles/') .'/'.  Auth::user()->image;
        $newprivateChatMessage->setAttribute('user',Auth::user());
        broadcast(new SendPrivateNotifications(["user"=>Auth::user(),'chat' => $checkPrivate->id , 'unread'=>$getAnotherunreadMessages],$another));
        broadcast(new SendMessageToPrivate(["message"=>$newprivateChatMessage],$checkPrivate->id))->toOthers();
        return response()->json(['success' => 'done','message' => $newprivateChatMessage],200);
    }
    public function getRooms (){
        $rooms = rooms::get();
        return response()->json(['success' => 'done','rooms' => $rooms],200);
    }
    public function addNewRoom(Request $request){
          $this->validate($request,[
            'name' => 'required|string',
            'type' => 'required|string',
        ]);
        if(Auth::user()->role != 'user' && Auth::user()->role != 'master'){
        if(Auth::user()->plan->nofrooms != Auth::user()->rooms()->count()){
            $roomname = $request->name;
            $roomtype = '';
            $roompass = null;
            if($request->type == '0'){
                $roomtype = 'random';
            }else{
                $roomtype = 'secure';
                $roompass = Hash::make($request->password);
                
            }
            $newRoom = new rooms();
            $newRoom->name = $roomname;
            $newRoom->type = $roomtype;
            $newRoom->password = $roompass;
            $newRoom->save();
            $newOwner = new roomsowners();
            $newOwner->room = $newRoom->id; 
            $newOwner->user = Auth::id(); 
            $newOwner->save(); 
            $mess  = 'تم اضافة الغرفة بنجاح';
             return response()->json(['message' => $mess , 'result' => 'done'],200);
        }else{
             $mess  = 'لا يمكنك اضافة غرف اكثر من الحد المسموح .';
             return response()->json(['message' => $mess , 'result' => 'failed','error'=>1],200);
        }
    }elseif(Auth::user()->role != 'user' && Auth::user()->role == 'master'){
        $roomname = $request->name;
            $roomtype = '';
            $roompass = null;
            if($request->type == '0'){
                $roomtype = 'random';
            }else{
                $roomtype = 'secure';
                $roompass = Hash::make($request->password);
                
            }
            $newRoom = new rooms();
            $newRoom->name = $roomname;
            $newRoom->type = $roomtype;
            $newRoom->password = $roompass;
            $newRoom->save();
            $newOwner = new roomsowners();
            $newOwner->room = $newRoom->id; 
            $newOwner->user = Auth::id(); 
            $newOwner->save(); 
            $mess  = 'تم اضافة الغرفة بنجاح';
             return response()->json(['message' => $mess , 'result' => 'done'],200);
    }
        
        
    }
    public function accessRoombypass(Request $request){
        $roomid = $request->room;
        $password = $request->password;
        $room = rooms::find($roomid);
       $check =  Hash::check($password,$room->password);
        if($check){
             $messages = messages::where('room_id',$roomid)->where('created_at','>=',Carbon::now()->subHours(6))->get();
        
                     $checkEnroll = $room->get_room_users->where('user_id',Auth::user()->id)->first();
             if(!$checkEnroll){
                  $newroom_users = new room_users();
             $newroom_users->room_id = $roomid;
             $newroom_users->user_id = Auth::user()->id;
             $newroom_users->save();
             }
             $messagesmap = collect($messages)->map(function ($item) {
                  $item['username'] = User::find($item->user_id)->name;
                  $item['userimage'] = url('images/profiles/') .'/'. User::find($item->user_id)->image;
                  if($item->type != 'text'){
                      $item['body'] = url('uploads/').'/'.$item->body;
                  }
          return $item;
        });
            return response()->json(['success' => 'done','status' => 'secure','messages' => collect($messagesmap)->values()],200); 
        }else{
            $err = 'كلمة المرور خاطئة';
            return response()->json(['success' => 'failed','message' => $err],200);
        }
       
        
    }
    public function banUsers(Request $request){
        if(Auth::user()->role != 'user' && Auth::user()->role != 'master'){
            $allowed_d = json_decode(Auth::user()->plan->nofban_days,false);
               $this->validate($request,[
            'duration' => 'required|in:' . implode(',',$allowed_d),
            'room' => 'required|exists:rooms,id',
            'user' => 'required|exists:users,id'       
        ]);
            $checkban = rooms_ban::where('room',$request->room)->where('user',$request->user)->orderBy('id','DESC')->first();
            if($checkban && Carbon::parse($checkban->ban_end_at) > Carbon::now()){
                 $message = 'هذا العضو محظور بالفعل .';
                 return response()->json(['success' =>  'failed','reason'=> $message],200);
            }
            else{
                $ban = new rooms_ban();
                $ban->room = $request->room;
                $ban->user = $request->user;
                $ban->ban_end_at = Carbon::now()->addDays($request->duration);
                $ban->save();
                $message = ' . تم حظر هذا العضو لمدة '.$request->duration.' يوم';
                broadcast(new SendPrivateBanned(['success'=>true , 'room'=>$request->room],$request->user));
                return response()->json(['success' =>  'done','reason'=> $message],200);
            }
            
        }
        elseif(Auth::user()->role != 'user' && Auth::user()->role == 'master'){
            $allowed_d = ['1','2','3','4','5','6','7'];
               $this->validate($request,[
            'duration' => 'required|in:' . implode(',',$allowed_d),
            'room' => 'required|exists:rooms,id',
            'user' => 'required|exists:users,id'       
        ]);
            $checkban = rooms_ban::where('room',$request->room)->where('user',$request->user)->orderBy('id','DESC')->first();
            if($checkban && Carbon::parse($checkban->ban_end_at) > Carbon::now()){
                 $message = 'هذا العضو محظور بالفعل .';
                 return response()->json(['success' =>  'failed','reason'=> $message],200);
            }
            else{
                $ban = new rooms_ban();
                $ban->room = $request->room;
                $ban->user = $request->user;
                $ban->ban_end_at = Carbon::now()->addDays($request->duration);
                $ban->save();
                $message = ' . تم حظر هذا العضو لمدة '.$request->duration.' يوم';
                broadcast(new SendPrivateBanned(['success'=>true , 'room'=>$request->room],$request->user));
                return response()->json(['success' =>  'done','reason'=> $message],200);
            }
            
        }
      
    }
    public function getRoom($id,$previous){
        $room = rooms::find($id); 
        if($room->allowedUsers == 'limit' && $room->get_available_users->count() >= $this->UsersInRoom ){
            return response()->json(['success' => 'failed','reason'=>'full'],200);
        }
        $checkban = rooms_ban::where('room',$room->id)->where('user',Auth::id())->orderBy('id','DESC')->first();
        if($checkban && Carbon::parse($checkban->ban_end_at) > Carbon::now()){
            Carbon::setlocale("ar");
            $message =  '. انت محظور يمكنك الانضمام ' .  Carbon::parse($checkban->ban_end_at)->diffForHumans(Carbon::now()) ;
            return response()->json(['success' => 'failed','reason'=>'banned','enroll_date'=>$message],200);
        }
         
        $removeenroll = room_users::where('room_id',$previous)->where('user_id',Auth::id())->first();  
        $enroll = room_users::where('room_id',$id)->where('user_id',Auth::id())->first();  
       
        
        if($room->type == 'secure' && !$enroll){
            return response()->json(['success' => 'done','status' => 'secure','room' => 'this room need password to enroll.'],200);
        }
//         if($removeenroll && $room->type == 'random'){ $removeenroll->delete();}
        $messages = messages::where('room_id',$id)->where('created_at','>=',Carbon::now()->subHours(6))->get();
        $messagesmap = collect($messages)->map(function ($item) {
           $item['username'] = User::find($item->user_id)->name;
           $item['role'] = User::find($item->user_id)->role;
                  $item['userimage'] = url('images/profiles/') .'/'. User::find($item->user_id)->image;
                  if($item->type != 'text'){
                      $item['body'] = url('uploads/').'/'.$item->body;
                  }
          return $item;
        });
        return response()->json(['success' => 'done','status' => 'notsecure','messages' => collect($messagesmap)->values()],200);
    }
    public function logout(){
        Auth::logout();
        if(!Auth::check()){
            return redirect('/');
        }
    
    }
    public function getChatByid($id){
        DB::table('private_chat_messages')->where('parent_id','!=',Auth::id())->where('read',0)->where('chat',$id)->update(['read'=>1]);
        $getMessages = privateChatMessage::where('chat',$id)->get();
         collect($getMessages)->map(function($item){
                $user = User::find($item->parent_id);
                $user->image = url('images/profiles/') .'/'. $user->image;
                $item->setAttribute('user',$user);
             if($item->type != 'text'){
                      $item['body'] = url('uploads/').'/'.$item->body;
                  }
             return $item;
            });
        return response()->json(['success' => 'done','messages' => $getMessages],200);
        
    }
    public function getPrivateNotifications(){
         $getPrivateChats = privateChat::
                where(function ($query){
            $query->where("parent_id" , Auth::id());
        })->orWhere(function ($query){
                  $query->where("child_id" , Auth::id());
        })->get();
        $privateNotify = [];
        foreach($getPrivateChats as $getprivate){
            $getAnother;
            if($getprivate->parent_id == Auth::id()){
                $getAnother = $getprivate->child_id;
            }else{
                $getAnother = $getprivate->parent_id;
            }
            $user = User::find($getAnother);
            $user->image = url('images/profiles/') .'/'. $user->image;
            $count  = $getprivate->privateChatMessages()->where('parent_id','!=', Auth::id())->where('read', 0)->count();
            $privateNotify[] = array('user'=>$user,'chat'=>$getprivate->id,'unread'=> $count );
        }
          return response()->json(['success' => 'done','notifications' => $privateNotify],200);
    }
    public function uploadfile(Request $request){
        
        $file = $request->file('file');
        $destinationPath = 'uploads';
        $allowedimages = array('jpg', 'JPG', 'png' ,'PNG' ,'jpeg' ,'JPEG');
        $allowedsound = array('mp3', 'ogg', 'flac','mpga','webm');
        $allowedvedio = array('mp4', 'mov', 'qt');
        $filetype ='';
        $ex  = $request->file->extension();
        if(in_array($ex,$allowedimages)){
            $filetype = 'image';
        }elseif(in_array($ex,$allowedsound)){
            $filetype = 'audio';
        }elseif(in_array($ex,$allowedvedio)){
             $filetype = 'video';
        }
        $fileName = 'uploadedFiles-'.Auth::id().time().'.'.$request->file->extension();  
        $file->move($destinationPath,$fileName);
        $newMessage = new messages();
        $newMessage->body = $fileName;
        $newMessage->user_id = Auth::user()->id;
        $newMessage->room_id = $request->room;
        $newMessage->ip = $request->ip();
        $newMessage->type = $filetype;
        $newMessage->save();
        $newMessage->setAttribute('username', Auth::user()->name);
        $newMessage->setAttribute('userimage', url('images/profiles/') .'/'. Auth::user()->image);
        $newMessage->setAttribute('status', 'تم الارسال');
        $newMessage->body = url('uploads/').'/'.$newMessage->body;
        broadcast(new SendMessageToRoom(['message'=>$newMessage,'user'=>Auth::user(),'room'=>$request->room]))->toOthers();
        return response()->json(['success' => 'done','message' =>$newMessage],200);
    }
       public function private_uploadfile(Request $request){
        
        $file = $request->file('file');
        $destinationPath = 'uploads';
        $allowedimages = array('jpg', 'JPG', 'png' ,'PNG' ,'jpeg' ,'JPEG');
        $allowedsound = array('mp3', 'ogg', 'flac','mpga','webm');
        $allowedvedio = array('mp4', 'mov', 'qt');
        $filetype ='';
        $ex  = $request->file->extension();
        if(in_array($ex,$allowedimages)){
            $filetype = 'image';
        }elseif(in_array($ex,$allowedsound)){
            $filetype = 'audio';
        }elseif(in_array($ex,$allowedvedio)){
             $filetype = 'video';
        }
        $fileName = 'uploaded_private_Files-'.Auth::id().time().'.'.$request->file->extension();  
        $file->move($destinationPath,$fileName);
        $another = $request->userid;
        $checkPrivate = privateChat::
                where(function ($query) use($another){
            $query->where("parent_id" , Auth::id())
                  ->where("child_id" , $another);
        })->orWhere(function ($query) use($another){
            $query->where("parent_id" ,  $another)
                  ->where("child_id" , Auth::id());
        })->first();
        $newprivateChatMessage = new privateChatMessage();
        $newprivateChatMessage->body = $fileName;
        $newprivateChatMessage->type = $filetype;
        $newprivateChatMessage->chat = $checkPrivate->id;
        $newprivateChatMessage->parent_id = Auth::id();
        $newprivateChatMessage->save();
        $newprivateChatMessage->setAttribute('username', Auth::user()->name);
        $newprivateChatMessage->setAttribute('userimage', url('images/profiles/') .'/'. Auth::user()->image);
        $newprivateChatMessage->setAttribute('status', 'تم الارسال');
        $newprivateChatMessage->body = url('uploads/').'/'.$newprivateChatMessage->body;
        $notificationid;
        $checkprivateNotifications = privateNotifications::where('chat',$checkPrivate->id)->first();
        if(!$checkprivateNotifications){
                $privateNotificationsnew = new privateNotifications();
                $privateNotificationsnew->chat = $checkPrivate->id;
                $privateNotificationsnew->save();
                $notificationid = $privateNotificationsnew->id;
        }
           else{
               $notificationid = $checkprivateNotifications->id;
           }
        $getAnotherunreadMessages = privateChatMessage::where(['parent_id'=>Auth::id(),'chat'=>$checkPrivate->id,'read'=>0])->count();
        Auth::user()->image =  url('images/profiles/') .'/'.  Auth::user()->image;
        $newprivateChatMessage->setAttribute('user',Auth::user());
        broadcast(new SendPrivateNotifications(["user"=>Auth::user(),'chat' => $checkPrivate->id , 'unread'=>$getAnotherunreadMessages],$another));
        broadcast(new SendMessageToPrivate(["message"=>$newprivateChatMessage],$checkPrivate->id))->toOthers();
        return response()->json(['success' => 'done','message' => $newprivateChatMessage],200);
    }
    
  
 public function updateProfile(Request $request){
    $request['role'] = Auth::user()->role;
        $validator  = Validator::make($request->all(),[
            'age' => 'required|date_format:Y-m-d',
            'gender' => 'required|integer|between:1,2',
            'visibility' => 'required_if:role,==,master|in:true,false',
        ]);
        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
       }
     $user = User::find(Auth::id());
     $user->birth = $request->age;
     $user->gender = $request->gender;
     $user->info = $request->info;
     if(Auth::user()->role == 'master'){
        $user->visibility = ($request->visibility == 'true') ? 'visible': 'hidden';
     }
     $user->save();
     return response()->json(['success' => 'done'],200);
 }
     public function updateProfileImage(Request $request){
      $this->validate($request,[
            'file' => 'required|file',
        ]);
         $file = $request->file('file');
     $destinationPath = 'images/profiles';
     $fileName = 'uploadedFiles-'.Auth::id().time().'.'.$request->file->extension();  
     $file->move($destinationPath,$fileName);
     $user = User::find(Auth::id());
     $user->image = $fileName;
     $user->save();
     return response()->json(['success' => 'done' , 'url' => url('images/profiles/') . '/' . $fileName],200);
 }
    public function deleteProfileImage(){
           $user = User::find(Auth::id());
     $user->image = 'default_guest.png';
     $user->save();
     return response()->json(['success' => 'done' , 'url' => url('images/profiles/') . '/default_guest.png'  ],200);
    }
    public function removeEnroll(Request $request){
        available_users::where('room_id',$request->room)->where('user_id',Auth::id())->delete();
    }
     public function newconnection(Request $request){
         $newConnection = new available_connections();
         $newConnection->socketid = $request->newsocket;
         $newConnection->user = Auth::id();
         $newConnection->save();
    }
    
    public function allusers(){
        $users =  room_users::join('users','users.id','=','room_users.user_id')->select('users.*')->get();
        $users->map(function($item){
            $item->image = url('uploads/').'/'.$item->image;
        });
        return response()->json(['success' => 'done' , 'users' => $users ],200);
    }
    public function usersinroom($room){
        $users =  room_users::where('room_id',$room)->join('users','users.id','=','room_users.user_id')->select('users.*')->get();
        $users->map(function($item){
            $item->image = url('uploads/').'/'.$item->image;
        });
        return response()->json(['success' => 'done' , 'users' => $users ],200);
    }
    public function verifyPayment(Request $request){
        $checkPayment = payments::where('tap_id',$request->tap_id)->first();
        if(!$checkPayment){
            abort(404);
        }
     $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.tap.company/v2/invoices/".$request->tap_id,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "{}",
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
             $json = json_decode($response, true); 
            //return $json;
            if(isset($json['errors'])){
               $checkPayment->status = 'FAILED';
               $checkPayment->save();
                return redirect('/');
            }
            $status = $json['status'];
            $userEmail = $json['customer']['email'];
            $planid = $json['metadata']['plan_id'];
            if($status == 'PAID'){
               $checkPayment->status = 'PAID';
               $checkPayment->save();
               $checkPayment->userObj->role = $planid;
               $checkPayment->userObj->save();
               $new_subscription = new subscriptions();
               $new_subscription->user = $checkPayment->userObj->id;
               $new_subscription->plan = $planid;
               $new_subscription->from = Carbon::now();
               $new_subscription->to = Carbon::now()->addMonth(1);
               $new_subscription->amount = $checkPayment->amount;
               $new_subscription->save();
               return redirect('/');
               
            }
        }
      

    }
    public function payment($plan){
        $planbyid = plans::find($plan);
        if(!$planbyid){
            return abort(404);
        }
        $plansPrice  = $planbyid->price;
        $desc = "الاشتراك في الخطه" . ' '.$planbyid->name;
    
$curl = curl_init();
$carbon_after_10 = Carbon::now()->addDays(10)->timestamp;
$carbon_after_20 = Carbon::now()->addDays(12)->timestamp;
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.tap.company/v2/invoices",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30000,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>'{
  "draft": false,
  "due": '.$carbon_after_10.'000,
  "expiry": '.$carbon_after_20.'000,
  "description": "'.$desc.'",
  "mode": "INVOICE",
  "note": "'.$desc.'",
  "notifications": {
    "channels": [
      "SMS",
      "EMAIL"
    ],
    "dispatch": true
  },
  "currencies": [
    "KWD"
  ],
  "metadata": {
    "plan_id": "'.$plan.'"
  },
  "charge": {
    "receipt": {
      "email": true,
      "sms": false
    },
    "statement_descriptor": "test"
  },
  "customer": {
    "email": "'.Auth::user()->email.'",
    "first_name": "'.Auth::user()->name.'"
  },
  "order": {
    "amount": "'.$plansPrice.'",
    "currency": "KWD",
    "items": [
      {
        "amount": "'.$plansPrice.'",
        "currency": "KWD",
        "description": "test",
        "image": "",
        "name": "'.$desc.'",
        "quantity": 1
      }
    ]
  },
  "payment_methods": [
    ""
  ],
  "post": {
    "url": "http://your_website.com/post_url"
  },
  "redirect": {
    "url": "'.url('/verifyPayment').'"
  },
  "reference": {
    "invoice": "INV_00001",
    "order": "ORD_00001"
  }
}',
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  
   $json = json_decode($response, true); 
        $newPayment = new payments();
        $newPayment->user_id = Auth::id();
        $newPayment->tap_id = $json['id'];
        $newPayment->plan =  $planbyid->id;
        $newPayment->amount =  $planbyid->price;
        $newPayment->currency =  'KWD';
        $newPayment->status =  $json['status'];
        $newPayment->save();
        return redirect($json['url']);
  
    
}
    }
    public function get_user_Rooms(){
        $user_rooms = auth()->guard()->user()->rooms()->with(['room'=>function($query){
                $query->select('id','name');
            }])->get();
         return response()->json(['success' => 'done' , 'rooms' => $user_rooms ],200);
    }
    public function remove_my_room(Request $request){
        
            $check_room = roomsowners::where(['room' => $request->room , 'user' => auth()->guard()->user()->id])->first();
            if($check_room){
               $get_room =  rooms::where('id',$check_room->room)->first();
               $get_room->delete();
               return response()->json(['success' => 'done' , 'message' => __('front.rooms.removed_successed') ],200);
            }
         return response()->json(['success' => 'faild' , 'message' => __('front.rooms.notallowed') ],200);
            
    }
    
}
