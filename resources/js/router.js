/**
 * Created by OKORO EFE on 1/5/2019.
 */

import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/home';
import Chat from './components/chat';
import AddFriend from  './components/add_friend';
import Register from  './components/register';
import Login from  './components/login';
import Profile from  './components/Profile';
import Logout from  './components/logout';

Vue.use(Router);

let router = new Router({
    //mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
            meta: { requiresAuth: true}
        },
        {
            path: "/chat",
            name: "chat",
            component: Chat,
            meta: { requiresAuth: true}
        },
        {
            path: "/add-friend",
            name: "add-friend",
            component: AddFriend,
            meta: { requiresAuth: true}
        },
        {
            path: "/profile",
            name: "profile",
            component: Profile,
            meta: { requiresAuth: true}
        },
        {
            path: "/logout",
            name: "logout",
            component: Logout,
            meta: { requiresAuth: true}
        },
        {
            path: "/register",
            name: "register",
            component: Register,
            meta: { requiresAuth: false}
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            meta: { requiresAuth: false}
        },
    ]
});

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if(localStorage.getItem("jwt")) {
            next();
        }else {
            next({name: 'login'});
        }
    }else {
        next();
    }
});


export default router;