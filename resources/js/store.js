/**
 * Created by OKORO EFE on 1/5/2019.
 */
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import getters from './store/getters';
import mutations from './store/mutations';
import actions from './store/actions';

Vue.use(Vuex);
Vue.use(axios);

export default new Vuex.Store({
    state: {
    	isLoggedIn: !!localStorage.getItem('jwt'),
        user: localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : "" ,
    	urls: {
    		login: "http://localhost/vuechat/public/api/login",
    		register: "http://localhost/vuechat/public/api/register",
            nextFriendsUrl: "api/users",
    	},
        friends: [],
        friendsFetched: false,
        usersFetched: false,
        otherUsers: [],
        chats: [],
        emptyChat: {        //to avoid error when the chat component is mounted, set it to an empty structure
            data: [],
            next_page_url: "",
            currentMessage: ""
        },
        emptyFriend: {
            id: "",
            name: "",
            picture: "",
        }
    },
    getters,
    mutations,
    actions
})