<?php

include("./../utils.php");
include("./../db_utils.php");

header('Content-Type: text/html; charset=UTF-8');

function on_get()
{
    global $STATUS_DESCRIPTION;
    if (!empty($_COOKIE["action_status"])) {
        alert($STATUS_DESCRIPTION[$_COOKIE["action_status"]]);
        setcookie('action_status', '', 1);
    }

    $_SESSION['csrf_token'] = generate_csrf_token();

    $db = connect_to_db();
    $submissions = get_form_submissions($db);
    $fpls_count = count_fpls($submissions);

    include("./admin_page.php");
}

function on_post()
{
    if ($_SESSION['csrf_token'] != $_POST['csrf_token']) {
        setcookie("action_status", "-4");
        header("Location: ./");
        exit();
    }
    switch ($_POST['button-action']) {
        case "EDIT":
            if (!validate_fields()) {
                setcookie("action_status", "-1");
                header("Location: ./index.php");
                exit();
            }
            $db = connect_to_db();

            $submission = parse_form_submission_from_post();

            update_sumbission_data($db, $_POST['user-id'], $submission);
            header("Location: ./index.php");
            setcookie("action_status", "2");
            break;
        case "DELETE":
            $db = connect_to_db();
            delete_form_submission($db, $_POST['user-id']);
            header("Location: ./index.php");
            setcookie("action_status", "3");
            break;
    }
}

$db = connect_to_db();

if (
    empty($_SERVER['PHP_AUTH_USER']) || 
    empty($_SERVER['PHP_AUTH_PW']) ||
    count(get_admin_db_data($db, $_SERVER['PHP_AUTH_USER'], get_password_hash($_SERVER['PHP_AUTH_PW']))) == 0
) 
{
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}

session_start();

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        on_get();
        break;
    case "POST":
        on_post();
        break;
}