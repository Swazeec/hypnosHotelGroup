let bookingBtn = document.getElementById('bookingBtn')
let availability = document.getElementById('availability')
let availabilityTitle = document.getElementById('availabilityTitle')
let bookingValidate = document.getElementById('bookingValidate')
let suiteAvailable = document.getElementById('available')
let suiteUnavailable = document.getElementById('unavailable')

bookingBtn.addEventListener('click', (e)=>{
    e.preventDefault()

    //recup les valeurs
    let startDateReq = document.getElementById('startDate').value
    let endDateReq = document.getElementById('endDate').value
    let suiteReq = document.getElementById('suite').value

    // affichage mauvaises dates
    let startDateHelp = document.getElementById('startDateHelp')
    let endDateHelp = document.getElementById('endDateHelp')

    if(startDateReq < endDateReq){
        startDateHelp.classList.add('d-none')
        endDateHelp.classList.add('d-none')

        startDateReq = new Date (startDateReq)
        endDateReq = new Date (endDateReq)
    
        let available = true
        let ajax = new XMLHttpRequest()
        ajax.open("GET", "bookingData.php", true)
        ajax.send()
        ajax.onreadystatechange = function(){
            if(this.readyState == 4 && this.status ==200){
                let data = JSON.parse(this.responseText)
                for(i=0; i<data.length ; i++){
                    if(data[i].suite_id == suiteReq){
                        if(available === true){
                            // ON VERIFIE LES DATES
                            let startDate = new Date(data[i].startDate)
                            let endDate = new Date(data[i].endDate)
                            if(!((startDateReq < startDate && endDateReq < startDate) || (startDateReq > endDate && endDateReq > endDate))){
                                available = false
                                break
                            } 
                        } 
                    }
                }
                if(available === true){
                    suiteAvailable.classList.remove('d-none')
                    suiteUnavailable.classList.add('d-none')
                    bookingBtn.classList.add('d-none')
                } else {
                    suiteUnavailable.classList.remove('d-none')
                    suiteAvailable.classList.add('d-none')
                }
            }
        }
    } else {
        startDateHelp.classList.remove('d-none')
        endDateHelp.classList.remove('d-none')
    }

})