import{t as b}from"./postSlug.iva7u65b.js";import{_ as D}from"./ScoreButton.br7jqlck.js";import{_ as $}from"./App.fk02nb60.js";import{S}from"./Caret.hnvbzqgq.js";import{_ as f}from"./_plugin-vue_export-helper.oebm7xum.js";import{o as n,c as l,m,b as c,v as i,k as _,l as w,a as s,G as M,E as k,t as C,C as g}from"./runtime-dom.esm-bundler.h3clfjuw.js";import"./translations.b896ab1m.js";import{a as B,_ as x}from"./default-i18n.hohxoesu.js";const A={props:{completelyDraggable:{type:Boolean,default(){return!0}}},data(){return{position1:0,position2:0,position3:0,position4:0}},methods:{dragMouseDown(e){e=e||window.event,e.preventDefault(),this.position3=e.clientX,this.position4=e.clientY,document.onmousemove=this.elementDrag,document.onmouseup=this.closeDragElement},elementDrag(e){e=e||window.event,e.preventDefault(),this.position1=this.position3-e.clientX,this.position2=this.position4-e.clientY,this.position3=e.clientX,this.position4=e.clientY,this.$el.style.top=this.$el.offsetTop-this.position2+"px",this.$el.style.left=this.$el.offsetLeft-this.position1+"px"},closeDragElement(){document.onmouseup=null,document.onmousemove=null}}},O={class:"aioseo-draggable"},E={key:1};function N(e,o,t,u,d,a){return n(),l("div",O,[t.completelyDraggable?(n(),l("div",{key:0,"on:dragMouseDown":o[0]||(o[0]=(...r)=>a.dragMouseDown&&a.dragMouseDown(...r))},[m(e.$slots,"default")],32)):c("",!0),t.completelyDraggable?c("",!0):(n(),l("div",E,[m(e.$slots,"default")]))])}const P=f(A,[["render",N]]),z="all-in-one-seo-pack",L={emits:["update:is-open"],setup(){return{truSeoShouldAnalyze:b}},components:{CoreScoreButton:D,PostSettings:$,SvgClose:S,UtilDraggable:P},props:{isOpen:{type:Boolean,default:!1},score:{type:Number,default:0}},data(){return{strings:{header:B(x("%1$s Settings",z),"AIOSEO")}}},methods:{toggleModal(){this.isOpen=!this.isOpen}}},V={class:"aioseo-pagebuilder-modal-header-title"},X={class:"aioseo-pagebuilder-modal-body edit-post-sidebar editor-sidebar"};function Y(e,o,t,u,d,a){const r=i("core-score-button"),h=i("svg-close"),v=i("PostSettings"),y=i("util-draggable");return n(),_(y,{ref:"modal-container",completelyDraggable:!1},{default:w(()=>[s("div",{class:M(["aioseo-pagebuilder-modal",{"aioseo-pagebuilder-modal-is-closed":!t.isOpen}])},[s("div",{class:"aioseo-pagebuilder-modal-header",onMousedown:o[1]||(o[1]=k(p=>e.$refs["modal-container"].dragMouseDown(p),["prevent"]))},[s("div",V,C(d.strings.header),1),t.score&&u.truSeoShouldAnalyze()?(n(),_(r,{key:0,score:t.score,class:"aioseo-score-button--active"},null,8,["score"])):c("",!0),s("div",{class:"aioseo-pagebuilder-modal-header-close",onClick:o[0]||(o[0]=p=>e.$emit("update:is-open",!1))},[g(h)])],32),s("div",X,[g(v)])],2)]),_:1},512)}const H=f(L,[["render",Y],["__scopeId","data-v-8c4e05e7"]]);export{H as M};
