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

let error = 0

// VALIDATION CONNEXION

let emailLogHelp = document.getElementById('emailLogHelp')
let pwdLogHelp = document.getElementById('pwdLogHelp')
let logBtn = document.getElementById('logBtn')
let emailLogIn = document.getElementById('emailLogIn')
let passwordLogIn = document.getElementById('passwordLogIn')

logBtn.addEventListener('click', (e)=>{
    if(checkEmail(emailLogIn.value) === false){
        emailLogHelp.classList.remove('d-none')
        error += 1
    }else {
        emailLogHelp.classList.add('d-none')
    } 
    if(checkPwd(passwordLogIn.value) === false){
        pwdLogHelp.classList.remove('d-none')
        error += 1
    } else {
        pwdLogHelp.classList.add('d-none')
    }

    if(error !=0){
        e.preventDefault()
        error = 0
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

signUpBtn.addEventListener('click', (event)=>{
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

    if(checkEmail(emailSignIn.value) === false){
        emailSignHelp.classList.remove('d-none')
        error += 1
    }else {
        emailSignHelp.classList.add('d-none')
    } 
    if(checkPwd(passwordSignIn.value) === false){
        pwdSignHelp.classList.remove('d-none')
        error += 1
    } else {
        pwdSignHelp.classList.add('d-none')
    }

    if(error !=0){
        event.preventDefault()
        error = 0
    }
})