function checkEmail(value){
    let rgxEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    if(!rgxEmail.test(value) || value === true || value > 60){
        return false
    } 
    return true
}

function checkPwd(value){
    let rgxPwd = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/    /* nécessite au moins 1 maj, 1 min, 1 chiffre, 1 caractère spécial, longueur entre 8 et 15*/
    if(!rgxPwd.test(value) || value === true){
        return false
    }
    return true
}

function checkName(value){
    let rgxNames = /^[a-zA-ZÀ-ž\-\'\ ]*$/g
    if(!rgxNames.test(value) || value.length < 2 || value === true  || value > 60){
        return false
    }
    return true
}

function checkTopic(value){
    if(value == '' || isNaN(value)){
        return false
    }
    return true
}

function checkMessage(value){
    if(value.length == 0 || value.length > 2000){
        return false
    }
    return true
}

module.exports =  {checkName, checkEmail, checkPwd, checkTopic, checkMessage}
