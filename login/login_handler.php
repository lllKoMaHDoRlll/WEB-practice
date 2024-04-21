<?php

function get_user_id($login, $password) {
    return -1;
}

$login = !empty($_POST['field-login'])? $_POST['field-login'] : "";
$password = !empty($_POST['field-password'])? $_POST['field-password'] : "";

$user_id = get_user_id($login, $password);

if ($user_id == -1) {
    setcookie("login-error", "1");
    exit();
}
else {
    setcookie("login-error", "", 1);
    if (!$is_session_started) {
        session_start();
    }

    $_SESSION['login'] = $_POST['field-login'];
    $_SESSION['user_id'] = $user_id;

    header("Location: ./../");
}