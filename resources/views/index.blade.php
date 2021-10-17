<!DOCTYPE html>
<html lang="en">
<head>
  <title>شات الجوال - كويت 965</title>
  <meta charset="utf-8">
        <meta name="csrf-token" content="{{csrf_token()}}"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
 <link href=
    "https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel=
    "stylesheet">
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('sign/fancybox/dist/jquery.fancybox.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/moment.js')}}"></script>
    
	<link rel="stylesheet" type="text/css" href="{{asset('sign/fancybox/dist/jquery.fancybox.min.css')}}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
   <meta name="user" content="{{Auth::id()}}">
   <meta name="username" content="{{Auth::user()->name}}">
   <meta name="role" content="{{Auth::user()->role}}">
   <meta name="type" content="{{Auth::user()->type}}">
   <meta name="image" content="{{url('images/profiles/') .'/'. Auth::user()->image}}">
   <meta http-equiv="Content-Security-Policy" content="none">
</head>
<body>
       @if(Auth::user()->type == 'register' && Auth::user()->verified == 0)
     <div class="out_page_container back_dark">
    <div class="out_page_content">
<div class="out_page_box">
<div class="pad_box">
<i class="fa fa-envelope-o text_ultra bmargin10"></i>
<p class="centered_element vpad10 sent_text">قمنا بإرسال رساله إلى <span class="theme_color">{{Auth::user()->mobile}}</span> . رجاءً أدخل رمز التحقق لتأكيد حسابك .</p>
    <form action="/verify" method="post">
    {{csrf_field()}}
    
<div class="boom_form vmargin15">
<input type="text" id="boom_code" placeholder="أدخل الرمز" name="code" class="full_input centered_element sub_input">
     @if (isset($errors) && count($errors) > 0)
        <div class="alert alert-danger" style="margin-top: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<button onclick="validCode(1);" class="large_button_rounded ok_btn"><i class="fa fa-paper-plane"></i> تأكيد الحساب</button><br>
<!--<button onclick="verifyAccount(2);" class="resend_hide tmargin10 small_button_rounded theme_btn"><i class="fa fa-edit"></i> إعادة ارسال</button>-->
    <a class="link_like tmargin5 bclick signup_code_sent" href="/logout">خروج</a>
        </form>
</div>
</div>
</div>
         </div>   
    @else
    <div  class="loadingio-spinner-rolling-bhl56zqj4fa hideloader"><div class="ldio-lm074eabdy">
<div></div>
</div></div>
<div id="app" >
     @php
                                                $right_banner = \App\banners::find(1);
                                                $left_banner = \App\banners::find(2);
                                                @endphp
    <div class="col-lg-12">
    <div class="banners_logo">
       <div class="hide_banner">
       <div class="bannerleft"><img style="width: 100%;
    height: 100%;" src="{{asset('uploads/banners/'.$right_banner->image)}}"></div>
        <div class="bannerright"><img style="width: 100%;
    height: 100%;" src="{{asset('uploads/banners/'.$left_banner->image)}}"></div>
       </div>
       <div id="carouselExampleControls" class="carousel slide w-100 mb-5" data-ride="carousel">
				  <div class="carousel-inner">
				   @php
                      $sliders = \App\banners::all();
                      @endphp
                      @foreach($sliders as $slider)
                      @if($loop->first)
                              <div class="carousel-item active">
                              <img class="d-block w-100 mw-100" src="{{asset('/uploads/banners/'.$slider->image)}}">
                            </div>
                      @else
                       <div class="carousel-item">
                              <img class="d-block w-100 mw-100" src="{{asset('/uploads/banners/'.$slider->image)}}">
                            </div>
                      @endif
                      @endforeach
				
				  </div>
	
				</div>
    <img src="{{asset('images/logo.png')}}" class="logo">
    </div>
        <div class="chat_box_background">
  <div class="row">
      <div id="private_box" class="privelem prifoff ui-draggable" >
	<div class="top_panel btable top_background ui-draggable-handle" id="private_top">
		<div onclick="" id="private_av_wrap" class="bcell_mid">
			<img id="private_av" :src="privatechatuserimage" >
		</div>
		<div onclick="" id="private_name" class="bcell_mid bellips">@{{privatechatusername}}</div>
		<div id="private_min" onclick="togglePrivate(1);" class="private_opt bcell_mid">
			<i class="fa fa-minus"></i>
		</div>
		<div id="private_close" class="private_opt bcell_mid" @click="hideprivatechat()">
			<i class="fa fa-times"></i>
		</div>
	</div>
	<div id="private_wrap_content">
		<div id="private_content" class="background_box" value="1" v-chat-scroll>
            <div class="large_spinner"><i class="fa fa-spinner fa-spin fa-fw boom_spinner"></i></div>
			<ul >
            <li v-for="(message, index) in privateMessages" :key="index">
						<div class="private_logs" v-if="user == message.parent_id">
							<div class="private_avatar">
								<img data="20181" class="get_info avatar_private" :src="message.user.image">
							</div>
							<div class="private_content">
								<div class="hunter_private" v-if="message.type == 'text'">@{{message.body}}</div>
                                 <p class="private_attach_image owner" v-if="message.type == 'image'"><a :href="message.body" data-fancybox="gallery"><img style="width: 115px;" :src="message.body"></a></p>
                                     <p class="private_attach_audio owner" v-if="message.type == 'audio'"><audio controls>
                      <source :src="message.body">
                      Your browser does not support the audio element.
                    </audio></p>
                                               <p class="private_attach_video owner" v-if="message.type == 'video'">
                      <video width="200" controls>
                      <source :src="message.body">
                      Your browser does not support HTML video.
                    </video>

                        </p>
							</div>
						</div>
                	<div class="private_logs" v-if="user != message.parent_id">
                        	<div class="private_content">
								<div class="target_private" v-if="message.type == 'text'">@{{message.body}}</div>
                                 <p class="private_attach_image another" v-if="message.type == 'image'"><a :href="message.body" data-fancybox="gallery"><img style="width: 115px;" :src="message.body"></a></p>
                                     <p class="private_attach_audio another" v-if="message.type == 'audio'"><audio controls>
                              <source :src="message.body">
                              Your browser does not support the audio element.
                            </audio></p>
                                                       <p class="private_attach_video another" v-if="message.type == 'video'">
                              <video width="200" controls>
                              <source :src="message.body">
                              Your browser does not support HTML video.
                            </video>

                                </p>
							</div>
							<div class="private_avatar">
								<img  class="get_info avatar_private" :src="message.user.image">
							</div>
						
						</div>
					</li>
            </ul>
		</div>
		<div id="priv_input_extra" class="add_shadow background_box">
		</div>
	</div>
	<div id="private_input" class="input_wrap">
		<form id="message_form" action="" method="post" name="private_form">
			<div class="input_table">
           
				<div value="0" id="emo_item_priv" class="input_item main_item" >
				
                       
				</div>
                
				<div id="private_input_box" class="td_input">
                    <img class="private_attach" @click="attachment()" src="images/attach.png">
                    <img class="private_voice"  @click="firerecored()" src="images/microphone.png" style="width: 23px;">
                    <input hidden="hidden" type="file" id="private_chat_attach" @change="fileuploadfn()">
					<input spellcheck="false" v-model="messageval" id="message_content" placeholder="اكتب هنا..." maxlength="200" autocomplete="off">
				</div>
								
                		<div id="message_send" class="main_item">
					<button class="default_btn csend" v-on:click.prevent="messagecontent()" id="private_send"><i class="fa fa-paper-plane"></i></button>
				</div>
			</div>
		</form>
		</div>
             <emoji-picker @emoji="append" :search="search">
      <div
        class="emoji-invoker"
        slot="emoji-invoker"
        slot-scope="{ events: { click: clickEvent } }"
        @click.stop="clickEvent"
      >
        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
        </svg>
      </div>
      <div slot="emoji-picker" slot-scope="{ emojis, insert, display }">
        <div class="emoji-picker" >
          <div class="emoji-picker__search">
            <input type="text" v-model="search" v-focus>
          </div>
          <div>
            <div v-for="(emojiGroup, category) in emojis" :key="category">
              <h5>@{{ category }}</h5>
              <div class="emojis">
                <span
                  v-for="(emoji, emojiName) in emojiGroup"
                  :key="emojiName"
                  @click="insert(emoji)"
                  :title="emojiName"
                >@{{ emoji }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </emoji-picker>
      </div>
   <div class="col-sm-9">
     <messages :messagesarr="childData" :room="room" :messagesroom="myroommessages" :sendclickres="clicksend" :profile_image_changed="profile_image"></messages>
      </div>
   <div class="col-sm-3 collapse_mobile">
       <span class="collapse_hide">X</span>
       <div class="sidebar_back">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active">المستخدمين</a>
          </li>
         
        </ul>
           
       <rooms  @banemiter="show_ban" @messages="updateMessages" @openchat="privatechat" @room="updateRoomid" @private="getPrivateMessages" @privatename="getprivatename" @privateid="getprivateid" :rooms="rooms" @roommessages="updateRoommessages"  @sendbtns="getbtnsendclick" @privateimage="getprivateimage"  @if(Auth::user()->role != 'user' && Auth::user()->role != 'master') :allowedbanduration="{{Auth::user()->plan->nofban_days}}" @elseif(Auth::user()->role != 'user' && Auth::user()->role == 'master') :allowedbanduration="['1','2','3','4','5','6','7']" @endif @getrooms="fetchedrooms"></rooms >
          
      </div>
  </div>
      
      </div>
</div>
           
   <div id="wrap_footer" data="1">
	<div class="chat_footer" id="menu_container">
		<div id="menu_container_inside">
						<div id="player_options" class="player_options sysmenu add_shadow hideall hidden">
								<div class="player_list_container">
					<p class="text_xsmall bold bpad5 rtl_elem">قائمة المحطات</p>
					<div id="player_listing">
					@php
            $channels = \App\musicChannels::get();
            @endphp
            @foreach($channels as $channel)
						<div class="radio_element sub_list_item" data="{{$channel->url}}">
            <div class="sub_list_name">{{$channel->name}}</div></div>
            @endforeach					
          </div>
				</div>
<!--
								<div class="player_volume">
					<div id="sound_display" class="bcell_mid">
						<i class="fa fa-volume-down show_sound"></i>
					</div>
					<div id="player_volume" class="bcell_mid boom_slider">
						<div id="slider" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"><div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min" style="width: 50%;"></div><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 50%;"></span><div class="ui-slider-range ui-corner-all ui-widget-header ui-slider-range-min" style="width: 50%;"></div></div>
					</div>
				</div>
-->
			</div>
						<div id="my_menu">
				<div class="chat_footer_empty bcell_mid">
										<div class="chat_player">
						<div class="player_menu player_elem" id="showMenuplayer_options" >
							<i class="fa fa-sliders"></i>
						</div>

						<div id="player_actual_status" class="player_elem player_button turn_on_play">
							<i id="current_play_btn" class="fa fa-play-circle"></i>
						</div>
					</div>
									</div>
				<div id="dpriv" onclick="togglePrivate(2);" class="chat_footer_item privhide">
					<img id="dpriv_av" src="">
					<div id="dpriv_notify" class="notification bnotify">
				   0
					</div>
				</div>
				<!--<div onclick="toggleRight();" class="chat_footer_item">
					<i class="i_btm fa fa-bars"></i>
				</div>-->
<!--
				<div value="0" onclick="getStoriesList();" id="stories_menu" class="privelem chat_footer_item">
					<i class="i_btm fas fa-camera-retro"></i>
					<div>القصص</div>
				</div>
-->
				<div value="0" id="get_private" class="privelem chat_footer_item">
					<i class="i_btm fa fa-envelope"></i>
					<div id="notify_private" class="notification bnotify" v-if="notifycount > 0">@{{notifycount}}</div>
					<div>الخاص</div>
				</div>
				<div id="users_option" title="قائمة المتواجدين" class="chat_footer_item" @click="getUsersInRoom()">
					<i class="i_btm fa fa-users"></i>
					<div>المتواجدين</div>
				</div>
				<div id="rooms_option" title="قائمة الرومات" class="chat_footer_item" @click="getRooms()">
					<i class="i_btm fa fa-home"></i>
					<div>الغرف</div>
				</div>
<!-- -->

<div id="main_mob_menu">

		<div class="chat_footer_item" id="setting_options">
				<img class="avatar_menu glob_av" src="{{asset('images/profiles/'.Auth::user()->image)}}">
				<div>الإعدادات</div>
			</div>
	</div>

                            <!-- Button trigger modal -->




			</div>
		</div>
	</div>
</div>     
    </div>
     <div id="full_room" class="over_modal_out modal_back" style="display: none;">
<div class="over_modal_in modal_in" style="max-width: 400px;">
<div class="modal_top">
<div class="modal_top_empty">
</div>
<div class="modal_top_element close_over" @click="hide_room_full()">
<i class="fa fa-times"></i>
</div>
</div>
<div id="over_modal_content" class="modal_content over_modal_content"><div class="pad15">
<div class="boom_form" style="text-align: center;">
 الغرفة ممتلئة . لا يمكنك الانضمام .
</div>
</div></div>
</div>
</div>
    
      <div class="modal" id="myprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
         <form id="updateProfileForm">
      <div class="modal-body">
                    <div id="my_profile_top" class="modal_wrap_top modal_top">
                    <div class="btable profile_top profile_background ">
                    <div id="proav" class="profile_avatar" data="default_guest.png">
                    <div class="avatar_spin">
                    <img class="fancybox avatar_profile"  src="{{asset('images/profiles/'.Auth::user()->image)}}">
                    </div>
                    <div class="avatar_control olay">
                    <div class="avatar_button" @click="deleteAvatar()" id="delete_avatar">
                    <i class="fa fa-times"></i>
                    </div>
                    <div id="avatarupload" class="avatar_button">
                    <i id="avat_icon" data="fa-camera" class="fa fa-camera"></i>
                    <input id="avatar_image" class="up_input" @change="uploadAvatar()" type="file">
                    </div>
                    </div>
                    </div>
                    <div class="profile_tinfo">
                    <div class="pdetails">
                    <div id="pro_name" class="pdetails_text pro_name cover_text">
                    {{Auth::user()->name}} </div>
                    </div>
                 
                    </div>
                    </div>
                    <div class="modal_top_menu">
                 
                    <div class="modal_top_menu_empty">
                    </div>
                    <div class="cancel_modal modal_top_item cover_text"  data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                    </div>
                    </div>
                    </div>
          
          <div class="col-lg-12">
          <div class="row">
               <div class="col-lg-6">
                 <div class="form-group">
      <label for="age">العمر</label>
    <input type="date" id="age" class="form-control" value="{{Auth::user()->birth}}">
    </div>
              </div>
           <div class="col-lg-6">
                 <div class="form-group ">
      <label for="gender">الجنس</label>
      <select id="gender" class="form-control" name="gender">
        <option selected disabled>اختر</option>
        <option value="1" @if(Auth::user()->gender === '1') selected @endif>ذكر</option>
        <option value="2" @if(Auth::user()->gender === '2') selected @endif>انثي</option>
      </select>
    </div>
              </div>
         
              <div class="col-lg-12">
               <div class="form-group">
    <label for="info">معلوماتي</label>
    <textarea class="form-control" id="info" rows="3">{{Auth::user()->info}}</textarea>
  </div>
              </div>
              @if(Auth::user()->role == 'master')
              <div class="col-lg-12">
              <label for="info">امكانية الظهور</label>
              <label class="switch" style="float:right;">
  <input type="checkbox" id="master_visibility" @if(Auth::user()->visibility == 'visible') checked @elseif(Auth::user()->visibility == 'hidden') '' @endif>
  <span class="slider round"></span>
</label>
</div>
@endif
              <div class="col-lg-12"  id="update_profile">
                                              <div class="alert alert-danger errors"  style="display:none"></div>
                                              <div class="alert alert-success messages"  style="display:none"></div>
                                              </div>
          </div></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
          </form>
    </div>
    </div></div>

    <div class="modal" id="subscribtions" tabindex="-1" role="dialog" aria-labelledby="subscribtions" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">الأشتراكات</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align:right">
          <span aria-hidden="true">×</span>
        </button>
      </div>
        @if(Auth::user()->role == 'user')
      <div class="modal-body" style="">
       
            <div style="width:50%;float:left;text-align:center">
            <a class="btn btn-danger" style="width:50%;margin-bottom:10px;" href="{{url('payment/2')}}">الاحمر</a>
            <h5>
                امكانية طرد مؤقت لمده يوم كامل
             </h5>
             <h5>
                امكانيه انشاء غرفه واحده عامه أو مغلقه
             </h5>
            </div>
            <div style="width:50%;float:left;text-align:center">
            <a href="{{url('payment/1')}}" class="btn btn-primary" style="width:50%;margin-bottom:10px;">الازرق</a>
            <h5>
         امكانية طرد مؤقت لمده يوم  أو أسبوع
             </h5>
             <h5>
                امكانيه انشاء غرفتين  عامتين أو مغلقتين مع امكانيه الاسماء او الارقام السريه
             </h5>
            </div>

            <div style="text-align:center">
                <img src="{{asset('images/mastercard.png')}}" style="width:20%;">
                <img src="{{asset('images/visa.png')}}" style="width:20%;">
                <img src="{{asset('images/express.png')}}" style="width:20%;">
            </div>
      </div>
        @elseif(Auth::user()->role != 'user' && Auth::user()->role != 'master')
             <div class="modal-body" style="">
                 <div class="row" style="text-align: right;direction: rtl;">
                     <div class="col-lg-4">انت مشترك في الخطة : </div>
                    <div class="col-lg-8" style="text-align: right;">{{Auth::user()->plan->name}}</div>
                 </div>
                       <div class="row" style="text-align: right;direction: rtl;">
                     <div class="col-lg-4">عدد الغرف لديك : </div>
                    <div class="col-lg-8" style="text-align: right;">{{Auth::user()->rooms()->count()}}</div>
                 </div>
                 @if(Auth::user()->subscription)
                 <div class="row" style="text-align: right;direction: rtl;">
                     <div class="col-lg-4">الاشتراك :</div>
                     <div class="col-lg-8" style="text-align: right;">يبدا من : {{\Carbon\Carbon::parse(Auth::user()->subscription->from)->format('Y-m-d')}}  - ينتهي في : {{\Carbon\Carbon::parse(Auth::user()->subscription->to)->format('Y-m-d')}}</div>
                 </div>
                 @endif
                @if(Auth::user()->plan->nofrooms != Auth::user()->rooms()->count()) 
            <div >
                <a class="btn btn-primary" @click="showAllRooms()">الغرف</a>
                <a class="btn btn-danger addRoomPop">اضافة غرفة</a>
            </div>
                 @else
                 <div  style="text-align: right;direction: rtl;" class="row">
                      <div class="col-lg-12"> لا يمكنك اضافه غرف اكثر من الحد المسموح </div>            
            </div>
                 @endif
      </div>
      @elseif(Auth::user()->role != 'user' && Auth::user()->role == 'master')
             <div class="modal-body" style="">
               
                       <div class="row" style="text-align: right;direction: rtl;">
                     <div class="col-lg-4">عدد الغرف لديك : </div>
                    <div class="col-lg-8" style="text-align: right;">{{Auth::user()->rooms()->count()}}</div>
                 </div>
        
            <div >
                <a class="btn btn-primary" @click="showAllRooms()">الغرف</a>
                <a class="btn btn-danger addRoomPop">اضافة غرفة</a>
            </div>
             
      </div>
        @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
  </div>
</div>
    

        <div class="modal" id="addRoomwithplans" tabindex="-1" role="dialog" aria-labelledby="addRoomwithplans" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">اضافة غرفة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align:right">
          <span aria-hidden="true">×</span>
        </button>
      </div>
 <div class="modal-body" style="">
               <form style="direction: rtl;">
          <div class="row" style="margin: 10px 0;">
            <div class="col-lg-3">
              <span>اسم الغرفه</span>
            </div>
            <div class="col-lg-6">
              <input type="text" class="form-control" v-model="newRoomName">
            </div>
          </div>
                   <div class="row" style="margin: 10px 0;">
            <div class="col-lg-3">
              <span>نوع الغرفة</span>
            </div>
            <div class="col-lg-6">
            <select id="roomtype" class="form-control" v-model="newroomtype">
        <option selected value="0">عام</option>
       <option value="1">خاص</option>
      </select>
            </div>
          </div>
                              <div class="row" id="passwordForRoom" style="margin: 10px 0;" v-if="newroomtype == 1">
            <div class="col-lg-3">
              <span>كلمة المرور</span>
            </div>
            <div class="col-lg-6">
            <input type="password" class="form-control" v-model="newroompass">
            </div>
          </div>
                                      <div class="row" v-if="addRoomSuccess"  style="margin: 10px 0;">
        <div class="col-lg-12">
                                          <div class="alert alert-success" style="direction: rtl;text-align:right">@{{addRoomSuccessval}}</div>
                                          </div>
                   </div>
                                       <div class="row" v-if="addRoomfailed"  style="margin: 10px 0;">
        <div class="col-lg-12">
                                          <div class="alert alert-danger" style="direction: rtl;text-align:right">@{{addRoomfailedval}}</div>
                                          </div>
                   </div>
        </form>
           
 
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        <button type="button" class="btn btn-primary" @click="savenewRoom()" :disabled="newRoomName == ''">حفظ</button>
      </div>
    </div>
  </div>
</div>
      <div class="modal" id="banned" tabindex="-1" role="dialog" aria-labelledby="banned" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align:right">
          <span aria-hidden="true">×</span>
        </button>
      </div>
     
      <div class="modal-body" style="">
       <img src="{{asset('images/banned.png')}}" class="ban_image">
          <h5 id="ban_enroll_date"></h5>
      
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
  </div>
</div>
        <div class="modal" id="user_related_rooms" tabindex="-1" role="dialog" aria-labelledby="user_related_rooms" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align:right">
          <span aria-hidden="true">×</span>
        </button>
      </div>
     
      <div class="modal-body" style="">
           <table class="table users_rooms_table" style="direction: rtl;">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">اسم الغرفة</th>
      <th scope="col">خيارات</th>
    </tr>
  </thead>
  <tbody>
      <tr v-for="room in user_related_rooms">
      <th scope="row">@{{room.room.id}}</th>
      <td>@{{room.room.name}}</td>
      <td><i class="fas fa-trash-alt" @click="remove_my_room(room.room.id)"></i></td>
    </tr>
      
  </tbody>
</table>
      <div class="alert alert-success" style="direction: rtl;text-align:right" v-if="removeRoomObj.status">@{{removeRoomObj.message}}</div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
  </div>
</div>
        <div class="modal" id="new_room_join" tabindex="-1" role="dialog" aria-labelledby="new_room_join" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align:right">
          <span aria-hidden="true">×</span>
        </button>
      </div>
     
      <div class="modal-body" style="">
      
          <h5 style="text-align:center">تم الانضمام بنجاح .</h5>
      
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
  </div>
</div>
<div id="large_modal" class="large_modal_out modal_back displaynone" >
	<div class="large_modal_in modal_in" style="max-width: 400px;">
		<div id="large_modal_content" class="modal_content large_modal_content"><div class="modal_top">
		<div onclick="clearPrivateList();" class="bcell_mid hpad10 bold private_cleaning">
		<i class="fa fa-trash"></i> Clear	</div>
		<div class="modal_top_empty bold">
	</div>
	<div class="modal_top_element close_modal">
		<i class="fa fa-times"></i>
	</div>
</div>
            
<div class="ulist_container">
	<div class="ulist_item" v-for="(notfication,index) in notifications" :key="index" @click="startpopprivteChat(notfication)">
			<div class="ulist_avatar">
				<img src="https://kuwait777.com/default_images/default_avatar.png">
			</div>
			<div class="ulist_name gprivate username user" data="22078" value="mohamedallam8000" data-av="https://kuwait777.com/default_images/default_avatar.png">
                @{{notfication.user.name}}
			</div>
			<div class="ulist_notify" v-if="notfication.unread != 0"><span class="pm_notify private_count bnotify">@{{notfication.unread}}</span></div>
			<div data="22078" class="ulist_option delete_private">
				<i class="fa fa-times"></i>
			</div>
		</div></div></div>
	</div>
</div>
     	  <div class="modal" id="ban_box" tabindex="-1" role="dialog" aria-labelledby="ban_box" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">طرد عضو</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align:right">
          <span aria-hidden="true">×</span>
        </button>
      </div>
     
      <div class="modal-body" style="">
         <div class="row" style="text-align: right;direction: rtl;">
                     <div class="col-lg-3">طرد لمدة : </div>
                 <div class="col-lg-5">

            <select id="roomtype" class="form-control" v-model="ban_duration">
        <option selected value="0">اختر المدة</option>
        <option v-for="(d,index) in allowedbanduration" :key="index"  :value="d">@{{d}}</option>
     
      </select>

            </div>
                    <div class="col-lg-4" style="text-align: right;">يوم</div>
                 </div>
             <div class="row" style="text-align: right;direction: rtl;margin-top:10px;" v-if="bansuccess">
                     <div class="col-lg-3"></div>
                 <div class="col-lg-8">
         <div class="alert alert-success" style="direction: ltr;">@{{bansuccessval}}</div>
            </div>
                    
                 </div>
             <div class="row" style="text-align: right;direction: rtl;margin-top:10px;" v-if="banerror">
                     <div class="col-lg-3"></div>
                 <div class="col-lg-8">
         <div class="alert alert-danger" style="direction: rtl;">@{{banerrorval}}</div>
            </div>
                    
                 </div>
          
      </div>
        

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" :disabled="ban_duration == 0" @click="ban_users()">حفظ</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
  </div>
</div> 
         <div class="modal" tabindex="-1" role="dialog" id="recordme_private">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <audio-recorder
         upload-url="some url"
        :time="2"
        :before-recording="callback_private"
        :after-recording="callbackstop_private"
        :before-upload="callback_private"
        :successful-upload="callback_private"
        :failed-upload="callback_private"
        :show-download-button="false"                  
                          />
      </div>
    </div>
  </div>
</div>
   </div>
<script src="{{asset('/js/app.js')}}"></script>
<script src="{{asset('/chat_files/custom.js')}}"></script>
    @endif
  
</body>
</html>
