<template>
	<section class="col-lg-9 connectedSortable">
        <div class="box box-warning direct-chat direct-chat-warning">
          <div class="box-body">
             <div class="direct-chat-messages" :class="scroll">
                  <button v-if="message.next_page_url" class="btn btn-default center-block btn-sm" @click="loadPrevious" :disabled="disableButton">{{ btnText}}</button>
                  
                      <div v-if="message.data.length > 0" v-for="(chat, index) in message.data" :key="index">
                        <div class="animated fadeIn direct-chat-msg" v-if="chat.user_id !== user.id">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">{{ friend.name }}</span>
                                <span class="direct-chat-timestamp pull-right">{{ chat.created_at }}</span>
                            </div>
                            <img class="direct-chat-img dp" v-if="friend.picture !== '' " :src="friend.picture" alt="dp">
                            <p v-else class="text-center center-block profile-pic-text">{{ friend.name.charAt(0) }}</p>
                            <div class="direct-chat-text">
                              <div v-if="chat.chat.startsWith('@#image@#-')">
                                <img :src="chat.chat.split('-').pop()" alt="chat-pic" class="img-responsive">
                              </div>
                              <div v-else>
                               {{ chat.chat }}
                              </div>                                 
                            </div>
                        </div>

                        <div class="animated fadeIn direct-chat-msg right" v-else>
                          <div class="direct-chat-info clearfix">
                              <span class="direct-chat-name pull-right">{{ user.name}}</span>
                              <span class="direct-chat-timestamp pull-left">{{ chat.created_at }}</span>
                          </div>
                          <img class="direct-chat-img" v-if="user.picture !== '' " :src="user.picture" alt="dp">
                          <p v-else class="text-center center-block profile-pic-text">{{ user.name.charAt(0) }}</p>
                          <div class="direct-chat-text">                          
                            <div v-if="chat.chat.startsWith('@#image@#-')">
                              
                              <img :src="chat.chat.split('-').pop()" alt="chat-pic" class="img-responsive">
                            </div>
                            <div v-else>
                             {{ chat.chat }}
                            </div>
                          </div>
                        </div>
                     </div>
                  <div v-if="message.data.length <= 0" class="no-message">
                      <i class="fa fa-comments-o"></i>
                      <p>No message here.</p>
                  </div>
              </div>
          </div>
          <ChatComposer :friend="friend"></ChatComposer>
      </div>
    </section>
</template>

<script>
    import ChatComposer from './ChatComposer';
    import {mapState} from 'vuex';
	  export default {
        data: function() {
            return {
                scroll: 'scroll',
                interval: '',
                skip: 0,
                sending: false,
                stopEvent: false,
                showButton: true,
                disableButton: false,
                btnText: "previous messages",
            }
        },
        components: {
          ChatComposer
        },
        computed: {
            ...mapState(['user']),
            message() { 
              return this.$store.getters.getChats(this.$route.params.id) ? this.$store.getters.getChats(this.$route.params.id) : this.$store.state.emptyChat;
            },
            friend() {
                return this.$store.getters.friend(this.$route.params.id) ? this.$store.getters.friend(this.$route.params.id) : this.$store.state.emptyFriend;;
            }
        },
    		mounted() {
          let id = this.$route.params.id;
          /*Echo.private(`chat.${id}.${this.user.id}`)
              .listen("BroadcastChat", (e) => {
                console.log(e);return;
                  this.chats.push(e.chat);
                  //todo mark as read when recieved if modal is open
                  this.$emit("unread", this.friend.id, 1, true);
                  this.scrollDown();
                  this.$emit("reorder", this.friend);
              });*/
          //this.fetchChat(id); 
    		},
        beforeRouteEnter(to, from, next) {
          let friendId = to.params.id;
          const form = new FormData;
            form.append("friend_id", friendId);
            axios.post("api/getchats", form)
                .then((response) => {
                    let data = response.data;
                    if(data.success) {
                        next(vm => {
                          vm.$store.commit("SETCHAT", {friendId: friendId, payload: data.chats});
                        });
                    }else {
                        /*console.error(data.message);*/
                    }
                })
                .catch((err) => {
                    /*console.error(err);*/
                });
        },
        beforeRouteUpdate(to, from, next) {
           if(this.fetchChat(to.params.id)) {
             next();
           }
        },
        watch: {
            '$route' (to, from) {
                let id = this.$route.params.id;
                //this.fetchChat(id); 
            }
        },
        methods: {
            fetchChat(userId) {
                if(userId) {
                    return this.$store.dispatch("getChats", userId);
                }   
            },
            loadPrevious() {
                if(this.message.next_page_url) {                
                    this.$store.dispatch("getPreviousChats", {friendId: this.friend.id, url: this.message.next_page_url});
                }
            }
        },
        created: function() {
          Echo.channels('chat')
              .listen("BroadcastChat", (e) => {
                console.log("enter");
                console.log(e);
                  this.chats.push(e.chat);
              });
        }
	}
</script>
<style scoped>
  div.no-message {
        width: 100%;
        height: 100%;
        vertical-align: middle;
        text-align: center;
        line-height: 115px;
        font-size: 2em;
        color: coral;
    }
    div.no-message p {
        color: coral;
    }
    div.direct-chat-messages {
      height: 70vh;
    }
</style>