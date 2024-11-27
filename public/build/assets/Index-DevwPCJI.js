import{d as p,s as E,e as m,b as a,w as l,F as C,o as u,a as e,u as b,j as c,i as F,k as L,v as j,h as S,t as r,g as o,f as V,x as k}from"./app-C6Ljm75g.js";import{_ as A}from"./PrimaryButton-DXw7G3WG.js";import{a as I}from"./DialogModal-4e0TKDxe.js";import{_ as T}from"./TextInput-CSJ5jCkD.js";import{p as q}from"./plantillanav-IzOOFMsV.js";import{V as O}from"./VisitaFooter-fQvL4C6g.js";import{_ as U}from"./_plugin-vue_export-helper-DlAUqK2U.js";/* empty css                                                                     */const G={class:"py-12"},P={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},Q={class:"overflow-hidden shadow-xl sm:rounded-lg divgrande"},R={class:"p-6 lg:p-8 border-gray-200 divpequeno"},z={class:"flex justify-between items-center mb-6"},H={class:"overflow-x-auto"},J={class:"table-auto w-full text-sm"},K={class:"p-3"},W={class:"p-3"},X={class:"p-3"},Y={class:"p-3"},Z={class:"p-3"},ee={class:"p-3 text-center"},se=["onClick"],te={class:"flex justify-between mt-4"},ae={key:0},le={key:1},oe={__name:"Index",props:{membresias:Object},setup(n){const i=p(!1),f=p(null),v=p(""),x=p("descripcion"),N=d=>{f.value=d,i.value=!0},$=()=>{f.value&&(k.delete(route("membresia.destroy",f.value.codMembresia)),i.value=!1)},B=()=>{k.get(route("membresia.index"),{criterio:x.value,buscar:v.value})};return(d,s)=>{const D=E("AppLayout");return u(),m(C,null,[a(q,{userName:d.$page.props.auth.user.name},null,8,["userName"]),a(D,{title:"Gestionar Membresías"},{header:l(()=>s[4]||(s[4]=[e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Lista de Membresías ",-1)])),default:l(()=>{var g,_,h,y;return[e("div",G,[e("div",P,[e("div",Q,[e("div",R,[s[13]||(s[13]=e("h1",{class:"text-2xl font-bold text-center mb-6"},"Lista de Membresías",-1)),e("div",z,[a(b(c),{href:d.route("membresia.create"),class:"btn btn-primary inline-flex items-center space-x-2"},{default:l(()=>s[5]||(s[5]=[e("i",{class:"fas fa-plus"},null,-1),e("span",null,"Registrar",-1)])),_:1},8,["href"]),e("form",{onSubmit:F(B,["prevent"]),class:"flex space-x-2"},[L(e("select",{"onUpdate:modelValue":s[0]||(s[0]=t=>x.value=t),class:"form-select w-32"},s[6]||(s[6]=[e("option",{value:"descripcion"},"Descripción",-1)]),512),[[j,x.value]]),a(T,{modelValue:v.value,"onUpdate:modelValue":s[1]||(s[1]=t=>v.value=t),class:"w-full",placeholder:"Buscar Membresía"},null,8,["modelValue"]),s[7]||(s[7]=e("button",{type:"submit",class:"btn btn-outline-secondary flex items-center space-x-2"},[e("i",{class:"fas fa-search"}),e("span",null,"Buscar")],-1))],32)]),e("div",H,[e("table",J,[s[10]||(s[10]=e("thead",null,[e("tr",null,[e("th",{class:"p-3 text-left"},"Código Membresía"),e("th",{class:"p-3 text-left"},"Descripción"),e("th",{class:"p-3 text-left"},"Precio Total"),e("th",{class:"p-3 text-left"},"Cliente"),e("th",{class:"p-3 text-left"},"Encargado"),e("th",{class:"p-3 text-center"},"Opciones")])],-1)),e("tbody",null,[(u(!0),m(C,null,S(n.membresias.data,t=>{var w,M;return u(),m("tr",{key:t.codMembresia,class:"border-b"},[e("td",K,r(t.codMembresia),1),e("td",W,r(t.descripcion),1),e("td",X,"Bs. "+r(t.precioTotal.toFixed(2)),1),e("td",Y,r(((w=t.cliente)==null?void 0:w.nombre)||"No disponible"),1),e("td",Z,r(((M=t.encargado)==null?void 0:M.nombre)||"No disponible"),1),e("td",ee,[a(b(c),{href:d.route("membresia.show",t.codMembresia),class:"btn btn-info btn-sm mx-1"},{default:l(()=>s[8]||(s[8]=[e("i",{class:"fas fa-eye"},null,-1),o(" Ver Detalle ")])),_:2},1032,["href"]),e("button",{onClick:re=>N(t),class:"btn btn-danger btn-sm mx-1"},s[9]||(s[9]=[e("i",{class:"fas fa-trash"},null,-1),o(" Eliminar ")]),8,se)])])}),128))])])]),e("div",te,[(g=n.membresias)!=null&&g.prev_page_url?(u(),m("div",ae,[a(b(c),{href:(_=n.membresias)==null?void 0:_.prev_page_url,class:"btn btn-primary"},{default:l(()=>s[11]||(s[11]=[e("i",{class:"fas fa-arrow-left"},null,-1),o(" Anterior ")])),_:1},8,["href"])])):V("",!0),(h=n.membresias)!=null&&h.next_page_url?(u(),m("div",le,[a(b(c),{href:(y=n.membresias)==null?void 0:y.next_page_url,class:"btn btn-primary"},{default:l(()=>s[12]||(s[12]=[o(" Siguiente "),e("i",{class:"fas fa-arrow-right"},null,-1)])),_:1},8,["href"])])):V("",!0)])])])]),a(O)]),a(I,{show:i.value,onClose:s[3]||(s[3]=t=>i.value=!1)},{title:l(()=>s[14]||(s[14]=[e("h1",{class:"text-lg font-semibold"},"Confirmar Eliminación",-1)])),content:l(()=>{var t;return[e("p",null,[s[15]||(s[15]=o("¿Estás seguro de que deseas eliminar la membresía ")),e("strong",null,r((t=f.value)==null?void 0:t.descripcion),1),s[16]||(s[16]=o("?"))])]}),footer:l(()=>[a(A,{onClick:$,class:"bg-red-600 hover:bg-red-800"},{default:l(()=>s[17]||(s[17]=[o("Eliminar")])),_:1}),e("button",{onClick:s[2]||(s[2]=t=>i.value=!1),class:"ml-4 btn btn-secondary"},"Cancelar")]),_:1},8,["show"])]}),_:1})],64)}}},ce=U(oe,[["__scopeId","data-v-02856e44"]]);export{ce as default};