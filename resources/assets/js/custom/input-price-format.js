'use strict';

import AutoNumeric from 'autonumeric';

window.setPrice = function (selector, price) {
    if (price != '' || price > 0) {
        if (typeof price !== 'number') {
            price = price.replace(/,/g, '');
        }
        let formattedPrice = addCommas(price);
        $(selector).val(formattedPrice);
    }
};

window.addCommas = function (nStr) {
    nStr += '';
    let x = nStr.split('.');
    let x1 = x[0];
    let x2 = x.length > 1 ? '.' + x[1] : '';
    let rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
};

window.getFormattedPrice = function(price) {
    if(price != '' || price > 0) {
        if(typeof price !== 'number') {
            price = price.replace(/,/g, '');
        }
        return addCommas(price);
    }
};

window.priceFormatSelector = function (selector) {
    new AutoNumeric(selector, {
        styleRules:
        AutoNumeric.options.styleRules.positiveNegative,
        formatOnPageLoad: true,
    });
};

window.removeCommas = function (str) {
    return str.replace(/,/g, '');
};

if ($('.price-input').length > 0) {
    priceFormatSelector('.price-input');
}

