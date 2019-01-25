export default {
        friends: (state) => {
            return state.friends;
        },
        getChats: state => userId => {
            let msg = state.chats.filter(val => userId == val.friendId)[0];
            msg ? msg.currentMessage = msg.currentMessage ? msg.currentMessage : "" : "";
            return msg;
        },
        //returns a friend from the store when id is passed
        friend: state => friendId => {
            return state.friends.filter(val => val.id == friendId)[0];
        }
    }