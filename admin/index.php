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
    else {

        $db = connect_to_db();
        $submissions = get_form_submissions($db);
        $fpls_count = count_fpls($submissions);

        include("./admin_page.php");
    }
}

function on_post()
{

}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        on_get();
        break;
    case "POST":
        on_post();
        break;
}