import{T as d,e as m,b as s,u as a,w as l,F as f,o as i,Z as c,a as o,t as p,f as _,n as w,g,i as y}from"./app-C6Ljm75g.js";import{A as b}from"./AuthenticationCard-CCWG2tCo.js";import{_ as x}from"./AuthenticationCardLogo-TrBGoRwW.js";import{_ as k}from"./InputError-DNwQAqX2.js";import{_ as V}from"./InputLabel-B9Ydpcgw.js";import{_ as v}from"./PrimaryButton-DXw7G3WG.js";import{_ as F}from"./TextInput-CSJ5jCkD.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const N={key:0,class:"mb-4 font-medium text-sm text-green-600"},$={class:"flex items-center justify-end mt-4"},q={__name:"ForgotPassword",props:{status:String},setup(r){const e=d({email:""}),n=()=>{e.post(route("password.email"))};return(C,t)=>(i(),m(f,null,[s(a(c),{title:"Forgot Password"}),s(b,null,{logo:l(()=>[s(x)]),default:l(()=>[t[2]||(t[2]=o("div",{class:"mb-4 text-sm text-gray-600"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1)),r.status?(i(),m("div",N,p(r.status),1)):_("",!0),o("form",{onSubmit:y(n,["prevent"])},[o("div",null,[s(V,{for:"email",value:"Email"}),s(F,{id:"email",modelValue:a(e).email,"onUpdate:modelValue":t[0]||(t[0]=u=>a(e).email=u),type:"email",class:"mt-1 block w-full",required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),s(k,{class:"mt-2",message:a(e).errors.email},null,8,["message"])]),o("div",$,[s(v,{class:w({"opacity-25":a(e).processing}),disabled:a(e).processing},{default:l(()=>t[1]||(t[1]=[g(" Email Password Reset Link ")])),_:1},8,["class","disabled"])])],32)]),_:1})],64))}};export{q as default};
