let firstname = document.getElementById('firstname')
let firstnameHelp = document.getElementById('firstnameHelp')

let lastname = document.getElementById('lastname')
let lastnameHelp = document.getElementById('lastnameHelp')

let email = document.getElementById('email')
let emailHelp = document.getElementById('emailHelp')

let topic = document.getElementById('topic')
let topicHelp = document.getElementById('topicHelp')

let message = document.getElementById('message')
let messageHelp = document.getElementById('messageHelp')

let contactBtn = document.getElementById('contactBtn')

error = 0

contactBtn.addEventListener('click', (e)=>{
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
        emailHelp.classList.remove('d-none')
        error += 1
    }else {
        emailHelp.classList.add('d-none')
    } 
    if(checkTopic(topic.value) === false){
        topicHelp.classList.remove('d-none')
        error += 1
    }else {
        topicHelp.classList.add('d-none')
    } 
    if(checkMessage(message.value) === false){
        messageHelp.classList.remove('d-none')
        error += 1
    }else {
        messageHelp.classList.add('d-none')
    }

    if(error !=0){
        e.preventDefault()
        error =0
    }
})