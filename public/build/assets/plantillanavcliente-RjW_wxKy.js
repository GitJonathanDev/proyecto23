import{o as r,e as i,a as s,n as p,g as d,t as u,f as c,k as m,v as f,m as v}from"./app-C6Ljm75g.js";import{_ as M}from"./_plugin-vue_export-helper-DlAUqK2U.js";const y={name:"NavBar",props:{cartItemCount:{type:Number,default:0},userName:{type:String,default:"Sin Usuario"}},data(){return{selectedStyle:localStorage.getItem("selectedStyle")||"defecto",isDarkMode:JSON.parse(localStorage.getItem("isDarkMode"))||!0,isMenuOpen:!1}},methods:{toggleMobileMenu(){this.isMenuOpen=!this.isMenuOpen},logout(){axios.post("/logout").then(l=>{console.log(l.data.message),window.location.href="/login"}).catch(l=>{console.error("Error al cerrar sesión:",l)})},updateStyles(){localStorage.setItem("selectedStyle",this.selectedStyle),localStorage.setItem("isDarkMode",JSON.stringify(this.isDarkMode));const l=this.currentStyles[this.selectedStyle];document.querySelectorAll('link[rel="stylesheet"][data-page-style]').forEach(g=>g.remove());const a=document.createElement("link");a.rel="stylesheet",a.href=l,a.setAttribute("data-page-style","true"),document.head.appendChild(a)},toggleCartModal(){this.$emit("toggle-cart-modal")}},computed:{currentStyles(){return{defecto:this.isDarkMode?"/css/estiloPagClienteOscuro.css":"/css/estiloPagClienteClaro.css",ninos:this.isDarkMode?"/css/estiloPagNinoOscuro.css":"/css/estiloPagNinoClaro.css",jovenes:this.isDarkMode?"/css/estiloPagJovenOscuro.css":"/css/estiloPagJovenClaro.css",adultos:this.isDarkMode?"/css/estiloPagAdultoOscuro.css":"/css/estiloPagAdultoClaro.css"}}},mounted(){if(this.updateStyles(),!document.querySelector('link[href*="font-awesome"]')){const l=document.createElement("link");l.href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css",l.rel="stylesheet",document.head.appendChild(l)}}},S={class:"navbar"},k={class:"navbar-container"},h={key:0,class:"cart-count"},C={class:"custom-select-wrapper"},w={class:"mode-switch"},A={class:"swap swap-rotate"},b={key:0,class:"swap-off h-10 w-10 fill-current sol",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},D={key:1,class:"swap-on h-10 w-10 fill-current luna",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},x={class:"user-info"},N={class:"greeting"};function Z(l,e,a,g,n,o){return r(),i("nav",S,[s("div",k,[e[14]||(e[14]=s("a",{href:"/",class:"logo"},[s("span",{class:"logo-body"},"Body"),s("span",{class:"logo-fit"},"Fit")],-1)),s("ul",{class:p(["nav-links",{open:n.isMenuOpen}])},e[7]||(e[7]=[s("li",{class:"nav-item"},[s("a",{href:"/membresias"},"Mis Membresías")],-1),s("li",{class:"nav-item"},[s("a",{href:"/vista-cliente"},"Comprar Productos")],-1)]),2),s("div",{class:"cart-icon",onClick:e[0]||(e[0]=(...t)=>o.toggleCartModal&&o.toggleCartModal(...t))},[e[8]||(e[8]=d(" 🛒 ")),a.cartItemCount>0?(r(),i("span",h,u(a.cartItemCount),1)):c("",!0)]),s("div",C,[e[10]||(e[10]=s("label",{for:"style-select"},[d(" TEMAS "),s("i",{class:"fas fa-chevron-down"})],-1)),m(s("select",{id:"style-select","onUpdate:modelValue":e[1]||(e[1]=t=>n.selectedStyle=t),onChange:e[2]||(e[2]=(...t)=>o.updateStyles&&o.updateStyles(...t))},e[9]||(e[9]=[s("option",{value:"defecto"},"Cliente",-1),s("option",{value:"ninos"},"Niños",-1),s("option",{value:"jovenes"},"Jóvenes",-1),s("option",{value:"adultos"},"Adultos",-1)]),544),[[f,n.selectedStyle]])]),s("div",w,[s("label",A,[m(s("input",{type:"checkbox",class:"theme-controller","onUpdate:modelValue":e[3]||(e[3]=t=>n.isDarkMode=t),onChange:e[4]||(e[4]=(...t)=>o.updateStyles&&o.updateStyles(...t))},null,544),[[v,n.isDarkMode]]),n.isDarkMode?c("",!0):(r(),i("svg",b,e[11]||(e[11]=[s("path",{d:"M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"},null,-1)]))),n.isDarkMode?(r(),i("svg",D,e[12]||(e[12]=[s("path",{d:"M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"},null,-1)]))):c("",!0)])]),s("div",x,[s("span",N,"Hola, "+u(a.userName),1),s("button",{onClick:e[5]||(e[5]=(...t)=>o.logout&&o.logout(...t)),class:"logout-btn"},e[13]||(e[13]=[s("i",{class:"fas fa-sign-out-alt"},null,-1),d(" Cerrar Sesión ")]))]),s("button",{onClick:e[6]||(e[6]=(...t)=>o.toggleMobileMenu&&o.toggleMobileMenu(...t)),class:"menu-toggle"},u(n.isMenuOpen?"Cerrar":"Desplegar"),1)])])}const I=M(y,[["render",Z],["__scopeId","data-v-56026c86"]]);export{I as p};