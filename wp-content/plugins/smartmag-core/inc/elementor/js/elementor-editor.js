!function(e){var t={};function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(o,r,function(t){return e[t]}.bind(null,r));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=0)}([function(e,t){
/**
 * Elementor backend editor extra functionality.
 * 
 * @copyright 2021 ThemeSphere.
 */
jQuery((function(e){const t=["query_type","sort_by","sort_order","sort_days","terms","cat","offset","reviews_only","tags","post_ids","post_formats","taxonomy","tax_ids","post_type"];elementor.hooks.addAction("panel/open_editor/section",(function(n,r,i){var s=n.$el;r.get("settings")&&r.get("settings").on("change",(e=>{Object.keys(e.changed).some((e=>t.includes(e)))&&o(i.$el)})),s.length&&s.find('[data-setting="gutter"]').on("change",(function(){if("none"!=e(this).val()){var t=s.find('[data-setting="gap"]');t.length&&t.val("no").trigger("change")}}))})),elementor.hooks.addAction("panel/open_editor/column",((e,t,n)=>{if(!e.$el)return;const o=n._parent;o&&o.getPreviousColumn&&t.get("settings").on("change:is_sidebar",((e,t)=>{const r=o.getPreviousColumn(n)||o.getNextColumn(n);if(!r)return;const i=r.model.get("settings");e!==i&&(t?((i.get("_inline_size")||e.get("_inline_size"))&&(i.set("_inline_size",66.667),e.set("_inline_size",33.333),n.render(),r.render()),i.set("is_main","main-content").set("_inline_size_tablet",100),e.set("_inline_size_tablet",100)):i.set("is_main",""))}))}));const n=e=>{const t=(e,n)=>{if(!n.elements)return;const o=n.elements;let r=n.elements.get(e);return r||(o.models?(o.models.find((n=>!!n.attributes&&(r=t(e,n.attributes),r))),r):void 0)};return t(e,elementor)},o=(t,o)=>{e(t).find("[data-model-cid]").each(((t,r)=>{const i=e(r).data("model-cid");if(o&&o===i)return;const s=n(i);"section"===s.getSetting("query_type")&&s.renderRemoteServer()}))};elementor.hooks.addFilter("elements/base/behaviors",((r,s)=>{if("widget"!==s.options.model.get("elType"))return r;(r=>{const s=r.options.model;if(!s||!s.on)return;const a=()=>e(r.el).closest("[data-element_type=section]"),l=s.get("settings");l&&l.on("change",(()=>{o(a(),s.cid)}));const d=()=>{const o=a(),r=n(o.data("model-cid"));if(!r||!r.get("settings"))return;let l=0;o.find("[data-model-cid]").each(((t,o)=>{const r=e(o).data("model-cid"),i=n(r),s=i.get("settings");s&&"section"===s.get("query_type")&&(s.set({skip_posts:l},{silent:!0}),l+=i.getSetting("posts")||0)}));const d=s.get("settings");let c=r.get("settings"),u={};if(c&&c.toJSON)for(i in c=c.toJSON(),c)t.includes(i)&&(u[i]=c[i]);d&&"section"===d.get("query_type")&&d.set({section_data:u},{silent:!0})};s.on("before:remote:render",d);let c=!1;r.on("render",(()=>{if(c)return c=!1,!1;const e=Object.assign({},s.get("settings").get("section_data"));c=!0,d();const t=s.get("settings").get("section_data");t&&!_.isEqual(e,t)?s.renderRemoteServer():c=!1}))})(s);var a=function(e){var t=[];return e.model&&e.model.getSetting?(e.model.getSetting("_column_size")&&t.push(e.model.getSetting("_column_size")),e._parent&&e.model&&(t=t.concat(a(e._parent))),t):[]};const l=e=>a(e).reduce(((e,t)=>t/100*e));var d=s.onRender.bind(s);return s.onRender=function(){let e;if(d.apply(this,arguments),s.model.getSetting("container_width")){if(!s.model.attributes._parentWidth)return void(s.model.attributes._parentWidth=l(s));if(e=l(s),s.model.attributes._parentWidth===e)return}var t=e||l(s);if(s.model.attributes._parentWidth=t,t){let e=1;elementor.$previewContents.find(".main:not(.no-sidebar)").length&&(e=.666);let n=33;(t*=e)>90?n=100:t>60?n=66:t>40&&(n=50),s.model.setSetting("container_width",n)}},r}));const r=()=>{const e=elementor.documents.getCurrent(),t=e.container.settings.get("post_status");$e.internal("document/save/save",{status:t,document:e,onSuccess:()=>{elementor.reloadPreview()}})};elementor.settings.page.addChangeCallback("show_page_title",r),elementor.settings.page.addChangeCallback("layout_style",r),function(){let e=!1;const t=Object.assign(new(Object.getPrototypeOf($e.hooks.ui).constructor),{getCommand:()=>"document/elements/create",getId:()=>"bunyad-section-set-defaults",getContainerType:()=>"",run(t,n){setTimeout((()=>{if(e&&"section"===t.model.elType&&n.model){n.model.setSetting("gutter","default"),n.model.setSetting("gap","no");try{n.view.render()}catch(e){elementor.panel.currentView.$el.find("[data-setting=gap]").trigger("change")}setTimeout((()=>e=!1),1)}}),2)}});$e.hooks.registerUIAfter(t),elementor.on("preview:loaded",(()=>{elementor.$previewContents.on("click",".elementor-preset",(t=>{e=!0})),elementor.$previewContents.on("drop",(t=>{elementor.channels.panelElements.request("element:selected").model&&(e=!0)}))}))}(),function(){if(window.elementorPro)return;const t=e("#tmpl-elementor-panel-categories");t.text(t.text().replace('elementor-nerd-box"','" style="display: none;"')),elementor.config.promotionWidgets={},$e.commandsInternal.on("run:after",((e,t)=>{"panel/state-ready"===t&&elementor.getPanelView().getRegion("content").on("show",(()=>{elementor.getPanelView().$el.find(".elementor-panel-menu-item-site-editor").hide()}))}))}()})),function(e){const t=elementor.modules.controls.BaseData.extend({applySavedValue(){elementor.modules.controls.BaseData.prototype.applySavedValue.apply(this,arguments);const t=this.ui.select,n=Object.assign({sortable:!0,multiple:!0,create:!1,ajax:!1,preload:!0},this.model.get("selectize_options")||{}),o=this.getControlValue(),r={create:n.create,items:o,plugins:[]};if(n.sortable&&r.plugins.push("drag_drop"),n.multiple&&r.plugins.push("remove_button"),n.ajax&&(r.preload=n.preload,r.load=(t,o,r)=>{window.bunyadAjaxCache||(window.bunyadAjaxCache={});const i=e=>{e=wpApiSettings.root.includes("?")?e.replace("?","&"):e;return wpApiSettings.root+wpApiSettings.versionString+e};let s=n.url||"";if(n.endpoint&&(s=i(n.endpoint),s=s.replace("{query}",encodeURIComponent(t))),r&&(s=i(n.endpoint_saved),s=s.replace("{ids}",t)),s in window.bunyadAjaxCache)return o(window.bunyadAjaxCache[s]);e.ajax({url:s,type:"GET",dataType:"json",beforeSend:e=>e.setRequestHeader("X-WP-Nonce",wpApiSettings.nonce),error:()=>o(),success:e=>{const t=[];e.forEach((e=>{e.id&&t.push({text:e.name,value:e.id})})),window.bunyadAjaxCache[s]=t,o(t)}})},o)){let e=o;Array.isArray(o)&&(e=o.filter((e=>parseInt(e))).join(","));const n=()=>{const n=t[0].selectize;r.load(e,(e=>{e&&(e.forEach((e=>n.addOption(e))),n.clear(!0),n.setValue(o,!0))}),!0)};e&&(r.onInitialize=n)}if(t.selectize(r),n.create){const e=t[0].selectize;if(Array.isArray(o)){for(const t of o)parseInt(t)||e.addOption({text:t,value:t});e.setValue(o,!0)}}}});elementor.addControlView("bunyad-selectize",t)}(jQuery)}]);