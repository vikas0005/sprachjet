import{a as E,u as W,f as w,g as A,r as x}from"./index.jlplx4ex.js";import{u as P}from"./GoogleSearchConsole.gxgbuztl.js";import{g as N}from"./params.k8e95b6q.js";import{_ as T}from"./Actionable.c3r1o8vr.js";import"./translations.b896ab1m.js";import{_ as I}from"./_plugin-vue_export-helper.oebm7xum.js";import{_ as r,a as B}from"./default-i18n.hohxoesu.js";import{v as p,o as i,k as C,l as b,x as k,t as d,a as _,c as h,C as f,E as M,F as v,b as S}from"./runtime-dom.esm-bundler.h3clfjuw.js";import{u as U}from"./WpTable.iid7bkmr.js";import{f as z}from"./index.npoectbv.js";import{C as D}from"./Index.lexckf3q.js";import{C as F}from"./Table.dpnj7vzp.js";import{c as O}from"./Caret.hnvbzqgq.js";const fe=()=>({validateLinksPerIndex:e=>{1>e.target.value&&(e.target.value=1),5e4<e.target.value&&(e.target.value=5e4)}}),l="all-in-one-seo-pack",R={setup(){const{strings:o}=P(),e="sitemapErrorsTable",{pageNumber:c,processPagination:s,resultsPerPage:t}=U({changeItemsPerPageSlug:"searchConsoleSitemapErrors",fetchData:()=>Promise.resolve(),resultsPerPage:5,tableId:e});return{composableStrings:o,optionsStore:E(),pageNumber:c,processPagination:s,resultsPerPage:t,rootStore:W(),searchStatisticsStore:w(),settingsStore:A(),tableId:e}},components:{CoreAlertActionable:T,CoreModal:D,CoreWpTable:F,SvgCircleCheck:O},props:{display:{type:Boolean,default:!1},sitemaps:{type:Array,default:()=>[]}},data(){return{loading:!1,bulkOptions:[{label:r("Remove",l),value:"remove"},{label:r("Ignore",l),value:"ignore"}],strings:x(this.composableStrings,{aioseoHasFoundSomeErrorsInSitemaps:B(r("%1$s has found some errors in sitemaps that were previously submitted to Google Search Console. Since %1$s manages your sitemaps, these additional sitemaps can be removed.",l),"AIOSEO"),allErrorsResolved:r("All errors have been resolved",l),removeSitemap:r("Remove",l),ignoreSitemap:r("Ignore",l),viewDetails:r("Details",l),sitemapErrors:r("Sitemap Errors",l),thereAreSitemapsWithErrors:r("There are sitemaps with errors",l)})}},computed:{totals(){return{page:1,pages:Math.ceil(this.searchStatisticsStore.sitemapsWithErrors.length/this.resultsPerPage),total:this.searchStatisticsStore.sitemapsWithErrors.length}},rows(){const o=this.pageNumber===1?0:(this.pageNumber-1)*this.resultsPerPage;return this.searchStatisticsStore.sitemapsWithErrors.slice(o,o+this.resultsPerPage)},columns(){return[{slug:"sitemap",label:r("Sitemap",l)},{slug:"actions",label:r("Actions",l),width:"220px"}]}},methods:{escUrl:z,fetchData(){return Promise.resolve()},processBulkAction({action:o,selectedRows:e}){if(!e.length)return;const c=[];switch(Array.isArray(e)?e.forEach(s=>{c.push(this.rows[s].path)}):c.push(e.path),o){case"remove":this.loading=!0,this.searchStatisticsStore.deleteSitemap({sitemap:c}).finally(()=>{this.loading=!1});break;case"ignore":this.loading=!0,this.searchStatisticsStore.ignoreSitemap({sitemap:c}).finally(()=>{this.loading=!1});break}},deleteSitemap(o){this.loading=!0,this.searchStatisticsStore.deleteSitemap({sitemap:o}).finally(()=>{this.loading=!1})},ignoreSitemap(o){this.loading=!0,this.searchStatisticsStore.ignoreSitemap({sitemap:o}).finally(()=>{this.loading=!1})},canRemoveSitemap(o){return!this.rootStore.aioseo.data.sitemapUrls.includes(o.path)}}},V={class:"aioseo-modal-body"},H={key:0},L=["href"],Y=["onClick"],j=["href"],q=["onClick"],J={key:1,class:"no-errors"};function K(o,e,c,s,t,n){const m=p("core-alert-actionable"),y=p("core-wp-table"),u=p("svg-circle-check"),g=p("core-modal");return i(),C(g,{show:c.display,onClose:e[0]||(e[0]=a=>o.$emit("close")),classes:["aioseo-sitemaps-errors-modal"]},{headerTitle:b(()=>[k(d(t.strings.sitemapErrors),1)]),body:b(()=>[_("div",V,[s.searchStatisticsStore.sitemapsWithErrors.length>0?(i(),h("div",H,[f(m,{title:t.strings.thereAreSitemapsWithErrors,text:t.strings.aioseoHasFoundSomeErrorsInSitemaps,type:"yellow",size:"small"},null,8,["title","text"]),f(y,{id:s.tableId,columns:n.columns,rows:n.rows,"bulk-options":t.bulkOptions,totals:n.totals,showSearch:!1,loading:t.loading,onPaginate:s.processPagination,onProcessBulkAction:n.processBulkAction},{sitemap:b(({row:a})=>[_("a",{href:n.escUrl(a.path),target:"_blank",rel:"noopener"},d(a.path),9,L)]),actions:b(({row:a})=>[_("a",{href:"#",onClick:M(()=>n.ignoreSitemap(a.path),["prevent"])},d(t.strings.ignoreSitemap),9,Y),a.detailsUrl!==""?(i(),h(v,{key:0},[k(" | "),_("a",{href:n.escUrl(a.detailsUrl),target:"_blank",rel:"noopener"},d(t.strings.viewDetails),9,j)],64)):S("",!0),n.canRemoveSitemap(a)?(i(),h(v,{key:1},[k(" | "),_("a",{href:"#",class:"aioseo-sitemaps-errors-remove",onClick:M(()=>n.deleteSitemap(a.path),["prevent"])},d(t.strings.removeSitemap),9,q)],64)):S("",!0)]),_:1},8,["id","columns","rows","bulk-options","totals","loading","onPaginate","onProcessBulkAction"])])):(i(),h("div",J,[f(u),_("p",null,d(t.strings.allErrorsResolved),1)]))])]),_:1},8,["show"])}const G=I(R,[["render",K]]),Q="all-in-one-seo-pack",X={setup(){const{strings:o,redirectToGscSettings:e}=P();return{searchStatisticsStore:w(),settingsStore:A(),optionsStore:E(),composableStrings:o,redirectToGscSettings:e}},components:{CoreAlertActionable:T,SitemapsWithErrorsModal:G},data(){return{showErrorsModal:!1,strings:x(this.composableStrings,{yourSiteIsConnected:r("Your site is connected directly to Google Search Console and your sitemaps are in sync.",Q)})}},mounted(){this.showErrorsModal=!!N()["open-modal"]}},Z={class:"google-search-console-alerts"},$={key:1};function ee(o,e,c,s,t,n){var u,g;const m=p("core-alert-actionable"),y=p("sitemaps-with-errors-modal");return i(),h("div",Z,[!s.searchStatisticsStore.isConnected&&!((u=s.settingsStore.settings.dismissedAlerts)!=null&&u.searchConsoleNotConnected)?(i(),C(m,{key:0,title:t.strings.connectToGoogleToAddSitemaps,text:t.strings.aioseoCanNowVerify,button:t.strings.connectToGoogleSearchConsole,buttonType:"link",type:"yellow",size:"small","show-close":"",onClick:s.redirectToGscSettings,onCloseAlert:e[0]||(e[0]=()=>s.settingsStore.dismissAlert("searchConsoleNotConnected"))},null,8,["title","text","button","onClick"])):S("",!0),s.searchStatisticsStore.isConnected&&!((g=s.settingsStore.settings.dismissedAlerts)!=null&&g.searchConsoleSitemapErrors)?(i(),h("div",$,[s.searchStatisticsStore.sitemapsWithErrors.length>0?(i(),C(m,{key:0,title:t.strings.thereAreSitemapsWithErrors,text:t.strings.aioseoHasFoundSomeErrorsInSitemaps,button:t.strings.fixSitemapErrors,buttonType:"link",type:"yellow",size:"small","show-close":"",onCloseAlert:e[1]||(e[1]=()=>s.settingsStore.dismissAlert("searchConsoleSitemapErrors")),onClick:e[2]||(e[2]=()=>t.showErrorsModal=!0)},null,8,["title","text","button"])):S("",!0),f(y,{display:t.showErrorsModal,onClose:e[3]||(e[3]=a=>t.showErrorsModal=!1)},null,8,["display"])])):S("",!0)])}const ye=I(X,[["render",ee]]),te="all-in-one-seo-pack",se={setup(){const{strings:o,redirectToGscSettings:e}=P();return{optionsStore:E(),searchStatisticsStore:w(),settingsStore:A(),rootStore:W(),composableStrings:o,redirectToGscSettings:e}},components:{CoreAlertActionable:T,SitemapsWithErrorsModal:G},data(){return{showErrorsModal:!1,strings:x(this.composableStrings,{yourSiteIsConnected:r("Your site is connected directly to Google Search Console and your sitemaps are in sync.",te)})}},computed:{showIsConnected(){return this.searchStatisticsStore.isConnected&&this.optionsStore.internalOptions.internal.searchStatistics.site.verified}}},oe={class:"google-search-console-alerts-inline"};function re(o,e,c,s,t,n){var u,g;const m=p("core-alert-actionable"),y=p("sitemaps-with-errors-modal");return i(),h("div",oe,[n.showIsConnected?(i(),h(v,{key:0},[f(m,{text:t.strings.yourSiteIsConnected,type:"green",size:"small"},null,8,["text"]),s.searchStatisticsStore.sitemapsWithErrors.length>0&&((u=s.settingsStore.settings.dismissedAlerts)!=null&&u.searchConsoleSitemapErrors)?(i(),C(m,{key:0,text:t.strings.aioseoHasFoundSomeErrorsInSitemaps,button:t.strings.fixSitemapErrors,buttonType:"link",type:"yellow",size:"small",onClick:e[0]||(e[0]=()=>t.showErrorsModal=!0)},null,8,["text","button"])):S("",!0),f(y,{display:t.showErrorsModal,onClose:e[1]||(e[1]=a=>t.showErrorsModal=!1),sitemaps:s.searchStatisticsStore.sitemapsWithErrors},null,8,["display","sitemaps"])],64)):(g=s.settingsStore.settings.dismissedAlerts)!=null&&g.searchConsoleNotConnected?(i(),C(m,{key:1,text:t.strings.connectToGoogleToAddSitemaps,button:t.strings.connectToGoogleSearchConsole,buttonType:"link",type:"yellow",size:"small",onClick:s.redirectToGscSettings},null,8,["text","button","onClick"])):S("",!0)])}const Ce=I(se,[["render",re]]);export{ye as S,Ce as a,fe as u};
