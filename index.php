<?php
include("./db_utils.php");
include("./utils.php");


$STATUS_DESCRIPTION = array(
    "1" => "Form was successfully sent.",
    "-1" => "An error was occured during validating fields.",
    "-2" => "An error was occured during connecting to the database.",
    "-3" => "An error was occured during serializing fields.",
    "-4"=> "An error was occured during sending data to the database.",
);

function on_get()
{
    global $STATUS_DESCRIPTION;
    if (!empty($_COOKIE["saving_status"])) {
        alert($STATUS_DESCRIPTION[$_COOKIE["saving_status"]]);
        setcookie('saving_status', '', 1);
    }
    $values = array();
    if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
        $user_id = $_SESSION['user_id'];
        $db = connect_to_db();
        $submission = get_user_form_submission($db, $user_id);
        if (!empty($submission)) {
            $submission_id = $submission[0]["id"];

            $values["name"] = $submission[0]['name'];
            $values["phone"] = $submission[0]['phone'];
            $values["email"] = $submission[0]['email'];
            $values["date"] = $submission[0]['bdate'];
            $values["gender"] = $submission[0]['gender'];
            $values["bio"] = $submission[0]['bio'];
            
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