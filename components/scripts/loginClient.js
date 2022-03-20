// GESTION AFFICHAGE LOGIN / SIGNUP FORM

let signUpLink = document.getElementById('signInLink')
let logInSection = document.getElementById('logInSection')
let signUpSection = document.getElementById('signUpSection')

function goToSignUp(){
    logInSection.classList.toggle('d-none')
    signUpSection.classList.toggle('d-none')
}

signUpLink.addEventListener('click', goToSignUp)

// FONCTION DE VERIFICATION DE CHAMPS

let rgxEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
let rgxPwd = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/    /* nécessite au moins 1 maj, 1 min, 1 chiffre, 1 caractère spécial, longueur entre 8 et 15*/
let rgxNames = /^[a-zA-ZÀ-ž\-\'\ ]*$/g

let error = 0

function checkEmail(value){
    if(!rgxEmail.test(value)){
        error += 1
        return false
    } 
    return true
}

function checkPwd(value){
    if(!rgxPwd.test(value)){
        error += 1
        return false
    }
    return true
}

function checkName(value){
    if(!rgxNames.test(value) || value.length < 2){
        error += 1
        return false
    }
    return true
}

// VALIDATION CONNEXION

let emailLogHelp = document.getElementById('emailLogHelp')
let pwdLogHelp = document.getElementById('pwdLogHelp')
let logBtn = document.getElementById('logBtn')
let emailLogIn = document.getElementById('emailLogIn')
let passwordLogIn = document.getElementById('passwordLogIn')

logBtn.addEventListener('click', (e)=>{
    if(checkEmail(emailLogIn.value) === false){
        emailHelp.classList.remove('d-none')
    }else {
        emailHelp.classList.add('d-none')
    } 
    if(checkPwd(passwordLogIn.value) === false){
        pwdHelp.classList.remove('d-none')
    } else {
        pwdHelp.classList.add('d-none')
    }

    if(error !=0){
        e.preventDefault()
        error =0
    }
})

// VALIDATION INSCRIPTION

let firstname = document.getElementById('firstname')
let firstnameHelp = document.getElementById('firstnameHelp')

let lastname = document.getElementById('lastname')
let lastnameHelp = document.getElementById('lastnameHelp')

let emailSignIn = document.getElementById('emailSignIn')
let emailSignHelp = document.getElementById('emailSignHelp')

let passwordSignIn = document.getElementById('passwordSignIn')
let pwdSignHelp = document.getElementById('pwdSignHelp')

let signUpBtn = document.getElementById('signUpBtn')

signUpBtn.addEventListener('click', (e)=>{
    if(checkName(firstname.value) === false){
        firstnameHelp.classList.remove('d-none')
    }else {
        firstnameHelp.classList.add('d-none')
    } 

    if(checkName(lastname.value) === false){
        lastnameHelp.classList.remove('d-none')
    }else {
        lastnameHelp.classList.add('d-none')
    } 

    if(checkEmail(emailSignIn.value) === false){
        emailSignHelp.classList.remove('d-none')
    }else {
        emailSignHelp.classList.add('d-none')
    } 
    if(checkPwd(passwordSignIn.value) === false){
        pwdSignHelp.classList.remove('d-none')
    } else {
        pwdSignHelp.classList.add('d-none')
    }

    if(error !=0){
        e.preventDefault()
        error =0
    }
})

module.exports = {
    checkEmail,
    checkPwd,
    checkName
}