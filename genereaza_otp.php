<?php
require(__DIR__ . '/phpmailer/class.phpmailer.php');
require_once('mail_config.php');
session_start();

$email = $_SESSION['email'];

$otp = rand(1000, 9999);

$_SESSION['otp'] = $otp;

function sendOTPByEmail($email, $otp) {

   global EMAIL_USERNAME, EMAIL_PASSWORD;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Port       = 465;
        $mail->Username   = EMAIL_USERNAME;
        $mail->Password   = EMAIL_PASSWORD;

        $mail->setFrom('biblioteca.aplicatie@gmail.com', 'Daw Project');
        $mail->addAddress($email, 'Destinatar');
        $mail->isHTML(false);
        $mail->Subject = 'Cod de acces temporar';
        $mail->Body    = "Codul de acces temporar este: $otp";

        $mail->send();
        header('Location: introducere_otp.php');

    } catch (Exception $e) {
        return false; 
    }
}
?>
