import{T as w,d as P,q as i,l as g,s as E,e as p,b as l,w as f,F as _,o as b,a as o,g as v,t as y,f as V,u as s,h,i as A,k as q,v as S,n as z,x as N}from"./app-C6Ljm75g.js";import{_ as m}from"./InputError-DNwQAqX2.js";import{_ as c}from"./InputLabel-B9Ydpcgw.js";import{_ as u}from"./TextInput-CSJ5jCkD.js";import{_ as U}from"./PrimaryButton-DXw7G3WG.js";import{p as Z}from"./plantillanav-IzOOFMsV.js";import{_ as C}from"./_plugin-vue_export-helper-DlAUqK2U.js";const L={class:"py-12"},F={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},B={class:"overflow-hidden shadow-xl sm:rounded-lg divgrande"},T={class:"p-6 lg:p-8 border-gray-200 divpequeno"},j={key:0,class:"alert alert-success mb-4 p-3 rounded-md shadow-md text-green-800 bg-green-100"},D={key:1,class:"alert alert-danger"},O={class:"mb-4"},G={class:"mb-4"},H={class:"mb-4"},J={class:"mb-4"},K={class:"mb-4"},Q={class:"mb-4"},R=["selected"],W=["selected"],X={class:"mb-4"},Y={class:"text-center mt-4"},ee={__name:"Edit",props:{vendedor:Object,errors:Object,sessionSuccess:String},setup(I){const n=I,e=w({carnetIdentidad:n.vendedor.carnetIdentidad||"",nombre:n.vendedor.nombre||"",apellidoPaterno:n.vendedor.apellidoPaterno||"",apellidoMaterno:n.vendedor.apellidoMaterno||"",sexo:n.vendedor.sexo||"",telefono:n.vendedor.telefono||"",edad:n.vendedor.edad||""}),r=P({carnetIdentidad:"",nombre:"",apellidoPaterno:"",apellidoMaterno:"",sexo:"",telefono:"",edad:""});i(()=>e.carnetIdentidad,a=>{r.value.carnetIdentidad=/^\d{8,10}$/.test(a)?"":"La cédula de identidad debe tener entre 8 y 10 caracteres."}),i(()=>e.nombre,a=>{r.value.nombre=/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(a)?"":"El nombre debe tener entre 3 y 30 caracteres y solo debe contener letras."}),i(()=>e.apellidoPaterno,a=>{r.value.apellidoPaterno=/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(a)?"":"El apellido paterno debe tener entre 3 y 30 caracteres y solo debe contener letras."}),i(()=>e.apellidoMaterno,a=>{r.value.apellidoMaterno=/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(a)?"":"El apellido materno debe tener entre 3 y 30 caracteres y solo debe contener letras."}),i(()=>e.telefono,a=>{r.value.telefono=/^\d{8,10}$/.test(a)?"":"El teléfono debe tener entre 8 y 10 dígitos."}),i(()=>e.edad,a=>{r.value.edad=/^\d+$/.test(a)&&a>=18&&a<=100?"":"La edad debe ser un número entre 18 y 100."}),i(()=>e.sexo,a=>{r.value.sexo=a?"":"El sexo es obligatorio."});const M=()=>{e.put(route("encargado.update",n.vendedor.carnetIdentidad),{onSuccess:()=>{N.get(route("encargado.index"))}})};g(()=>/^\d{8,10}$/.test(e.carnetIdentidad)&&/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(e.nombre)&&/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(e.apellidoPaterno)&&/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,30}$/.test(e.apellidoMaterno)&&e.sexo!==""&&/^\d{8,10}$/.test(e.telefono)&&/^\d+$/.test(e.edad)&&e.edad>=18&&e.edad<=100);const x=g(()=>n.sessionSuccess);return(a,t)=>{const $=E("AppLayout");return b(),p(_,null,[l(Z,{userName:a.$page.props.auth.user.name},null,8,["userName"]),l($,{title:"Editar Proveedor"},{header:f(()=>t[7]||(t[7]=[o("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Editar Proveedor ",-1)])),default:f(()=>[o("div",L,[o("div",F,[o("div",B,[o("div",T,[t[12]||(t[12]=o("h1",{class:"text-2xl font-bold text-center mb-6"},"Editar Proveedor",-1)),x.value?(b(),p("div",j,[t[8]||(t[8]=o("strong",null,"¡Éxito!",-1)),v(" "+y(x.value),1)])):V("",!0),s(e).errors?(b(),p("div",D,[o("ul",null,[(b(!0),p(_,null,h(s(e).errors,(d,k)=>(b(),p("li",{key:k},y(d),1))),128))])])):V("",!0),o("form",{onSubmit:A(M,["prevent"])},[o("div",O,[l(c,{for:"carnetIdentidad",value:"Cédula de Identidad",class:"bb"}),l(u,{modelValue:s(e).carnetIdentidad,"onUpdate:modelValue":t[0]||(t[0]=d=>s(e).carnetIdentidad=d),id:"carnetIdentidad",type:"text",class:"mt-1 block w-full cc",placeholder:"Ingrese la cédula de identidad",required:""},null,8,["modelValue"]),l(m,{message:r.value.carnetIdentidad,class:"text-red-500 text-sm dd"},null,8,["message"])]),o("div",G,[l(c,{for:"nombre",value:"Nombre",class:"bb"}),l(u,{modelValue:s(e).nombre,"onUpdate:modelValue":t[1]||(t[1]=d=>s(e).nombre=d),id:"nombre",type:"text",class:"mt-1 block w-full cc",placeholder:"Ingrese el nombre",required:""},null,8,["modelValue"]),l(m,{message:r.value.nombre,class:"text-red-500 text-sm dd"},null,8,["message"])]),o("div",H,[l(c,{for:"apellidoPaterno",value:"Apellido Paterno",class:"bb"}),l(u,{modelValue:s(e).apellidoPaterno,"onUpdate:modelValue":t[2]||(t[2]=d=>s(e).apellidoPaterno=d),id:"apellidoPaterno",type:"text",class:"mt-1 block w-full cc",placeholder:"Ingrese el apellido paterno",required:""},null,8,["modelValue"]),l(m,{message:r.value.apellidoPaterno,class:"text-red-500 text-sm dd"},null,8,["message"])]),o("div",J,[l(c,{for:"apellidoMaterno",value:"Apellido Materno",class:"bb"}),l(u,{modelValue:s(e).apellidoMaterno,"onUpdate:modelValue":t[3]||(t[3]=d=>s(e).apellidoMaterno=d),id:"apellidoMaterno",type:"text",class:"mt-1 block w-full cc",placeholder:"Ingrese el apellido materno",required:""},null,8,["modelValue"]),l(m,{message:r.value.apellidoMaterno,class:"text-red-500 text-sm dd"},null,8,["message"])]),o("div",K,[l(c,{for:"edad",value:"Edad",class:"bb"}),l(u,{modelValue:s(e).edad,"onUpdate:modelValue":t[4]||(t[4]=d=>s(e).edad=d),id:"edad",type:"number",class:"mt-1 block w-full cc",placeholder:"Ingrese la edad",required:""},null,8,["modelValue"]),l(m,{message:r.value.edad,class:"text-red-500 text-sm dd"},null,8,["message"])]),o("div",Q,[l(c,{for:"sexo",value:"Sexo",class:"bb"}),q(o("select",{"onUpdate:modelValue":t[5]||(t[5]=d=>s(e).sexo=d),id:"sexo",class:"mt-1 block w-full cc",required:""},[t[9]||(t[9]=o("option",{value:""},"Seleccione el sexo",-1)),o("option",{value:"masculino",selected:s(e).sexo==="masculino"},"Masculino",8,R),o("option",{value:"femenino",selected:s(e).sexo==="femenino"},"Femenino",8,W)],512),[[S,s(e).sexo]]),l(m,{message:r.value.sexo,class:"text-red-500 text-sm dd"},null,8,["message"])]),o("div",X,[l(c,{for:"telefono",value:"Teléfono",class:"bb"}),l(u,{modelValue:s(e).telefono,"onUpdate:modelValue":t[6]||(t[6]=d=>s(e).telefono=d),id:"telefono",type:"tel",class:"mt-1 block w-full cc",placeholder:"Ingrese el teléfono",required:""},null,8,["modelValue"]),l(m,{message:r.value.telefono,class:"text-red-500 text-sm dd"},null,8,["message"])]),o("div",Y,[t[11]||(t[11]=o("button",{onclick:"history.back()",class:"btn btn-secondary me-2 ff"},[o("i",{class:"fas fa-arrow-left"}),v(" Atrás ")],-1)),l(U,{type:"submit",class:z(["mt-4 btn-primary ff",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:f(()=>t[10]||(t[10]=[o("i",{class:"fas fa-pencil-alt"},null,-1),v(" Modificar ")])),_:1},8,["class","disabled"])])],32)])])])])]),_:1})],64)}}},ne=C(ee,[["__scopeId","data-v-d7cb2e9f"]]);export{ne as default};
