!function(e){var t={};function n(a){if(t[a])return t[a].exports;var r=t[a]={i:a,l:!1,exports:{}};return e[a].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(a,r,function(t){return e[t]}.bind(null,r));return a},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=50)}({50:function(e,t,n){e.exports=n("MHUW")},MHUW:function(e,t,n){"use strict";$(document).ready((function(){$("#paymentMode").select2({width:"100%"}),$("#paymentDate").datetimepicker({format:"YYYY-MM-DD HH:mm:ss",useCurrent:!0,sideBySide:!0,icons:{up:"fa fa-chevron-up",down:"fa fa-chevron-down",next:"fa fa-chevron-right",previous:"fa fa-chevron-left"}}),$(document).on("click","#addPayment",(function(e){var t=$(e.currentTarget).data("id");renderData(t)})),$("#note").summernote({dialogsInBody:!0,minHeight:150,toolbar:[["style",["bold","italic","underline","clear"]],["font",["strikethrough"]],["para",["paragraph"]]]}),window.renderData=function(e){$.ajax({url:addPaymentUrl,type:"GET",data:{invoice_id:e},success:function(e){e.success&&($("#paymentOwnerId").val(e.data.id),$("#paymentAmount").val(getFormattedPrice(e.data.amount)),$("#paymentDate").val(format(e.data.date,"YYYY-MM-DD HH:mm:ss")),$("#addPaymentModal").appendTo("body").modal("show"))},error:function(e){displayErrorMessage(e.responseJSON.message)}})},$(document).on("submit","#addNewPaymentForm",(function(e){e.preventDefault(),processingBtn("#addNewPaymentForm","#btnPaymentSave","loading"),$.ajax({url:paymentSaveUrl,type:"POST",data:$(this).serialize(),success:function(e){e.success&&(displaySuccessMessage(e.message),$("#addPaymentModal").modal("hide"),$("#paymentsTbl").DataTable().ajax.reload(null,!0),window.location.href=invoiceUrl+"/"+invoiceId)},error:function(e){displayErrorMessage(e.responseJSON.message)},complete:function(){processingBtn("#addNewPaymentForm","#btnPaymentSave")}})}))})),$("#addPaymentModal").on("show.bs.modal",(function(){$(".note-toolbar-wrapper").removeAttr("style"),$(".note-toolbar").removeAttr("style")}))}});