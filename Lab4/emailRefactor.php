<?php

const mail = "[A-Za-z0-9_.'\-]";
const host = "[A-Za-z_]+.([a-z]{2,3})+";
const tag = "[A-Za-z0-9]+";
const email = "[A-Za-z0-9_.'\-]+(\+[A-Za-z0-9]+)?@[A-Za-z_\/]+(\.[a-z]{2,3})+($|\s)";

if (isset($_FILES['plainfile'])) {
    $plainfile = fopen($_FILES['plainfile']['tmp_name'], "r");
    if($plainfile) {
        $plaintext = fread($plainfile, filesize($_FILES['plainfile']['tmp_name']));
        fclose($plainfile);
        echo replaceEMail($plaintext);
    } else {
        echo "<p style='color: red'>Couldn't open file</p>";
    }
} else {
    echo "<p style='color: red'>Choose file please</p>";
}

function replaceEMail($text): string
{
    $matches = array();
    $answer = "<div>";
    preg_match_all("/" . email . "/u", $text, $matches);
    if ($matches) {
        for ($i = 0; $i < count($matches); $i++) {
            $answer = $answer . trim($matches[0][$i]) . "<br/>";
        }
    }
    $text = preg_replace("/" . email . "/u", "<a href='mailto:$0' style='color: red;'>$0</a>", $text);
    return $answer . "</div>" . "<pre>" . $text . "</pre>";
}