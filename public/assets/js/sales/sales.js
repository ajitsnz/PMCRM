!function(e){var t={};function r(a){if(t[a])return t[a].exports;var n=t[a]={i:a,l:!1,exports:{}};return e[a].call(n.exports,n,n.exports,r),n.l=!0,n.exports}r.m=e,r.c=t,r.d=function(e,t,a){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(r.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)r.d(a,n,function(t){return e[t]}.bind(null,n));return a},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r(r.s=51)}({51:function(e,t,r){e.exports=r("jR7m")},jR7m:function(e,t,r){"use strict";function a(e){return function(e){if(Array.isArray(e))return n(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return n(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(r);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return n(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function n(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,a=new Array(t);r<t;r++)a[r]=e[r];return a}$(document).ready((function(){setTimeout((function(){$("#invoiceCurrencyId, #creditNoteCurrencyId, #proposalCurrencyId, #estimateCurrencyId").trigger("change")}),500),$(".tags-select-box").select2({width:"100%",placeholder:"   Select Tags",multiple:!0}),$(".tax-rates").select2({width:"100%",placeholder:"Select Tax",multiple:!0}),$(".payment-modes").select2({width:"100%",placeholder:"   Select Payment Mode",multiple:!0}),$(".status").select2({width:"100%",placeholder:"Select Status"}),$(".currency-select-box, .sale-agent-select-box, #customerSelectBox").select2({width:"100%",placeholder:"Select Customer"}),$("#addItemSelectBox").select2({width:"87%",placeholder:"Add Product"}),$("#billTaskSelectBox").select2({width:"87%",placeholder:"Bill Tasks"}),$("#recurringInvoiceSelect, #discountTypeSelect").select2(),window.renderOptions=function(){var e=$(".items-container>tr:last-child").find(".tax-rates");taxData.forEach((function(t){var r=new Option(t.tax_rate,t.id,!1,!1);e.select2({width:"100%",placeholder:"Select tax"}),e.append(r).trigger("change")}))},"undefined"!=typeof isCreate&&renderOptions(),$(document).on("click","#itemAddBtn",(function(e){e.preventDefault();var t=prepareTemplateRender("#invoiceItemTemplate");$(".items-container").append(t),$("#invoiceCurrencyId, #creditNoteCurrencyId, #proposalCurrencyId, #estimateCurrencyId").trigger("change"),renderOptions()})),$(document).on("change","#shippingAddressEnable",(function(){$(this).prop("checked"),$("#shippingAddressForm").slideToggle()})),$(document).on("click",".remove-invoice-item",(function(e){e.preventDefault(),$(this).parent().parent().remove(),calculateSubTotal()})),$(document).on("keyup",".qty",(function(){$(this).val($(this).val().replace(/[^0-9.]/g,"").replace(/(\..*)\./g,"$1"));var e=$(this).val(),t=removeCommas($(this).parent().next().find(".rate").val());calculateItemAmount(e,t,$(this)),calculateSubTotal(),$(".tax-rates").trigger("change")})),$(document).on("keyup",".rate",(function(){var e=removeCommas($(this).val()),t=0;""!=$(this).val()&&($(this).val(getFormattedPrice(e)),t=$(this).parent().prev().find(".qty").val()),calculateItemAmount(t,e,$(this)),calculateSubTotal(),$(".tax-rates").trigger("change")})),window.calculateItemAmount=function(e,t,r){var a=e*t;isNaN(a)||r.parent().siblings().children(".item-amount").text(getFormattedPrice(a))};var e=0;window.calculateSubTotal=function(){e=0,$(".items-container>tr").each((function(){var t=$(this).find(".item-amount").text();e+=parseFloat(removeCommas(t)),e=parseFloat(e)})),$("#subTotal").text(getFormattedPrice(e)),calculateFinalTotal(),checkDiscountType()&&$("#footerDiscount").trigger("change")},$(document).on("change","#discountTypeSelect",(function(){$("#footerDiscount").trigger("change"),0==$(this).val()?$("#footerDiscount").val(0):$("#footerDiscount").val(1)}));var t=1;$(document).on("change","#footerDiscount",(function(){if(checkDiscountType())return t=$(this).val(),$(".footer-discount-input").trigger("keyup"),!1;$(".footer-discount-input").val(0),$(".footer-discount-input").trigger("keyup")}));var r=0;$(document).on("keyup",".footer-discount-input",(function(){if(""!=$(this).val()){var a=$(this).val().replace(/[^0-9.]/g,"").replace(/(\..*)\./g,"$1");$(this).val(parseFloat(a))}else $(this).val(0);if(""===checkDiscountType()&&$(this).val()>0)alert("please select discount type first");else{prepareSelectedTaxes(),r=0;var n=checkDiscountType();if(1==n){if($(".footer-discount-numbers").text(getFormattedPrice(-$(this).val())),1==t){var o=$(this).val();o=o>100?100:o,$(this).val(o);var i=parseFloat(e)*parseFloat(o)/100;$(".footer-discount-numbers").text(getFormattedPrice(-i))}}else if(2==n){if($(".footer-discount-numbers").text(getFormattedPrice(-$(this).val())),1==t){var s=$(this).val();s=s>100?100:s,$(this).val(s),$(".footer-discount-numbers").text(getFormattedPrice(-(e+c)*s/100));var l=parseFloat(c)+parseFloat(e);l=l*parseFloat(s)/100,$(".footer-discount-numbers").text(getFormattedPrice(-l))}}else{$(".footer-discount-numbers").text(getFormattedPrice(-$(this).val())),$(this).val(0);var u=getSubTotalIncludingTaxes();$(".footer-discount-numbers").text(getFormattedPrice(u*parseFloat(-$(this).val())/100))}r=parseFloat(removeCommas($(".footer-discount-numbers").text())),prepareSelectedTaxes(),calculateFinalTotal()}})),window.getSubTotalWithDiscount=function(){return e+r},$(document).on("mousewheel","#adjustment",(function(){$(this).blur()}));var n=0;$(document).on("keyup","#adjustment",(function(){n=""==$(this).val()?0:$(this).val(),$(".adjustment-numbers").text(getFormattedPrice(n)),calculateFinalTotal()})),window.checkDiscountType=function(){var e=$("#discountTypeSelect").val();if(""!=e&&0==e&&($(".footer-discount-input").val(""),$("#footerDiscount").val(0),$(".fDiscount").hide()),1==e||2==e)return $(".fDiscount").show(),e};var o=[];$(document).on("change",".tax-rates",(function(){prepareSelectedTaxes(),checkDiscountType()&&$("#footerDiscount").trigger("change"),calculateFinalTotal()}));var i={items:[]};window.prepareSelectedTaxes=function(){o=[],i.items=[],$(".items-container>tr").each((function(){var e=[];$.each($(this).find(".tax-rates option:selected"),(function(){e.push($(this).text())})),o=[].concat(a(o),e);var t,r,n,c=removeCommas($(this).find(".item-amount").text());i.items.push((n=c,(r=e)in(t={})?Object.defineProperty(t,r,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[r]=n,t))})),o=Array.from(new Set(o)),renderTaxList()};var c=0,s=0;window.renderTaxList=function(){s=$(".footer-discount-input").val(),c=0,$("#taxesListTable").html("");1==checkDiscountType()&&getSubTotalWithDiscount();o.forEach((function(e){var t=0;i.items.forEach((function(r){$.each(r,(function(r,a){r.split(",").forEach((function(r){r==e&&(t=parseFloat(t)+parseFloat(a))}))}))}));var r=0;if(0==$("#discountTypeSelect").val())r=getFormattedPrice(parseFloat(t)*parseFloat(e)/100);else if(1==$("#discountTypeSelect").val()){var a=getFormattedPrice(parseFloat(t)*parseFloat(s)/100);r=getFormattedPrice((parseFloat(t)-parseFloat(a?removeCommas(a):0))*e/100)}else 2==$("#discountTypeSelect").val()&&(r=getFormattedPrice(parseFloat(t)*parseFloat(e)/100));c+=parseFloat(removeCommas(r));var n=prepareTemplateRender("#taxesList",[{tax_name:e,tax_rate:r}]);$("#taxesListTable").append(n)}))},window.getSubTotalIncludingTaxes=function(){return e-c},window.calculateFinalTotal=function(){var t=$("#discountTypeSelect").val();if(0==t)$(".total-numbers").text(getFormattedPrice(parseFloat(e)+parseFloat(c)+parseFloat(n)));else if(1==t){var a=getFormattedPrice(parseFloat(e)+parseFloat(c)+parseFloat(n)+parseFloat(r));$(".total-numbers").text(a)}else if(2==t){var o=parseFloat(c)+parseFloat(e);o+=parseFloat(r),$(".total-numbers").text(getFormattedPrice(o+parseFloat(n)))}},window.getCurrencyFormatted=function(e){return getFormattedPrice(e)},window.getAddressDetail=function(e){if("undefined"!=typeof editData&&editData){var t=[{street:e.find(".street").val(),city:e.find(".city").val(),state:e.find(".state").val(),country:e.find(".country").val(),zip_code:e.find(".zip-code").val()}];return prepareTemplateRender("#addressTemplate",t)}},window.createAddressDetail=function(e){if("undefined"!=typeof createData&&createData){var t=[{street:e.find(".street").val(),city:e.find(".city").val(),state:e.find(".state").val(),country:e.find(".country").val(),zip_code:e.find(".zip-code").val()}];return prepareTemplateRender("#createAddressTemplate",t)}},setTimeout((function(){$(".address-modal").trigger("hidden.bs.modal")}),100),setTimeout((function(){$("#addModal").trigger("hidden.bs.modal")}),100);var l={qty:"qty",hours:"hours",qtyHours:"qtyHours"};$("#qty, #hours, #qtyHours").on("change",(function(){var e=l[$(this).data("quantity-for")];$(this).data("quantity-for")===e&&$(this).prop("checked")&&$(".qtyHeader").text($(this).next().text())})),"undefined"!=typeof editData&&editData&&$("#qty, #hours, #qtyHours").trigger("change");var u={0:"fas fa-rupee-sign",1:"fas fa-dollar-sign",2:"fas fa-dollar-sign",3:"fas fa-euro-sign",4:"fas fa-yen-sign",5:"fas fa-pound-sign",6:"fas fa-dollar-sign"};$("#invoiceCurrencyId, #creditNoteCurrencyId, #proposalCurrencyId, #estimateCurrencyId").on("change input",(function(){var e=$(this).val();$(document).find("[data-set-currency-class='true']").attr("class",u[e])})),$(document).on("blur","#adjustment",(function(){var e=$(this).val();isEmpty(e)&&$("#adjustment").val("0")}))}))}});