<?php

$STATUS = 1;

function validate_fields () {
    
    if (empty($_POST["field-name"]) || strlen($_POST["field-name"]) > 150 || !preg_match("/^[\p{Cyrillic}a-zA-Z-' ]*$/u", $_POST["field-name"])) {
        return -1;
    }
    if (empty($_POST["field-phone"]) || !preg_match('/[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}/i', $_POST["field-phone"])) {
        return -2;
    }
    if (empty($_POST["field-email"]) || !filter_var($_POST["field-email"], FILTER_VALIDATE_EMAIL)) {
        return -3;
    }
    if (empty($_POST["field-date"])) {
        return -4;
    }
    if (empty($_POST["field-gender"])) {
        return -5;
    }
    if (empty($_POST["field-pl"]) || count($_POST["field-pl"]) < 1) {
        return -6;
    }
    if (empty($_POST["check-accept"]) || $_POST["check-accept"] != "accepted") {
        return -7;
    }
    return 1;
}

function prepare_data () {
    return;
}

function connect_to_db () {
    $user = 'u67423';
    $pass = '2585011';
    $db = new PDO('mysql:host=localhost;dbname=test', $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    return $db;
}

function save_to_db ($db) {
    $name = $_POST["field-name"];
    $phone = $_POST["field-phone"];
    $email = $_POST["field-email"];
    $bdate = $_POST["field-date"];
    $gender = $_POST["field-gender"] == "male" ? '1' : '0';
    $fpl = implode(",", $_POST["field-pl"]);
    $bio = empty($_POST["field-bio"]) ? '' : $_POST["field-bio"];

    print($name);
    print("|");
    print($phone);
    print("|");
    print($email);
    print("|");
    print($bdate);
    print("|");
    print($gender);
    print("|");
    print($fpl);
    print("|");
    print($bio);
    print("|");

    $stmt = $db->prepare("INSERT INTO application (name, phone, email, bdate, gender, fpl, bio) VALUES (:name, :phone, :email, :bdate, :gender, :fpl, :bio);");
    $stmt->bindParam('name', $name);
    $stmt->bindParam('phone', $phone);
    $stmt->bindParam('email', $email);
    $stmt->bindParam('bdate', $bdate);
    $stmt->bindParam('gender', $gender);
    $stmt->bindParam('fpl', $fpl);
    $stmt->bindParam('bio', $bio);
    $stmt->execute();
}

if (validate_fields() != 1) {
    $STATUS = validate_fields();
}

print(implode("\n", $_POST));
echo "<br>";
save_to_db(connect_to_db());


//header(sprintf("Location: ?form_save=%d", $STATUS));

