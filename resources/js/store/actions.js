export default {
        logout({commit}) {
            localStorage.removeItem('jwt');
            localStorage.removeItem('user');
            commit("CHANGELOGINSTATETOLOGOUT");
            axios.post("api/logout")
                .then((res) => {
                    let data = res.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getUsers({commit, state}) {
            if(state.urls.nextFriendsUrl) {
                axios.get(state.urls.nextFriendsUrl)
                .then((res) => {
                    let data = res.data;
                    if(data.data) {
                        if(state.usersFetched) {    //if this is not the first fetch, update the users array
                            commit("UPDATEOTHERUSERS", data.data);                            
                        }else { //if this is the first, set the array instead                            
                            commit("SETOTHERUSERS", data.data);
                        }                   
                        state.urls.nextFriendsUrl = data.links.next;                    
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
            }
        },
        getFriends({commit, state}) {
            if(!state.friendsFetched) {
                axios.get("api/friends")
                .then((res) => {
                    let result = res.data;
                    if(result.success) {
                        commit("SETFRIENDS", result.friends);
                    }else {

                    }
                })
                .catch((err) => {
                    console.log(err)
                })
            }
        },
        addFriend({commit, state}, user) {
            let form = new FormData();
            form.append("friend_id", user.id);
            axios.post("api/addfriend", form)
            .then((res) => {
              let data = res.data;
              if(data.success) {
                commit("UPDATEFRIENDS", user);
                commit("REMOVEFROMOTHERUSERS", user);
              }
            })
            .catch((err) => {
              console.log(err)
            })
        },
        getChats({commit, state}, friendId) {
            //if user chat has been previously fetched, dont't fetch again, pusher will update it
            let skip = 0;
            let arrOfUserIds = state.chats.map(chat => chat.friendId);
            if(arrOfUserIds.includes(friendId)) {    //if user record exist in store, dont make request
                return ''; 
            }
            const form = new FormData;
            form.append("friend_id", friendId);
            form.append("skip", skip);
            axios.post("api/getchats", form)
                .then((response) => {
                    let data = response.data;
                    if(data.success) {
                        commit("SETCHAT", {friendId: friendId, payload: data.chats});
                        return true;
                    }else {
                        /*console.error(data.message);*/
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        getPreviousChats({commit, state}, {friendId,url}) {
            const form = new FormData;
            form.append("friend_id", friendId);
            axios.post(url, form)
            .then(response => {
                let data = response.data;
                if(data.success) {
                    //console.log(data.chats);
                    commit("PUSHTOCHAT", {friendId, payload: data.chats, top: true})
                }
            })
            .catch(err => console.log(err))
        },
        sendChat({commit, state}, {friendId, chat, photo}) {
            let form = new FormData();                                                       
            form.append("chat", chat);
            form.append("photo", photo);
            console.log(photo);
            form.append("friend-id", friendId);
            axios.post("api/sendchat", form,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then((res) => {
                let data = res.data;
                if(data.success) {
                  commit("PUSHTOCHAT", {friendId, payload: data.chat, top: false});                              
                  if(this.photo !== '') {
                    this.chats.push(data.chat);
                    this.loader = false;
                    $("div.chat_"+this.friendid).css("opacity", "1");
                  }
                }
              })
              .catch((err) => {
                this.errMsg = "Check Your internet connection";
                this.loader = false;
                $("div.chat_"+this.friendid).css("opacity", "1");       
              }
            );                    
        }
        
    }