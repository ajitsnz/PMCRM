!function(e){var t={};function n(a){if(t[a])return t[a].exports;var o=t[a]={i:a,l:!1,exports:{}};return e[a].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(a,o,function(t){return e[t]}.bind(null,o));return a},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=40)}({"3tMT":function(e,t,n){"use strict";$(document).ready((function(){$("#currency").select2({width:"100%",placeholder:"Select Currency"}),$(document).on("submit","#createExpense, #editExpense",(function(){if(jQuery(this).find("#btnSave").button("loading"),""!==$("#error-msg").text())return!1;var e=""===$("<div />").html($("#expenseNote").summernote("code")).text().trim().replace(/ \r\n\t/g,"");if($("#expenseNote").summernote("isEmpty"))$("#expenseNote").val("");else if(e){return displayErrorMessage("Note field is not contain only white space"),jQuery(this).find("#btnSave").button("reset"),!1}}));var e=0;$("#taxAmount").text(0),$("#expenseCategory").select2({width:"100%",placeholder:"Select Expense Category"}),$("#customers").select2({width:"100%"}),$("#paymentMode").select2({width:"100%"}),$("#tax1,#tax2").select2({width:"100%"}),$(".price-input").trigger("input"),$(".datepicker").datetimepicker({format:"YYYY-MM-DD HH:mm:ss",useCurrent:!0,sideBySide:!0,icons:{up:"fa fa-chevron-up",down:"fa fa-chevron-down",next:"fa fa-chevron-right",previous:"fa fa-chevron-left"}}),$(".datepicker").on("dp.show",(function(){matchWindowScreenPixels({expenseDate:".datepicker"},"exp")})),$(document).on("keyup keydown","#amount",(function(){var t=null!==$("#amount").val()?removeCommas($("#amount").val()):0;e=t,!0===isEdit&&calculateEditedTaxAmount()})),window.calculateEditedTaxAmount=function(){var t=""!=$("#tax1").val()?$("#tax1").find(":selected").text():0,n=""!=$("#tax2").val()?$("#tax2").find(":selected").text():0,a=e*(parseFloat(t)+parseFloat(n))/100,o=parseFloat(e)+parseFloat(a);$("#taxRate").val(o)},!0===isEdit?($(document).ready((function(){e=null!==$("#amount").val()?removeCommas($("#amount").val()):0})),$(document).on("change","#tax1,#tax2",(function(t){arguments.length>1&&void 0!==arguments[1]&&arguments[1];""!=$("#tax1").val()||""!=$("#tax2").val()?calculateEditedTaxAmount():$("#taxRate").val(e)}))):($(document).on("change","#tax1,#tax2",(function(t){arguments.length>1&&void 0!==arguments[1]&&arguments[1];if(""!=$("#tax1").val()||""!=$("#tax2").val()){var n=""!=$("#tax1").val()?$("#tax1").find(":selected").text():0,a=""!=$("#tax2").val()?$("#tax2").find(":selected").text():0,o=e*(parseFloat(n)+parseFloat(a))/100;$("#taxAmount").text(addCommas(o)),$("#taxRate").val(e),checkTaxApplied(),$("#isTaxApplied").removeClass("d-none"),""==$("#tax1").val()&&""==$("#tax2").val()&&$("#taxApplied").prop("checked",!1)}else $("#taxApplied").prop("checked",!1),$("#taxAmount").text(""),$("#taxRate").val(""),$("#isTaxApplied").addClass("d-none"),calculateFinalAmount()})),window.calculateFinalAmount=function(){var t=void 0!==removeCommas($("#taxAmount").text())?removeCommas($("#taxAmount").text()):0,n=e-t;$("#amount").val(addCommas(n)),$("#taxRate").val(e)},$(document).on("change","#taxApplied",(function(){checkTaxApplied()})),window.checkTaxApplied=function(){!0===$("#taxApplied").prop("checked")?calculateFinalAmount():($("#amount").val(addCommas(e)),$("#taxRate").val(""))}),$(document).on("change","#billable",(function(){$(".showBillableFields").hasClass("d-none")?$(".showBillableFields").removeClass("d-none"):($("#autoCreateInvoice,#sendMail").prop("checked",!1),$(".showBillableFields").addClass("d-none"))})),window.removeCommas=function(e){return e.replace(/,/g,"")}})),$(document).on("mouseenter",".expense-attachment",(function(){$(this).find(".expense-attachment__icon").removeClass("d-none")})),$(document).on("mouseleave",".expense-attachment",(function(){$(this).find(".expense-attachment__icon").addClass("d-none")}))},40:function(e,t,n){e.exports=n("3tMT")}});