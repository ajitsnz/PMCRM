'use strict';

// Search Front Side Article 
$(document).on('keyup', '#searchArticle', function () {
    let searchData = $(this).val();
    if (searchData != '') {
        $.ajax({
            url: articleSearchUrl,
            type: 'GET',
            data: { searchData: searchData },
            success: function (result) {
                $('#articles').html(result);
            },
            error: function (result) {
                manageAjaxErrors(result.responseJSON.message);
            },
        });
    }
}); 
