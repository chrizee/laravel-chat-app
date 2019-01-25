<template>
    <div class="box-footer">
      <!-- <loader :display="loader"></loader> --> 
      <div class="input-group">
          <!-- <input type="text" @keyup.enter="sendChat" v-model="chat" placeholder="Type Message ..." class="form-control"/> -->
          <textarea  id="area" rows="1" @keyup.enter="sendChat" v-model="chat" :placeholder="placeholder" class="form-control" @focus="errMsg = '' ">          
          </textarea>
          <div class="chat-error center-block animated slideInUp" v-show="errMsg">
            <i class="fa fa-times pull-right inline-block" @click="errMsg = ''"></i>            
            <p class="clearfix">{{ errMsg }}</p>
          </div>
          <input type="file" name="photo" id="photo">
          <label for="photo" title="add image"><i class="fa fa-image"></i></label>
          <!-- <emoji @tie="append"></emoji> -->
          <span class="input-group-btn">
              <button type="button" class="btn btn-warning btn-flat" @click="sendChat" :disabled="isDisabled">Send <i class="fa fa-send"></i></button>
        </span>
      </div>
    </div>

</template>

<script>
  import {mapState} from 'vuex';
  //import emoji from "./emoji";
    export default {
        name: "ChatComposer",
        //components: {emoji},
        //props: ["sendroute", "friendid", "userid", "chats"],
        props: {
          friend: {
            required: true,
            default: {},
            type: Object
          },
          placeholder: {
            type: String,
            required: false,
            default: "Type Message ..."
          },          
        },
        data: function () {
            return {
                chat: '',
                pos: 0,
                errMsg: '',
                photo: '',
                loader: false
            }
        },
        computed: {
          isDisabled: function() {
              return this.chat === '';
          }
        },
        methods: {
            append(emoji) {
                let pos = this.caretPosition(document.getElementById('area'));
                if(pos !== this.chat.length) {
                    this.pos = pos;
                }else {
                    if (this.pos !== 0) {
                        pos = this.pos + 2;
                        this.chat = this.chat.slice(0, pos) + emoji + this.chat.slice(pos);
                        this.pos = this.pos + 2;
                        return;
                    }
                }
                this.chat = this.chat.slice(0,pos) + emoji + this.chat.slice(pos);
            },
            caretPosition(el) {
              let pos = 0;
              if(document.selection) {
                el.focus();
                let range = document.selection.createRange().movestart("character", -el.value.length);
                pos = range.text.length;
              }else if(el.selectionStart || el.selectionStart == 0) {
                pos = el.selectionStart;
              }
              return pos;
            },
            sendChat: function(e) {              
              this.$store.dispatch("sendChat", {friendId: this.$route.params.id, chat: this.chat, photo: this.photo});
              this.chat = this.photo = '';
            }
        },
        mounted() {
          document.getElementById('area').addEventListener("focus", (e) => {
                if(this.chat.length === this.caretPosition(e.target)) this.pos = 0;
              });
          let input = document.getElementById('photo');
          const allowedFileTypes = ["image/jpeg", "image/png", "image/gif", "image/svg+xml", "image/bmp", "image/webp"];
          input.addEventListener("change", (e) => {
              this.errMsg = "";
              let type = e.target.files[0].type;
              if(allowedFileTypes.includes(type)) {
                  let prompt = confirm("Send photo");                  
                  if(prompt) {
                    this.photo = e.target.files[0];
                    this.chat = "photo" //send something to prevent backend validation from failing                 
                    this.sendChat(e);
                  }
              }else {
                  this.errMsg = "Only image files are allowed.";
              }
          });
        }
    }
</script>

<style scoped>
    .chat-right, .chat-left {
        width: 70%;
    }
    textarea {
      resize: none;
      height: 34px !important;
      padding: 0 1.7em 0 2em; 
      line-height: 30px;
      font-size: 1.2em;
    }
    div.chat-error {
      position: absolute;
      left: 0.2rem;
      top: -5.7rem;
      width: 99%;
      background: brown;      
      padding: 1rem;
    }
    div.chat-error p {
      color: white !important;
    }
    div.chat-error i {
      cursor: pointer;
    }
    input[type='file']{
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
  }
  input[type='file'] + label {
      padding: 2px 4px;
      font-weight: 700;
      color: #b1c6d0;
      display: inline-block;
      cursor: pointer;
      position: absolute;
      top: 0.3rem;
      right: 7.9rem;
      margin-bottom: 0;
      z-index: 9999;
      font-size: 1.8rem;
      transition: all 0.2s;
  }
  input[type='file'] + label:hover {
    transform: scale(1.1);
  }
</style>