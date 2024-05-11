<?php

header('Content-Type: text/html; charset=UTF-8');
header("Location: ./");

if(!validate_fields_and_set_cookies()) {
    setcookie("action_status", "-1");
    exit();
}

$db = connect_to_db();

$submission = parse_form_submission_from_post();

if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['user_id']) && !empty($_SESSION['login'])) {
    if ($_SESSION['csrf_token'] != $_POST['csrf_token']) {
        setcookie("action_status", "-4");
        header("Location: ./");
        exit();
    }
    update_sumbission_data($db, $_SESSION['user_id'], $submission);
}
else {
    $login = generate_login();
    $password = generate_password();
    $password_hash = get_password_hash($password);

    setcookie('login', $login, time() + 60*60*24*365);
    setcookie('password', $password, time() + 60*60*24*365);

    $user_id = add_new_user($db, $login, $password_hash);
    save_form_submission($db, $user_id, $submission);
}

setcookie("action_status", "1");