import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/home';
import Chat from './components/chat';
import AddFriend from  './components/add_friend';
import Register from  './components/register';
import Login from  './components/login';
import Profile from  './components/Profile';
import Logout from  './components/logout';
import SingleChat from './components/singlechat';
import NProgress from "nprogress";
Vue.use(Router);

let router = new Router({
    //mode: "history",
    linkActiveClass: "active",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
            meta: { requiresAuth: true, loaded: false}  //loaded to prevent nprogress from showing apart from the first time
        },
        {
            path: "/chat",
            name: "chat",
            component: Chat,
            children: [
                {
                    path: ":id",
                    component: SingleChat,
                }
            ],
            meta: { requiresAuth: true, loaded: false}
        },
        {
            path: "/add-friend",
            name: "add-friend",
            component: AddFriend,
            meta: { requiresAuth: true, loaded: false}
        },
        {
            path: "/profile",
            name: "profile",
            component: Profile,
            meta: { requiresAuth: true, loaded: false}
        },
        {
            path: "/logout",
            name: "logout",
            component: Logout,
            meta: { requiresAuth: true, loaded: false}
        },
        {
            path: "/register",
            name: "register",
            component: Register,
            meta: { requiresAuth: false, loaded: false}
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            meta: { requiresAuth: false, loaded: false}
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
router.beforeResolve((to, from, next) => {
  // If this isn't an initial page load.
  if (!to.meta.loaded) {
      // Start the route progress bar.
      NProgress.start()
  }
  next()
})

router.afterEach((to, from) => {
  // Complete the animation of the route progress bar.
  NProgress.done()
  to.meta.loaded = true;
})

export default router;