<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Adaugă Carte</title>
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
    <p>Dacă doriți să adăugați o nouă carte, vă rog să completați formularul. Un bibliotecar va verifica formularul și, în caz de aprobare, această carte va fi adăugată.</p>
    <h1>Adaugă Carte Nouă</h1>

    <?php
    include('db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titlu = $_POST['titlu'];
        $id_autor = $_POST['autor'];
        $an_publicatie = $_POST['an_publicatie'];
        $disponibilitate = 1;
        $url_poza_coperta = $_POST['url_poza_coperta'];

        $sql = "INSERT INTO car_req (titlu, id_autor_req, an_publicatie, disponibilitate, url_poza_coperta)
                VALUES ('$titlu', $id_autor, $an_publicatie, $disponibilitate, '$url_poza_coperta')";

        if (mysqli_query($conn, $sql)) {
            echo "Formularul a fost trimis cu succes! Cartea va fi verificată de către un bibliotecar.";
        } else {
            echo "Eroare la trimitere formular: " . mysqli_error($conn);
        }
    }
    ?>

    <form method="POST" action="">
        <label for="titlu">Titlu:</label>
        <input type="text" id="titlu" name="titlu" required><br><br>

        <label for="autor">Autor:</label>
        <select id="autor" name="autor" required>
            <?php
            $sql_autori = "SELECT * FROM autori";
            $result_autori = mysqli_query($conn, $sql_autori);

            if ($result_autori && mysqli_num_rows($result_autori) > 0) {
                while ($row_autor = mysqli_fetch_assoc($result_autori)) {
                    echo "<option value='" . $row_autor['id_autor'] . "'>" . $row_autor['nume'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="an_publicatie">An Publicație:</label>
        <input type="number" id="an_publicatie" name="an_publicatie" required><br><br>

        <label for="url_poza_coperta">URL Copertă:</label>
        <input type="url" id="url_poza_coperta" name="url_poza_coperta" required><br><br>

        <input type="submit" value="Adaugă Carte">
    </form>
</body>
</html>
