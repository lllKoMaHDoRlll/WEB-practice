<?php

$STATUS_DESCRIPTION = array(
    "1" => "Form was sent.",
    "-1" => "Name field value is incorrect.",
    "-2" => "Phone field value is incorrect.",
    "-3" => "Email field value is incorrect.",
    "-4" => "Date field value is incorrect.",
    "-5" => "Gender field value is incorrect.",
    "-6" => "Favorite PL field value is incorrect.",
    "-7" => "Accept checkbox field value is incorrect.",
    "-10" => "Error was occured while connecting to the DB.",
    "-11" => "Error was occured while sending form to the DB."
);

function on_get() {
    global $STATUS_DESCRIPTION;
    if(!empty($_GET["form_save"])) {
        echo sprintf("<script>alert ('%s')</script>", $STATUS_DESCRIPTION[$_GET["form_save"]]);
    }
    include("./index_page.html");
}

function on_post() {
    include("./form_handler.php");
}

switch($_SERVER["REQUEST_METHOD"])
{
    case "GET": on_get(); break;
    case "POST": on_post(); break;
}