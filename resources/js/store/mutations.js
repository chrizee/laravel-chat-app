export default {
    	CHANGELOGINSTATETOLOGIN(state, user) {   //used during login and registration
    		state.isLoggedIn = true;
    		state.user = JSON.parse(localStorage.getItem('user'));
            document.body.classList.remove("login-page", "register-page");
            document.body.classList.add("skin-blue");
            //set authorization header once the user is logged in
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt');
    	},
        CHANGELOGINSTATETOLOGOUT(state) {
            state.isLoggedIn = false;
            state.user = "";
        },
        SETOTHERUSERS(state, payload) {
        	state.otherUsers = payload;
            //set this flag to true to avoid fetching the users twice
            state.usersFetched = true;
        },
        UPDATEOTHERUSERS(state, payload) {
    	    payload.map((load) => state.otherUsers.push(load));	//push each user into the stack individually
        },
        SETFRIENDS(state, payload) {
            //set friends to null because all friends are fetched when calling this mutation
            state.friends = [];
            payload.map((load) => state.friends.push(load));
            //set the friendsFetched to true when the friends are fetched for the first time to avoid fetching a second time
            state.friendsFetched = true;
        },
        UPDATEFRIENDS(state, payload) {
            state.friends.unshift(payload);
    	    //payload.map((load) => state.friends.push(load));
        },
        REMOVEFROMOTHERUSERS(state, payload) {
            state.otherUsers.map((item, index) => {
                if(item.id == payload.id) {
                    state.otherUsers.splice(index, 1);
                }
            })
        },
        SETCHAT(state, {friendId, payload}) {
            payload.friendId = friendId;
            payload.data = payload.data.reverse();
            state.chats.push(payload);
        },
        PUSHTOCHAT(state, {friendId, payload,top}) {
            state.chats.map(val => {
                if(val.friendId == friendId) {
                    if(top) {
                        val.data.unshift(...payload.data.reverse());
                        val.next_page_url = payload.next_page_url;                       
                    }else {
                        val.data.push(payload);
                        state.friends.map((friend,index) => {
                            if(friend.id == friendId) {
                                state.friends.splice(index,1);
                                state.friends.splice(0,0,friend)
                            }
                        });
                    }
                }
            })
        }
    }