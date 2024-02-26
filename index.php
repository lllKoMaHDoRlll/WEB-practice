<?php

function on_get() {
    if(!empty($_GET["form_save"])) {
        echo "<script>alert ('Form was sent.')</script>";
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