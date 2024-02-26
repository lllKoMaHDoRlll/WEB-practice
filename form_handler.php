<?php

$STATUS = 1;

function validate_fields () {
    
    if (empty($_POST["field-name"]) || strlen($_POST["field-name"]) > 150 || !preg_match("/^[\p{Cyrillic}a-zA-Z-' ]*$/u", $_POST["field-name"])) {
        return -1;
    }
    if (empty($_POST["field-phone"]) || !preg_match('/[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}/i', $_POST["field-phone"])) {
        return -2;
    }
    if (empty($_POST["field-email"]) || !filter_var($_POST["field-email"], FILTER_VALIDATE_EMAIL)) {
        return -3;
    }
    if (empty($_POST["field-date"])) {
        return -4;
    }
    if (empty($_POST["field-gender"])) {
        return -5;
    }
    if (empty($_POST["field-pl"]) || count($_POST["field-pl"]) < 1) {
        return -6;
    }
    if (empty($_POST["check-accept"]) || $_POST["check-accept"] != "accepted") {
        return -7;
    }
    return 1;
}

if (validate_fields() != 1) {
    $STATUS = validate_fields();
}

header(sprintf("Location: ?form_save=%d", $STATUS));

