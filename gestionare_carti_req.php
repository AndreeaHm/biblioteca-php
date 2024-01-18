<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Gestionare Cereri Carti</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=6651754646"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', '6651754646');
</script>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Gestionare Cereri Carti</h1>
    <table>
        <tr>
            <th>Titlu</th>
            <th>Autor</th>
            <th>An Publicatie</th>
            <th>Disponibilitate</th>
            <th>Copertă</th>
            <th>Acțiuni</th>
        </tr>
        <?php
        session_start();
        include("db.php");

        $sql = "SELECT * FROM car_req";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["titlu"] . "</td>";
                echo "<td>" . getAuthorName($row["id_autor_req"], $conn) . "</td>";
                echo "<td>" . $row["an_publicatie"] . "</td>";
                echo "<td>" . ($row["disponibilitate"] == 1 ? "Disponibil" : "Indisponibil") . "</td>";
                echo "<td><img src='" . $row["url_poza_coperta"] . "' alt='Coperta' width='150' height='200'></td>";
                echo "<td><a href='aproba_carte_req.php?id=" . $row["id_carte_req"] . "'>Aproba</a> | <a href='sterge_carte_req.php?id=" . $row["id_carte_req"] . "'>Sterge</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nu există cereri de carte în baza de date.</td></tr>";
        }

        function getAuthorName($id_autor_req, $conn) {
            $sql = "SELECT nume FROM autori WHERE id_autor = $id_autor_req";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["nume"];
            } else {
                return "Autor necunoscut";
            }
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
