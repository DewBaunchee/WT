<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Background color</title>
</head>
<body>

<form method="post">
    <label>
        Background color:
        <input type="color" name="bgColor" placeholder="Background color" <?php if(isset($_SESSION['bgColor'])) echo "value=\"" . $_SESSION['bgColor'] . "\""?>>
    </label>
    <label>Font size: <input type="text" name="fontSize" placeholder="Font size" <?php if(isset($_SESSION['fontSize'])) echo "value=\"" . $_SESSION['fontSize'] . "\""?>></label>
    <label>Font color: <input type="color" name="fontColor" placeholder="Font color" <?php if(isset($_SESSION['fontColor'])) echo "value=\"" . $_SESSION['fontColor'] . "\""?>></label>
    <input type="submit">
</form>
<?php include_once 'bgColor.php' ?>
</body>
</html>