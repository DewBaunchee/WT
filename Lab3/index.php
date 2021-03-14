<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Calendar</title>
</head>
<body>
<form method="post">
    <label>
        <input type="text" placeholder="Year" pattern="-?[0-9]+" name="year">
    </label>
    <input type="submit" value="Form calendar">
</form>
<div id="container">
    <?php include_once 'calendar.php' ?>
</div>
</body>
</html>
