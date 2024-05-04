<?php

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


function validate_fields()
{
    $validation_passed = True;

    if (empty($_POST["field-name"]) || strlen($_POST["field-name"]) > 150 || !preg_match("/^[\p{Cyrillic}a-zA-Z-' ]*$/u", $_POST["field-name"])) {
        $validation_passed = False;
    }
    
    if (empty($_POST["field-phone"]) || !preg_match('/[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}/i', $_POST["field-phone"])) {
        $validation_passed = False;
    }
    if (empty($_POST["field-email"]) || !filter_var($_POST["field-email"], FILTER_VALIDATE_EMAIL)) {
        $validation_passed = False;
    }

    if (empty($_POST["field-date"]) || !preg_match('/^\d{4}-\d{2}-\d{2}$/i', $_POST["field-date"])) {
        $validation_passed = False;
    }

    if (empty($_POST["field-gender"]) || !preg_match('/^\Qmale\E|\Qfemale\E$/i', $_POST["field-gender"])) {
        $validation_passed = False;
    }

    if (empty($_POST["field-pl"]) || count($_POST["field-pl"]) < 1 || !preg_match('/^((\Qpascal\E|\Qc\E|\Qcpp\E|\Qjs\E|\Qphp\E|\Qpython\E|\Qjava\E|\Qhaskel\E|\Qclojure\E|\Qprolog\E|\Qscala\E){1}[\,]{0,1})+$/i', implode(",", $_POST["field-pl"]))) {
        $validation_passed = False;
    }

    if (empty($_POST["check-accept"]) || $_POST["check-accept"] != "accepted") {
        $validation_passed = False;
    }

    if (strlen($_POST["field-bio"]) > 300) {
        $validation_passed = False;
    }

    return $validation_passed;
}

function get_form_submissions($db)
{
    try {
        $stmt = $db->prepare('SELECT * FROM application');
        $stmt->execute();
        
        $submissions = $stmt->fetchAll();
        
        foreach ($submissions as &$submission) {
            $stmt = $db->prepare('SELECT fpl FROM fpls WHERE parent_id = :parent_id');
            $stmt->bindParam('parent_id', $submission['id']);
            $stmt->execute();
            $submission['fpls'] = array();
            $fpls = $stmt->fetchAll();
            foreach ($fpls as &$fpl) {
                array_push($submission['fpls'], $fpl['fpl']);
            }
            unset($fpl);
        }
        unset($submission);

        return $submissions;
    } catch (Exception $e) {
        return;
    }
}

function count_fpls($submissions) {
    $fpls_count = array();
    foreach ($submissions as $submission) {
        foreach ($submission['fpls'] as $fpl) {
            if (array_key_exists($fpl, $fpls_count)) {
                $fpls_count[$fpl] += 1;
            }
            else {
                $fpls_count[$fpl] = 1;
            }
        }
    }
    return $fpls_count;
}

function on_get()
{
    $db = connect_to_db();
    $submissions = get_form_submissions($db);
    $fpls_count = count_fpls($submissions);

    include("./admin_page.php");
}

function update_sumbission_data($db, $user_id) {
    try {
        $db->beginTransaction();
        $stmt = $db->prepare("UPDATE application 
        SET name = :name, phone = :phone, email = :email, bdate = :bdate, gender = :gender, bio = :bio
        WHERE user_id = :user_id");
        $stmt->bindParam('user_id', $user_id);
        $stmt->bindParam('name', $_POST['field-name']);
        $stmt->bindParam('phone', $_POST['field-phone']);
        $stmt->bindParam('email', $_POST['field-email']);
        $stmt->bindParam('bdate', $_POST['field-date']);
        $gender = $_POST["field-gender"] == "male" ? '1' : '0';
        $stmt->bindParam('gender', $gender);
        $stmt->bindParam('bio', $_POST['field-bio']);
        $stmt->execute();

        $stmt = $db->prepare("SELECT id from application WHERE user_id = :user_id");
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $row_id = $stmt->fetchAll()[0]['id'];

        $stmt = $db->prepare("DELETE FROM fpls WHERE parent_id = :parent_id");
        $stmt->bindParam('parent_id', $row_id);
        $stmt->execute();

        foreach ($_POST['field-pl'] as $fpl) {
            $stmt = $db->prepare(sprintf("INSERT INTO fpls (parent_id, fpl) VALUES (%s, :fpl);", $row_id));
            $stmt->bindParam('fpl', $fpl);
            $stmt->execute();
        }

        $db->commit();
    }
    catch (PDOException $e) {
        $db->rollback();
        setcookie("action_status", "-4");
        header("Location: ./index.php");
        exit();
    }
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
            update_sumbission_data($db, $_POST['user-id']);
            header("Location: ./index.php");
            setcookie("action_status", "1");
            break;
        case "DELETE":
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