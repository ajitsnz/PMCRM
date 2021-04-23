function _typeof2(e){return(_typeof2="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var autoScroll=function(){"use strict";function e(e,n){var t,r;return r=n,"function"==typeof(e=void 0===(t=e)?void 0===r?t:r:t)?function(){for(var n=arguments,t=arguments.length,r=Array(t),o=0;o<t;o++)r[o]=n[o];return!!e.apply(this,r)}:e?function(){return!0}:function(){return!1}}var n,t,r,o,i=["webkit","moz","ms","o"],a=function(){for(var e=0,n=i.length;e<n&&!window.requestAnimationFrame;++e)window.requestAnimationFrame=window[i[e]+"RequestAnimationFrame"];var t;return window.requestAnimationFrame||(t=0,window.requestAnimationFrame=function(e){var n=(new Date).getTime(),r=Math.max(0,16-n-t),o=window.setTimeout(function(){return e(n+r)},r);return t=n+r,o}),window.requestAnimationFrame.bind(window)}(),u=function(){for(var e=0,n=i.length;e<n&&!window.cancelAnimationFrame;++e)window.cancelAnimationFrame=window[i[e]+"CancelAnimationFrame"]||window[i[e]+"CancelRequestAnimationFrame"];return window.cancelAnimationFrame||(window.cancelAnimationFrame=function(e){window.clearTimeout(e)}),window.cancelAnimationFrame.bind(window)}(),c=(n=function(e){return"function"==typeof e},t=Math.pow(2,53)-1,r=function(e){var n=function(e){var n=Number(e);return isNaN(n)?0:0!==n&&isFinite(n)?(n>0?1:-1)*Math.floor(Math.abs(n)):n}(e);return Math.min(Math.max(n,0),t)},o=function(e){var n=e.next();return!Boolean(n.done)&&n},function(e){var t,i,a,u=this,c=arguments.length>1?arguments[1]:void 0;if(void 0!==c){if(!n(c))throw new TypeError("Array.from: when provided, the second argument must be a function");arguments.length>2&&(t=arguments[2])}var l=function(e,t){if(null!=e&&null!=t){var r=e[t];if(null==r)return;if(!n(r))throw new TypeError(r+" is not a function");return r}}(e,function(e){if(null!=e){if(["string","number","boolean","symbol"].indexOf(_typeof2(e))>-1)return Symbol.iterator;if("undefined"!=typeof Symbol&&"iterator"in Symbol&&Symbol.iterator in e)return Symbol.iterator;if("@@iterator"in e)return"@@iterator"}}(e));if(void 0!==l){i=n(u)?Object(new u):[];var f,s,m=l.call(e);if(null==m)throw new TypeError("Array.from requires an array-like or iterable object");for(a=0;;){if(!(f=o(m)))return i.length=a,i;s=f.value,i[a]=c?c.call(t,s,a):s,a++}}else{var d=Object(e);if(null==e)throw new TypeError("Array.from requires an array-like object - not null or undefined");var v,w=r(d.length);for(i=n(u)?Object(new u(w)):new Array(w),a=0;a<w;)v=d[a],i[a]=c?c.call(t,v,a):v,a++;i.length=w}return i}),l=("function"==typeof Array.from&&Array.from,Array.isArray,Object.prototype.toString,"function"==typeof Symbol&&"symbol"===_typeof2(Symbol.iterator)?function(e){return _typeof2(e)}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol?"symbol":_typeof2(e)}),f=function(e){return null!=e&&"object"===(void 0===e?"undefined":l(e))&&1===e.nodeType&&"object"===l(e.style)&&"object"===l(e.ownerDocument)};function s(e,n){if(n=v(n,!0),!f(n))return-1;for(var t=0;t<e.length;t++)if(e[t]===n)return t;return-1}function m(e,n){return-1!==s(e,n)}function d(e){for(var n=arguments,t=[],r=arguments.length-1;r-- >0;)t[r]=n[r+1];return function(e,n){for(var t=0;t<n.length;t++)m(e,n[t])||e.push(n[t]);return n}(e,t=t.map(v))}function v(e,n){if("string"==typeof e)try{return document.querySelector(e)}catch(e){throw e}if(!f(e)&&!n)throw new TypeError(e+" is not a DOM element.");return e}function w(e){if(e===window)return function(){var e={top:{value:0,enumerable:!0},left:{value:0,enumerable:!0},right:{value:window.innerWidth,enumerable:!0},bottom:{value:window.innerHeight,enumerable:!0},width:{value:window.innerWidth,enumerable:!0},height:{value:window.innerHeight,enumerable:!0},x:{value:0,enumerable:!0},y:{value:0,enumerable:!0}};if(Object.create)return Object.create({},e);var n={};return Object.defineProperties(n,e),n}();try{var n=e.getBoundingClientRect();return void 0===n.x&&(n.x=n.left,n.y=n.top),n}catch(n){throw new TypeError("Can't call getBoundingClientRect on "+e)}}var p,y=void 0;"function"!=typeof Object.create?(p=function(){},y=function(e,n){if(e!==Object(e)&&null!==e)throw TypeError("Argument must be an object, or null");p.prototype=e||{};var t=new p;return p.prototype=null,void 0!==n&&Object.defineProperties(t,n),null===e&&(t.__proto__=null),t}):y=Object.create;var h=y,g=["altKey","button","buttons","clientX","clientY","ctrlKey","metaKey","movementX","movementY","offsetX","offsetY","pageX","pageY","region","relatedTarget","screenX","screenY","shiftKey","which","x","y"];function b(e,n){n=n||{};for(var t=h(e),r=0;r<g.length;r++)void 0!==n[g[r]]&&(t[g[r]]=n[g[r]]);return t}function E(e,n){console.log("data ",n),e.data=n||{},e.dispatched="mousemove"}function T(n,t){void 0===t&&(t={});var r=this,o=4,i=!1;this.margin=t.margin||-1,this.scrollWhenOutside=t.scrollWhenOutside||!1;var c={},l=function(n,t){var r=e((t=t||{}).allowUpdate,!0);return function(e){if(e=e||window.event,n.target=e.target||e.srcElement||e.originalTarget,n.element=this,n.type=e.type,r(e)){if(e.targetTouches)n.x=e.targetTouches[0].clientX,n.y=e.targetTouches[0].clientY,n.pageX=e.targetTouches[0].pageX,n.pageY=e.targetTouches[0].pageY,n.screenX=e.targetTouches[0].screenX,n.screenY=e.targetTouches[0].screenY;else{if(null===e.pageX&&null!==e.clientX){var t=e.target&&e.target.ownerDocument||document,o=t.documentElement,i=t.body;n.pageX=e.clientX+(o&&o.scrollLeft||i&&i.scrollLeft||0)-(o&&o.clientLeft||i&&i.clientLeft||0),n.pageY=e.clientY+(o&&o.scrollTop||i&&i.scrollTop||0)-(o&&o.clientTop||i&&i.clientTop||0)}else n.pageX=e.pageX,n.pageY=e.pageY;n.x=e.clientX,n.y=e.clientY,n.screenX=e.screenX,n.screenY=e.screenY}n.clientX=n.x,n.clientY=n.y}}}(c),f=function(e){var n={screenX:0,screenY:0,clientX:0,clientY:0,ctrlKey:!1,shiftKey:!1,altKey:!1,metaKey:!1,button:0,buttons:1,relatedTarget:null,region:null};function t(e){for(var t=0;t<g.length;t++)n[g[t]]=e[g[t]]}return void 0!==e&&e.addEventListener("mousemove",t),{destroy:function(){e&&e.removeEventListener("mousemove",t,!1),n=null},dispatch:MouseEvent?function(e,t,r){var o=new MouseEvent("mousemove",b(n,t));return E(o,r),e.dispatchEvent(o)}:"function"==typeof document.createEvent?function(e,t,r){var o=b(n,t),i=document.createEvent("MouseEvents");return i.initMouseEvent("mousemove",!0,!0,window,0,o.screenX,o.screenY,o.clientX,o.clientY,o.ctrlKey,o.altKey,o.shiftKey,o.metaKey,o.button,o.relatedTarget),E(i,r),e.dispatchEvent(i)}:"function"==typeof document.createEventObject?function(e,t,r){var o=document.createEventObject(),i=b(n,t);for(var a in i)o[a]=i[a];return E(o,r),e.dispatchEvent(o)}:void 0}}(),p=!1;window.addEventListener("mousemove",l,!1),window.addEventListener("touchmove",l,!1),isNaN(t.maxSpeed)||(o=t.maxSpeed),this.autoScroll=e(t.autoScroll),this.syncMove=e(t.syncMove,!1),this.destroy=function(e){window.removeEventListener("mousemove",l,!1),window.removeEventListener("touchmove",l,!1),window.removeEventListener("mousedown",Y,!1),window.removeEventListener("touchstart",Y,!1),window.removeEventListener("mouseup",A,!1),window.removeEventListener("touchend",A,!1),window.removeEventListener("pointerup",A,!1),window.removeEventListener("mouseleave",j,!1),window.removeEventListener("mousemove",F,!1),window.removeEventListener("touchmove",F,!1),window.removeEventListener("scroll",S,!0),n=[],e&&O()},this.add=function(){for(var e=[],t=arguments.length;t--;)e[t]=arguments[t];return d.apply(void 0,[n].concat(e)),this},this.remove=function(){for(var e=[],t=arguments.length;t--;)e[t]=arguments[t];return function(e){for(var n=arguments,t=[],r=arguments.length-1;r-- >0;)t[r]=n[r+1];return t.map(v).reduce(function(n,t){var r=s(e,t);return-1!==r?n.concat(e.splice(r,1)):n},[])}.apply(void 0,[n].concat(e))};var y,h,T=null;"[object Array]"!==Object.prototype.toString.call(n)&&(n=[n]),h=n,n=[],h.forEach(function(e){e===window?T=window:r.add(e)}),Object.defineProperties(this,{down:{get:function(){return p}},maxSpeed:{get:function(){return o}},point:{get:function(){return c}},scrolling:{get:function(){return i}}});var L,X=null;function S(e){for(var t=0;t<n.length;t++)if(n[t]===e.target){i=!0;break}i&&a(function(){return i=!1})}function Y(){p=!0}function A(){p=!1,O()}function O(){u(L),u(y)}function j(){p=!1}function M(){for(var e=null,t=0;t<n.length;t++)x(c,n[t])&&(e=n[t]);return e}function F(e){if(r.autoScroll()&&!e.dispatched){var t=e.target,o=document.body;X&&!x(c,X)&&(r.scrollWhenOutside||(X=null)),t&&t.parentNode===o?t=M():(t=function(e){if(!e)return null;if(X===e)return e;if(m(n,e))return e;for(;e=e.parentNode;)if(m(n,e))return e;return null}(t))||(t=M()),t&&t!==X&&(X=t),T&&(u(y),y=a(K)),X&&(u(L),L=a(q))}}function K(){_(T),u(y),y=a(K)}function q(){X&&(_(X),u(L),L=a(q))}function _(e){var n,t,o=w(e);n=c.x<o.left+r.margin?Math.floor(Math.max(-1,(c.x-o.left)/r.margin-1)*r.maxSpeed):c.x>o.right-r.margin?Math.ceil(Math.min(1,(c.x-o.right)/r.margin+1)*r.maxSpeed):0,t=c.y<o.top+r.margin?Math.floor(Math.max(-1,(c.y-o.top)/r.margin-1)*r.maxSpeed):c.y>o.bottom-r.margin?Math.ceil(Math.min(1,(c.y-o.bottom)/r.margin+1)*r.maxSpeed):0,r.syncMove()&&f.dispatch(e,{pageX:c.pageX+n,pageY:c.pageY+t,clientX:c.x+n,clientY:c.y+t}),setTimeout(function(){t&&function(e,n){e===window?window.scrollTo(e.pageXOffset,e.pageYOffset+n):e.scrollTop+=n}(e,t),n&&function(e,n){e===window?window.scrollTo(e.pageXOffset+n,e.pageYOffset):e.scrollLeft+=n}(e,n)})}window.addEventListener("mousedown",Y,!1),window.addEventListener("touchstart",Y,!1),window.addEventListener("mouseup",A,!1),window.addEventListener("touchend",A,!1),window.addEventListener("pointerup",A,!1),window.addEventListener("mousemove",F,!1),window.addEventListener("touchmove",F,!1),window.addEventListener("mouseleave",j,!1),window.addEventListener("scroll",S,!0)}function x(e,n,t){return t?e.y>t.top&&e.y<t.bottom&&e.x>t.left&&e.x<t.right:function(e,n){var t=w(n);return e.y>t.top&&e.y<t.bottom&&e.x>t.left&&e.x<t.right}(e,n)}return function(e,n){return new T(e,n)}}();
