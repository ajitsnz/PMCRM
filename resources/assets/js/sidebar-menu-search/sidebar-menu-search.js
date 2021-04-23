'use strict';

$(document).ready(function () {
    let $block = $('.no-results');

    $(document).on('keyup', '#searchText', function () {
        let searchText = $(this).val();
        let isMatch = false;

        let value = this.value.toLowerCase().trim();
        $(document).on('click', '.close-sign', function () {
            $('#searchText').val('');
            $('.side-menus').show().filter(function () {
                if (searchText != '') {
                    $(this).removeClass('active');
                }
            });
            $('.close-sign').hide();
            $('.search-sign').show();
            $('.no-results').css('display', 'none');
            toggleSubMenu();
        });

        $('.side-menus').show().filter(function () {
            $(this).addClass('active');
            if (searchText == '') {
                $(this).removeClass('active');
                $('.close-sign').hide();
                $('.search-sign').show();
                toggleSubMenu();
            }
            if ($(this).text().toLowerCase().trim().indexOf(value) == -1) {
                $(this).hide();
                $('.close-sign').show();
                $('.search-sign').hide();
            } else {
                isMatch = true;
                $(this).show();
            }
        });
        $block.toggle(!isMatch);
    });

    window.toggleSubMenu = function () {
        let hasClassNames = $(document).find('.side-menus');
        if (hasClassNames.hasClass('dropdown-menu'))
            $('.dropdown-menu').css('display', 'none');
    };
});
