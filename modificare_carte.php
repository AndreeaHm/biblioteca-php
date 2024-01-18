<!DOCTYPE html>
<html>
<head>
    <title>Modificare Carte</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=6651754646"></script>
</head>
<body>
    <h1>Modificare Carte</h1>

    <?php
    include('db.php');

    if (isset($_GET['id'])) {
        $id_carte = $_GET['id'];

        $sql = "SELECT carti.*, autori.nume AS nume_autor FROM carti
                INNER JOIN autori ON carti.id_autor = autori.id_autor
                WHERE carti.id_carte = $id_carte";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $carte = mysqli_fetch_assoc($result);
        } else {
            echo "Cartea nu a fost găsită.";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $titlu = $_POST['titlu'];
            $id_autor = $_POST['autor'];
            $an_publicatie = $_POST['an_publicatie'];
            $disponibilitate = isset($_POST['disponibilitate']) ? 1 : 0;

            $sql = "UPDATE carti SET titlu = '$titlu', id_autor = $id_autor, an_publicatie = $an_publicatie, disponibilitate = $disponibilitate WHERE id_carte = $id_carte";

            if (mysqli_query($conn, $sql)) {
                echo "Cartea a fost actualizată cu succes!";
                header("refresh:2;url=gestionare_carti.php");
            } else {
                echo "Eroare la actualizare: " . mysqli_error($conn);
            }
        }
    } else {
        echo "ID-ul cărții lipsește.";
        exit;
    }
    ?>

    <form method="POST" action="">
        <label for="titlu">Titlu:</label>
        <input type="text" id="titlu" name="titlu" value="<?php echo $carte['titlu']; ?>" required><br><br>

        <label for="autor">Autor:</label>
        <select id="autor" name="autor" required>
            <?php
            $sql_autori = "SELECT * FROM autori";
            $result_autori = mysqli_query($conn, $sql_autori);

            if ($result_autori && mysqli_num_rows($result_autori) > 0) {
                while ($row_autor = mysqli_fetch_assoc($result_autori)) {
                    $selected = ($carte['id_autor'] == $row_autor['id_autor']) ? 'selected' : '';
                    echo "<option value='" . $row_autor['id_autor'] . "' $selected>" . $row_autor['nume'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="an_publicatie">An Publicație:</label>
        <input type="number" id="an_publicatie" name="an_publicatie" value="<?php echo $carte['an_publicatie']; ?>" required><br><br>

        <label for="disponibilitate">Disponibilitate:</label>
        <input type="checkbox" id="disponibilitate" name="disponibilitate" <?php echo $carte['disponibilitate'] == 1 ? 'checked' : ''; ?>><br><br>

        <input type="submit" value="Modifică Carte">
    </form>
</body>
</html>
