<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Listă Autori Request</title>
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
    <h1>Listă Autori Request</h1>
    <table>
        <tr>
            <th>Nume</th>
            <th>Nationalitate</th>
            <th>An Nastere</th>
            <th>Actiuni</th>
        </tr>
        <?php
        session_start();
        include("db.php");

        $sql = "SELECT * FROM aut_req";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nume"] . "</td>";
                echo "<td>" . $row["nationalitate"] . "</td>";
                echo "<td>" . $row["an_nastere"] . "</td>";
                echo "<td><a href='aproba_autor_req.php?id=" . $row["id_autor_req"] . "'>Aproba</a> | <a href='sterge_autor_req.php?id=" . $row["id_autor_req"] . "'>Sterge</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nu există cereri de autor în baza de date.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
