import{d as _,s as N,e as d,b as a,w as o,F as C,o as u,a as e,u as m,j as c,h as $,t as p,g as l,f as y,x as E}from"./app-C6Ljm75g.js";import{_ as V}from"./PrimaryButton-DXw7G3WG.js";import{a as B}from"./DialogModal-4e0TKDxe.js";import{_ as L}from"./TextInput-CSJ5jCkD.js";import{p as j}from"./plantillanav-IzOOFMsV.js";import{V as F}from"./VisitaFooter-fQvL4C6g.js";import{_ as A}from"./_plugin-vue_export-helper-DlAUqK2U.js";/* empty css                                                                     */const I={class:"py-12"},q={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},D={class:"overflow-hidden shadow-xl sm:rounded-lg divgrande"},O={class:"p-6 lg:p-8 border-gray-200 divpequeno"},S={class:"flex justify-between items-center mb-6"},G=["action"],M={class:"input-group flex items-center space-x-2"},R={class:"overflow-x-auto"},T={class:"table-auto w-full text-sm"},z={class:"p-3"},H={class:"p-3"},J={class:"p-3 text-center"},K=["onClick"],P={class:"flex justify-between mt-4"},Q={key:0},U={key:1},W={__name:"Index",props:{categorias:Object},setup(n){const i=_(!1),f=_(null),h=r=>{f.value=r,i.value=!0},w=()=>{f.value&&(E.delete(route("categoria.destroy",f.value.codCategoria)),i.value=!1)};return(r,t)=>{const k=N("AppLayout");return u(),d(C,null,[a(j,{userName:r.$page.props.auth.user.name},null,8,["userName"]),a(k,{title:"Gestionar Categorías"},{header:o(()=>t[2]||(t[2]=[e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Lista de Categorías ",-1)])),default:o(()=>{var g,b,x,v;return[e("div",I,[e("div",q,[e("div",D,[e("div",O,[t[11]||(t[11]=e("h1",{class:"text-2xl font-bold text-center mb-6"},"Lista de Categorías",-1)),e("div",S,[a(m(c),{href:r.route("categoria.create"),class:"btn btn-primary inline-flex items-center space-x-2"},{default:o(()=>t[3]||(t[3]=[e("i",{class:"fas fa-plus"},null,-1),e("span",null,"Registrar",-1)])),_:1},8,["href"]),e("form",{action:r.route("categoria.index"),method:"get",class:"flex items-center space-x-2"},[e("div",M,[t[4]||(t[4]=e("select",{name:"criterio",class:"form-select"},[e("option",{value:"nombre"},"Nombre")],-1)),a(L,{class:"w-full",name:"buscar",placeholder:"Buscar categoría"}),t[5]||(t[5]=e("button",{type:"submit",class:"btn btn-outline-secondary flex items-center space-x-2"},[e("i",{class:"fas fa-search"}),e("span",null,"Buscar")],-1))])],8,G)]),e("div",R,[e("table",T,[t[8]||(t[8]=e("thead",null,[e("tr",null,[e("th",{class:"p-3 text-left"},"Código de Categoría"),e("th",{class:"p-3 text-left"},"Nombre"),e("th",{class:"p-3 text-center"},"Opciones")])],-1)),e("tbody",null,[(u(!0),d(C,null,$(n.categorias.data,s=>(u(),d("tr",{key:s.codCategoria,class:"border-b"},[e("td",z,p(s.codCategoria),1),e("td",H,p(s.nombre),1),e("td",J,[a(m(c),{href:r.route("categoria.edit",s.codCategoria),class:"btn btn-warning btn-sm mx-1"},{default:o(()=>t[6]||(t[6]=[e("i",{class:"fas fa-edit"},null,-1),l(" Editar ")])),_:2},1032,["href"]),e("button",{onClick:X=>h(s),class:"btn btn-danger btn-sm mx-1"},t[7]||(t[7]=[e("i",{class:"fas fa-trash"},null,-1),l(" Eliminar ")]),8,K)])]))),128))])])]),e("div",P,[(g=n.categorias)!=null&&g.prev_page_url?(u(),d("div",Q,[a(m(c),{href:(b=n.categorias)==null?void 0:b.prev_page_url,class:"btn btn-primary"},{default:o(()=>t[9]||(t[9]=[e("i",{class:"fas fa-arrow-left"},null,-1),l(" Anterior ")])),_:1},8,["href"])])):y("",!0),(x=n.categorias)!=null&&x.next_page_url?(u(),d("div",U,[a(m(c),{href:(v=n.categorias)==null?void 0:v.next_page_url,class:"btn btn-primary"},{default:o(()=>t[10]||(t[10]=[l(" Siguiente "),e("i",{class:"fas fa-arrow-right"},null,-1)])),_:1},8,["href"])])):y("",!0)])])])])]),a(B,{show:i.value,onClose:t[1]||(t[1]=s=>i.value=!1)},{title:o(()=>t[12]||(t[12]=[e("h1",{class:"text-lg font-semibold"},"Confirmar Eliminación",-1)])),content:o(()=>{var s;return[e("p",null,[t[13]||(t[13]=l("¿Estás seguro de que deseas eliminar la categoría ")),e("strong",null,p((s=f.value)==null?void 0:s.nombre),1),t[14]||(t[14]=l("?"))])]}),footer:o(()=>[a(V,{onClick:w,class:"bg-red-600 hover:bg-red-800"},{default:o(()=>t[15]||(t[15]=[l("Eliminar")])),_:1}),e("button",{onClick:t[0]||(t[0]=s=>i.value=!1),class:"ml-4 btn btn-secondary"},"Cancelar")]),_:1},8,["show"])]}),_:1}),a(F)],64)}}},re=A(W,[["__scopeId","data-v-f444347c"]]);export{re as default};
