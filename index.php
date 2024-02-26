<?php

function on_get() {
    if(empty($_GET["form_save"])) {
        include("./index_page.html");
    }
    else {
        echo "<script>alert ('Form was sent.')</script>";
        return;
    }
}

function on_post() {
    echo "Nothing there";
}

switch($_SERVER["REQUEST_METHOD"])
{
    case "GET": on_get();
    case "POST": on_post();
}