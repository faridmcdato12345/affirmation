import{j as a,o as n,c as d,w as p,a as r,f,i as y,k as g,t as m,n as b,l as x,u as h,m as v}from"../app.js";const k={class:"flex mx-auto"},B={key:0,class:"animate-spin -ml-1 mr-3 h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},w=r("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"},null,-1),C=r("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"},null,-1),S=[w,C],_={__name:"Button",props:{label:{type:String,required:!0},uppercase:{type:Boolean,default:!1},btnBlock:{type:Boolean,default:!1},color:{type:String,default:"primary"},outline:{type:Boolean,default:!1},size:{type:String,default:"base"},rounded:{type:Boolean,default:!1},componentType:{type:String,default:"button"},href:{type:String,default:""},type:{type:String,default:"button"},loading:{type:Boolean,default:!1},darken:{type:Boolean,default:!1}},setup(t){const e=t,s={sm:"px-4 py-2 text-xs",base:"px-4 py-2.5 text-sm",lg:"px-14 py-3 text-lg",xl:"px-14 py-3 text-xl"},o={success:"green",error:"red",warning:"orange",primary:"blue",gray:"gray","theme-color-green":"#096A2E"},l=a(()=>({normal:e.darken?"700":"600",hover:e.darken?"800":"700",active:e.darken?"900":"800"})),c=a(()=>e.uppercase?e.label.toUpperCase():e.label),i=a(()=>s[e.size]),u=a(()=>e.outline?`border-2 border-${o[e.color]}-600 border-solid`:`
    bg-${o[e.color]}-${l.value.normal} 
    hover:bg-${o[e.color]}-${l.value.hover} 
    active:bg-${o[e.color]}-${l.value.active}
    disabled:hover:bg-${o[e.color]}-600 
    focus:ring focus:ring-${o[e.color]}-600`);return($,z)=>(n(),d(x(t.componentType=="link"?h(v):"button"),{href:t.href,type:t.type,disabled:t.loading,class:b(["duration-150 ease-out text-white text-center flex",i.value,u.value,{"w-full block":t.btnBlock},t.rounded?"rounded-full":"rounded-lg"])},{default:p(()=>[r("span",k,[t.loading?(n(),f("svg",B,S)):y("",!0),g(" "+m(c.value),1)])]),_:1},8,["href","type","disabled","class"]))}};export{_};