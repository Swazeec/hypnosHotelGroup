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
    }else {
        emailLogHelp.classList.add('d-none')
    } 
    if(checkPwd(passwordLogIn.value) === false){
        pwdLogHelp.classList.remove('d-none')
    } else {
        pwdLogHelp.classList.add('d-none')
    }

    if(error !=0){
        e.preventDefault()
        error =0
    }
})