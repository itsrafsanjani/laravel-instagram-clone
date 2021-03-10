/**
 * My Custom JS
 * Run after page load
 */
$(document).ready(function() {
    // tooltips popover
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    let likeBtn = e => {
        // like button
        $('.likeBtn')
            .css('cursor', 'pointer')
            .click(function () {
                $(this).toggleClass('far');
                $(this).toggleClass('fas');
            });
    }

    likeBtn();

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

                likeBtn();

                lazyLoading();
            }
        });
    });
});
