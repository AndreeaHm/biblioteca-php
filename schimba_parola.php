<?php
session_start();
require(__DIR__ . '/phpmailer/class.phpmailer.php');
require('mail_config.php');

if (isset($_SESSION['email']) && filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)) {
    $email = $_SESSION['email'];

    $message = "Reseteaza parola!";

    $message = wordwrap($message, 70, "\r\n");

    $mail = new PHPMailer;
    $mail->IsSMTP();

    try {
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 587;
        $mail->Username = EMAIL_USERNAME;
        $mail->Password = EMAIL_PASSWORD;
        $mail->AddReplyTo($email, 'Daw Project');
        $mail->AddAddress($email, 'Daw Project');
        $mail->SetFrom('biblioteca.aplicatie@gmail.com', 'Daw Project');
        $mail->Subject = 'Resetare Parolă';

        $resetLink = 'https://biblioteca-aplicatie.infinityfreeapp.com/resetare_parola.php';
        $mail->Body    = "Pentru a reseta parola, accesați următorul link: $resetLink";
        $mail->AltBody = 'Pentru a vizualiza acest mesaj, vă rugăm să utilizați un vizualizator HTML compatibil.';

        if ($mail->Send()) {
            header('Location: index.php');
            exit();
        } else {
            echo "Eroare la trimiterea email-ului. Vă rugăm să încercați din nou.";
        }
    } catch (phpmailerException $e) {
        echo "Eroare PHPMailer: " . $e->errorMessage();
    } catch (Exception $e) {
        echo "Eroare generală: " . $e->getMessage();
    }
} else {
    echo "Metoda de cerere sau adresa de email lipsesc sau nu sunt valide.";
}
?>
