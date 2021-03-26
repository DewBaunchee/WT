<?php

if(isset($_POST['textContent']) || isset($_POST['files'])) {

} else {
    printErrorAndDie("Enter text or choose file");
}

function printErrorAndDie($error)
{
    echo "<p style='color: red;'>$error</p>";
    die();
}