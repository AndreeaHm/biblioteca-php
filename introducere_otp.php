<?php
session_start();

if (isset($_POST['verifica_otp'])) {
    $otp_inserat = $_POST['otp'];

    if ($otp_inserat == $_SESSION['otp']) {
        header('Location: form_parola.php');
        exit();
    } else {
        $error = "OTP incorect. Vă rugăm să încercați din nou.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Introduceți OTP</title>
</head>
<body>
    <h2>Introduceți OTP</h2>
    <?php if (isset($error)) { echo '<p style="color: red;">' . $error . '</p>'; } ?>
    <form method="POST">
        <label for="otp">Introduceți codul OTP primit prin e-mail:</label>
        <input type="text" name="otp" required>
        <input type="submit" name="verifica_otp" value="Verifică OTP">
    </form>
</body>
</html>
