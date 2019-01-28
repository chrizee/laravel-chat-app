
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import header from './components/header';
import sidebar from './components/sidebar';
import App from './components/App';
import home from './components/home';
import footer from './components/footer';
import store from './store';
import router from './router';
import axios from "axios";
import NProgress from "nprogress";
import '../../node_modules/nprogress/nprogress.css'
require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt');

//show nprogress when an axios request is fired
axios.interceptors.request.use(config => {
  NProgress.start()
  return config
})

// before a response is returned stop nprogress
axios.interceptors.response.use(response => {
  NProgress.done()
  return response
})
Vue.component('App', App);
Vue.component("headercomponent",header);
Vue.component("sidebar", sidebar);
Vue.component("home", home);
Vue.component("footercomponent", footer);
Vue.use(axios);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store, router,
    el: '#app'
});
