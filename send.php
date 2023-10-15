<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST["submit"])){
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'aakjaz@gmail.com';
    $mail->Password = 'dzmc dnvk plbs ycij';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = '456';

    $mail->setFrom('aakjaz@gmail.com');

    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);

    $mail->Subject = $_POST['subject'];

    $mail->Body = $_POST['message'];

    $mail->submit();


    echo 
    "
    <script>
    alert('sent Successfully');
    document.location.href = 'index.html';
    </script>
    "
}
?>