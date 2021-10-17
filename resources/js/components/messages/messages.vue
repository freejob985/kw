<template>
   <div>
       
       	  <div class="messages_area" id="messages_area_id" v-chat-scroll>
     
       <ul>
           <li class="ch_logs public"  v-for="(message,index) in messages" :key="index">
				<div class="chat_avatar">
					<img class="avav avsex boy " :src="message.userimage">
				</div>
				<div class="my_text">
					<div class="btable">
         <div class="cdate">{{message.created_at | moment}}<span style="font-size: 10px;" v-if="message.user_id == user"> - {{message.status}}</span></div>
                       
							<div class="cname"><span class="username " :class="{'bluefont' : message.role == 1 ,'redfont' : message.role == 2,'greenfont' : message.role == 'master'}">{{message.username}}</span></div>
					</div>
					<div class="chat_message  bolded" :class="{'bluefont' : message.role == 1 ,'redfont' : message.role == 2,'greenfont' : message.role == 'master'}">
      <p v-if="message.type == 'text'" >{{message.body}}</p>
               <p class="attach" v-if="message.type == 'image'"><a :href="message.body" data-fancybox="gallery"><img style="width: 115px;" :src="message.body"></a></p>
            <p class="attach" v-if="message.type == 'audio'"><audio controls>
  <source :src="message.body">
  Your browser does not support the audio element.
</audio></p>
                           <p class="attach" v-if="message.type == 'video'">
  <video width="200" controls>
  <source :src="message.body">
  Your browser does not support HTML video.
</video>
    
    </p>
    </div>
				</div>
			</li>   
    </ul>
       </div>
       <div class="input_area">
<form @submit.prevent autocomplete="off" v-bind:class= "[(type != 'guest') ? 'input_send_message' : 'input_send_message_fullwidth']">
       <input class=""  @keyup.enter="saveMessage"
                   v-model="newMessage" 
type="text"
              :disabled="room == 0"
				    name="message"
				    placeholder="اكتب هنا ..." >
</form>
               <emoji-picker @emoji="append" :search="search" v-if="room != 0">
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
              <h5>{{ category }}</h5>
              <div class="emojis">
                <span
                  v-for="(emoji, emojiName) in emojiGroup"
                  :key="emojiName"
                  @click="insert(emoji)"
                  :title="emojiName"
                >{{ emoji }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </emoji-picker>
     <div class="timer_group" v-if="recordStarted">
           <i class="far fa-times-circle" @click="stopRecord()"></i>
           <span class="timer">{{counterText}}</span>
           <i class="far fa-check-circle" @click="sendRecord()"></i>
           </div>
           <div  class="emoje_btn" v-if="type != 'guest'" >
          <div class="btn-group-vertical">
				<button type="file" style="margin-bottom: 4px;
    padding: 2px 4px;" @click="attachment()">
				<img src="images/attach.png" style="width: 23px;">
			      </button>
		
		     <button style="padding: 2px 4px;" @click="firerecored()"><img src="images/microphone.png" style="width: 23px"></button>
		 </div>
           </div>
       </div> 
      
       <input id="fileattach" hidden="hidden" type="file" @change="fileuploadfn()">

       <div>
	    
</div>
    
    </div>
</template>

<script>
     export default {
          props: { messagesarr : Array, messagesroom:Array,room : Number , sendclickres : Number , profile_image_changed : String},
         data() {
            return {
                room_id: 0,
                newMessage : '',
                messages : [],
                user : 0,
                role : '',
                username : '',
                subscribedRooms : [],
                uploadedRate : 0,
                uploadedsrc:'',
                singlemessage:{},
                type: '',
      search: '',
                userimage : '',
                badwords : [],
                rec : null,
                audioChunks: [],
                counter : 0,
                counterText : '00:00:00',
                recordStarted : false,
                recordEnded : false,
                recordSend : false,
                recordedInterval : false

            }
        },
         filters: {
    moment: function (date) {
      return moment(date).format('YYYY-MM-DD h:mm a');
    }
  },
        mounted() {
            console.log(this.profile_image_changed);
            var user = document.head.querySelector('meta[name="user"]').content;
            var username = document.head.querySelector('meta[name="username"]').content;
            var type = document.head.querySelector('meta[name="type"]').content;
            var image = document.head.querySelector('meta[name="image"]').content;
            var role = document.head.querySelector('meta[name="role"]').content;
            this.type = type;
            this.user = user;
            this.role = role;
            this.username = username;
            this.userimage = image;
                      axios.get('/bad').then(res => {
                  this.badwords = res.data;
                  
            });

        }, directives: {
    focus: {
      inserted(el) {
        el.focus()
      },
    },
  },
         methods: {
             append(emoji) {
      this.newMessage += emoji
    },
            saveMessage() {
                
                  var rgx = new RegExp(this.badwords.join("|"), "gi");
                ;
                let mess = this.newMessage;
                this.newMessage = '';
                let message = {"body":mess.replace(rgx, "****") , "user_id":this.user,role : this.role,"room_id":this.room_id,"type":"text","updated_at":new Date().toISOString(),"created_at":new Date().toISOString(),"id":0,"username":  this.username,"userimage":this.userimage, "status" : 'ارسال'};
                 this.messages.push(message);
               axios.post('/addMessage',{
                   message : mess,
                   room : this.room_id
               }).then(res => {
                   if(res.data.success == 'failed' && res.data.reason == 'banned'){
                        $('#ban_enroll_date').html(res.data.enroll_date);
                                                $("#banned").modal('show');
                       return;
                   }
                   message.status = res.data.newMessage.status;
                  
            });
            },
             attachment(){
                 $("#fileattach").click();
             },fileuploadfn(){
                  var reader = new FileReader();
 let message ;
            reader.onload =  (e)=>{
                var type = $("#fileattach")[0].files[0].type;
                var filetype =  type.split("/")[0];
                  message = {"body":e.target.result , "user_id":this.user,role : this.role,"room_id":this.room_id,"type":filetype,"updated_at":new Date().toISOString(),"created_at":new Date().toISOString(),"id":0,"username":  this.username,"userimage":this.userimage, "status" : 'ارسال'};
                 this.messages.push(message);
            };

            reader.readAsDataURL($("#fileattach")[0].files[0]);
                 let formData = new FormData();
                 formData.append('file', $("#fileattach")[0].files[0]);
                 formData.append('room', this.room_id);
              

                
                 axios.post('/uploadfile', formData,  {
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
              callback (msg) {
      console.log('Event: ', msg)
    },
             firerecored(){
                 navigator.mediaDevices.getUserMedia({audio:true})
            .then(stream => {
              this.handlerFunction(stream);
              this.startRecord();
              })
                
             }
      ,
      handlerFunction(stream) {
        this.rec = new MediaRecorder(stream);
          this.rec.ondataavailable = e => {
                if(this.recordEnded == true){
                    this.recordStarted = false;
                    this.recordEnded = false;
                }else if(this.recordSend == true){
                      this.audioChunks.push(e.data);
                      if (this.rec.state == "inactive"){
                        let blob = new Blob(this.audioChunks,{type:'audio/mp3'});
                        this.recordStarted = false;
                        this.recordEnded = false;
                        this.sendData(blob);
                        }
                }
               this.rec.stream.getAudioTracks().forEach((e)=>{
                          e.stop();
                        });
               this.rec = null;
          }
         
        },
        sendRecord(){
          this.rec.stream.getAudioTracks().forEach((e)=>{
                          e.stop();
                        });
            this.counterText = '00:00:00';
            this.counter = 0;
            clearInterval(this.recordedInterval);
            this.recordSend = true;
            this.rec.stop();
        },
        sendData(d){
           let  message = {"body":URL.createObjectURL(d), "user_id":this.user,role : this.role,"room_id":this.room_id,"type":'audio',"updated_at":new Date().toISOString(),"created_at":new Date().toISOString(),"id":0,"username":  this.username,"userimage":this.userimage, "status" : 'ارسال'};
                    this.messages.push(message);
                  $('#recordme').modal('hide');
                      let formData = new FormData();
                 formData.append('file', d);
                 formData.append('room', this.room_id);
                 axios.post('/uploadfile', formData,  {
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
        },
        startRecord(){
          this.counterText = '00:00:00';
          this.counter = 0;
          this.recordStarted = true;
          clearInterval(this.recordedInterval);
          this.recordedInterval = setInterval(this.timer, 1000);
          this.audioChunks = [];
          this.rec.start();
        },
        stopRecord(){
          this.rec.stream.getAudioTracks().forEach((e)=>{
                          e.stop();
                        });
          this.counterText = '00:00:00';
          this.counter = 0;
          clearInterval(this.recordedInterval);
          this.rec.stop();
          this.recordEnded = true;
        },
        timer(){
          this.counter = this.counter + 1;
           var date = new Date(null);
           date.setSeconds(this.counter);
           var result = date.toISOString().substr(11, 8);
           this.counterText = result;
           console.log(this.counterText);
        }
         },
         watch :{
             room:function(val) {
//                     let el = document.getElementById('messages_area_id');
//                      el.scrollTop = el.scrollHeight; //or .scrollHeight
                 if(val != 0){
                     if(this.subscribedRooms.indexOf(val) <= -1){
                           this.room_id = val;
                           Echo.join(`room.${this.room_id}`)
                            .listen('.SendMessageToRoom', (data) => {
                               if(this.room_id == data.data.room){
                                   var rgx = new RegExp(this.badwords.join("|"), "gi");
                                   var message = data.data.message;
                                   if(this.badwords.length > 0){
                                     message.body =data.data.message.body.replace(rgx, "****");   
                                   }
                                   this.messages.push(message);
                               }
                            });
                     }
                   
                 }
        
         },
                  messagesarr:function(val) { 
                         
                          this.messages = val;

         },
             messagesroom:function (val){
                         
                          this.messages = val;

         },
        profile_image_changed:function (val){
            this.messages.map((message) => {
                if(message.user_id == this.user){
                    message.userimage = val;
                }
            });

         }
             ,sendclickres:function(val){
                 axios.post('/addMessage',{
                   message : this.newMessage,
                   room : this.room_id
               }).then(res => {
                   this.newMessage = '';
                   this.messages.push(res.data.newMessage);
            })
         }
    }
     }
</script>

<style scoped="true">
/* Tailwind CSS-styled demo is available here: https://codepen.io/DCzajkowski/pen/Brxvzj */

.wrapper {
  position: relative;
  display: inline-block;
}



.input_send_message:focus {
  box-shadow: 0 0 0 3px rgba(66,153,225,.5);
}

.emoji-invoker {
  position: absolute;
  top: 24px;
  right: 50px;
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.2s;
}
.emoji-invoker:hover {
  transform: scale(1.1);
}
.emoji-invoker > svg {
  fill: #b1c6d0;
}

.emoji-picker {
    bottom: 0px;
  position: absolute;
  z-index: 1;
  font-family: Montserrat;
  border: 1px solid #ccc;
  width: 17rem;
  height: 20rem;
  overflow-y: scroll;
  padding: 1rem;
  box-sizing: border-box;
  border-radius: 0.5rem;
  background: #fff;
  box-shadow: 1px 1px 8px #c7dbe6;
}
.emoji-picker__search {
  display: flex;
}
.emoji-picker__search > input {
  flex: 1;
  border-radius: 10rem;
  border: 1px solid #ccc;
  padding: 0.5rem 1rem;
  outline: none;
}
.emoji-picker h5 {
  margin-bottom: 0;
  color: #b1b1b1;
  text-transform: uppercase;
  font-size: 0.8rem;
  cursor: default;
}
.emoji-picker .emojis {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}
.emoji-picker .emojis:after {
  content: "";
  flex: auto;
}
.emoji-picker .emojis span {
  padding: 0.2rem;
  cursor: pointer;
  border-radius: 5px;
}
.emoji-picker .emojis span:hover {
  background: #ececec;
  cursor: pointer;
}
.bluefont{
  color:blue;
}
.redfont{
  color:red;
}
.greenfont{
  color:green;
}
</style>