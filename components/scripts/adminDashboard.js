// MODIFICATION INFOS MANAGER

let firstname = document.getElementById('firstname')
let firstnameHelp = document.getElementById('firstnameHelp')

let lastname = document.getElementById('lastname')
let lastnameHelp = document.getElementById('lastnameHelp')

let email = document.getElementById('email')
let emailHelp = document.getElementById('emailHelp')

let password = document.getElementById('password')
let pwdHelp = document.getElementById('pwdHelp')

let modifyManagerBtn = document.getElementById('modifyManager')

let error = 0

modifyManagerBtn.addEventListener('click', (event)=>{
    if(checkName(firstname.value) === false){
        firstnameHelp.classList.remove('d-none')
        error += 1
    }else {
        firstnameHelp.classList.add('d-none')
    } 

    if(checkName(lastname.value) === false){
        lastnameHelp.classList.remove('d-none')
        error += 1
    }else {
        lastnameHelp.classList.add('d-none')
    } 

    if(checkEmail(email.value) === false){
        email.classList.remove('d-none')
        error += 1
    }else {
        emailHelp.classList.add('d-none')
    } 
    if(checkPwd(password.value) === false){
        pwdHelp.classList.remove('d-none')
        error += 1
    } else {
        pwdHelp.classList.add('d-none')
    }

    if(error !=0){
        event.preventDefault()
        error = 0
    }
})

// AJOUT MANAGER

let newfirstname = document.getElementById('newfirstname')
let newfirstnameHelp = document.getElementById('newfirstnameHelp')

let newlastname = document.getElementById('newlastname')
let newlastnameHelp = document.getElementById('newlastnameHelp')

let newemail = document.getElementById('newemail')
let newemailHelp = document.getElementById('newemailHelp')

let newpassword = document.getElementById('newpassword')
let newpwdHelp = document.getElementById('newpwdHelp')

let addManagerBtn = document.getElementById('addManagerBtn')

addManagerBtn.addEventListener('click', (e)=>{
    
    if(checkName(newfirstname.value) === false){
        newfirstnameHelp.classList.remove('d-none')
        error += 1
    }else {
        newfirstnameHelp.classList.add('d-none')
    } 

    if(checkName(newlastname.value) === false){
        newlastnameHelp.classList.remove('d-none')
        error += 1
    }else {
        newlastnameHelp.classList.add('d-none')
    } 

    if(checkEmail(newemail.value) === false){
        newemail.classList.remove('d-none')
        error += 1
    }else {
        newemailHelp.classList.add('d-none')
    } 
    if(checkPwd(newpassword.value) === false){
        newpwdHelp.classList.remove('d-none')
        error += 1
    } else {
        newpwdHelp.classList.add('d-none')
    }

    if(error !== 0){
        e.preventDefault()
        error = 0
    } 
})