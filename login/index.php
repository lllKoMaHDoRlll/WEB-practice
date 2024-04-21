<?php

function on_get() {
    include("./login_page.php");
}

function on_post() {
    include("./login_handler.php");
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        on_get();
        break;
    case "POST":
        on_post();
        break;
}