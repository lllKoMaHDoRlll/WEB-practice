<?php
include("./db_utils.php");
include("./utils.php");

header('Content-Type: text/html; charset=UTF-8');

function on_get()
{
    global $STATUS_DESCRIPTION;
    if (!empty($_COOKIE["action_status"])) {
        alert($STATUS_DESCRIPTION[$_COOKIE["action_status"]]);
        setcookie('action_status', '', 1);
    }
    $values = array();
    if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {

        $_SESSION['csrf_token'] = generate_csrf_token();

        $user_id = $_SESSION['user_id'];
        $db = connect_to_db();
        $submission = get_user_form_submission($db, $user_id);
        if (!empty($submission)) {
            $submission_id = $submission[0]["id"];

            $values["name"] = sanitize($submission[0]['name']);
            $values["phone"] = sanitize($submission[0]['phone']);
            $values["email"] = sanitize($submission[0]['email']);
            $values["date"] = sanitize($submission[0]['bdate']);
            $values["gender"] = sanitize($submission[0]['gender']);
            $values["bio"] = sanitize($submission[0]['bio']);
            
            $fpls = get_user_fpls($db, $submission_id);
            $values["fpls"] = sprintf("@%s@", implode("@", array_map('sanitize', $fpls)));

        }
    }
    else {
        $values["name"] = empty($_COOKIE['field-name']) ? '' : sanitize($_COOKIE['field-name']);
        $values["phone"] = empty($_COOKIE['field-phone']) ? '' : sanitize($_COOKIE['field-phone']);
        $values["email"] = empty($_COOKIE['field-email']) ? '' : sanitize($_COOKIE['field-email']);
        $values["date"] = empty($_COOKIE['field-date']) ? '' : sanitize($_COOKIE['field-date']);
        $values["gender"] = empty($_COOKIE['field-gender']) ? '' : (sanitize($_COOKIE['field-gender']) == "male"? '1' : '0');
        $values["fpls"] = empty($_COOKIE['field-pl']) ? '' : sanitize($_COOKIE['field-pl']);
        $values["bio"] = empty($_COOKIE['field-bio']) ? '' : sanitize($_COOKIE['field-bio']);
    }

    setcookie("login", "", 1);
    setcookie("password", "", 1);
    include("./index_page.php");
}

function on_post()
{
    include("./form_handler.php");
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        on_get();
        break;
    case "POST":
        on_post();
        break;
}