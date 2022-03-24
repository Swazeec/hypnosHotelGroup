// MODIFICATION INFOS MANAGER

let firstname = document.getElementById('firstname')
let firstnameHelp = document.getElementById('firstnameHelp')

let lastname = document.getElementById('lastname')
let lastnameHelp = document.getElementById('lastnameHelp')

let email = document.getElementById('emailSignIn')
let emailHelp = document.getElementById('emailSignHelp')

let password = document.getElementById('passwordSignIn')
let pwdHelp = document.getElementById('pwdSignHelp')

let modifyManagerBtn = document.getElementById('modifyManager')

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