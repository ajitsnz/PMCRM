!function(e){var t={};function r(o){if(t[o])return t[o].exports;var i=t[o]={i:o,l:!1,exports:{}};return e[o].call(i.exports,i,i.exports,r),i.l=!0,i.exports}r.m=e,r.c=t,r.d=function(e,t,o){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(r.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)r.d(o,i,function(t){return e[t]}.bind(null,i));return o},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r(r.s=10)}({10:function(e,t,r){e.exports=r("H0FQ")},H0FQ:function(e,t,r){"use strict";$(document).ready((function(){$("#filter_status").select2({width:"150px"})})),$(document).on("change","#filter_status",(function(){window.livewire.emit("filterStatus",$(this).val())})),$(document).on("click",".addTicketPriorityModal",(function(){$("#addModal").appendTo("body").modal("show")})),$(document).on("submit","#addNewForm",(function(e){e.preventDefault(),processingBtn("#addNewForm","#btnSave","loading"),$.ajax({url:ticketPrioritySaveUrl,type:"POST",data:$(this).serialize(),success:function(e){e.success&&(displaySuccessMessage(e.message),$("#addModal").modal("hide"),window.livewire.emit("refresh"))},error:function(e){displayErrorMessage(e.responseJSON.message)},complete:function(){processingBtn("#addNewForm","#btnSave")}})})),$(document).on("click",".edit-btn",(function(e){var t=$(e.currentTarget).data("id");renderData(t)})),window.renderData=function(e){$.ajax({url:ticketPriorityUrl+e+"/edit",type:"GET",success:function(e){if(e.success){$("#ticketPriorityId").val(e.data.id);var t=document.createElement("textarea");t.innerHTML=e.data.name,$("#editName").val(t.value),e.data.status&&$("#editStatus").prop("checked",!0),$("#editModal").appendTo("body").modal("show")}},error:function(e){displayErrorMessage(e.responseJSON.message)}})},$(document).on("submit","#editForm",(function(e){e.preventDefault(),processingBtn("#editForm","#btnEditSave","loading");var t=$("#ticketPriorityId").val();$.ajax({url:ticketPriorityUrl+t,type:"put",data:$(this).serialize(),success:function(e){e.success&&(displaySuccessMessage(e.message),$("#editModal").modal("hide"),window.livewire.emit("refresh"))},error:function(e){displayErrorMessage(e.responseJSON.message)},complete:function(){processingBtn("#editForm","#btnEditSave")}})})),$(document).on("click",".delete-btn",(function(){var e=$(this).attr("data-id");deleteItemLiveWire(ticketPriorityUrl+e,"Ticket Priority")})),$(document).on("change",".status",(function(e){var t=$(e.currentTarget).data("id");activeDeActiveCategory(t)})),window.activeDeActiveCategory=function(e){$.ajax({url:ticketPriorityUrl+e+"/active-deactive",method:"post",cache:!1,beforeSend:function(){startLoader()},success:function(e){e.success&&window.livewire.emit("refresh")},complete:function(){stopLoader()}})},$("#addModal").on("hidden.bs.modal",(function(){resetModalForm("#addNewForm","#validationErrorsBox")})),$("#editModal").on("hidden.bs.modal",(function(){resetModalForm("#editForm","#editValidationErrorsBox")}))}});