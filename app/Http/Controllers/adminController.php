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
use App\sliders;
use App\banners;
use App\musicChannels;
use Hash;
use Auth;
use DB;
use \Carbon\Carbon;
use Twilio\Rest\Client;
use Validator;
class adminController extends Controller {
    
      public function login(){
        return view('admin.login');
    }
     public function home(){
        return view('admin.home');
    }
    
     public function loginPost(Request $request){
         auth()->guard('admin')->attempt(['email' => $request->email , 'password' => $request->password],$request->remember);
            if(auth()->guard('admin')->check()){
                return response()->json(['status' => 'done','message'=> __('admin.successedSignin')],200);
            }else{
                return response()->json(['status' => 'failed','message'=>__('admin.passwordNotCorrect')],200);
            }
    }
     public function logout(){
        auth()->guard('admin')->logout();
        return redirect(route('admin.login'));
    }
 
     public function users(){
         $users = User::all();
        return view('admin.users',compact('users'));
    }
    public function monitors(){
        $users = User::where('type','byAdmin')->get();
       return view('admin.monitors',compact('users'));
   }
    
     public function usersCreate(){
        return view('admin.addusers');
    }
    public function monitorsCreate(){
        return view('admin.addmonitors');
    }
    
       public function usersInsert(Request $request){
           if($request->birth){
               $diffYears = Carbon::now()->diffInYears(Carbon::parse($request->birth));
               $request['birthdiff'] = $diffYears;
           }
           // return $request->all();
                $messages = [
           'name.required' => __('admin.user_name_required'),
           'name.string' => __('admin.user_name_string'),
           'email.required' => __('admin.user_email_required'),
           'email.email' => __('admin.user_email_email'),
           'email.unique' => __('admin.user_email_unique'),
           'mobile.required' => __('admin.user_mobile_required'),
           'mobile.string' => __('admin.user_mobile_string'),
           'mobile.unique' => __('admin.user_mobile_unique'),
           'birth.required' => __('admin.user_birth_required'),
           'birth.date_format' => __('admin.user_birth_date_format'),
           'password.required' => __('admin.user_password_required'),
           'password.string' => __('admin.user_password_string'),
           'password.min' => __('admin.user_password_min'),
           'gender.required' => __('admin.user_gender_required'),
           'gender.string' => __('admin.user_gender_string'),
           'gender.in' => __('admin.user_gender_in'),
           'birthdiff.gt' => __('admin.user_birthdiff_gt'),
            
        ];
           // return $request->all();
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|unique:users,mobile',
            'birth' => 'required|date_format:Y-m-d',
            'password' => 'required|string|min:8',
            'gender' => 'required|string|in:1,2',
            'birthdiff' => 'required|gt:18',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
           $newUser = new User();
           $newUser->name =  $request->name;
           $newUser->email =  $request->email;
           $newUser->mobile =  $request->mobile;
           $newUser->birth =  Carbon::parse($request->birth);
           $newUser->password =  Hash::make($request->password);
           $newUser->verified = 1;
           $newUser->type = 'register';
           $newUser->gender = $request->gender;
           $newUser->save();
           return back()->with('message',__('admin.newUserAdded'));
    }
    public function monitorsInsert(Request $request){
        if($request->birth){
            $diffYears = Carbon::now()->diffInYears(Carbon::parse($request->birth));
            $request['birthdiff'] = $diffYears;
        }
        // return $request->all();
             $messages = [
        'name.required' => __('admin.user_name_required'),
        'name.string' => __('admin.user_name_string'),
        'email.required' => __('admin.user_email_required'),
        'email.email' => __('admin.user_email_email'),
        'email.unique' => __('admin.user_email_unique'),
        'mobile.required' => __('admin.user_mobile_required'),
        'mobile.string' => __('admin.user_mobile_string'),
        'mobile.unique' => __('admin.user_mobile_unique'),
        'birth.required' => __('admin.user_birth_required'),
        'birth.date_format' => __('admin.user_birth_date_format'),
        'password.required' => __('admin.user_password_required'),
        'password.string' => __('admin.user_password_string'),
        'password.min' => __('admin.user_password_min'),
        'gender.required' => __('admin.user_gender_required'),
        'gender.string' => __('admin.user_gender_string'),
        'gender.in' => __('admin.user_gender_in'),
        'birthdiff.gt' => __('admin.user_birthdiff_gt'),
         
     ];
        // return $request->all();
     $validator = Validator::make($request->all(),[
         'name' => 'required|string',
         'email' => 'required|email|unique:users,email',
         'mobile' => 'required|string|unique:users,mobile',
         'birth' => 'required|date_format:Y-m-d',
         'password' => 'required|string|min:8',
         'gender' => 'required|string|in:1,2',
         'birthdiff' => 'required|gt:18',
         'visibility' => 'required|in:hidden,visible',
         'monitor_type' => 'required|in:1,2,master',
         
     ],$messages);
     if($validator->fails()){
         return back()->withErrors($validator);
     }
        $newUser = new User();
        $newUser->name =  $request->name;
        $newUser->email =  $request->email;
        $newUser->mobile =  $request->mobile;
        $newUser->birth =  Carbon::parse($request->birth);
        $newUser->password =  Hash::make($request->password);
        $newUser->verified = 1;
        $newUser->type = 'byAdmin';
        $newUser->role = $request->monitor_type;
        $newUser->gender = $request->gender;
        $newUser->visibility = $request->visibility;
        $newUser->save();
        return back()->with('message',__('admin.newUserAdded'));
 }
 public function monitorsEdit($id){
    $user = User::find($id);
    return view('admin.editmonitors',compact('user'));
}
public function monitorsUpdate(Request $request , $id){
       $user = User::find($id);
       if(!$user){return abort(404);}
       if($request->birth){
           $diffYears = Carbon::now()->diffInYears(Carbon::parse($request->birth));
           $request['birthdiff'] = $diffYears;
       }
       // return $request->all();
            $messages = [
       'name.required' => __('admin.user_name_required'),
       'name.string' => __('admin.user_name_string'),
       'email.required' => __('admin.user_email_required'),
       'email.email' => __('admin.user_email_email'),
       'email.unique' => __('admin.user_email_unique'),
       'mobile.required' => __('admin.user_mobile_required'),
       'mobile.string' => __('admin.user_mobile_string'),
       'mobile.unique' => __('admin.user_mobile_unique'),
       'birth.required' => __('admin.user_birth_required'),
       'birth.date_format' => __('admin.user_birth_date_format'),
       'password.required' => __('admin.user_password_required'),
       'password.string' => __('admin.user_password_string'),
       'password.min' => __('admin.user_password_min'),
       'gender.required' => __('admin.user_gender_required'),
       'gender.string' => __('admin.user_gender_string'),
       'gender.in' => __('admin.user_gender_in'),
       'birthdiff.gt' => __('admin.user_birthdiff_gt'),
        
    ];
       // return $request->all();
    $validator = Validator::make($request->all(),[
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,'.$id,
        'mobile' => 'required|string|unique:users,mobile,'.$id,
        'birth' => 'required|date_format:Y-m-d',
        'password' => 'nullable|string|min:8',
        'gender' => 'required|string|in:1,2',
        'birthdiff' => 'required|gt:18',
        'visibility' => 'required|in:hidden,visible',
        'monitor_type' => 'required|in:1,2,master',
        
    ],$messages);
    if($validator->fails()){
        return back()->withErrors($validator);
    }
       $user->name =  $request->name;
       $user->email =  $request->email;
       $user->mobile =  $request->mobile;
       $user->birth =  Carbon::parse($request->birth);
        if($request->password != null){
            $user->password =  Hash::make($request->password);
        }
       $user->gender = $request->gender;
       $user->visibility = $request->visibility;
       $user->role = $request->monitor_type;
       $user->save();
       return back()->with('message',__('admin.UserUpdated'));
}
    public function usersEdit($id){
        $user = User::find($id);
        return view('admin.editusers',compact('user'));
    }
    public function usersUpdate(Request $request , $id){
           $user = User::find($id);
           if(!$user){return abort(404);}
           if($request->birth){
               $diffYears = Carbon::now()->diffInYears(Carbon::parse($request->birth));
               $request['birthdiff'] = $diffYears;
           }
           // return $request->all();
                $messages = [
           'name.required' => __('admin.user_name_required'),
           'name.string' => __('admin.user_name_string'),
           'email.required' => __('admin.user_email_required'),
           'email.email' => __('admin.user_email_email'),
           'email.unique' => __('admin.user_email_unique'),
           'mobile.required' => __('admin.user_mobile_required'),
           'mobile.string' => __('admin.user_mobile_string'),
           'mobile.unique' => __('admin.user_mobile_unique'),
           'birth.required' => __('admin.user_birth_required'),
           'birth.date_format' => __('admin.user_birth_date_format'),
           'password.required' => __('admin.user_password_required'),
           'password.string' => __('admin.user_password_string'),
           'password.min' => __('admin.user_password_min'),
           'gender.required' => __('admin.user_gender_required'),
           'gender.string' => __('admin.user_gender_string'),
           'gender.in' => __('admin.user_gender_in'),
           'birthdiff.gt' => __('admin.user_birthdiff_gt'),
            
        ];
           // return $request->all();
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile' => 'required|string|unique:users,mobile,'.$id,
            'birth' => 'required|date_format:Y-m-d',
            'password' => 'nullable|string|min:8',
            'gender' => 'required|string|in:1,2',
            'birthdiff' => 'required|gt:18',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
           $user->name =  $request->name;
           $user->email =  $request->email;
           $user->mobile =  $request->mobile;
           $user->birth =  Carbon::parse($request->birth);
            if($request->password != null){
                $user->password =  Hash::make($request->password);
            }
           $user->gender = $request->gender;
           $user->save();
           return back()->with('message',__('admin.UserUpdated'));
    }
    public function plans(){
        $plans = plans::all();
        return view('admin.plans',compact('plans'));
    }
    public function addplans(){
        return view('admin.addplans');
    }
    public function insertplans(Request $request){
                $messages = [
           'name.required' => __('admin.plan_name_required'),
           'name.string' => __('admin.plan_name_string'),
           'price.required' => __('admin.plan_price_required'),
           'price.numeric' => __('admin.plan_price_numeric'),
           'joinnumber.required' => __('admin.plan_joinnumber_required'),
           'joinnumber.numeric' => __('admin.plan_joinnumber_numeric'),
           'blockdays.required' => __('admin.plan_blockdays_required'),
           'blockdays.*.required' => __('admin.plan_blockdays_*_required'),
           'blockdays.*.numeric' => __('admin.plan_blockdays_*_numeric'),
         
            
        ];
           // return $request->all();
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'price' => 'required|numeric',
            'joinnumber' => 'required|numeric',
            'blockdays' => 'required|array',
            'blockdays.*' => 'required|numeric',
          
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $newPlan  = new plans();
        $newPlan->name = $request->name;
        $newPlan->price = $request->price;
        $newPlan->nofrooms = $request->joinnumber;
        $newPlan->nofban_days = json_encode($request->blockdays);
        $newPlan->save();
          return back()->with('message',__('admin.planCreated'));
    }
        public function updateplans(Request $request,$id){
             $plan = plans::find($id);
        if(!$plan){return abort(404);}
                $messages = [
           'name.required' => __('admin.plan_name_required'),
           'name.string' => __('admin.plan_name_string'),
           'price.required' => __('admin.plan_price_required'),
           'price.numeric' => __('admin.plan_price_numeric'),
           'joinnumber.required' => __('admin.plan_joinnumber_required'),
           'joinnumber.numeric' => __('admin.plan_joinnumber_numeric'),
           'blockdays.required' => __('admin.plan_blockdays_required'),
           'blockdays.*.required' => __('admin.plan_blockdays_*_required'),
           'blockdays.*.numeric' => __('admin.plan_blockdays_*_numeric'),
         
            
        ];
           // return $request->all();
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'price' => 'required|numeric',
            'joinnumber' => 'required|numeric',
            'blockdays' => 'required|array',
            'blockdays.*' => 'required|numeric',
          
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->nofrooms = $request->joinnumber;
        $plan->nofban_days = json_encode($request->blockdays);
        $plan->save();
          return back()->with('message',__('admin.planUpdated'));
    }
    
    public function bad(){
        $bad = badWords::all();
        return view('admin.badwords',compact('bad'));
    }
    public function createbad(){
        return view('admin.addbadword');
    }
    public function insertbad(Request $request){
           $messages = [
           'word.required' => __('admin.bad_word_required'),
           'word.string' => __('admin.bad_word_string'),
           'word.unique' => __('admin.bad_word_exists'),
         
            
        ];
           // return $request->all();
        $validator = Validator::make($request->all(),[
            'word' => 'required|string|unique:bad_words,word',
          
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $newbadWord = new badWords();
        $newbadWord->word = $request->word;
        $newbadWord->save();
          return back()->with('message',__('admin.badwordcreated'));
    }
    public function editplans($id){
          $plan = plans::find($id);
        if(!$plan){return abort(404);}
         return view('admin.editplans',compact('plan'));
    }
      public function editbad($id){
          $badword = badWords::find($id);
        if(!$badword){return abort(404);}
         return view('admin.editbadword',compact('badword'));
    }
        public function updatebad(Request $request,$id){
                      $badword = badWords::find($id);
        if(!$badword){return abort(404);}
           $messages = [
           'word.required' => __('admin.bad_word_required'),
           'word.string' => __('admin.bad_word_string'),
           'word.exists' => __('admin.bad_word_exists'),
         
            
        ];
           // return $request->all();
        $validator = Validator::make($request->all(),[
            'word' => 'required|string|unique:bad_words,word,'. $id,
          
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $badword->word = $request->word;
        $badword->save();
          return back()->with('message',__('admin.badwordupdated'));
    }
    
      public function sliders(){
         $sliders = sliders::all();
         return view('admin.sliders',compact('sliders'));
    }
        public function upload_slider(Request $request){
            $messages = [
        ];
        $validator = Validator::make($request->all(),[
            'image' => 'nullable|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $allcounted = sliders::all()->count();
        $allcounted += 1;
        $fileName = time() . '-' . $allcounted .'.'.$request->image->extension();  
        $request->image->move(public_path('uploads/sliders'), $fileName);
        
        $new_image = new sliders();
        $new_image->image = $fileName;
        $new_image->save();
        return response()->json(['status' => 'success' , 'image' => $new_image->id],200);
    }
     public function remove_image_slider($id){
          $slider = sliders::findOrFail($id);
          if(!$slider){ return response()->json(['status' => 'error'],200);}
          $slider->delete();
          return response()->json(['status' => 'success'],200);
    }
    public function banners(){
        return view('admin.banners');
    }
    public function banners_image(Request $request){
            $messages = [
        ];
        $validator = Validator::make($request->all(),[
            'image' => 'nullable|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
            'banner' => 'in:1,2',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $banners_right = banners::find($request->banner);
        $fileName = time() . '_rigth' .'.'.$request->image->extension();  
        $request->image->move(public_path('uploads/banners'), $fileName);
        $banners_right->image = $fileName;
        $banners_right->save();
        return response()->json(['status' => 'success'],200);
        
    }
    public function get_chat_history(){
        $messages = messages::has('room')->has('user')->where('type','text')->orderBy('id','desc')->get();
        return view('admin.messages',compact('messages'));
    }
    public function getMusicChannels(){
        $musicChannels = musicChannels::get();
        return view('admin.musicchannels',compact('musicChannels'));
    }
    public function getaddMusicChannels(){
        return view('admin.addmusicchannel');
    }
    public function postaddMusicChannels(Request $request){
        $messages = [
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'url' => 'required',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $newChannel = new musicChannels();
        $newChannel->name = $request->name;
        $newChannel->url = $request->url;
        $newChannel->save();
        return back()->with('message',__('admin.musicChannels.added'));
    }
    public function getupdateMusicChannels($id){
        $channel = musicChannels::findOrFail($id);
        return view('admin.editmusicchannel',compact('channel'));
    }
    public function postupdateMusicChannels(Request $request,$id){
        $channel = musicChannels::findOrFail($id);
        $messages = [
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'url' => 'required',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $channel->name = $request->name;
        $channel->url = $request->url;
        $channel->save();
        return back()->with('message',__('admin.musicChannels.updated'));
    }
    public function terms(){
        return view('admin.terms');
    }
    public function terms_update(Request $request){
        $terms = \App\main_settings::find(1);
        $messages = [
        ];
        $validator = Validator::make($request->all(),[
            'terms' => 'required',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $terms->terms = $request->terms;
        $terms->save();
        return back()->with('message',__('admin.terms_updated'));
    }  
        
    
    
    
    
    
    
}
