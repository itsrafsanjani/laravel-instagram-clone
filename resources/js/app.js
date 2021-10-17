/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./plugins/jquery.jscroll.min')
// require('./plugins/jquery.lazy.min')
// require('./plugins/jquery.lazy.plugins.min')
require('owl.carousel')
require('owl.carousel/dist/assets/owl.carousel.css')
require('owl.carousel/dist/assets/owl.theme.default.min.css')
require('moment')
require('./plugins/nice-toast-js.min')

import ClipboardJS from 'clipboard';
import { initializeApp } from 'firebase/app';
import { getAnalytics } from "firebase/analytics";

// check if the clipboard class is available in DOM
let clipboard = document.getElementsByClassName('clipboard');
if (clipboard.length > 0) {
    // initialize clipboardjs
    new ClipboardJS('.clipboard');
}

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyAxPpkCArq0cVN89_FwaXkd5gACoCBGAts",
    authDomain: "laragram2.firebaseapp.com",
    projectId: "laragram2",
    storageBucket: "laragram2.appspot.com",
    messagingSenderId: "49536770108",
    appId: "1:49536770108:web:6ab2e2dd4593018182e339",
    measurementId: "G-705L5J2HZN"
};
// Initialize Firebase
const app = initializeApp(firebaseConfig);
getAnalytics(app);

// nice-toast-js setup
$.niceToast.setup({
    position: "top-right",
    timeout: 5000,
});

require('./custom')

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('follow-button', require('./components/FollowButton.vue').default);
// Vue.component('like-button', require('./components/LikeButton.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

