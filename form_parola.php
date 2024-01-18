<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: index.php'); 
    exit();
}

if (isset($_POST['schimba_parola'])) {
    $noua_parola = $_POST['noua_parola'];

    include('db.php');

    $email = $_SESSION['email'];

    $sql = "UPDATE utilizatori SET parola = '$noua_parola' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo "Eroare la actualizarea parolei: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formular Parolă Nouă</title>
</head>
<body>
    <h2>Introduceți Parola Nouă</h2>
    <form method="POST">
        <label for="noua_parola">Noua Parolă:</label>
        <input type="password" name="noua_parola" id="noua_parola" required>
        <input type="submit" name="schimba_parola" value="Schimbă Parola">
    </form>
</body>
</html>
