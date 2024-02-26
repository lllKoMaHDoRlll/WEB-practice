<?php

echo $_POST["field-name"];

if (empty($_POST["field-name"])) {
    echo "<script>alert ('name is empty')</script>";
}

echo $_POST["field-phone"];
echo $_POST["field-email"];
echo $_POST["field-date"];
echo $_POST["field-gender"];
echo $_POST["field-pl[]"];
echo $_POST["field-bio"];
echo $_POST["check-accept"];
echo $_POST["button-submit"];

header("Location: ?form_save=1");

