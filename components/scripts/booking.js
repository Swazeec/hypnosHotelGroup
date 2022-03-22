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

    console.log(startDateReq)

    startDateReq = new Date (startDateReq)
    endDateReq = new Date (endDateReq)

    console.log(startDateReq)

    let available = true
    let ajax = new XMLHttpRequest()
    ajax.open("GET", "bookingData.php", true)
    ajax.send()
    ajax.onreadystatechange = function(){
        if(this.readyState == 4 && this.status ==200){
            let data = JSON.parse(this.responseText)
            console.log(data)
            for(i=0; i<data.length ; i++){
                if(data[i].suite_id == suiteReq){
                    if(available === true){
                        // ON VERIFIE LES DATES
                        let startDate = new Date(data[i].startDate)
                        let endDate = new Date(data[i].endDate)
                        if(!((startDateReq < startDate && endDateReq < startDate) || (startDateReq > endDate && endDateReq > endDate))){
                            console.log(endDateReq > endDate)
                            console.log(data[i])
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

                /* availabilityTitle.innerHTML = "Bonne nouvelle !"
                availability.innerHTML = 'La suite est disponible aux dates demandées. Il ne vous reste plus qu\'à valider !'
                bookingValidate.classList.remove('d-none') */
            } else {
                suiteUnavailable.classList.remove('d-none')
                suiteAvailable.classList.add('d-none')

                /* availabilityTitle.innerHTML = "Oupsi..."
                availability.innerHTML = "La suite n'est pas disponible aux dates demandées. Vous pouvez changer de suite, ou de dates !"
                bookingValidate.classList.add('d-none') */
            }
        }
    }
})