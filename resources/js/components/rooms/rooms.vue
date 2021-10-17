<template>
   <div style="height: calc(100% - 38px)">
   
            <div id="over_modal" class="over_modal_out modal_back room_enroll_secret" style="display: none;">
<div class="over_modal_in modal_in" style="max-width: 400px;">
<div class="modal_top">
<div class="modal_top_empty">
</div>
<div class="modal_top_element close_over" @click="hide_room_enroll_secret()">
<i class="fa fa-times"></i>
</div>
</div>
<div id="over_modal_content" class="modal_content over_modal_content"><div class="pad15">
<div class="boom_form">
<div class="setting_element">
<p class="label" style="direction: rtl;text-align:right;margin-bottom:10px;">كلمة المرور</p>
<input id="pass_input" class="full_input" type="password">
</div>
    <div class="alert alert-danger" style="direction: rtl;text-align:right;" v-if="roomaccesserror">{{roomaccesserrorval}}</div>
</div>
<button @click="accessRoom()" id="access_room" class="reg_button theme_btn"><i class="fa fa-check"></i> نعم</button>
<button @click="hide_room_enroll_secret()" class="cancel_over reg_button default_btn">إلغاء</button>
</div></div>
</div>
</div>  
       <div class="tab-content" id="myTabContent">
      

        <div class="usernameprofile"> <span style="float: left;">{{currrent}}</span> <span style="    float: right;margin-left: 7px;">: مرحبا</span></div>
          <div class="tab-pane fade show activeTab" id="userslist" role="tabpanel" aria-labelledby="home-tab">
            <div class="text-center form-check" style="margin-top: 10px;">
    <input type="checkbox" class="form-check-input" @change="showallusers($event)" v-model="showall" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">عرض كل المستخدمين في كل الغرف</label>
               
  </div>
          
                <div class="form-group">
    <input type="text" class="form-control search" id="exampleInputPassword1" v-on:keyup="findUser()" v-model="searchval" placeholder="ابحث ..." style="text-align:right;direction:rtl">
  </div>
              <div class="active_users_box">
              <div class="active_users" v-for="member in users" :key='member.id' v-if="user != member.id">
 <div  class="user_item">
<div class="user_item_avatar">
    <img class="acav avsex boy " :src="member.image">

    </div>
<div class="user_item_data"><p class="username" :class= "{ 'blue' : member.role == '1' , 'red' :  member.role == '2', 'green' :  member.role == 'master'}">{{member.name}}</p>

    </div>
<div class="user_item_icon icrank">
 <span style="font-size: 11px;" v-if="member.role != 'user' && member.role != 'master'">مراقب</span>
  <span style="font-size: 11px;" v-if="member.role != 'user' && member.role == 'master'">مراقب ماستر</span>
 <span style="font-size: 11px;" v-if="member.type == 'guest'">زائر</span>
 <span style="font-size: 11px;" v-if="member.type != 'guest' && member.role == 'user'">عضو</span>
    
    </div>
 
</div>
<div class="drop_list" style="display: none;">
    
    <div class="aclist gprivate rprivate listpriv" @click="privteChat(member.id,member)">
<span class="list_icon"><i class="fa fa-comments theme_color"></i></span>رسالة</div>
    
<!--
    <div class="aclist get_info rglobal">
<span class="list_icon"><i class="fa fa-user-circle-o default_color"></i></span>عرض الملف الشخصي</div>
-->
    <div  class="aclist get_actions ractions" v-if="role != 'user' && member.role == 'user'" @click="show_ban_box(member.id)">
<span class="list_icon"><i class="fa fa-flash error"></i></span>طرد</div>
    </div>
              </div>
                 
                    </div>
            
            </div>
          <div class="tab-pane fade" id="roomslist" role="tabpanel" aria-labelledby="profile-tab">
     
      
              <div class="active_rooms">
                  <div class="in_room_element btauto noview list_element" v-for="(room,index) in rooms" :key='index' @click="getRoomMessages(room)">
        <div class="in_room_icon">
        <img title="عام" class="in_room_img" src="https://kuwait777.com/default_images/rooms/public_room.svg"> </div>
        <div class="in_room_name" :class="{'blue':currentRoom == room.id}">{{room.name}}</div>
        <div class="in_room_count">
<!--        <p class="text_reg">10 <i class="fa fa-user theme_color"></i></p>-->
        </div>
</div>
             
  
              </div>
         
    </div>
                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab">
     
      <ul class="ul_settings">
    <li id="show_profile_pop">الملف الشخصي <i class="fas fa-user-circle"></i></li>
          <li  id="showsubscribtions" v-if="type != 'guest'">الاشتراكات <i class="fas fa-subway"></i></li>
          <li  id="showsubscribtions" ><a href="/logout" style="color:white">تسجيل الخروج</a> <i class="fas fa-sign-out-alt"></i></li>
    </ul>
           
    </div>
          
    </div>
         
    </div>
</template>

<script>
    export default {
      props : ['rooms','allowedbanduration'],
        data() {
            return {
                usersInRoom: [],
                chatid : 0,
                privateMessages : [],
                userprivateName : '',
                user : 0,
                currrent : '',
                subscribedPrivateChats: [],
                subscribedRooms: [],
                unreadedNotifications : 0,
                currentRoom : 0,
                showall : false,
                roomtoaccess : 0,
                roomaccesserror : false,
                roomaccesserrorval : '',
                searchval : '',
                role : '',
                type :'',
                badwords : [],
            }
        },
        beforeDestroy: function() {
     localStorage.setItem('preference', 'dvd');
},
      
        mounted() {
                        axios.get('/bad').then(res => {
                  this.badwords = res.data;
                  
            });
            this.$emit("getrooms", this.allowedbanduration);
       window.Echo.connector.pusher.connection.bind('connected', (data) => {
             axios.post('/new',{'newsocket' : data.socket_id}).then((res)=>{});  
    });
       var user = document.head.querySelector('meta[name="user"]').content;
       var username = document.head.querySelector('meta[name="username"]').content;
       var role = document.head.querySelector('meta[name="role"]').content;
       var type = document.head.querySelector('meta[name="type"]').content;
            this.role = role;
            this.type = type;
                      Echo.join(`active`)
		        .here(user => {
		        })
		        .joining(user => {       
		        })
		        .leaving(user => {

		        });
            this.user = user;
              
              Echo.private(`ban.${user}`)
                    .listen('.SendPrivateBanned', (e) => {
                      Echo.leave(`room.${e.data.room}`);
                     // Echo.disconnect();
                  this.users = [];
                
                    });
            this.currrent = username;
            axios.post('/initialRoom').then((response) =>{
                if(response.data){
                                    let roomid = response.data.room_id;
                 this.$emit("messages", response.data.messages);
                 this.$emit("room", roomid);
                if(roomid){
                    this.currentRoom = roomid;
                    this.subscribedRooms.push(roomid);
                        Echo.join(`room.${roomid}`)
		        .here(user => {
                    
                    this.usersInRoom = user.filter(u =>{ 
                        if(u.role == 'master' && u.visibility == 'visible'){
                            return u;
                        }else if(u.role == 'master' && u.visibility == 'hidden'){

                        }else{
                            return u;
                        }
                        
                        });
                  
                           
		        })
		        .joining(user => {
                              if(user && user.role == 'master' && user.visibility == 'visible'){
                                this.usersInRoom.push(user);
                    }else if(user && user.role == 'master' && user.visibility == 'hidden'){

                    }else{
                        this.usersInRoom.push(user);
                    }
                            
                            
		        })
		        .leaving(user => {
		            this.usersInRoom = this.usersInRoom.filter(u => u.id != user.id);
           
		        })
                }
                }
 
                })
                .catch((error) =>{
                    console.log(error);
                });
     
            
        },
        computed: {
             reversedRooms() {
      return this.rooms.reverse();
    },
               users:{
                   get : function() {
                        if(this.searchval){
      return this.usersInRoom.filter((item)=>{
        return this.searchval.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
      })
      }else{
        return this.usersInRoom;
      }
                       
                   },
                    set : function (val){
                        return this.usersInRoom = val;
                        
                    },   
     
    }
        }
        ,
        methods:{
            findUser(){
                console.log(this.searchval);
            },
            accessRoom(){
                 this.roomaccesserror = false;
                                        this.roomaccesserrorval = '';
                 $(".loadingio-spinner-rolling-bhl56zqj4fa").removeClass('hideloader');
                var pass = $("#pass_input").val();
                                axios.post('/accessRoombypass',{'password' : pass , 'room' : this.roomtoaccess}).then((res)=>{
                                     $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
       if(res.data.success == 'done'){
           axios.post('/removeEnroll',{'room' : this.currentRoom , 'user' : this.user}).then((res)=>{});
                     Echo.leave('room.'+this.currentRoom);
                     this.currentRoom = this.roomtoaccess;
                     this.$emit("roommessages", res.data.messages);
                    this.$emit("room", this.roomtoaccess);
     
                                     Echo.join(`room.${this.roomtoaccess}`)
		        .here(user => {
                            this.usersInRoom = user;
		             console.log( user);
		        })
		        .joining(user => {
                            console.log(user);
                            this.usersInRoom.push(user);
                            
		        })
		        .leaving(user => {
		            this.usersInRoom = this.usersInRoom.filter(u => u.id != user.id);
		        });
              $(".room_enroll_secret").hide();   
       }
                                    else{
                                        this.roomaccesserror = true;
                                        this.roomaccesserrorval = res.data.message;
                                        
                                    }
            }).catch((err)=>{
                                     $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                                });
           
            },
        privteChat(id,member){
            this.$emit("openchat",{user : id , member : member} );
             }
            ,
            
            getRoomMessages(room){
                         
                                        axios.get('getRoom/'+room.id + '/' + this.currentRoom).then((res)=>{
                                            if(res.data.success == 'failed' && res.data.reason == 'banned'){
                                                $('#ban_enroll_date').html(res.data.enroll_date);
                                                $("#banned").modal('show');
                                                console.log(res.data.enroll_date);
                                            }else if(res.data.success == 'failed' && res.data.reason == 'full'){
                                                 $('#full_room').show();
                                            } else{
                                            if(res.data.status == "notsecure"){
                    axios.post('/removeEnroll',{'room' : this.currentRoom , 'user' : this.user}).then((res)=>{});                  
                     Echo.leave('room.'+this.currentRoom);
                     this.currentRoom = room.id;
                                                $('#new_room_join').modal('show');
                     this.$emit("roommessages", res.data.messages);
                    this.$emit("room", room.id);
     
                                     Echo.join(`room.${room.id}`)
		        .here(user => {
                            this.usersInRoom = user;
		             console.log( user);
		        })
		        .joining(user => {
                            console.log(user);
                            this.usersInRoom.push(user);
                            
		        })
		        .leaving(user => {
		            this.usersInRoom = this.usersInRoom.filter(u => u.id != user.id);
		        })
                                            }else{
                                                this.roomtoaccess = room.id;
                                            $(".room_enroll_secret").show();   
                                                
                                            }
                                            }
                    
                });
                    
                
                
            },sendBtn(){
                  this.$emit("sendbtns",Math.random()) ;
            },showallusers(event){
                if(this.showall){
                 
                          Echo.leave('room.'+this.currentRoom);
                          Echo.leave('active');
                          Echo.join(`active`)
		        .here(user => {
                               this.usersInRoom = user;
		        })
		        .joining(user => {  
                               this.usersInRoom.push(user);
		        })
		        .leaving(user => {
                                this.usersInRoom = this.usersInRoom.filter(u => u.id != user.id);
		        });
                }else{
                    this.usersInRoom = [];
                                         Echo.join(`room.${this.currentRoom}`)
		        .here(user => {
                            this.usersInRoom = user;
		             console.log( user);
		        })
		        .joining(user => {
                            console.log(user);
                            this.usersInRoom.push(user);
                            
		        })
		        .leaving(user => {
		            this.usersInRoom = this.usersInRoom.filter(u => u.id != user.id);
		        })
                }
    
            },hide_room_enroll_secret(){
                $(".room_enroll_secret").hide();
            },showsubscribtions(){
                     $('#subscribtions').modal('show');

            },
            show_ban_box(userId){
                 this.$emit('banemiter', userId,this.currentRoom)
                
            }
            
            
        
    },watch:{
        chatid(){
            console.log(this.chatid);
        }        
    }
    }
</script>
