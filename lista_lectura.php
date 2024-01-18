<?php
session_start();

include 'db.php';

$email = $_SESSION['email'];

if (isset($_GET['remove_id'])) {
    $remove_id = $_GET['remove_id'];

    $query = "DELETE FROM lista_lectura WHERE email_utilizator = ? AND id_carte = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $email, $remove_id);
    $stmt->execute();
    $stmt->close();

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$query = "SELECT carti.titlu, autori.nume AS autor, carti.an_publicatie, carti.url_poza_coperta, carti.id_carte
          FROM lista_lectura
          INNER JOIN carti ON lista_lectura.id_carte = carti.id_carte
          INNER JOIN autori ON carti.id_autor = autori.id_autor
          WHERE lista_lectura.email_utilizator = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listă de Lectură</title>
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
    <h1>Listă de Lectură</h1>

    <table border="1">
        <tr>
            <th>Titlu</th>
            <th>Autor</th>
            <th>An Publicație</th>
            <th>Coperta</th>
            <th>Acțiuni</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['titlu'] . "</td>";
            echo "<td>" . $row['autor'] . "</td>";
            echo "<td>" . $row['an_publicatie'] . "</td>";
            echo "<td><img src='" . $row['url_poza_coperta'] . "' alt='Coperta cărții' width='150' height='200'></td>";
            echo "<td><a href='lista_lectura.php?remove_id=" . $row['id_carte'] . "'>Șterge</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
