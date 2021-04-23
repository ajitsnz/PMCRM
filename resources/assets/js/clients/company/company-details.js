'use strict';

$(document).ready(function () {

    $('#currencyId').select2({
        width: '100%',
    });

    $('#languageId').select2({
        width: '100%',
    });

    $('#countryId').select2({
        width: '100%',
    });

    $(document).on('blur', '#website', function () {
        let website = $(this).val();
        if (isEmpty(website)) {
            $('#website').val('');
        } else {
            website = websiteURLConvert(website);
            $('#website').val(website);
        }
    });

    window.websiteURLConvert = function (website) {
        if (!~website.indexOf('http')) {
            website = 'http://' + website;
        }

        return website;
    };

});
