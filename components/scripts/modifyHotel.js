// MODIFICATION HOTEL

let newhotelName = document.getElementById('newhotelName')
let newhotelNameHelp = document.getElementById('newhotelNameHelp')

let newaddress = document.getElementById('newaddress')
let newaddressHelp = document.getElementById('newaddressHelp')

let newcity = document.getElementById('newcity')
let newcityHelp = document.getElementById('newcityHelp')

let newdescription = document.getElementById('newdescription')
let newdescriptionHelp = document.getElementById('newdescriptionHelp')

let newhotelManager = document.getElementById('newhotelManager')
let newhotelManagerHelp = document.getElementById('newhotelManagerHelp')

let modifyHotelBtn = document.getElementById('modifyHotelBtn')

let error = 0

modifyHotelBtn.addEventListener('click', (e)=>{
    if(checkName(newhotelName.value) === false){
        newhotelNameHelp.classList.remove('d-none')
        error += 1
        console.log(error)
    }else {
        newhotelNameHelp.classList.add('d-none')
    } 
    if(checkAddress(newaddress.value) === false){
        newaddressHelp.classList.remove('d-none')
        error += 1
    }else {
        newaddressHelp.classList.add('d-none')
    }
    if(checkName(newcity.value) === false){
        newcityHelp.classList.remove('d-none')
        error += 1
    }else {
        newcityHelp.classList.add('d-none')
    } 
    if(checkMessage(newdescription.value) === false){
        newdescriptionHelp.classList.remove('d-none')
        error += 1
    }else {
        newdescriptionHelp.classList.add('d-none')
    }
    if(checkId(newhotelManager.value) === false){
        newhotelManagerHelp.classList.remove('d-none')
        error += 1
    }else {
        newhotelManagerHelp.classList.add('d-none')
    }
    if(error != 0){
        e.preventDefault()
        error = 0
    }
})