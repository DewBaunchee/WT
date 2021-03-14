<?php

const url = "/[a-zA-Z]+:(\/\/(([a-zA-Z0-9.\-]|(%[A-F0-9]{2}))+)(:\d+)?)?(\/(([a-zA-Z0-9.\-]|(%[A-F0-9]{2}))+\/)*(([a-zA-Z0-9.\-]|(%[A-F0-9]{2}))+)?)?(\?(([a-zA-Z0-9_]+)=([a-zA-Z0-9_]+))([;&](([a-zA-Z0-9_]+)=([a-zA-Z0-9_]+)))*)?(#([a-zA-Z0-9.\-]|(%[A-F0-9]{2}))+)?/u";
const semanticUrl = "[a-zA-Z]+:(\/\/[a-zA-Z0-9.\-]+)(\/(([a-zA-Z.\-]+)|([0-9\-.]+)))*(([a-zA-Z.\-]+)|([0-9\-.]+))";

if (isset($_FILES['plainfile'])) {
    $plainfile = fopen($_FILES['plainfile']['tmp_name'], "r");
    if ($plainfile) {
        $plaintext = fread($plainfile, filesize($_FILES['plainfile']['tmp_name']));
        fclose($plainfile);
        echo replaceURL($plaintext);
    } else {
        echo "<p style='color: red'>Couldn't open file</p>";
    }
} else {
    echo "<p style='color: red'>Choose file please</p>";
}

function replaceURL($text): string
{
    $text = preg_replace(url, "<a href='$0' style='color: red;'>$0</a>", $text);
    $matches = array();
    $insertIndex = 0;
    preg_match_all("/" . semanticUrl . "/u", $text, $matches);
    if ($matches) {
        for ($j = 0; $j < count($matches); $j = $j + 2) {
            $match = $matches[0][$j];
            $matchIndex = strpos($text, $match, $insertIndex);
            $insertIndex = strpos($text, "<", $matchIndex);
            $text = substr_replace($text, "; " . $match, $insertIndex, 0);
            $insertIndex = $insertIndex + strlen("; " . $match);
        }
    }
    return "<pre>" . $text . "</pre>";
}