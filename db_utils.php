<?php

function connect_to_db()
{
    try {
        include("db_data.php");
        $db = new PDO('mysql:host=localhost;dbname=u67423', $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $db;
    }
    catch (PDOException $e) {
        exit();
    }
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

function update_sumbission_data($db, $user_id, $submission) {
    try {
        $db->beginTransaction();
        $stmt = $db->prepare("UPDATE application 
        SET name = :name, phone = :phone, email = :email, bdate = :bdate, gender = :gender, bio = :bio
        WHERE user_id = :user_id");
        $stmt->bindParam('user_id', $user_id);
        $stmt->bindParam('name', $submission['name']);
        $stmt->bindParam('phone', $submission['phone']);
        $stmt->bindParam('email', $submission['email']);
        $stmt->bindParam('bdate', $submission['date']);
        $gender = $submission["gender"] == "male" ? '1' : '0';
        $stmt->bindParam('gender', $gender);
        $stmt->bindParam('bio', $submission['bio']);
        $stmt->execute();

        $stmt = $db->prepare("SELECT id from application WHERE user_id = :user_id");
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $row_id = $stmt->fetchAll()[0]['id'];

        $stmt = $db->prepare("DELETE FROM fpls WHERE parent_id = :parent_id");
        $stmt->bindParam('parent_id', $row_id);
        $stmt->execute();

        foreach ($submission['fpls'] as $fpl) {
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

function delete_form_submission($db, $user_id) {
    try {
        $db->beginTransaction();

        $stmt = $db->prepare("SELECT id from application WHERE user_id = :user_id");
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $row_id = $stmt->fetchAll()[0]['id'];

        $stmt = $db->prepare("DELETE FROM fpls WHERE parent_id = :parent_id");
        $stmt->bindParam('parent_id', $row_id);
        $stmt->execute();

        $stmt = $db->prepare("DELETE FROM application WHERE user_id = :user_id");
        $stmt->bindParam('user_id', $user_id);
        $stmt->execute();

        $db->commit();
    }
    catch (PDOException $e) {
        $db->rollback();
        setcookie("action_status", "-3");
        header("Location: ./index.php");
        exit();
    }
}

function save_form_submission($db, $user_id, $submission)
{
    try {
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO application 
        (user_id, name, phone, email, bdate, gender, bio) 
        VALUES (:user_id, :name, :phone, :email, :bdate, :gender, :bio);");
        $stmt->bindParam('user_id', $user_id);
        $stmt->bindParam('name', $submission['name']);
        $stmt->bindParam('phone', $submission['phone']);
        $stmt->bindParam('email', $submission['email']);
        $stmt->bindParam('bdate', $submission['date']);
        $gender = $submission['gender'] == "male" ? '1' : '0';
        $stmt->bindParam('gender', $gender);
        $stmt->bindParam('bio', $submission['bio']);
        $stmt->execute();

        $submission_rowid = $db->lastInsertId();
        foreach ($submission["fpls"] as $fpl) {
            $stmt = $db->prepare(sprintf("INSERT INTO fpls (parent_id, fpl) VALUES (%s, :fpl);", $submission_rowid));
            $stmt->bindParam('fpl', $fpl);
            $stmt->execute();
        }

        $db->commit();
    } catch (Exception $e) {
        $db->rollback();
        echo $e;
        setcookie("saving_status", "-4");
        return;
    }
}

function add_new_user($db, $login, $password_hash) {
    try {
        $stmt = $db->prepare("INSERT INTO users (login, password_hash) VALUES (:login, :password_hash)");
        $stmt->bindParam('login', $login);
        $stmt->bindParam('password_hash', $password_hash);
        $stmt->execute();

        $user_id = $db->lastInsertId();
        return $user_id;
    }
    catch (PDOException $e) {
        setcookie("saving_status", "-4");
        header("Location: ./index.php");
        exit();
    }
}

function get_user_db_data($db, $login, $password_hash)
{
    try {
        $stmt = $db->prepare('SELECT user_id FROM users WHERE
        login = :login AND password_hash = :password_hash');
        $stmt->bindParam('login', $login);
        $stmt->bindParam('password_hash', $password_hash);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (Exception $e) {
        exit();
    }
}

function get_user_id($db, $login, $password_hash) {
    $result = get_user_db_data($db, $login, $password_hash);
    print_r($result);
    if (!$result || count($result) == 0) {
        return -1;
    }
    else {
        return $result[0]['user_id'];
    }
}

function get_user_form_submission($db, $user_id)
{
    try {
        $stmt = $db->prepare('SELECT * FROM application WHERE
        user_id = :user_id');
        $stmt->bindParam('user_id', $user_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (Exception $e) {
        exit();
    }
}

function get_user_fpls($db, $submission_id)
{
    try {
        $stmt = $db->prepare('SELECT fpl FROM fpls WHERE
        parent_id = :parent_id');
        $stmt->bindParam('parent_id', $submission_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (Exception $e) {
        exit();
    }
}