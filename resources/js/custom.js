/**
 * My Custom JS
 * Run after page load
 */
$(document).ready(function() {
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    var firebaseConfig = {
        apiKey: "AIzaSyAxPpkCArq0cVN89_FwaXkd5gACoCBGAts",
        authDomain: "laragram2.firebaseapp.com",
        projectId: "laragram2",
        storageBucket: "laragram2.appspot.com",
        messagingSenderId: "49536770108",
        appId: "1:49536770108:web:6ab2e2dd4593018182e339",
        measurementId: "G-705L5J2HZN"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();

    // nice-toast-js setup
    $.niceToast.setup({
        position: "top-right",
        timeout: 5000,
    });

    // tooltips popover
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    let lazyLoading = e => {
        $('.lazy').Lazy();
    }

    lazyLoading();

    // infinite scroll
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

                lazyLoading();
            }
        });
    });

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
        if (footerCloseButton != null ) {
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
            console.log('fixed footer closed')
            $('#footer').hide()
            localStorage.setItem('footerCloseButton', JSON.stringify({
                closed: true,
                timestamp: Date.now()
            }));
        })
    })
});
