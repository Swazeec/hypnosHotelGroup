<?php
function checkName($value){
    $rgxNames = '/^[a-zA-ZÀ-ž\-\'\ ]*$/';
    if(strlen($value) > 50 || !preg_match($rgxNames, $value)){
        return false;
    } else {
        return true;
    }
}

function checkEmail($value){
    if(strlen($value) > 60 || !filter_var($value, FILTER_VALIDATE_EMAIL)){
        return false;
    } else {
        return true;
    }
}

function checkPwd($value){
    $rgxPwd = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/';
    if(strlen($value) > 60 || !preg_match($rgxPwd, $value)){
        return false;
    } else {
        return true;
    }
}

function checkAddress($value){
    $rgxAdd = '/^[0-9a-zA-ZÀ-ž \-\']+$/';
    if(strlen($value) > 100 || !preg_match($rgxAdd, $value)){
        return false;
    } else {
        return true;
    }
}