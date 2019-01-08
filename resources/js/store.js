/**
 * Created by OKORO EFE on 1/5/2019.
 */
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);
Vue.use(axios);

export default new Vuex.Store({
    state: {
    	isLoggedIn: !!localStorage.getItem('jwt'),
        user: localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : "" ,
    	urls: {
    		login: "http://localhost/vuechat/public/api/login",
    		register: "http://localhost/vuechat/public/api/register",
    	},
        friends: [],
        otherUsers: []
    },
    getters: {

    },
    mutations: {
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
        },
        UPDATEOTHERUSERS(state, payload) {
    	    payload.map((load) => state.otherUsers.push(load));		//push each user into the stack individually
        },
        UPDATEFRIENDS(state, payload) {
    	    payload.map((load) => state.friends.push(load));
        }
    },
    actions: {
        logout({commit}) {
            localStorage.removeItem('jwt');
            localStorage.removeItem('user');
            commit("CHANGELOGINSTATETOLOGOUT");
            axios.post("api/logout")
                .then((res) => {
                    let data = res.data;
                    console.log(data);
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getUsers({commit}) {
            axios.post("api/users")
                .then((res) => {
                    let data = res.data;
                    console.log(data);
                    commit("UPDATEOTHERUSERS");
                })
                .catch((err) => {
                    console.log(err);
                })
        }
    }
})