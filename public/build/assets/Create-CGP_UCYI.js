import{T as q,d as S,l as U,q as A,s as h,e as l,b as t,w as v,F as x,o as n,a as r,i as D,u as s,f as c,k as R,v as $,h as E,t as B,g as C}from"./app-C6Ljm75g.js";import{_ as p}from"./InputLabel-B9Ydpcgw.js";import{_ as b}from"./InputError-DNwQAqX2.js";import{_ as f}from"./TextInput-CSJ5jCkD.js";import{_ as M}from"./PrimaryButton-DXw7G3WG.js";import{p as T}from"./plantillanav-IzOOFMsV.js";import{V as j}from"./VisitaFooter-fQvL4C6g.js";import{_ as z}from"./_plugin-vue_export-helper-DlAUqK2U.js";/* empty css                                                                     */const G={class:"py-12"},O={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},H={class:"overflow-hidden shadow-xl sm:rounded-lg divgrande"},J={class:"p-6 lg:p-8 border-gray-200 divpequeno"},K={class:"mb-4"},Q={key:0,class:"text-red-500 text-sm dd"},W={class:"mb-4"},X={key:0,class:"text-red-500 text-sm dd"},Y={class:"mb-4"},Z={key:0,class:"text-red-500 text-sm dd"},ee={class:"mb-4"},oe={key:0,class:"text-red-500 text-sm dd"},te={class:"mb-4"},re=["value"],se={key:0,class:"text-red-500 text-sm dd"},ae={class:"mb-4"},de=["src"],le={key:1,class:"text-red-500 text-sm dd"},ne={class:"text-center"},ie={__name:"Create",props:{categorias:Array,errors:Object},setup(m){const o=q({codProducto:"",nombre:"",descripcion:"",precio:"",codCategoriaF:"",imagen:null}),_=S(null),i=a=>{const e=o[a];if(a==="precio")return parseFloat(e)>0;if(a==="codCategoriaF")return e&&e!=="";if(a==="imagen")return!!e;const u={codProducto:2,nombre:2,descripcion:5},g={codProducto:20,nombre:50,descripcion:250};return e.length>=u[a]&&e.length<=g[a]},F=()=>i("codProducto"),y=()=>i("nombre"),P=()=>i("descripcion"),V=()=>i("precio"),k=()=>i("codCategoriaF"),w=()=>i("imagen"),I=U(()=>["codProducto","nombre","descripcion","precio","codCategoriaF","imagen"].every(i)),L=a=>{const e=a.target.files[0];if(e){o.imagen=e;const u=new FileReader;u.onload=g=>{_.value=g.target.result},u.readAsDataURL(e)}},N=()=>{o.post(route("producto.store"),{onSuccess:()=>{router.get(route("producto.index"))}})};return A(()=>[o.codProducto,o.nombre,o.descripcion,o.precio,o.codCategoriaF],()=>{}),(a,e)=>{const u=h("Link"),g=h("AppLayout");return n(),l(x,null,[t(T,{userName:a.$page.props.auth.user.name},null,8,["userName"]),t(g,{title:"Registrar Producto"},{header:v(()=>e[6]||(e[6]=[r("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Registrar Producto ",-1)])),default:v(()=>[r("div",G,[r("div",O,[r("div",H,[r("div",J,[e[10]||(e[10]=r("h1",{class:"text-2xl font-bold text-center mb-6"},"Registrar Producto",-1)),r("form",{onSubmit:D(N,["prevent"]),novalidate:""},[r("div",K,[t(p,{for:"codProducto",value:"Código del Producto",class:"bb"}),t(b,{message:m.errors.codProducto},null,8,["message"]),t(f,{modelValue:s(o).codProducto,"onUpdate:modelValue":e[0]||(e[0]=d=>s(o).codProducto=d),id:"codProducto",class:"mt-1 block w-full cc",placeholder:"Ingrese el código del producto",required:"",onInput:a.validateForm},null,8,["modelValue","onInput"]),!F()&&s(o).codProducto.length>0?(n(),l("div",Q," * El código debe tener entre 2 y 20 caracteres. ")):c("",!0)]),r("div",W,[t(p,{for:"nombre",value:"Nombre",class:"bb"}),t(b,{message:m.errors.nombre},null,8,["message"]),t(f,{modelValue:s(o).nombre,"onUpdate:modelValue":e[1]||(e[1]=d=>s(o).nombre=d),id:"nombre",class:"mt-1 block w-full cc",placeholder:"Ingrese el nombre del producto",required:"",onInput:a.validateForm},null,8,["modelValue","onInput"]),!y()&&s(o).nombre.length>0?(n(),l("div",X," * El nombre debe tener entre 2 y 50 caracteres. ")):c("",!0)]),r("div",Y,[t(p,{for:"descripcion",value:"Descripción",class:"bb"}),t(b,{message:m.errors.descripcion},null,8,["message"]),t(f,{modelValue:s(o).descripcion,"onUpdate:modelValue":e[2]||(e[2]=d=>s(o).descripcion=d),id:"descripcion",class:"mt-1 block w-full cc",placeholder:"Ingrese la descripción",required:"",onInput:a.validateForm},null,8,["modelValue","onInput"]),!P()&&s(o).descripcion.length>0?(n(),l("div",Z," * La descripción debe tener entre 5 y 250 caracteres. ")):c("",!0)]),r("div",ee,[t(p,{for:"precio",value:"Precio",class:"bb"}),t(b,{message:m.errors.precio},null,8,["message"]),t(f,{modelValue:s(o).precio,"onUpdate:modelValue":e[3]||(e[3]=d=>s(o).precio=d),type:"number",id:"precio",class:"mt-1 block w-full cc",placeholder:"Ingrese el precio",required:"",onInput:a.validateForm},null,8,["modelValue","onInput"]),!V()&&s(o).precio?(n(),l("div",oe," * El precio debe ser mayor a 0. ")):c("",!0)]),r("div",te,[t(p,{for:"codCategoriaF",value:"Categoría",class:"bb"}),t(b,{message:m.errors.codCategoriaF},null,8,["message"]),R(r("select",{"onUpdate:modelValue":e[4]||(e[4]=d=>s(o).codCategoriaF=d),id:"codCategoriaF",class:"form-select mt-1 block w-full ee",required:"",onChange:e[5]||(e[5]=(...d)=>a.validateForm&&a.validateForm(...d))},[e[7]||(e[7]=r("option",{value:""},"Seleccione una categoría",-1)),(n(!0),l(x,null,E(m.categorias,d=>(n(),l("option",{key:d.codCategoria,value:d.codCategoria},B(d.nombre),9,re))),128))],544),[[$,s(o).codCategoriaF]]),!k()&&s(o).codCategoriaF?(n(),l("div",se," * Seleccione una categoría. ")):c("",!0)]),r("div",ae,[t(p,{for:"imagen",value:"Imagen",class:"bb"}),r("input",{type:"file",id:"imagen",class:"form-control mt-1 ee",accept:"image/*",onChange:L},null,32),_.value?(n(),l("img",{key:0,src:_.value,alt:"Previsualización",class:"img-fluid mt-2"},null,8,de)):c("",!0),!w()&&s(o).imagen?(n(),l("div",le," * La imagen es obligatoria. ")):c("",!0)]),r("div",ne,[t(u,{href:"{{ route('producto.index') }}",class:"btn btn-secondary me-3"},{default:v(()=>e[8]||(e[8]=[r("i",{class:"fas fa-arrow-left"},null,-1),C(" Atrás ")])),_:1}),t(M,{disabled:!I.value||s(o).processing,class:"mt-4 btn-primary"},{default:v(()=>e[9]||(e[9]=[r("i",{class:"fas fa-save"},null,-1),C(" Guardar ")])),_:1},8,["disabled"])])],32)])])]),t(j)])]),_:1})],64)}}},he=z(ie,[["__scopeId","data-v-93dac524"]]);export{he as default};
