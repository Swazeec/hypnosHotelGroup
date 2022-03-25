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

// AJOUT HOTEL

let hotelName = document.getElementById('hotelName')
let hotelNameHelp = document.getElementById('hotelNameHelp')

let address = document.getElementById('address')
let addressHelp = document.getElementById('addressHelp')

let city = document.getElementById('city')
let cityHelp = document.getElementById('cityHelp')

let description = document.getElementById('description')
let descriptionHelp = document.getElementById('descriptionHelp')

let hotelManager = document.getElementById('hotelManager')
let hotelManagerHelp = document.getElementById('hotelManagerHelp')

let addHotelBtn = document.getElementById('addHotelBtn')

addHotelBtn.addEventListener('click', (ev)=>{
    if(checkName(hotelName.value) === false){
        hotelNameHelp.classList.remove('d-none')
        error += 1
    }else {
        hotelNameHelp.classList.add('d-none')
    } 
    if(checkAddress(address.value) === false){
        addressHelp.classList.remove('d-none')
        error += 1
    }else {
        addressHelp.classList.add('d-none')
    }
    if(checkName(city.value) === false){
        cityHelp.classList.remove('d-none')
        error += 1
    }else {
        cityHelp.classList.add('d-none')
    } 
    if(checkMessage(description.value) === false){
        descriptionHelp.classList.remove('d-none')
        error += 1
    }else {
        descriptionHelp.classList.add('d-none')
    }
    if(checkId(hotelManager.value) === false){
        hotelManagerHelp.classList.remove('d-none')
        error += 1
    }else {
        hotelManagerHelp.classList.add('d-none')
    }
    if(error != 0){
        ev.preventDefault()
        error = 0
    }
})

// MODIFICATION HOTEL

// let newhotelName = document.getElementById('newhotelName')
// let newhotelNameHelp = document.getElementById('newhotelNameHelp')

// let newaddress = document.getElementById('newaddress')
// let newaddressHelp = document.getElementById('newaddressHelp')

// let newcity = document.getElementById('newcity')
// let newcityHelp = document.getElementById('newcityHelp')

// let newdescription = document.getElementById('newdescription')
// let newdescriptionHelp = document.getElementById('newdescriptionHelp')

// let newhotelManager = document.getElementById('newhotelManager')
// let newhotelManagerHelp = document.getElementById('newhotelManagerHelp')

// let modifyHotelBtn = document.getElementById('modifyHotelBtn')


// modifyHotelBtn.addEventListener('click', (e)=>{

//     if(checkName(newhotelName.value) === false){
//         newhotelNameHelp.classList.remove('d-none')
//         error += 1
//     }else {
//         newhotelNameHelp.classList.add('d-none')
//     } 
//     if(checkAddress(newaddress.value) === false){
//         newaddressHelp.classList.remove('d-none')
//         error += 1
//     }else {
//         newaddressHelp.classList.add('d-none')
//     }
//     if(checkName(newcity.value) === false){
//         newcityHelp.classList.remove('d-none')
//         error += 1
//     }else {
//         newcityHelp.classList.add('d-none')
//     } 
//     if(checkMessage(newdescription.value) === false){
//         newdescriptionHelp.classList.remove('d-none')
//         error += 1
//     }else {
//         newdescriptionHelp.classList.add('d-none')
//     }
//     if(checkId(newhotelManager.value) === false){
//         newhotelManagerHelp.classList.remove('d-none')
//         error += 1
//     }else {
//         newhotelManagerHelp.classList.add('d-none')
//     }
//     if(error != 0){
//         e.preventDefault()
//         error = 0
//     }
// })