<?php
if (isset($_POST['struct']) && strlen($_POST['struct']) > 0) {
    $struct = $_POST['struct'];
    $struct = preg_replace("/ +/u", " ", $struct);
    $args = explode(" ", $struct);
    if (isCorrectStruct($args)) {
        solve($args);
    } else {
        echo "<p style='color: red;'>Invalid input</p>";
    }
} else {
    echo "<p style='color: red;'>Fill the field</p>";
}

function getSQLType($str)
{
    switch ($str) {
        case "text":
            return "VARCHAR(40)";
        case "number":
            return "INT";
        case "date":
            return "DATE";
        case "time":
            return "TIME";
        default:
            return false;
    }
}

function isCorrectStruct($args): bool
{
    if (count($args) % 2 == 0 || count($args) < 3) return false;
    for ($i = 1; $i < count($args); $i = $i + 2) {
        if (!getSQLType($args[$i])) return false;
    }
    return true;
}

function solve($args)
{
    $db = mysqli_connect("localhost", "dewey", "password", "random");
    if ($db->connect_error) {
        printErrorAndDie("Invalid connection");
    }

    $res = mysqli_query($db, "DROP TABLE IF EXISTS random");
    if (!$res) {
        printErrorAndDie("Dropping: " . mysqli_error($db));
    }

    $countOfRows = $args[count($args) - 1];
    $names = array();
    $types = array();
    for ($i = 0; $i < count($args) - 1; $i += 2) {
        $names[$i / 2] = $args[$i];
        $types[$i / 2] = $args[$i + 1];
    }

    $type = getSQLType($types[0]);
    $res = mysqli_query($db, "CREATE TABLE random(`$names[0]` $type)");
    if (!$res) {
        printErrorAndDie("Creating: " . mysqli_error($db));
    }

    for ($i = 1; $i < count($types); $i++) {
        $type = getSQLType($types[$i]);
        $res = mysqli_query($db, "ALTER TABLE random ADD COLUMN `$names[$i]` $type");
        if (!$res) {
            printErrorAndDie("Adding: " . mysqli_error($db));
        }
    }

    for ($i = 0; $i < $countOfRows; $i++) {
        $namesString = "";
        $values = "";

        for ($j = 0; $j < count($types) - 1; $j++) {
            $namesString = $namesString . "`" . $names[$j] . "`, ";
            $values = $values . "'" . getRandomValue($types[$j]) . "', ";
        }
        $namesString = $namesString . "`" . $names[count($types) - 1] . "`";
        $values = $values . "'" . getRandomValue($types[count($types) - 1]) . "'";

        mysqli_query($db, "INSERT INTO random($namesString) VALUES ($values)");
        if (!$res) {
            printErrorAndDie("Adding: " . mysqli_error($db));
        }
    }

    $res = mysqli_query($db, "SELECT * FROM random");
    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo getSQLTable($names, $types, $data);
}

function getSQLTable($names, $types, $data): string
{
    $table = "<table><tr>";

    for($i = 0; $i < count($names); $i++) {
        $table = $table . "<th>" . $names[$i] . " : " . $types[$i] . "</th>";
    }

    $table = $table . "</tr>";

    for($i = 0; $i < count($data); $i++) {
        $table = $table . "<tr>";
        for($j = 0; $j < count($data[$i]); $j++) {
            $table = $table . "<td>" . $data[$i][$names[$j]] . "</td>";
        }
        $table = $table . "</tr>";
    }

    return $table . "</table>";
}

function getRandLetter()
{
    return chr(rand() % (ord('Z') - ord('A')) + ord('A'));
}

function getRandomValue($type)
{
    switch ($type) {
        case "text":
            $string = "";
            for ($i = 0; $i < 40; $i++) {
                $string = $string . getRandLetter();
            }
            return $string;
        case "number":
            return rand();
        case "date":
            return date("Y-m-d", rand());
        case "time":
            return date("H:i:s", rand());
        default:
            return false;
    }
}

function printErrorAndDie($error)
{
    echo "<p style='color: red;'>$error</p>";
    die();
}