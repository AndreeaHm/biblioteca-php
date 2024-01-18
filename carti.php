<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Cărți</title>
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
    <h1>Cărți</h1>

    <form method="GET" action="#">
        <label for="nume_carte">Caută după nume de carte:</label>
        <input type="text" id="nume_carte" name="nume_carte">
        <input type="submit" value="Caută">
    </form>

    <h2>Listă de Cărți</h2>
    <table border="1">
        <tr>
            <th>Titlu</th>
            <th>Autor</th>
            <th>An Publicație</th>
            <th>Disponibilitate</th>
            <th>Coperta</th>
            <th>Acțiuni</th>
        </tr>
       <?php
        include('db.php');

        function obtine_toate_cartile($conn, $nume_carte = "") {
            $sql = "SELECT carti.titlu, autori.nume AS autor, carti.an_publicatie, carti.disponibilitate, carti.url_poza_coperta, carti.id_carte FROM carti
                    INNER JOIN autori ON carti.id_autor = autori.id_autor
                    WHERE carti.titlu LIKE '%$nume_carte%' OR autori.nume LIKE '%$nume_carte%'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $carti = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $carti[] = $row;
                }
                return $carti;
            } else {
                echo "Eroare la interogare: " . mysqli_error($conn);
                return array();
            }
        }

        $carti = obtine_toate_cartile($conn, isset($_GET['nume_carte']) ? $_GET['nume_carte'] : '');

        if (isset($_SESSION['success_message'])) {
    echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}

        foreach ($carti as $carte) {
            echo "<tr>";
            echo "<td>" . $carte['titlu'] . "</td>";
            echo "<td>" . $carte['autor'] . "</td>";
            echo "<td>" . $carte['an_publicatie'] . "</td>";
            echo "<td>" . ($carte['disponibilitate'] == 1 ? 'Disponibil' : 'Indisponibil') . "</td>";
            echo "<td><img src='" . $carte['url_poza_coperta'] . "' alt='Coperta cărții' width='150' height='200'></td>";
            echo "<td><a href='adauga_lista.php?id_carte=" . $carte['id_carte'] . "'>Adaugă în lista de lectură</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    
</body>
</html>
