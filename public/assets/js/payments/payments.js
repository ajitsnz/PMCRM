!function(e){var t={};function n(r){if(t[r])return t[r].exports;var a=t[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)n.d(r,a,function(t){return e[t]}.bind(null,a));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=49)}({49:function(e,t,n){e.exports=n("smiP")},smiP:function(e,t,n){"use strict";$("#paymentsTbl").DataTable({oLanguage:{sEmptyTable:showNoDataMsg},processing:!0,serverSide:!0,order:[[2,"desc"]],ajax:{url:paymentUrl,data:function(e){e.owner_type=ownerType,e.owner_id=invoiceId}},columnDefs:[{targets:[4],orderable:!1,className:"text-center",width:"5%"},{targets:[0,2],width:"15%"},{targets:[3],className:"text-right",width:"15%"},{targets:"_all",defaultContent:"N/A"}],columns:[{data:"payment_mode.name",name:"payment_mode"},{data:function(e){var t=document.createElement("textarea");return t.innerHTML=e.note,""!=t.value?t.value:"N/A"},name:"note"},{data:function(e){return e},render:function(e){return moment(e.payment_date).format("Do MMM, Y h:mm A")},name:"payment_date"},{data:function(e){return'<i class="'+currentCurrencyClass+'"></i> '+getFormattedPrice(e.amount_received)+"</i>"},name:"amount_received"},{data:function(e){var t=[{id:e.id}];return prepareTemplateRender("#paymentActionTemplate",t)},name:"id"}]}),$(document).on("click",".delete-btn-payment",(function(e){var t=$(e.currentTarget).data("id");deleteItem(paymentUrl+t,"#paymentsTbl","Payment"),$("#addPayment").removeClass("disabled")}))}});