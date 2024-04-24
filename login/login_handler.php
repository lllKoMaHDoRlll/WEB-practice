<?php

function get_user_id($login, $password) {
    $result = get_user_db_data(connect_to_db(), $login, $password);

    if (!$result || count($result) == 0) {
        return -1;
    }
    else {
        return $result[0]['user_id'];
    }
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

function get_user_db_data($db, $login, $password)
{
    try {
        $stmt = $db->prepare('SELECT user_id FROM users WHERE
        login = :login AND password_hash = :password_hash');
        $stmt->bindParam('login', $login);
        $stmt->bindParam('password_hash', md5($password));
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return;
    }
}

$login = !empty($_POST['field-login'])? $_POST['field-login'] : "";
$password = !empty($_POST['field-password'])? $_POST['field-password'] : "";

$user_id = get_user_id($login, $password);

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