<?php

$db = mysqli_connect("localhost", "root", "root", "addresses");
if($db->connect_error) {
    die(wrapError("Connection error."));
}

$addr = $_SERVER['REMOTE_ADDR'];
$res = mysqli_query($db, "SELECT * FROM addresses WHERE `IP`='$addr'");

if(mysqli_num_rows($res) == 0) {
    $res = mysqli_query($db, "INSERT INTO addresses(`IP`, `Visit count`) VALUES ('$addr', 1)");
    if(!$res) die(wrapError("Error while inserting new address."));
} else {
    $res = mysqli_query($db, "UPDATE addresses SET `Visit count` = `Visit count` + 1 WHERE IP='$addr'");
    if(!$res) die(wrapError("Error while incrementing existing address."));
}

echo getTable($db);

function getTable($db) {
    $table = "<table><tr><th>IP</th><th>Visit count</th></tr>";
    $res = mysqli_query($db, "SELECT * FROM addresses ORDER BY `Visit count` DESC");
    $matrix = mysqli_fetch_all($res);

    for($i = 0; $i < count($matrix); $i++) {
        $table .= "<tr><td>" . $matrix[$i][0] . "</td><td>" . $matrix[$i][1] . "</td></tr>";
    }

    return $table . "</table>";
}

function wrapError($text) {
    return "<p style='color: red;'>$text</p>";
}