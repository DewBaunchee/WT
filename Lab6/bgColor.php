<?php
if (isset($_POST['bgColor']) && isset($_POST['fontSize']) && count($_POST) > 0 && isset($_POST['fontColor'])) {
    if (is_numeric($_POST['fontSize']) && $_POST['fontSize'] > 0 && $_POST['fontSize'] < 41) {
        $_SESSION['bgColor'] = $_POST['bgColor'];
        $_SESSION['fontSize'] = $_POST['fontSize'];
        $_SESSION['fontColor'] = $_POST['fontColor'];
        echo formStyle($_POST['bgColor'], $_POST['fontSize'], $_POST['fontColor']);
    } else {
        printErrorAndDie("Font size is not a number or it out of bounds (< 1 or > 40)");
    }
} else {
    printErrorAndDie("Fill all fields");
}

function formStyle($bgColor, $fontSize, $fontColor): string
{
    return "<style>html {
    background-color: $bgColor;
    }
    * {
    font-size: $fontSize;
    color: $fontColor;
    }</style>";
}

function printErrorAndDie($error)
{
    echo "<p style='color: red;'>$error</p>";
    die();
}