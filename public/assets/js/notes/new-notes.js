!function(e){var n={};function t(o){if(n[o])return n[o].exports;var s=n[o]={i:o,l:!1,exports:{}};return e[o].call(s.exports,s,s.exports,t),s.l=!0,s.exports}t.m=e,t.c=n,t.d=function(e,n,o){t.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:o})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,n){if(1&n&&(e=t(e)),8&n)return e;if(4&n&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(t.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&n&&"string"!=typeof e)for(var s in e)t.d(o,s,function(n){return e[n]}.bind(null,s));return o},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},t.p="/",t(t.s=90)}({90:function(e,n,t){e.exports=t("P0qb")},P0qb:function(e,n,t){"use strict";$(document).on("click","#btnCancel",(function(){$("#noteContainer").summernote("code","")})),$(document).on("click","#btnNote",(function(){var e=s.summernote("code"),n=$("#ownerId").val(),t=$("#moduleId").val();if(s.summernote("isEmpty"))return!1;var o=""===$("<div />").html($("#noteContainer").summernote("code")).text().trim().replace(/ \r\n\t/g,"");if($("#noteContainer").summernote("isEmpty"))$("#noteContainer").val("");else if(o){return displayErrorMessage("Note field is not contain only white space"),$(this).button("reset"),!1}var a=$(this);a.button("loading"),$.ajax({url:noteSaveUrl,type:"post",data:{note:e,owner_id:n,module_id:t},success:function(e){e.success&&function(e){var n=function(e){var n=e.id,t="";return e.added_by==authId&&(t='                    <a class="user__icons del-note d-none task-comment-delete" data-id="'+n+'"><i class="fas fa-trash ml-0 card-delete-icon"></i></a>\n                    <a class="user__icons edit-note d-none task-comment-edit" data-id="'+n+'"><i class="fas fa-edit mr-2 card-edit-icon"></i></a>\n                    <a class="user__icons save-note comment-save-icon-'+n+' d-none task-comment-check" data-id="'+n+'"><i class="far fa-check-circle card-save-icon text-success font-weight-bold hand-cursor mr-2 ml-2"></i></a>\n                    <a class="user__icons cancel-note comment-cancel-icon-'+n+' d-none task-comment-cancel" data-id="'+n+'"><i class="fas fa-times card-cancel-icon hand-cursor"></i></a>\n'),'<div class="activity clearfix notes__information" id="note__'+n+'">\n        <div class="activity-icon">\n            <img class="user__img profile" src="'+e.user.image_url+'" alt="User Image" width="50" height="50">\n            <span class="user__username">\n            </span>\n        </div>\n        <div class="activity-detail col-xl-11 col-lg-10 pt-1 mb-3">        <div class="mb-0 d-flex justify-content-between flex-wrap">        <div class="d-flex flex-wrap align-items-center">             <span class="font-weight-bold lead">'+e.user.full_name+'</span>\n            <span class="user__description text-job text-dark ml-2">Just now</span>\n        </div><div>'+t+'            </div></div>            <div class="user__comment mt-2 note-display comment-display-'+n+'" data-id="'+n+'">\n'+e.note+'           </div>\n           <div class="user__comment d-none note-edit comment-edit-'+n+'">\n           <div id="noteEditContainer'+n+'" class="quill-editor-container"></div>\n           </div>\n       </div>    </div>'}(e);$(".notes .activities").prepend(n),s.summernote("code",""),$(".no_notes").hide()}(e.data),a.button("reset")},error:function(e){a.button("reset"),printErrorMessage("#taskValidationErrorsBox",e)}})})),$(document).on("click",".del-note",(function(){var e=$(this).data("id");swal({title:"Delete !",text:'Are you sure want to delete this "Note" ?',type:"warning",showCancelButton:!0,closeOnConfirm:!1,showLoaderOnConfirm:!0,confirmButtonColor:"#6777ef",cancelButtonColor:"#d33",cancelButtonText:"No",confirmButtonText:"Yes"},(function(){$.ajax({url:noteUrl+e,type:"DELETE",success:function(n){n.success&&function(e,n){$("#note__"+e).remove(),$.ajax({url:ownerUrl+"/"+n+"/notes/notes-count",type:"GET",success:function(e){0==e.data&&($(".no_notes").show(),$(".no_notes").removeClass("d-none"))}})}(e,ownerId),swal({title:"Deleted!",text:"Note has been deleted.",type:"success",confirmButtonColor:"#6777ef",timer:2e3})},error:function(e){swal({title:"",text:e.responseJSON.message,type:"error",timer:5e3})}})}))}));var o=[];$(document).on("click",".note-display,.edit-note",(function(){var e=$(this).data("id");if($(document).find("[class*='comment-display-']").removeClass("d-none"),$(document).find("[class*='comment-edit-']").addClass("d-none"),$(document).find("[class*='comment-save-icon-']").addClass("d-none"),$(document).find("[class*='comment-cancel-icon-']").addClass("d-none"),$(".comment-display-"+e).addClass("d-none"),""===$("#noteEditContainer"+e).html())setNoteEditData(e);else{var n=$.trim($(".comment-display-"+e).html());o[e].summernote("code",""),o[e].summernote("code",n)}$(".comment-edit-"+e).removeClass("d-none"),$(".comment-save-icon-"+e).removeClass("d-none"),$(".comment-cancel-icon-"+e).removeClass("d-none")})),window.setNoteEditData=function(e){o[e]=$("#noteEditContainer"+e).summernote({placeholder:"Add Note...",minHeight:200,toolbar:[["style",["bold","italic","underline","clear"]],["font",["strikethrough"]],["para",["paragraph"]]]});var n=$.trim($(".comment-display-"+e).html());o[e].summernote("code",n)},$(document).on("click",".cancel-note",(function(){var e=$(this).data("id");$(this).addClass("d-none"),$(".comment-display-"+e).removeClass("d-none"),$(".comment-edit-"+e).addClass("d-none"),$(".comment-save-icon-"+e).addClass("d-none")})),$(document).on("click",".save-note",(function(){var e=$(this).data("id"),n=o[e].summernote("code"),t=$("#ownerId").val(),s=$("#moduleId").val();if(o[e].summernote("isEmpty"))return!1;var a=""===$("<div />").html($("#noteEditContainer"+e).summernote("code")).text().trim().replace(/ \r\n\t/g,"");if($("#noteEditContainer"+e).summernote("isEmpty"))$("#noteEditContainer"+e).val("");else if(a){return displayErrorMessage("Note field is not contain only white space"),$(this).button("reset"),!1}$.ajax({url:noteUrl+e,type:"put",data:{note:n,owner_id:t,module_id:s},success:function(t){t.success&&function(e,n){$(".comment-display-"+e).html(n).removeClass("d-none"),$(".comment-edit-"+e).addClass("d-none"),$(".comment-save-icon-"+e).addClass("d-none"),$(".comment-cancel-icon-"+e).addClass("d-none")}(e,n)},error:function(e){printErrorMessage("#taskValidationErrorsBox",e)}})})),$(document).on("mouseenter",".notes__information",(function(){$(this).find(".del-note").removeClass("d-none"),$(this).find(".edit-note").removeClass("d-none")})),$(document).on("mouseleave",".notes__information",(function(){$(this).find(".del-note").addClass("d-none"),$(this).find(".edit-note").addClass("d-none")}));var s=$("#noteContainer").summernote({placeholder:"Add Note...",minHeight:200,toolbar:[["style",["bold","italic","underline","clear"]],["font",["strikethrough"]],["para",["paragraph"]]]})}});