!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r(r.s=88)}({88:function(e,t,r){e.exports=r("j+eg")},"j+eg":function(e,t,r){"use strict";for(var n,o=[],a=document.getElementsByClassName("board").length,u=0;u<a;u++)o.push(document.querySelector(".board-"+u));var c=dragula({containers:o,revertOnSpill:!0,direction:"vertical"}).on("drag",(function(e){e.className=e.className.replace("ex-moved","")})).on("drop",(function(e,t){var r=$(t);e.className+=" ex-moved",n=$(".ex-moved").data("id");var o=$(t).data("board-status");r.parent().find(".infy-loader").fadeIn(),$.ajax({url:ticketUrl+"/"+n+"/status/"+o,type:"PUT",cache:!1,complete:function(){r.parent().find(".infy-loader").fadeOut()}})})).on("over",(function(e,t){t.className+=" ex-over"})).on("out",(function(e,t){t.className=t.className.replace("ex-over","")}));$(document).ready((function(){var e=[document.querySelector(".flex-nowrap")];$(".board").each((function(t,r){e.push(document.querySelector(".board-"+t))}));autoScroll(e,{margin:200,autoScroll:function(){return this.down&&c.dragging}})}))}});