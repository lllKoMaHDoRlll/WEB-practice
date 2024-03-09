<?php

$STATUS_DESCRIPTION = array(
    "1" => "Form was successfully sent.",
    "-1" => "An error was occured during validating fields.",
    "-2" => "An error was occured during connecting to the database.",
    "-3" => "An error was occured during serializing fields.",
    "-4"=> "An error was occured during sending data to the database.",
);

function on_get()
{
    global $STATUS_DESCRIPTION;
    if (!empty($_COOKIE["saving_status"])) {
        echo sprintf("<script>alert ('%s')</script>", $STATUS_DESCRIPTION[$_COOKIE["saving_status"]]);
    }
    include("./index_page.php");
}

function on_post()
{
    include("./form_handler.php");
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        on_get();
        break;
    case "POST":
        on_post();
        break;
}