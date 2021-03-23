<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MySQL LAB 5</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
    * {
        font-family: 'Montserrat', sans-serif;
        font-size: 20px;
    }

    input[type="text"] {
        width: 500px;
    }
</style>
<form method="post">
    <input type="submit">
    <input type="text" placeholder="<name> <type>[ <name> <type>] <row_count>" name="struct">
</form>
<?php include_once 'randomSQL.php' ?>
</body>
</html>