/**
 * Created by OKORO EFE on 1/5/2019.
 */

import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/home';
import Chat from './components/chat';
import AddFriend from  './components/add_friend';

Vue.use(Router);

export default new Router({
    //mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/chat",
            name: "chat",
            component: Chat,
        },
        {
            path: "/add-friend",
            name: "add-friend",
            component: AddFriend,
        },
    ]
})