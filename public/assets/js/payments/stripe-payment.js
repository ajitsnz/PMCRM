!function(e){var n={};function t(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,t),o.l=!0,o.exports}t.m=e,t.c=n,t.d=function(e,n,r){t.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:r})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,n){if(1&n&&(e=t(e)),8&n)return e;if(4&n&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(t.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&n&&"string"!=typeof e)for(var o in e)t.d(r,o,function(n){return e[n]}.bind(null,o));return r},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},t.p="/",t(t.s=91)}({91:function(e,n,t){e.exports=t("QQRR")},QQRR:function(e,n,t){"use strict";$(document).ready((function(){$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$(document).on("click","#invoiceStripePayment",(function(){var e=this,n={invoiceId:invoiceID};$(this).html('<div class="spinner-border spinner-border-sm" role="status">\n<span class="sr-only">Loading...</span>\n</div>  Loading...'),$(this).addClass("disabled"),$.post(invoiceStripePaymentUrl,n).done((function(e){var n=e.data.sessionId;stripe.redirectToCheckout({sessionId:n}).then((function(e){manageAjaxErrors(e)}))})).catch((function(n){manageAjaxErrors(n),$(e).removeClass("disabled")}))}))}))}});