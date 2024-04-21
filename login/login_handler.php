<?php

function get_user_id($login, $password) {
    return -1;
}

function connect_to_db()
{
    try {
        include("./../db_data.php");
        $db = new PDO('mysql:host=localhost;dbname=u67423', $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $db;
    }
    catch (PDOException $e) {
        exit();
    }
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