!function(e){var t={};function r(o){if(t[o])return t[o].exports;var n=t[o]={i:o,l:!1,exports:{}};return e[o].call(n.exports,n,n.exports,r),n.l=!0,n.exports}r.m=e,r.c=t,r.d=function(e,t,o){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(r.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)r.d(o,n,function(t){return e[t]}.bind(null,n));return o},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r(r.s=3)}({3:function(e,t,r){e.exports=r("k/L1")},"k/L1":function(e,t,r){"use strict";$(document).on("click",".addTagModal",(function(){$("#addModal").appendTo("body").modal("show")})),$(document).on("submit","#addNewForm",(function(e){e.preventDefault(),processingBtn("#addNewForm","#btnSave","loading");var t=""===$("<div />").html($("#createDescription").summernote("code")).text().trim().replace(/ \r\n\t/g,"");if($("#createDescription").summernote("isEmpty"))$("#createDescription").val("");else if(t)return displayErrorMessage("Description field is not contain only white space"),processingBtn("#addNewForm","#btnSave","reset"),!1;$.ajax({url:tagSaveUrl,type:"POST",data:$(this).serialize(),success:function(e){e.success&&(displaySuccessMessage(e.message),$("#addModal").modal("hide"),window.livewire.emit("refresh"))},error:function(e){displayErrorMessage(e.responseJSON.message)},complete:function(){processingBtn("#addNewForm","#btnSave")}})})),$(document).on("click",".edit-btn",(function(e){var t=$(e.currentTarget).data("id");renderData(t)})),window.renderData=function(e){$.ajax({url:tagUrl+e+"/edit",type:"GET",success:function(e){if(e.success){$("#tagId").val(e.data.id);var t=document.createElement("textarea");t.innerHTML=e.data.name,$("#editName").val(t.value),$("#editDescription").summernote("code",e.data.description),$("#editModal").appendTo("body").modal("show")}},error:function(e){displayErrorMessage(e.responseJSON.message)}})},$(document).on("submit","#editForm",(function(e){e.preventDefault(),processingBtn("#editForm","#btnEditSave","loading");var t=$("#tagId").val(),r=""===$("<div />").html($("#editDescription").summernote("code")).text().trim().replace(/ \r\n\t/g,"");if($("#editDescription").summernote("isEmpty"))$("#editDescription").val("");else if(r)return displayErrorMessage("Description field is not contain only white space"),processingBtn("#editForm","#btnEditSave","reset"),!1;$.ajax({url:tagUrl+t,type:"put",data:$(this).serialize(),success:function(e){e.success&&(displaySuccessMessage(e.message),$("#editModal").modal("hide"),window.livewire.emit("refresh"))},error:function(e){displayErrorMessage(e.responseJSON.message)},complete:function(){processingBtn("#editForm","#btnEditSave")}})})),$(document).on("click",".show-btn",(function(e){var t=$(e.currentTarget).attr("data-id");$.ajax({url:tagUrl+t,type:"GET",beforeSend:function(){startLoader()},complete:function(){stopLoader()},success:function(e){if(e.success){$("#showName").html(""),$("#showDescription").html("");var t=document.createElement("textarea");t.innerHTML=e.data.name,$("#showName").append(t.value);var r=document.createElement("textarea");r.innerHTML=e.data.description;var o=r.value;$("#showDescription").append(o||"N/A"),$("#showModal").appendTo("body").modal("show")}},error:function(e){displayErrorMessage(e.responseJSON.message)}})})),$(document).on("click",".delete-btn",(function(e){var t=$(e.currentTarget).data("id");deleteItemLivewire("deleteTag",t,"Tag")})),window.addEventListener("deleted",(function(e){livewireDeleteEventListener(e,"Tag")})),$("#addModal").on("show.bs.modal",(function(){$(".note-toolbar-wrapper").removeAttr("style"),$(".note-toolbar").removeAttr("style")})),$("#editModal").on("show.bs.modal",(function(){$(".note-toolbar-wrapper").removeAttr("style"),$(".note-toolbar").removeAttr("style")})),$("#addModal").on("hidden.bs.modal",(function(){resetModalForm("#addNewForm","#validationErrorsBox"),$("#createDescription").summernote("code","")})),$("#editModal").on("hidden.bs.modal",(function(){resetModalForm("#editForm","#editValidationErrorsBox")}))}});