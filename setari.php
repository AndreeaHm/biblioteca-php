<?php
session_start();

include('db.php');

$email = $_SESSION['email'];

if ($conn->connect_error) {
    die("Eroare la conectarea la baza de date: " . $conn->connect_error);
}

$sql = "SELECT nume, prenume, rol_user FROM utilizatori WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nume = $row['nume'];
    $prenume = $row['prenume'];
    $rol_user = $row['rol_user'];
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

if (isset($_POST['sterge_cont'])) {
    $sql_delete_lista_lectura = "DELETE FROM lista_lectura WHERE email_utilizator = '$email'";
    if ($conn->query($sql_delete_lista_lectura) === TRUE) {
        $sql_delete_utilizator = "DELETE FROM utilizatori WHERE email = '$email'";
        if ($conn->query($sql_delete_utilizator) === TRUE) {
            session_destroy();
            header('Location: index.php');
            exit();
        } else {
            echo "Eroare la ștergerea utilizatorului: " . $conn->error;
        }
    } else {
        echo "Eroare la ștergerea înregistrărilor din lista de lectură: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Setări</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=6651754646"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', '6651754646');
</script>

</head>
<body>
    <h2>Setări utilizator</h2>
    <p>Nume: <?php echo $nume; ?></p>
    <p>Prenume: <?php echo $prenume; ?></p>
    <p>Email: <?php echo $email; ?></p>
    <p>Nivel acces (Rol): <?php echo $rol_user; ?></p>

    <form method="POST" id="stergeForm">
        <input type="submit" name="logout" value="Deconectare">
        <input type="submit" name="sterge_cont" value="Șterge Contul" onclick="return confirm('Sunteți sigur că doriți să ștergeți contul?')">
    </form>

    <form method="POST" action="genereaza_otp.php" id="schimbaParolaForm">
    <input type="submit" name="schimba_parola" value="Schimbă Parola">
</form>


</body>
</html>
