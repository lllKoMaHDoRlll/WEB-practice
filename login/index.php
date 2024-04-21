<?php

$is_session_started = false;
if(!empty($_COOKIE[session_name()]) && session_start()) {
    $is_session_started = true;
    if (!empty($_SESSION['login'])) {
        header('Location: ./../');
        exit();
    }
}

function on_get() {
    header('Content-Type: text/html; charset=UTF-8');
    include("./login_page.php");
}

function on_post() {
    global $is_session_started;
    include("./login_handler.php");
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        on_get();
        break;
    case "POST":
        on_post();
        break;
}