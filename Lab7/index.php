<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail and captcha</title>
</head>
<body>
<style>
    form * {
        display: block;
        margin-left: 10px;
        margin-top: 10px;
    }
</style>
<form action="mail.php" method="post">
    <textarea name="textContent" id="" cols="30" rows="10"></textarea>
    <input type="file" name="files" multiple>
    <div>
        <img src="captcha.php" id="captcha-image">
        <a href="javascript:void(0);" onclick="document.getElementById('captcha-image')
        .src='captcha.php?rid=' + Math.random();">Обновить</a>
    </div>
    <input type="text" name="captcha">
    <input type="submit">
</form>
</body>
</html>