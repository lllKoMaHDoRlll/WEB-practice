<?php

header('Content-Type: text/html; charset=UTF-8');
header("Location: /web-2-task-4/");

function validate_fields()
{
    $expiration_time_on_error = 0;
    $expiration_time_on_success = time() + 60*60*24*365;
    $validation_passed = True;

    if (empty($_POST["field-name"]) || strlen($_POST["field-name"]) > 150 || !preg_match("/^[\p{Cyrillic}a-zA-Z-' ]*$/u", $_POST["field-name"])) {
        setcookie("field-name-error", "1", $expiration_time_on_error);
        setcookie('field-name', $_POST["field-name"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-name', $_POST["field-name"], $expiration_time_on_success);
        setcookie("field-name-error", "", 1);
    }
    
    if (empty($_POST["field-phone"]) || !preg_match('/[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}/i', $_POST["field-phone"])) {
        setcookie("field-phone-error", "1", $expiration_time_on_error);
        setcookie('field-phone', $_POST["field-phone"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-phone', $_POST["field-phone"], $expiration_time_on_success);
        setcookie("field-phone-error", "", 1);
    }

    if (empty($_POST["field-email"]) || !filter_var($_POST["field-email"], FILTER_VALIDATE_EMAIL)) {
        setcookie("field-email-error", "1", $expiration_time_on_error);
        setcookie('field-email', $_POST["field-email"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-email', $_POST["field-email"], $expiration_time_on_success);
        setcookie("field-email-error", "", 1);
    }

    if (empty($_POST["field-date"]) || !preg_match('/^\d{4}-\d{2}-\d{2}$/i', $_POST["field-date"])) {
        setcookie("field-date-error", "1", $expiration_time_on_error);
        setcookie('field-date', $_POST["field-date"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-date', $_POST["field-date"], $expiration_time_on_success);
        setcookie("field-date-error", "", 1);
    }

    if (empty($_POST["field-gender"]) || !preg_match('/^\Qmale\E|\Qfemale\E$/i', $_POST["field-gender"])) {
        setcookie("field-gender-error", "1", $expiration_time_on_error);
        setcookie('field-gender', $_POST["field-gender"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-gender', $_POST["field-gender"], $expiration_time_on_success);
        setcookie("field-gender-error", "", 1);
    }

    if (empty($_POST["field-pl"]) || count($_POST["field-pl"]) < 1 || !preg_match('/^((\Qpascal\E|\Qc\E|\Qcpp\E|\Qjs\E|\Qphp\E|\Qpython\E|\Qjava\E|\Qhaskel\E|\Qclojure\E|\Qprolog\E|\Qscala\E){1}[\,]{0,1})+$/i', implode(",", $_POST["field-pl"]))) {
        setcookie("field-pl-error", "1", $expiration_time_on_error);
        setcookie('field-pl', sprintf("@%s@", implode("@", $_POST["field-pl"])), $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-pl', sprintf("@%s@", implode("@", $_POST["field-pl"])), $expiration_time_on_success);
        setcookie("field-pl-error", "", 1);
    }

    if (empty($_POST["check-accept"]) || $_POST["check-accept"] != "accepted") {
        setcookie("field-accept-error", "1", $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie("field-accept-error", "", 1);
    }

    if (strlen($_POST["field-bio"]) > 300) {
        setcookie("field-bio-error", "1", $expiration_time_on_error);
        setcookie('field-bio', $_POST["field-bio"], $expiration_time_on_error);
        $validation_passed = False;
    }
    else {
        setcookie('field-bio', $_POST["field-bio"], $expiration_time_on_success);
        setcookie("field-bio-error", "", 1);
    }

    return $validation_passed;
}

function connect_to_db()
{
    try {
        include("db_data.php");
        $db = new PDO('mysql:host=localhost;dbname=u67423', $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $db;
    }
    catch (PDOException $e) {
        setcookie("saving_status", "-2");
        exit();
    }
}

function save_to_db($db)
{
    try {
        $name = $_POST["field-name"];
        $phone = $_POST["field-phone"];
        $email = $_POST["field-email"];
        $bdate = $_POST["field-date"];
        $gender = $_POST["field-gender"] == "male" ? '1' : '0';
        $bio = empty($_POST["field-bio"]) ? '' : $_POST["field-bio"];
    } catch (Exception $e) {
        setcookie("saving_status", "-3");
        return;
    }

    try {
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO application 
        (name, phone, email, bdate, gender, bio) 
        VALUES (:name, :phone, :email, :bdate, :gender, :bio);");
        $stmt->bindParam('name', $name);
        $stmt->bindParam('phone', $phone);
        $stmt->bindParam('email', $email);
        $stmt->bindParam('bdate', $bdate);
        $stmt->bindParam('gender', $gender);
        $stmt->bindParam('bio', $bio);
        $stmt->execute();

        $submition_rowid = $db->lastInsertId();
        foreach ($_POST["field-pl"] as $fpl) {
            $stmt = $db->prepare(sprintf("INSERT INTO fpls (parent_id, fpl) VALUES (%s, :fpl);", $submition_rowid));
            $stmt->bindParam('fpl', $fpl);
            $stmt->execute();
        }

        $db->commit();
    } catch (Exception $e) {
        $db->rollback();
        setcookie("saving_status", "-4");
        return;
    }
    setcookie("saving_status", "1");
}

if(!validate_fields()) {
    setcookie("saving_status", "-1");
    exit();
}

save_to_db(connect_to_db());
setcookie("saving_status", "1");