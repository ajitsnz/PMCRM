!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=4)}({4:function(e,t,n){e.exports=n("UcGs")},UcGs:function(module,exports,__webpack_require__){"use strict";function deleteItemAjax(url,header){var callFunction=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;$.ajax({url:url,type:"DELETE",dataType:"json",success:function success(obj){obj.success&&window.livewire.emit("refresh"),swal({title:"Deleted!",text:header+" has been deleted.",type:"success",confirmButtonColor:"#6777ef",timer:2e3}),callFunction&&eval(callFunction)},error:function(e){swal({title:"",text:e.responseJSON.message,type:"error",confirmButtonColor:"#6777ef",timer:5e3})}})}$(document).on("click",".customer-delete-btn",(function(e){var t=$(e.currentTarget).data("id"),n='<div class="alert alert-warning swal__alert">\n<strong class="swal__text-warning">'+deleteCustomerConfirm+'</strong><div class="swal__text-message">'+byDeleteThisCustomer+"</div></div>";deleteItemInputConfirmation(customerUrl+"/"+t,"Customer",n)})),window.deleteItemInputConfirmation=function(e,t,n){arguments.length>3&&void 0!==arguments[3]&&arguments[3];swal({type:"input",inputPlaceholder:deleteConfirm+' "'+deleteWord+'" '+toTypeDelete+" "+t+".",title:deleteHeading+" !",text:n,html:!0,showCancelButton:!0,closeOnConfirm:!1,showLoaderOnConfirm:!0,confirmButtonColor:"#6777ef",cancelButtonColor:"#d33",cancelButtonText:noMessages,confirmButtonText:yesMessages,imageUrl:baseUrl+"img/warning.png"},(function(n){return!1!==n&&(""==n||"delete"!=n.toLowerCase()?(swal.showInputError('Please type "delete" to delete this '+t+"."),$(".sa-input-error").css("top","23px!important"),$(document).find(".sweet-alert.show-input :input").val(""),!1):void("delete"===n.toLowerCase()&&deleteItemAjax(e,t,null)))}))}}});