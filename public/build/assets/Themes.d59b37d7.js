import{K as M,j as A,r as d,T as E,e as N,o as a,c as g,w as k,b as r,u as n,Z as O,a as e,f as u,s as w,d as c,i as y,F as j,O as T}from"../app.js";import{_ as F}from"./AuthenticatedLayout.44fd2bff.js";import{_ as P}from"./Modal.4b7d0677.js";import{_ as C}from"./Button.7aedc941.js";import{t as i}from"./useToast.e3f4d0c9.js";import{r as m}from"./CheckCircleIcon.a00ffa1a.js";import{r as R}from"./PlusCircleIcon.c72ca0fb.js";const Y=e("div",{class:"h-screen w-full bg-gray-900/60 fixed top-0"},null,-1),K={class:"z-20 md:max-w-7xl w-full mx-auto relative flex flex-col h-screen px-6 pb-12 md:pb-0"},L=e("h1",{class:"text-white text-3xl mt-24 md:mt-12 text-center"}," Background Image ",-1),Z=e("h2",{class:"text-white font-medium text-2xl mt-8"}," My Backgrounds ",-1),q=e("hr",{class:"my-5 border-gray-600"},null,-1),D={class:"grid grid-cols-1 md:grid-cols-3 gap-3"},G=["onClick"],H=["src"],J=["onClick"],Q={class:"absolute top-3 right-3"},W=e("h3",{class:"font-medium"}," Upload Image ",-1),X=e("p",{class:"text-gray-600 text-sm"}," Click here to start adding your own background image. You can add up to 10 images only ",-1),ee=e("h2",{class:"text-white font-medium text-2xl mt-8"}," System Background ",-1),te=e("hr",{class:"my-5 border-gray-600"},null,-1),se={class:"w-full items-stretch pb-24 md:pb-40 grid grid-cols-1 md:grid-cols-3 gap-3"},oe=["onClick"],ae=["src"],re={class:"text-center"},le=e("h1",{class:"mt-2"}," Change Background ",-1),ne=e("p",{class:"text-sm md:text-base max-w-md mx-auto leading-6 mt-2 font-light"}," Are you sure you want to switch your current background image to this? You can still switch back if you'd like to. ",-1),ce={class:"flex items-center justify-center gap-x-2 mt-4"},fe={__name:"Themes",props:{backgroundImages:Object},setup(h){const B=h,p=M(),f=A(()=>{var s;return(s=p.props.auth.user.background_image)!=null?s:"/images/bg1.jpg"}),o=d(!1),_=d(""),b=d(""),v=E({image:null});N(()=>{console.log(B.backgroundImages)});const I=["/images/bg1.jpg","/images/bg2.jpg","/images/bg3.jpg","/images/bg4.jpg","/images/bg5.jpg","/images/bg6.jpg","/images/bg7.jpg","/images/bg8.jpg"],x=s=>{o.value=!o.value,_.value=s},S=()=>{b.value.click()},U=s=>{if(s.target.files&&s.target.files[0]&&s.target.files[0].size>8388608)return s.target.value="",i.error("Sorry! Image size limit is 8mb only.");v.image=s.target.files[0],z()},$=()=>{T.put(`user/${p.props.auth.user.id}/switch-background`,{img:_.value},{onSuccess:()=>{o.value=!1},onError:()=>{i.error("Something went wrong. Please try again!")}})},z=()=>{v.post(route("themes.image-upload"),{onSuccess:()=>i.success("Image has been uploaded successfully!"),onError:()=>i.success("Upload of image failed. Please try again")})};return(s,l)=>(a(),g(F,null,{default:k(()=>[r(n(O),{title:"Themes"}),Y,e("div",K,[L,Z,q,e("div",D,[(a(!0),u(j,null,w(h.backgroundImages,t=>(a(),u("div",{key:t,class:"relative w-full h-[160px] md:h-[200px] rounded-md border border-gray-200/30 object-cover items-stretch hover:-translate-y-1 cursor-pointer ease-out duration-150",onClick:c(V=>x(t.image),["prevent"])},[f.value===t.image?(a(),g(n(m),{key:0,class:"w-6 md:w-7 text-green-600 absolute top-2 right-3 z-20"})):y("",!0),e("img",{src:t.image,alt:"Background Image",class:"object-cover w-full h-full rounded-md brightness-75 hover:brightness-100"},null,8,H)],8,G))),128)),e("div",{class:"bg-white relative h-fit hover:-translate-y-1 active:bg-gray-200 duration-200 ease-out w-full rounded-md shadow px-5 py-6 cursor-pointer",onClick:c(S,["stop"])},[e("div",Q,[r(n(R),{class:"w-6 text-green-600 hover:text-green-700"})]),W,X,e("input",{id:"imageUpload",ref_key:"imageUploadRef",ref:b,type:"file",name:"imageUpload",class:"hidden",onChange:U},null,544)],8,J)]),ee,te,e("div",se,[(a(),u(j,null,w(I,t=>e("div",{key:t,class:"relative w-full h-[160px] md:h-[200px] rounded-md border border-gray-200/30 object-cover items-stretch hover:-translate-y-1 cursor-pointer ease-out duration-150",onClick:c(V=>x(t),["prevent"])},[f.value===t?(a(),g(n(m),{key:0,class:"w-6 md:w-7 text-green-600 absolute top-2 right-3 z-20"})):y("",!0),e("img",{src:t,alt:"Background Image",class:"object-cover w-full h-full rounded-md brightness-75 hover:brightness-100"},null,8,ae)],8,oe)),64))])]),r(P,{modelValue:o.value,"onUpdate:modelValue":l[1]||(l[1]=t=>o.value=t)},{default:k(()=>[e("div",re,[r(n(m),{class:"w-10 md:w-14 mx-auto text-green-600"}),le,ne]),e("div",ce,[r(C,{label:"Cancel",color:"gray",onClick:l[0]||(l[0]=c(t=>o.value=!1,["prevent"]))}),r(C,{label:"Switch Background",color:"success",onClick:c($,["prevent"])},null,8,["onClick"])])]),_:1},8,["modelValue"])]),_:1}))}};export{fe as default};