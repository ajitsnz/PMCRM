!function(e){var t={};function n(r){if(t[r])return t[r].exports;var s=t[r]={i:r,l:!1,exports:{}};return e[r].call(s.exports,s,s.exports,n),s.l=!0,s.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var s in e)n.d(r,s,function(t){return e[t]}.bind(null,s));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=82)}({82:function(e,t,n){e.exports=n("syCH")},syCH:function(e,t,n){"use strict";$(document).on("click","a",(function(e){e.stopPropagation()})),$(document).on("click","#markAsDraft, #markAsSend ,#markAsOpen,#markAsRevised,#markAsDeclined,#markAsAccepted",(function(){var e=$(this).data("status");$.ajax({url:changeStatus,type:"put",data:{status:e},success:function(e){e.success&&(window.location.href=proposalId,displaySuccessMessage(e.message))},error:function(e){displayErrorMessage(e.responseJSON.message)}})})),$(document).on("click","#convertToInvoice",(function(){$.ajax({url:invoiceSaveUrl,type:"post",success:function(e){if(e.success){var t=e.data.id;window.location.href=invoiceUrl+"/"+t,displaySuccessMessage(e.message)}},error:function(e){displayErrorMessage(e.responseJSON.message)}})})),$(document).on("click","#convertToEstimate",(function(){$.ajax({url:estimateSaveUrl,type:"post",success:function(e){if(e.success){var t=e.data.id;window.location.href=estimateUrl+"/"+t,displaySuccessMessage(e.message)}},error:function(e){displayErrorMessage(e.responseJSON.message)}})}))}});