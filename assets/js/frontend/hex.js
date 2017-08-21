var app = (function($) {
    var $window = $(window),
        $document = $(document),
        body = $('body'),
        isMobile = body.hasClass('mobile'),

        stickyToggle = function(sticky, stickyWrapper, scrollElement) {
            var stickyHeight = sticky.outerHeight();
            var stickyTop = stickyWrapper.offset().top;
            if (scrollElement.scrollTop() >= stickyTop) {
                stickyWrapper.height(stickyHeight);
                sticky.addClass("is-sticky");
            } else {
                sticky.removeClass("is-sticky");
                stickyWrapper.height('auto');
            }
        },

        base = function() {

            $('a[href="#"]').on('click', function(event) {
                event.preventDefault();
            });
            $('#backToTop').click(function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 500);
            });
            $("a[href*='#']:not([data-toggle],.panel-toggle)").on('click', function(event) {
                if ($(this).prop("href").indexOf(window.location.pathname) > -1) {
                    var hash = $(this).prop("hash");
                    if ($(hash).length) {
                        event.preventDefault();
                        var ypos = $(hash).offset().top - ($('#header').height() + $('.navbar.sticky').height());
                        $('html,body').animate({ scrollTop: ypos }, 300);
                        $('.panel').removeClass('expanded');
                    }
                }
            });

            // Find all data-toggle="sticky-onscroll" elements
            $('[data-toggle="sticky-onscroll"]').each(function() {
                var sticky = $(this);
                var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
                sticky.before(stickyWrapper);
                sticky.addClass('sticky');

                // Scroll & resize events
                $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function() {
                    stickyToggle(sticky, stickyWrapper, $(this));
                });

                // On page load
                stickyToggle(sticky, stickyWrapper, $(window));
            });

        },

        panels = function() {
            $('.sitepanel-toggle').on('click', function(e) {
                e.preventDefault();

                var $this = $(this),
                    $targetID = '#' + $this.data('toggle'),
                    $target = $($targetID);

                $('.sitepanel:not(' + $targetID + ')').removeClass('expanded');
                $target.toggleClass('expanded');

                //body scrolling
                $('body,html')
                    .toggleClass('noscroll', $target.is('.expanded'))
                    .toggleClass('panel-expanded', $target.is('.expanded'));

                //close search
                $('#site-header-search').slideUp(200);
            });

            $('.sitepanel-menu')
                .on('click', 'li a', function(event) {
                    // $('.sitepanel-menu').removeClass('expanded');
                })
                .on('click', '.menu-item-has-children > a', function(event) {
                    var dd = $(this).closest('.menu-item-has-children');
                    event.preventDefault();
                    dd.toggleClass('open');
                });
        };

    return {
        init: function() {
            base();
            panels();
        }
    };

})(jQuery);

jQuery(document).ready(app.init);