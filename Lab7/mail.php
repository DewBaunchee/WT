<?php

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

if (isset($_POST['g-recaptcha-response'])) {
    if (isset($_POST['textContent']) || isset($_FILES['files'])) {
        if (isset($_POST['to']) && strlen($_POST['to']) > 0) {
            $text = $_POST['textContent'];
            $files = $_FILES['files'];
            if (strlen($text) == 0) die("Empty mail");

            if (checkCaptcha($_POST['g-recaptcha-response'])) {
                sendMail($_POST['to'], $_POST['title'], $text, $files);
            } else {
                echo "<p style='color: red;'>Invalid captcha</p>";
            }
        } else {
            echo "<p style='color: red;'>Enter e-mail address</p>";
        }
    } else {
        echo "<p style='color: red;'>Invalid mail content</p>";
    }
}

function sendMail($to, $title, $text, $files)
{
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;

        $mail->Host = "smtp.gmail.com";
        $mail->Username = "testforwtlabs";
        $mail->Password = "1r2r3r4r";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->setFrom("testforwtlabs@gmail.com", "Dewey");

        $mail->addAddress($to);
        if ($files) {
            for ($i = 0; $i < count($files['tmp_name']); $i++) {
                $mail->addAttachment($files['tmp_name'][$i], $files['name'][$i]);
            }
        }

        $mail->isHTML(false);
        $mail->Subject = $title;
        $mail->Body = $text;

        $mail->send();
        echo "Success";
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        echo "Error";
    }
}

function checkCaptcha($captcha_response)
{
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $params = [
        'secret' => '6LfXp48aAAAAALt6ijQTYXHQMzFrBjoo2CU4EfOA',
        'response' => $captcha_response,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    if (!empty($response)) $decoded_response = json_decode($response);

    $success = false;

    if ($decoded_response && $decoded_response->success) {
        $success = $decoded_response->success;
    }

    return $success;
}