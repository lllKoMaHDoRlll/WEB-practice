<?php

include("./../utils.php");
include("./../db_utils.php");

function on_get()
{
    $db = connect_to_db();
    $submissions = get_form_submissions($db);
    $fpls_count = count_fpls($submissions);

    include("./admin_page.php");
}

function on_post()
{
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
            setcookie("action_status", "1");
            break;
        case "DELETE":
            $db = connect_to_db();
            delete_form_submission($db, $_POST['user-id']);
            header("Location: ./index.php");
            setcookie("action_status", "1");
            break;
    }
}

if (
    empty($_SERVER['PHP_AUTH_USER']) || 
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    md5($_SERVER['PHP_AUTH_PW']) != md5('admin')
) 
{
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        on_get();
        break;
    case "POST":
        on_post();
        break;
}