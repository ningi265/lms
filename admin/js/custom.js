/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/** ******  left menu  *********************** **/
$(function () {
    $('#sidebar-menu li ul').slideUp();
    $('#sidebar-menu li').removeClass('active');

    $('#sidebar-menu li').click(function () {
        if ($(this).is('.active')) {
            $(this).removeClass('active');
            $('ul', this).slideUp();
            $(this).removeClass('nv');
            $(this).addClass('vn');
        } else {
            $('#sidebar-menu li ul').slideUp();
            $(this).removeClass('vn');
            $(this).addClass('nv');
            $('ul', this).slideDown();
            $('#sidebar-menu li').removeClass('active');
            $(this).addClass('active');
        }
    });

    $('#menu_toggle').click(function (e) {
        e.preventDefault();
        console.log('Menu toggle clicked');
        var MOBILE_BREAKPOINT = 991;
        var isMobile = $(window).width() <= MOBILE_BREAKPOINT;
        console.log('Is mobile:', isMobile, 'Window width:', $(window).width());
        
        if (isMobile) {
            // Mobile: toggle overlay menu
            $('body').toggleClass('menu-open');
            console.log('Mobile menu toggled, menu-open:', $('body').hasClass('menu-open'));
            if ($('body').hasClass('menu-open')) {
                $('.left_col').show().css({
                    'display': 'block',
                    'position': 'fixed',
                    'top': '50px',
                    'left': '0',
                    'bottom': '0',
                    'width': '230px',
                    'z-index': '2000'
                });
            } else {
                $('.left_col').hide();
            }
        } else {
            // Desktop: toggle between nav-md and nav-sm
            console.log('Desktop mode - Current body classes:', $('body').attr('class'));
            if ($('body').hasClass('nav-md')) {
                console.log('Collapsing to nav-sm');
                $('body').removeClass('nav-md').addClass('nav-sm');
                $('.col-md-3.left_col').removeClass('scroll-view').removeAttr('style');
                $('.sidebar-footer').hide();

                if ($('#sidebar-menu li').hasClass('active')) {
                    $('#sidebar-menu li.active').addClass('active-sm').removeClass('active');
                }
            } else {
                console.log('Expanding to nav-md');
                $('body').removeClass('nav-sm').addClass('nav-md');
                $('.col-md-3.left_col').addClass('scroll-view');
                $('.sidebar-footer').show();

                if ($('#sidebar-menu li').hasClass('active-sm')) {
                    $('#sidebar-menu li.active-sm').addClass('active').removeClass('active-sm');
                }
            }
            console.log('After toggle - Body classes:', $('body').attr('class'));
            console.log('Left col classes:', $('.left_col').attr('class'));
        }
    });
});

/* Sidebar Menu active class */
$(function () {
    var url = window.location;
    $('#sidebar-menu a[href="' + url + '"]').parent('li').addClass('current-page');
    $('#sidebar-menu a').filter(function () {
        return this.href == url;
    }).parent('li').addClass('current-page').parent('ul').slideDown().parent().addClass('active');
});

/** ******  /left menu  *********************** **/



/** ******  tooltip  *********************** **/
$(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    /** ******  /tooltip  *********************** **/
    /** ******  progressbar  *********************** **/
if ($(".progress .progress-bar")[0]) {
    $('.progress .progress-bar').progressbar(); // bootstrap 3
}
/** ******  /progressbar  *********************** **/
/** ******  switchery  *********************** **/
if ($(".js-switch")[0]) {
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elems.forEach(function (html) {
        var switchery = new Switchery(html, {
            color: '#26B99A'
        });
    });
}
/** ******  /switcher  *********************** **/
/** ******  collapse panel  *********************** **/
// Close ibox function
$('.close-link').click(function () {
    var content = $(this).closest('div.x_panel');
    content.remove();
});

// Collapse ibox function
$('.collapse-link').click(function () {
    var x_panel = $(this).closest('div.x_panel');
    var button = $(this).find('i');
    var content = x_panel.find('div.x_content');
    content.slideToggle(200);
    (x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
    (x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
    button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
    setTimeout(function () {
        x_panel.resize();
    }, 50);
});
/** ******  /collapse panel  *********************** **/
/** ******  iswitch  *********************** **/
if ($("input.flat")[0]) {
    $(document).ready(function () {
        $('input.flat').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    });
}
/** ******  /iswitch  *********************** **/
/** ******  star rating  *********************** **/
// Starrr plugin (https://github.com/dobtco/starrr)
var __slice = [].slice;

(function ($, window) {
    var Starrr;

    Starrr = (function () {
        Starrr.prototype.defaults = {
            rating: void 0,
            numStars: 5,
            change: function (e, value) {}
        };

        function Starrr($el, options) {
            var i, _, _ref,
                _this = this;

            this.options = $.extend({}, this.defaults, options);
            this.$el = $el;
            _ref = this.defaults;
            for (i in _ref) {
                _ = _ref[i];
                if (this.$el.data(i) != null) {
                    this.options[i] = this.$el.data(i);
                }
            }
            this.createStars();
            this.syncRating();
            this.$el.on('mouseover.starrr', 'span', function (e) {
                return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
            });
            this.$el.on('mouseout.starrr', function () {
                return _this.syncRating();
            });
            this.$el.on('click.starrr', 'span', function (e) {
                return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
            });
            this.$el.on('starrr:change', this.options.change);
        }

        Starrr.prototype.createStars = function () {
            var _i, _ref, _results;

            _results = [];
            for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
                _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
            }
            return _results;
        };

        Starrr.prototype.setRating = function (rating) {
            if (this.options.rating === rating) {
                rating = void 0;
            }
            this.options.rating = rating;
            this.syncRating();
            return this.$el.trigger('starrr:change', rating);
        };

        Starrr.prototype.syncRating = function (rating) {
            var i, _i, _j, _ref;

            rating || (rating = this.options.rating);
            if (rating) {
                for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
                    this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
                }
            }
            if (rating && rating < 5) {
                for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
                    this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
                }
            }
            if (!rating) {
                return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
            }
        };

        return Starrr;

    })();
    return $.fn.extend({
        starrr: function () {
            var args, option;

            option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
            return this.each(function () {
                var data;

                data = $(this).data('star-rating');
                if (!data) {
                    $(this).data('star-rating', (data = new Starrr($(this), option)));
                }
                if (typeof option === 'string') {
                    return data[option].apply(data, args);
                }
            });
        }
    });
})(window.jQuery, window);

$(function () {
    return $(".starrr").starrr();
});

$(document).ready(function () {

    $('#stars').on('starrr:change', function (e, value) {
        $('#count').html(value);
    });


    $('#stars-existing').on('starrr:change', function (e, value) {
        $('#count-existing').html(value);
    });

});
/** ******  /star rating  *********************** **/
/** ******  table  *********************** **/
$('table input').on('ifChecked', function () {
    check_state = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('table input').on('ifUnchecked', function () {
    check_state = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});

var check_state = '';
$('.bulk_action input').on('ifChecked', function () {
    check_state = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('.bulk_action input').on('ifUnchecked', function () {
    check_state = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});
$('.bulk_action input#check-all').on('ifChecked', function () {
    check_state = 'check_all';
    countChecked();
});
$('.bulk_action input#check-all').on('ifUnchecked', function () {
    check_state = 'uncheck_all';
    countChecked();
});

function countChecked() {
        if (check_state == 'check_all') {
            $(".bulk_action input[name='table_records']").iCheck('check');
        }
        if (check_state == 'uncheck_all') {
            $(".bulk_action input[name='table_records']").iCheck('uncheck');
        }
        var n = $(".bulk_action input[name='table_records']:checked").length;
        if (n > 0) {
            $('.column-title').hide();
            $('.bulk-actions').show();
            $('.action-cnt').html(n + ' Records Selected');
        } else {
            $('.column-title').show();
            $('.bulk-actions').hide();
        }
    }
    /** ******  /table  *********************** **/
    /** ******    *********************** **/
    /** ******    *********************** **/
    /** ******    *********************** **/
    /** ******    *********************** **/
    /** ******    *********************** **/
    /** ******    *********************** **/
    /** ******  Accordion  *********************** **/

$(function () {
    $(".expand").on("click", function () {
        $(this).next().slideToggle(200);
        $expand = $(this).find(">:first-child");

        if ($expand.text() == "+") {
            $expand.text("-");
        } else {
            $expand.text("+");
        }
    });
});

/** ******  Accordion  *********************** **/
/** ******  scrollview  *********************** **/
$(document).ready(function () {
  
            $(".scroll-view").niceScroll({
                touchbehavior: true,
                cursorcolor: "rgba(42, 63, 84, 0.35)"
            });

});
/** ******  /scrollview  *********************** **/

// custom.js - Sidebar toggle functionality
$(document).ready(function() {
    // Sidebar toggle functionality
    $('#menu_toggle').click(function() {
        const $body = $('body');
        const $mainContainer = $('.main_container');
        
        if ($body.hasClass('nav-sm')) {
            // If sidebar is collapsed, expand it
            $body.removeClass('nav-sm');
            $mainContainer.removeClass('nav-sm');
            // Store the state in localStorage
            localStorage.setItem('sidebarState', 'expanded');
        } else {
            // If sidebar is expanded, collapse it
            $body.addClass('nav-sm');
            $mainContainer.addClass('nav-sm');
            // Store the state in localStorage
            localStorage.setItem('sidebarState', 'collapsed');
        }
    });
    
    // Check and apply saved sidebar state on page load
    function applySavedSidebarState() {
        const savedState = localStorage.getItem('sidebarState');
        const $body = $('body');
        const $mainContainer = $('.main_container');
        
        if (savedState === 'collapsed') {
            $body.addClass('nav-sm');
            $mainContainer.addClass('nav-sm');
        } else {
            $body.removeClass('nav-sm');
            $mainContainer.removeClass('nav-sm');
        }
    }
    
    // Apply saved state when page loads
    applySavedSidebarState();
    
    // Also handle window resize for responsive behavior
    $(window).resize(function() {
        if ($(window).width() < 768) {
            $('body').addClass('nav-sm');
            $('.main_container').addClass('nav-sm');
        } else {
            // On larger screens, apply saved state
            applySavedSidebarState();
        }
    });
    
    // Initialize on page load for responsive
    if ($(window).width() < 768) {
        $('body').addClass('nav-sm');
        $('.main_container').addClass('nav-sm');
    }
});