!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=36)}({36:function(e,t,n){"use strict";function r(){!function(){const e=document.querySelectorAll(".nv-repeater--wrap");_.each(e,(function(e){const t=e.querySelector(".nv-repeater--reorder"),n=e.querySelector(".nv-repeater--add-new"),r=e.querySelectorAll(".nv-repeater--items-wrap .nv-repeater--item"),c=e.querySelector(".nv-repeater--items-wrap"),a=e.querySelector(".nv-repeater--hidden-item .nv-repeater--item");_.each(r,(function(t){o(t,e)})),n.addEventListener("click",(function(){const t=a.cloneNode(!0);o(t,e),c.appendChild(t),i(e)})),t.addEventListener("click",(function(t){t.preventDefault(),e.classList.toggle("reordering"),i(e)}))}))}()}function o(e,t){const n=e.querySelector(".nv-repeater--toggle"),r=e.querySelector(".nv-repeater--item-title"),o=e.querySelector(".reorder-btn.down"),c=e.querySelector(".reorder-btn.up"),a=e.querySelector(".nv-repeater--remove-item"),l=e.querySelector('input[data-key="title"]'),u=e.querySelector(".nv-repeater--title-text"),s=e.querySelectorAll(".color-picker-hex"),d=e.querySelectorAll(".has-value"),p=e.querySelectorAll(".nv--icon-field-wrap");n.addEventListener("click",(function(){this.parentNode.classList.toggle("visibility-hidden"),this.setAttribute("data-value","yes"===this.getAttribute("data-value")?"no":"yes"),i(t)})),r.addEventListener("click",(function(){this.parentNode.parentNode.classList.toggle("expanded")})),a.addEventListener("click",(function(){e.parentNode.removeChild(e),i(t)})),o.addEventListener("click",(function(n){n.stopPropagation();const r=e.nextSibling;if(!r)return!1;r.parentNode.insertBefore(e,r.nextSibling),i(t)})),c.addEventListener("click",(function(n){n.stopPropagation();if(!e.previousSibling)return!1;e.parentNode.insertBefore(e,e.previousSibling),i(t)})),l.addEventListener("input",(function(){u.innerHTML=""!==this.value?this.value:u.dataset.default,i(t)})),_.each(s,(function(e){jQuery(e).wpColorPicker({change(){setTimeout((function(){i(t)}),1)},clear(){i(t)}})})),_.each(p,(function(e){const n=e.querySelector(".nv--icon-selector"),r=e.querySelector("input"),o=e.querySelector(".nv--remove-icon"),c=e.querySelectorAll(".nv--icons-container > a"),a=e.querySelector(".nv--icons-search > input");n.addEventListener("click",(function(t){t.preventDefault(),e.classList.toggle("nv--iconpicker-expanded"),a.value="",a.dispatchEvent(new Event("input")),a.focus()})),o.addEventListener("click",(function(o){o.preventDefault(),r.value="",n.innerHTML='<span class="dashicons dashicons-plus"></span>';const c=e.querySelector("a.selected");null!==c&&c.classList.remove("selected"),i(t)})),_.each(c,(function(o){o.addEventListener("click",(function(c){c.preventDefault(),n.innerHTML=o.innerHTML,r.value=o.dataset.icon;const a=e.querySelector("a.selected");null!==a&&a.classList.remove("selected"),o.classList.add("selected"),e.classList.remove("nv--iconpicker-expanded"),i(t)}))})),a.addEventListener("input",(function(e){const t=e.target.value.toLowerCase().replace(/\s+/g,"");console.log(t),_.each(c,(function(e){e.dataset.icon.toLowerCase().indexOf(t)>-1?e.style.display="":e.style.display="none"}))}))})),_.each(d,(function(e){e.addEventListener("change",(function(){i(t)}))}))}function i(e){const t=e.querySelector(".nv-repeater--collector"),n=e.querySelectorAll(".nv-repeater--items-wrap .nv-repeater--item"),r=[];_.each(n,(function(e){const t=e.querySelectorAll(".has-value"),n={};_.each(t,(function(e){const t=e.dataset.key;let r;r="checkbox"===e.getAttribute("type")?e.checked:e.dataset.value?e.dataset.value:e.value,n[t]=r})),r.push(n)})),t.value=JSON.stringify(r),jQuery(t).trigger("change")}n.r(t),wp.customize.bind("ready",(function(){r()}))}});