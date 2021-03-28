<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail and captcha</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<style>
    form * {
        display: block;
        margin-left: 10px;
        margin-top: 10px;
    }
</style>
<form method="post" action="mail.php" enctype="multipart/form-data">
    <label>
        To:
        <input type="text" name="to" placeholder="To:">
    </label>
    <label>
        Title:
        <input type="text" name="title" placeholder="Title:">
    </label>
    <label>
        Text:
        <textarea name="textContent" id="" cols="30" rows="10"></textarea>
    </label>
    <label>Attachments:
        <input type="file" name="files[]">
    </label>
    <div class="g-recaptcha" data-sitekey="6LfXp48aAAAAAEZ9-YBQmCNguIUtlVJ-KWc25mYl"></div>
    <input type="submit">
</form>
</body>
</html>