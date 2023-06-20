import './bootstrap';
import './plugins/jquery.jscroll.min';
import 'owl.carousel';
import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel/dist/assets/owl.theme.default.min.css';
import 'moment';
import 'jquery-pjax';

import autosize from 'autosize';
import ClipboardJS from 'clipboard';
import { initializeApp } from 'firebase/app';
import { getAnalytics } from "firebase/analytics";
import NProgress from 'nprogress';

import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
import '../sass/app.scss';

// If you are using JavaScript/ECMAScript modules:
import Dropzone from "dropzone";
import "dropzone/dist/dropzone.css";
window.Dropzone = Dropzone;

// Create an instance of Notyf
const notyf = new Notyf({
    position: {
        x: 'right',
        y: 'top',
    },
    dismissible: true,
});

// NProgress
$(document).on('pjax:start', function () {
    NProgress.start();
});
$(document).on('pjax:end', function () {
    NProgress.done();
});

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
    if (window.user !== undefined && window.user.currentPageRouteName === 'posts.index') {
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

    // posts.create image preview
    let preview = $("#preview");
    $('#image').on('change', function () {
        preview.html('');
        for (let i = 0; i < $(this)[0].files.length; i++) {
            preview.append(
                `<div class="col-md-6">
                    <img src="${window.URL.createObjectURL(this.files[i])}" class="img-thumbnail my-3" alt="image"/>
                </div>`
            );
        }
    });

    // send coins modal form
    $('#amount').on('input', function () {
        let amount = parseInt($(this).val());
        let balance = parseInt($('#balance').val());
        let new_balance = balance - amount;
        if(amount > balance || amount < 1) {
            $('#sendCoinsButton').attr('disabled', true);
        } else {
            $('#sendCoinsButton').removeAttr('disabled');
        }
        $('#new_balance').val(new_balance);
    });
}
// PJAX
$.pjax.defaults.timeout = 5000;
$(document).pjax('[data-pjax] a, a[data-pjax]', '#app');

$(document).on('pjax:end', function () {
    laragramInit()
});

// document ready
$(function () {
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
                    success: function ({ data }) {
                        likeCount.text(data.likers_count);
                        // notyf.success(data.message);
                    },
                    error: function (response) {
                        notyf.error(response.responseJSON.message);
                    }
                });
            });

            // follow/unfollow
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
                    success: function ({ data }) {
                        $('#followersCount').text(data.followers_count)

                        // notyf.success(data.message);
                    },
                    error: function (response) {
                        notyf.error(response.responseJSON.message);
                    }
                });
            });

            // comment store
            $(document).on('keyup', '.commentTextarea', function (e) {
                e.preventDefault();

                let postSlug = $(this).data('postSlug');
                let comment = $('#comment-' + postSlug).val();

                comment = comment.trim();
                if (comment.length > 0) {
                    $('.commentButton').removeAttr('disabled');
                    if (e.keyCode === 13 && !e.shiftKey) {
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

                                $('.commentButton').attr('disabled', 'disabled');

                                notyf.success('Comment added successfully!');
                            },
                            error: function (response) {
                                notyf.error(response.responseJSON.message);
                            }
                        });
                    }
                } else {
                    $('.commentButton').attr('disabled', 'disabled');
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

                        $('.commentButton').attr('disabled', 'disabled');

                        notyf.success('Comment added successfully!');
                    },
                    error: function (response) {
                        notyf.error(response.responseJSON.message);
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
                        $('#comment-' + commentId).remove();
                        notyf.success(data.message);
                    },
                    error: function (response) {
                        notyf.error(response.responseJSON.message);
                    }
                });
            });

            // bioCharacterCountBadge
            $(document).on('input', '#bio', function (e) {
                e.preventDefault();

                let bio = $('#bio').val();
                let currentCount = $('#currentCount');
                let bioCharacterCountBadge = $('#bioCharacterCountBadge');

                currentCount.text(bio.length);

                if (bio.length > 150) {
                    bioCharacterCountBadge.addClass('text-danger');
                } else {
                    bioCharacterCountBadge.removeClass('text-danger');
                }
            });
        }

        // footer copyright
        $(window).on('load', function () {
            let footerHtml = `<footer class="footer fixed-bottom bg-glass mt-auto py-2" id="footer">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="container">
                    <div class="d-md-flex text-center justify-content-between">
                        <span class="text-muted d-md-block d-none">Made with <i class="fa fa-heart text-danger"></i> and <a href="//laravel.com" target="_blank">Laravel</a> by <a href="${import.meta.env.VITE_GITHUB_PROFILE_LINK}" target="_blank">Md Rafsan Jani Rafin</a>.</span>
                        <span class="d-md-none d-block">
                            <span class="text-muted">Made with <i class="fa fa-heart text-danger"></i> and <a href="//laravel.com" target="_blank">Laravel</a></span><br>
                            <span>by <a href="${import.meta.env.VITE_GITHUB_PROFILE_LINK}" target="_blank">Md Rafsan Jani Rafin</a>.</span>
                        </span>
                        <span class="text-muted">Source code <a href="${import.meta.env.VITE_GITHUB_REPO_LINK}" target="_blank">
                                <i class="fab fa-github"></i> Github</a>.</span>
                    </div>
                </div>
                <span id="footerCloseButton" type="button"><i class="far fa-times-circle"></i></span>
                </div>
            </footer>`
            let footerCloseButton = localStorage.getItem('footerCloseButton');
            if (footerCloseButton != null) {
                let data = JSON.parse(footerCloseButton)
                let expectedDate = data.timestamp + (30 * 24 * 60 * 60 * 1000) // 30 days
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

                notyf.success('Footnote hidden for 30 days!');
            })
        })

        if (window.user.notification !== null) {
            if (window.user.notification.type === 'success') {
                notyf.success(window.user.notification.message)
            } else {
                notyf.error(window.user.notification.message)
            }
        }
    }
});
