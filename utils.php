<?php

$STATUS_DESCRIPTION = array(
    "1" => "Form was successfully sent.",
    "2" => "Form submission was successfully edited.",
    "3" => "Form submission was successfully deleted.",
    "-1" => "An error was occured during validation.",
    "-2" => "An error was occured during connecting to the database.",
    "-3"=> "An error was occured during sending data to the database.",
);

function parse_form_submission_from_post() {
    $submission = array();
    $submission['name'] = strip_tags($_POST['field-name']);
    $submission['phone'] = strip_tags($_POST['field-phone']);
    $submission['email'] = strip_tags($_POST['field-email']);
    $submission['date'] = strip_tags($_POST['field-date']);
    $submission['gender'] = strip_tags($_POST['field-gender']);
    $submission['bio'] = strip_tags($_POST['field-bio']);
    $submission['fpls'] = array_map('strip_tags', $_POST['field-pl']);

    return $submission;
}

function generate_login() {
    return uniqid();
}

function generate_password() {
    return rand();
}

function get_password_hash($password) {
    return md5($password);
}

function validate_fields_and_set_cookies()
{
    $expiration_time_on_error = 0;
    $expiration_time_on_success = time() + 60*60*24*365;
    $validation_passed = True;

    if (empty($_POST["field-name"]) || strlen($_POST["field-name"]) > 150 || !preg_match("/^[\p{Cyrillic}a-zA-Z-' ]*$/u", $_POST["field-name"])) {
        setcookie("field-name-error", "1", $expiration_time_on_error);
        setcookie('field-name', $_POST["field-name"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-name', $_POST["field-name"], $expiration_time_on_success);
        setcookie("field-name-error", "", 1);
    }
    
    if (empty($_POST["field-phone"]) || !preg_match('/[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}/i', $_POST["field-phone"])) {
        setcookie("field-phone-error", "1", $expiration_time_on_error);
        setcookie('field-phone', $_POST["field-phone"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-phone', $_POST["field-phone"], $expiration_time_on_success);
        setcookie("field-phone-error", "", 1);
    }

    if (empty($_POST["field-email"]) || !filter_var($_POST["field-email"], FILTER_VALIDATE_EMAIL)) {
        setcookie("field-email-error", "1", $expiration_time_on_error);
        setcookie('field-email', $_POST["field-email"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-email', $_POST["field-email"], $expiration_time_on_success);
        setcookie("field-email-error", "", 1);
    }

    if (empty($_POST["field-date"]) || !preg_match('/^\d{4}-\d{2}-\d{2}$/i', $_POST["field-date"])) {
        setcookie("field-date-error", "1", $expiration_time_on_error);
        setcookie('field-date', $_POST["field-date"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-date', $_POST["field-date"], $expiration_time_on_success);
        setcookie("field-date-error", "", 1);
    }

    if (empty($_POST["field-gender"]) || !preg_match('/^\Qmale\E|\Qfemale\E$/i', $_POST["field-gender"])) {
        setcookie("field-gender-error", "1", $expiration_time_on_error);
        setcookie('field-gender', $_POST["field-gender"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-gender', $_POST["field-gender"], $expiration_time_on_success);
        setcookie("field-gender-error", "", 1);
    }

    if (empty($_POST["field-pl"]) || count($_POST["field-pl"]) < 1 || !preg_match('/^((\Qpascal\E|\Qc\E|\Qcpp\E|\Qjs\E|\Qphp\E|\Qpython\E|\Qjava\E|\Qhaskel\E|\Qclojure\E|\Qprolog\E|\Qscala\E){1}[\,]{0,1})+$/i', implode(",", $_POST["field-pl"]))) {
        setcookie("field-pl-error", "1", $expiration_time_on_error);
        setcookie('field-pl', sprintf("@%s@", implode("@", $_POST["field-pl"])), $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-pl', sprintf("@%s@", implode("@", $_POST["field-pl"])), $expiration_time_on_success);
        setcookie("field-pl-error", "", 1);
    }

    if (empty($_POST["check-accept"]) || $_POST["check-accept"] != "accepted") {
        setcookie("field-accept-error", "1", $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie("field-accept-error", "", 1);
    }

    if (strlen($_POST["field-bio"]) > 300) {
        setcookie("field-bio-error", "1", $expiration_time_on_error);
        setcookie('field-bio', $_POST["field-bio"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-bio', $_POST["field-bio"], $expiration_time_on_success);
        setcookie("field-bio-error", "", 1);
    }

    return $validation_passed;
}

function alert($message) {
    echo sprintf("<script>alert ('%s')</script>", $message);
}

function validate_fields()
{
    $validation_passed = True;

    if (empty($_POST["field-name"]) || strlen($_POST["field-name"]) > 150 || !preg_match("/^[\p{Cyrillic}a-zA-Z-' ]*$/u", $_POST["field-name"])) {
        $validation_passed = False;
    }
    
    if (empty($_POST["field-phone"]) || !preg_match('/[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}/i', $_POST["field-phone"])) {
        $validation_passed = False;
    }
    if (empty($_POST["field-email"]) || !filter_var($_POST["field-email"], FILTER_VALIDATE_EMAIL)) {
        $validation_passed = False;
    }

    if (empty($_POST["field-date"]) || !preg_match('/^\d{4}-\d{2}-\d{2}$/i', $_POST["field-date"])) {
        $validation_passed = False;
    }

    if (empty($_POST["field-gender"]) || !preg_match('/^\Qmale\E|\Qfemale\E$/i', $_POST["field-gender"])) {
        $validation_passed = False;
    }

    if (empty($_POST["field-pl"]) || count($_POST["field-pl"]) < 1 || !preg_match('/^((\Qpascal\E|\Qc\E|\Qcpp\E|\Qjs\E|\Qphp\E|\Qpython\E|\Qjava\E|\Qhaskel\E|\Qclojure\E|\Qprolog\E|\Qscala\E){1}[\,]{0,1})+$/i', implode(",", $_POST["field-pl"]))) {
        $validation_passed = False;
    }

    if (empty($_POST["check-accept"]) || $_POST["check-accept"] != "accepted") {
        $validation_passed = False;
    }

    if (strlen($_POST["field-bio"]) > 300) {
        $validation_passed = False;
    }

    return $validation_passed;
}

function count_fpls($submissions) {
    $fpls_count = array();
    foreach ($submissions as $submission) {
        foreach ($submission['fpls'] as $fpl) {
            if (array_key_exists($fpl, $fpls_count)) {
                $fpls_count[$fpl] += 1;
            }
            else {
                $fpls_count[$fpl] = 1;
            }
        }
    }
    return $fpls_count;
}
