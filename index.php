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
        $user_id = $_SESSION['user_id'];
        $db = connect_to_db();
        $submission = get_user_form_submission($db, $user_id);
        if (!empty($submission)) {
            $submission_id = $submission[0]["id"];

            $values["name"] = strip_tags($submission[0]['name']);
            $values["phone"] = strip_tags($submission[0]['phone']);
            $values["email"] = strip_tags($submission[0]['email']);
            $values["date"] = strip_tags($submission[0]['bdate']);
            $values["gender"] = strip_tags($submission[0]['gender']);
            $values["bio"] = strip_tags($submission[0]['bio']);
            
            $fpls = get_user_fpls($db, $submission_id);
            $values["fpls"] = sprintf("@%s@", implode("@", $fpls));

        }
    }
    else {
        $values["name"] = empty($_COOKIE['field-name']) ? '' : strip_tags($_COOKIE['field-name']);
        $values["phone"] = empty($_COOKIE['field-phone']) ? '' : strip_tags($_COOKIE['field-phone']);
        $values["email"] = empty($_COOKIE['field-email']) ? '' : strip_tags($_COOKIE['field-email']);
        $values["date"] = empty($_COOKIE['field-date']) ? '' : strip_tags($_COOKIE['field-date']);
        $values["gender"] = empty($_COOKIE['field-gender']) ? '' : (strip_tags($_COOKIE['field-gender']) == "male"? '1' : '0');
        $values["fpls"] = empty($_COOKIE['field-pl']) ? '' : strip_tags($_COOKIE['field-pl']);
        $values["bio"] = empty($_COOKIE['field-bio']) ? '' : strip_tags($_COOKIE['field-bio']);
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