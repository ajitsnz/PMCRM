!function(e){var t={};function a(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,a),o.l=!0,o.exports}a.m=e,a.c=t,a.d=function(e,t,r){a.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,t){if(1&t&&(e=a(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(a.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)a.d(r,o,function(t){return e[t]}.bind(null,o));return r},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p="/",a(a.s=24)}({24:function(e,t,a){e.exports=a("7+e3")},"7+e3":function(e,t,a){"use strict";$("#leadStatusTbl").DataTable({oLanguage:{sEmptyTable:showNoDataMsg},processing:!0,serverSide:!0,order:[[2,"asc"]],ajax:{url:leadStatusUrl},columnDefs:[{targets:[1],width:"8%",orderable:!1},{targets:[2],className:"text-right",width:"8%"},{targets:[3],className:"text-center",width:"8%",searchable:!1},{targets:[4],orderable:!1,className:"text-center",width:"7%"},{targets:"_all",defaultContent:"N/A"}],columns:[{data:function(e){var t=document.createElement("textarea");return t.innerHTML=e.name,t.value},name:"name"},{data:function(e){var t=[{color:e.color,colorStyle:"style"}];return null==e.color?"N/A":prepareTemplateRender("#leadStatusColorBox",t)},name:"color"},{data:"order",name:"order"},{data:"leads_count",name:"leads_count"},{data:function(e){var t=[{id:e.id}];return prepareTemplateRender("#leadStatusActionTemplate",t)},name:"id"}]});var r=Pickr.create({el:".color-wrapper",theme:"nano",closeWithKey:"Enter",autoReposition:!0,defaultRepresentation:"HEX",position:"bottom-end",swatches:["rgba(244, 67, 54, 1)","rgba(233, 30, 99, 1)","rgba(156, 39, 176, 1)","rgba(103, 58, 183, 1)","rgba(63, 81, 181, 1)","rgba(33, 150, 243, 1)","rgba(3, 169, 244, 1)","rgba(0, 188, 212, 1)","rgba(0, 150, 136, 1)","rgba(76, 175, 80, 1)","rgba(139, 195, 74, 1)","rgba(205, 220, 57, 1)","rgba(255, 235, 59, 1)","rgba(255, 193, 7, 1)"],components:{preview:!0,hue:!0,interaction:{input:!0,clear:!1,save:!1}}}),o=Pickr.create({el:".color-wrapper",theme:"nano",closeWithKey:"Enter",autoReposition:!0,defaultRepresentation:"HEX",position:"bottom-end",swatches:["rgba(244, 67, 54, 1)","rgba(233, 30, 99, 1)","rgba(156, 39, 176, 1)","rgba(103, 58, 183, 1)","rgba(63, 81, 181, 1)","rgba(33, 150, 243, 1)","rgba(3, 169, 244, 1)","rgba(0, 188, 212, 1)","rgba(0, 150, 136, 1)","rgba(76, 175, 80, 1)","rgba(139, 195, 74, 1)","rgba(205, 220, 57, 1)","rgba(255, 235, 59, 1)","rgba(255, 193, 7, 1)"],components:{preview:!0,hue:!0,interaction:{input:!0,clear:!1,save:!1}}});r.on("change",(function(){var e=r.getColor().toHEXA().toString();r.setColor(e),$("#color").val(e)})),o.on("change",(function(){var e=o.getColor().toHEXA().toString();o.setColor(e),$("#edit_color").val(e)}));$(document).on("click","#color",(function(){!0})),$(document).on("click",".addLeadStatusModal",(function(){$("#addModal").appendTo("body").modal("show")})),$(document).on("submit","#addNewForm",(function(e){if(""==$("#color").val())return displayErrorMessage("Please select your color."),!1;e.preventDefault(),processingBtn("#addNewForm","#btnSave","loading"),$.ajax({url:leadStatusSaveUrl,type:"POST",data:$(this).serialize(),success:function(e){e.success&&(displaySuccessMessage(e.message),$("#addModal").modal("hide"),$("#leadStatusTbl").DataTable().ajax.reload(null,!1))},error:function(e){displayErrorMessage(e.responseJSON.message)},complete:function(){processingBtn("#addNewForm","#btnSave")}})})),$(document).on("click",".edit-btn",(function(e){var t=$(e.currentTarget).data("id");renderData(t)})),window.renderData=function(e){$.ajax({url:leadStatusUrl+e+"/edit",type:"GET",success:function(e){if(e.success){$("#leadStatusId").val(e.data.id);var t=document.createElement("textarea");t.innerHTML=e.data.name,$("#editName").val(t.value),o.setColor(e.data.color),$("#editOrder").val(e.data.order),$("#editModal").appendTo("body").modal("show")}},error:function(e){displayErrorMessage(e.responseJSON.message)}})},$(document).on("submit","#editForm",(function(e){e.preventDefault(),processingBtn("#editForm","#btnEditSave","loading");var t=$("#leadStatusId").val();$.ajax({url:leadStatusUrl+t,type:"put",data:$(this).serialize(),success:function(e){e.success&&(displaySuccessMessage(e.message),$("#editModal").modal("hide"),$("#leadStatusTbl").DataTable().ajax.reload(null,!1))},error:function(e){displayErrorMessage(e.responseJSON.message)},complete:function(){processingBtn("#editForm","#btnEditSave")}})})),$(document).on("click",".delete-btn",(function(e){var t=$(e.currentTarget).data("id");deleteItem(leadStatusUrl+t,"#leadStatusTbl","Lead Status")})),$("#addModal").on("show.bs.modal",(function(){r.setColor("#3F51B5")})),$("#addModal").on("hidden.bs.modal",(function(){r.setColor("#000"),resetModalForm("#addNewForm","#validationErrorsBox"),r.hide()})),$("#editModal").on("hidden.bs.modal",(function(){resetModalForm("#editForm","#editValidationErrorsBox"),o.hide()}))}});