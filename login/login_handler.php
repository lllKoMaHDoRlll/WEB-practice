<?php

include("./../db_utils.php");

$db = connect_to_db();

$login = !empty($_POST['field-login'])? $_POST['field-login'] : "";
$password = !empty($_POST['field-password'])? $_POST['field-password'] : "";
$password_hash = get_password_hash($password);

$user_id = get_user_id($db, $login, $password_hash);

if ($user_id == -1) {
    setcookie("login-error", "1");
    header("Location: ./");
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