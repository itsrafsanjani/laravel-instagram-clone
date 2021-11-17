/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./plugins/jquery.jscroll.min');
require('owl.carousel');
require('owl.carousel/dist/assets/owl.carousel.css');
require('owl.carousel/dist/assets/owl.theme.default.min.css');
require('moment');
require('jquery-pjax');
require('./plugins/nice-toast-js.min');

import autosize from 'autosize';
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

autosize(document.querySelectorAll('textarea'));
/**
 * My Custom JS
 * Run after page load
 */

// initialize all plugins which needs to reinitialized after ajax
function laragramInit() {
    // tooltips popover
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    // owlcarousel2
    $('.owl-carousel').owlCarousel({
        items: 1,
        lazyLoad: true,
        nav: true,
        dots: false
    });

    // infinite scroll only in posts.index page
    if (window.user.currentPageRouteName === 'posts.index') {
        $('ul.pagination').hide();
        $(function () {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="d-flex justify-content-center mb-5"><img src="/images/loading.gif" alt="Loading..." /></div>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function () {
                    $('ul.pagination').remove();
                    laragramInit();
                }
            });
        });
    }
}
$.pjax.defaults.timeout = 3000;
$(document).pjax('[data-pjax] a, a[data-pjax]', '#app');

$(document).on('pjax:end', function() {
    laragramInit()
});

$(document).ready(function () {
    laragramInit();

    /**
     * check if user is logged in
     * if logged in then like, follow, comment
     * etc will be available
     */

    if (typeof window.user !== 'undefined') {
        if (window.user.isLoggedIn === true) {
            // like
            $(document).on('click', '.likeButton', function (e) {
                e.preventDefault();

                let postSlug = $(this).data('postSlug');
                let likeCount = $('#likeCount-' + postSlug);
                let _url = '/likes/' + postSlug;
                let _token = $('meta[name="csrf-token"]').attr('content');

                // change icon style
                $('#likeIcon-' + postSlug).toggleClass('far fas');

                $.ajax({
                    url: _url,
                    type: "POST",
                    data: {
                        _token: _token
                    },
                    success: function (data) {
                        let likes = data;
                        likeCount.text(likes.data.likers_count);
                        $.niceToast.success(likes.message);
                    },
                    error: function (response) {
                        $.niceToast.error(response.responseJSON.message);
                    }
                });
            });

            // follow
            $(document).on('click', '#followUnfollowButton', function (e) {
                e.preventDefault();

                // follow/unfollow text
                let followUnfollowButton = $('#followUnfollowButton');

                if (followUnfollowButton.text().trim() === 'Follow') {
                    followUnfollowButton.text('Unfollow');
                } else if (followUnfollowButton.text().trim() === 'Unfollow') {
                    followUnfollowButton.text('Follow');
                }

                let username = $(this).data('username');
                let _url = '/follows/' + username;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: _url,
                    type: "POST",
                    data: {
                        _token: _token
                    },
                    success: function (response) {
                        $('#followersCount').text(response.data.followers_count)

                        $.niceToast.success(response.message);
                    },
                    error: function (response) {
                        $.niceToast.error(response.responseJSON.message);
                    }
                });
            });

            // comment store
            $(document).on('keyup', '.commentTextarea', function (e) {
                e.preventDefault();

                if (e.keyCode === 13 && e.shiftKey) {
                    let postSlug = $(this).data('postSlug');
                    let comment = $('#comment-' + postSlug).val();
                    let _url = '/comments';
                    let _token = $('meta[name="csrf-token"]').attr('content');
                    let commentAppend = window.user.commentAppend;

                    $.ajax({
                        url: _url,
                        type: "POST",
                        data: {
                            post_slug: postSlug,
                            comment: comment,
                            _token: _token
                        },
                        success: function (data) {
                            if (commentAppend) {
                                $('#commentList-' + postSlug).append(data);
                            } else {
                                $('#commentList-' + postSlug).prepend(data);
                            }

                            $('#comment-' + postSlug).val('');

                            autosize.destroy(document.querySelectorAll('textarea'));

                            $.niceToast.success('Comment added successfully!');
                        },
                        error: function (response) {
                            $.niceToast.error(response.responseJSON.message);
                        }
                    });
                }
            });

            $(document).on('click', '.commentButton', function (e) {
                e.preventDefault();

                let postSlug = $(this).data('postSlug');
                let comment = $('#comment-' + postSlug).val();
                let _url = '/comments';
                let _token = $('meta[name="csrf-token"]').attr('content');
                let commentAppend = window.user.commentAppend;

                $.ajax({
                    url: _url,
                    type: "POST",
                    data: {
                        post_slug: postSlug,
                        comment: comment,
                        _token: _token
                    },
                    success: function (data) {
                        if (commentAppend) {
                            $('#commentList-' + postSlug).append(data);
                        } else {
                            $('#commentList-' + postSlug).prepend(data);
                        }

                        $('#comment-' + postSlug).val('');

                        autosize.destroy(document.querySelectorAll('textarea'));

                        $.niceToast.success('Comment added successfully!');
                    },
                    error: function (response) {
                        $.niceToast.error(response.responseJSON.message);
                    }
                });
            });

            // comment delete
            $(document).on('click', '.commentDeleteButton', function (e) {
                if (!confirm("Are you sure you want to delete?")) {
                    return false;
                }

                e.preventDefault();

                let commentId = $(this).data('commentId');
                let _url = '/comments/' + commentId;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: _url,
                    type: "DELETE",
                    data: {
                        _token: _token
                    },
                    success: function (data) {
                        let comment = data
                        $('#comment-' + commentId).remove();
                        $.niceToast.success(comment.message);
                    },
                    error: function (response) {
                        $.niceToast.error(response.responseJSON.message);
                    }
                });
            });
        }

        // footer copyright
        $(window).on('load', function () {
            let footerHtml = `<footer class="footer fixed-bottom bg-glass mt-auto py-2" id="footer">
                <div class="container-fluid d-flex justify-content-between">
                <div class="container">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Made with <i class="fa fa-heart text-danger"></i> and <a href="//laravel.com" target="_blank">Laravel</a>
                            by <a href="//github.com/itsrafsanjani" target="_blank">Md Rafsan Jani Rafin</a>.</span>
                        <span class="text-muted">Source code <a href="//github.com/itsrafsanjani/laravel-instagram-clone" target="_blank">
                                <i class="fab fa-github"></i> Github</a>.</span>
                    </div>
                </div>
                <span id="footerCloseButton" type="button"><i class="far fa-times-circle"></i></span>
                </div>
            </footer>`
            let footerCloseButton = localStorage.getItem('footerCloseButton');
            if (footerCloseButton != null) {
                let data = JSON.parse(footerCloseButton)
                let expectedDate = data.timestamp + (30 * 24 * 60 * 60 * 1000)
                let currentDate = Date.now()
                if (currentDate >= expectedDate) {
                    $('#app').append(footerHtml)
                }
            } else {
                $('#app').append(footerHtml)
            }

            $('#footerCloseButton').on('click', function () {

                $('#footer').hide()
                localStorage.setItem('footerCloseButton', JSON.stringify({
                    closed: true,
                    timestamp: Date.now()
                }));
            })
        })
    }
});
