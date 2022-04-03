let error = 0

// AJOUT SUITE

let suiteName = document.getElementById('suiteName')
let suiteNameHelp = document.getElementById('suiteNameHelp')
let price = document.getElementById('price')
let priceHelp = document.getElementById('priceHelp')
let description = document.getElementById('description')
let descriptionHelp = document.getElementById('descriptionHelp')
let bookingLink = document.getElementById('bookingLink')
let bookingLinkHelp = document.getElementById('bookingLinkHelp')
let primePicture = document.getElementById('primePicture')
let primePictureHelp = document.getElementById('primePictureHelp')
let galeriePictures = document.getElementById('galeriePictures')
let galeriePicturesHelp = document.getElementById('galeriePicturesHelp')

let addSuiteBtn = document.getElementById('addSuiteBtn')

addSuiteBtn.addEventListener('click', (e)=>{
    if(checkName(suiteName.value) === false){
        suiteNameHelp.classList.remove('d-none')
        error +=1
    }else {
        suiteNameHelp.classList.add('d-none')
    } 
    if(checkId(price.value) === false){
        priceHelp.classList.remove('d-none')
        error +=1
    } else {
        priceHelp.classList.add('d-none')
    }
    if(checkMessage(description.value) === false){
        descriptionHelp.classList.remove('d-none')
        error +=1
    } else {
        descriptionHelp.classList.add('d-none')
    }
    if(checkURL(bookingLink.value) === false){
        bookingLinkHelp.classList.remove('d-none')
        error +=1
    } else {
        bookingLinkHelp.classList.add('d-none')
    }
    if(primePicture.files.length === 0){
        primePictureHelp.classList.remove('d-none')
        error +=1 
    } else if(checkPicture(primePicture.files[0]) === false){
        primePictureHelp.classList.remove('d-none')
        error +=1
    } else {
        primePictureHelp.classList.add('d-none')
    }
    if(galeriePictures.files.length > 0){
        for(i=0 ; i< galeriePictures.files.length ; i++){
            if(checkPicture(galeriePictures.files[i]) === false){
                galeriePicturesHelp.classList.remove('d-none')
                error +=1
                break
            } else {
                galeriePicturesHelp.classList.add('d-none')
            }
        }
    }
    if(error !=0){
        e.preventDefault()
        error =0
    }
})