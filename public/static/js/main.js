/*******************************************************************************

    Title :  Sabilulungan
    Date  :  November 2013
    Author:  Suitmedia (http://www.suitmedia.com)

********************************************************************************/



var Site = {

    init: function() {
        Site.alertBarToggle();
        Site.navSubToggle();
        Site.featuredCategoryTab();
        Site.fancyBoxPopup();
        Site.addPhotoField();
        Site.addDanaField();
        Site.addLpjField();
        Site.addVideoField();
        Site.customPlaceholder();
        Site.datePicker();
        // Site.customSelect();
    },

    /**
     * Alert Toggle
     */
    alertBarToggle: function() {
        setTimeout(function() {
            $('.alert-bar').fadeOut(500);
        }, 3000);
    },

    /**
     * Nav Sub Toggle
     */
    navSubToggle: function() {
        var navToggle = function elToggle(elShow, event) {
            event.preventDefault();
            elShow.toggle();
        };

        var $navSub    = $('.nav-sub-panel'),
            $navUser   = $('.nav-user-panel');

        $('.btn-user').on('click', function(event) {
            navToggle($navUser, event);
        });

        $('.header-main').click(function(event) {
            event.stopPropagation();
        });

        $(document).click(function() {
            $navSub.hide();
        });
    },

    /**
     * Featured Category tab
     */
    featuredCategoryTab: function() {
        var $tabNav = $('.featured-category-tab-nav'),
            $tabNavList = $tabNav.find('li'),
            $tabPanel = $('.featured-category-tab-panel');

        $tabPanel.hide();
        $tabNavList.first().addClass('active').show();
        $tabPanel.first().show();

        $tabNavList.click(function(event) {
            event.preventDefault();
            $tabNavList.removeClass('active');
            $(this).addClass('active');
            $tabPanel.hide();

            var activeTab = $(this).find('a').attr('href');
            console.log(activeTab);
            $(activeTab).show();
        });
    },

    /**
     * Fancybox Popup
     */
    fancyBoxPopup: function() {
        // Gallery Popup
        $('.gallery-popup').fancybox();

        // $(".various").fancybox({
        //     maxWidth    : 800,
        //     maxHeight   : 600,
        //     fitToView   : false,
        //     width       : '70%',
        //     height      : '70%',
        //     autoSize    : false,
        //     closeClick  : false,
        //     openEffect  : 'none',
        //     closeEffect : 'none'
        // });

        // After Registration Callback
        $('.btn-register').fancybox({
            closeBtn: false,
            closeClick: true,
            padding: 0
        });

        $('body').on('click', '.btn-close', function(event) {
            event.preventDefault();
            $.fancybox.close();
        });
    },

    /**
     * Add Photo Field
     */
    addPhotoField: function() {
        $('.control-group').on('click', '.link', function(event) {
            event.preventDefault();
            var $content = $('<div class="controls file"> <input type="file" name="foto[]"> </div>');
            $content.insertBefore($(this));
        });
    },

    addDanaField: function() {
        $('.control-group').on('click', '.dana', function(event) {
            event.preventDefault();
            var $content = $('<div class="controls file"><input type="text" name="deskripsi[]" placeholder="Deskripsi"><input type="number" name="jumlah[]" placeholder="Jumlah"></div>');
            $content.insertBefore($(this));
        });
    },

    addLpjField: function() {
        $('.control-group').on('click', '.lpj', function(event) {
            event.preventDefault();
            var $content = $('<div class="controls file"> <input type="file" name="foto[]"> <input type="text" name="deskripsi[]" placeholder="Deskripsi"> </div>');
            $content.insertBefore($(this));
        });
    },

    addVideoField: function() {
        $('.control-group').on('click', '.video', function(event) {
            event.preventDefault();
            var $content = $('<div class="controls file"> <input type="text" name="video[]" placeholder="Youtube URL"> </div>');
            $content.insertBefore($(this));
        });
    },

    /**
     * Custom placeholder
     */
    customPlaceholder: function() {
        if (!Modernizr.input.placeholder) {
            $('[placeholder]').focus(function() {
                var input = $(this);
                if (input.val() === input.attr('placeholder')) {
                    input.val('');
                    input.removeClass('placeholder');
                }
            }).blur(function() {
                var input = $(this);
                if (input.val() === '' || input.val() === input.attr('placeholder')) {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            }).blur();
            $('[placeholder]').parents('form').submit(function() {
                $(this).find('[placeholder]').each(function() {
                    var input = $(this);
                    if (input.val() === input.attr('placeholder')) {
                        input.val('');
                    }
                });
            });
        }
    },

    /**
     *  Datepicker
     */
    datePicker: function() {
        $('#datepicker-from').Zebra_DatePicker({
            format: 'Y',
            view: 'years'
            // direction: true,
            // pair: $('#datepicker-to')
        });

        $('#datepicker-to').Zebra_DatePicker({
            format: 'Y',
            view: 'years'
            // direction: 1
        });

        $('#datepicker-tgl').Zebra_DatePicker({
            // direction: 1
        });

        $('#datepicker-tgl1').Zebra_DatePicker({
            // direction: 1
        });

        $('#datepicker-tgl2').Zebra_DatePicker({
            // direction: 1
        });

        $('#datepicker-tgl3').Zebra_DatePicker({
            // direction: 1
        });

        $('#datepicker-tgl4').Zebra_DatePicker({
            // direction: 1
        });

        $('#datepicker-tgl5').Zebra_DatePicker({
            // direction: 1
        });

        $('#datepicker-tgl6').Zebra_DatePicker({
            // direction: 1
        });

        $('#datepicker-tgl7').Zebra_DatePicker({
            // direction: 1
        });
    },

    /**
     *  Custom Select
     */
    customSelect: function() {
        $('.custom-select').chosen();
    }
};

$(function() {
    'use strict';
    Site.init();
});

