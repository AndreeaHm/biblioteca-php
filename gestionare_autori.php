<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Gestionare Autori</title>
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
    <h1>Gestionare Autori</h1>

    <form method="GET" action="gestionare_autori.php">
        <label for="nume_autor">Caută după nume de autor:</label>
        <input type="text" id="nume_autor" name="nume_autor">
        <input type="submit" value="Caută">
    </form>

    <p>Nu găsiți autorul dorit în listă? <a href="adauga_autor.php">Adaugă autor nou</a>.</p>

    <h2>Listă de Autori</h2>
    <table border="1">
        <tr>
            <th>Nume Autor</th>
            <th>Nationalitate</th>
            <th>An Nastere</th>
            <th>Acțiuni</th>
        </tr>
        <?php
        include('db.php');

        if (isset($_GET['nume_autor'])) {
            $nume_autor = $_GET['nume_autor'];
            $query = "SELECT * FROM autori WHERE nume LIKE '%$nume_autor%'";
        } else {
            $query = "SELECT * FROM autori";
        }

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['nume'] . "</td>";
                echo "<td>" . $row['nationalitate'] . "</td>";
                echo "<td>" . $row['an_nastere'] . "</td>";
                echo "<td><a href='modificare_autor.php?id=" . $row['id_autor'] . "'>Modifică</a> | <a href='sterge_autor.php?id=" . $row['id_autor'] . "' onclick='return confirm(\"Sunteți sigur că doriți să ștergeți acest autor?\")'>Șterge</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nu există autori disponibili.</td></tr>";
        }
        ?>
    </table>

    <br>
</body>
</html>
