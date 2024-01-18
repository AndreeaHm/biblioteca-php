<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Modificare Autor</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=6651754646"></script>
</head>
<body>
    <h1>Modificare Autor</h1>

    <?php
    include('db.php');

    if (isset($_GET['id'])) {
        $id_autor = $_GET['id'];

        $sql = "SELECT * FROM autori WHERE id_autor = $id_autor";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $autor = mysqli_fetch_assoc($result);
        } else {
            echo "Autorul nu a fost găsit.";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nume = $_POST['nume'];
            $nationalitate = $_POST['nationalitate'];
            $an_nastere = $_POST['an_nastere'];

            $sql = "UPDATE autori SET nume = '$nume', nationalitate = '$nationalitate', an_nastere = $an_nastere WHERE id_autor = $id_autor";

            if (mysqli_query($conn, $sql)) {
                echo "Autorul a fost actualizat cu succes!";
                header("refresh:2;url=gestionare_autori.php");
            } else {
                echo "Eroare la actualizare: " . mysqli_error($conn);
            }
        }
    } else {
        echo "ID-ul autorului lipsește.";
        exit;
    }
    ?>

    <form method="POST" action="">
        <label for="nume">Nume Autor:</label>
        <input type="text" id="nume" name="nume" value="<?php echo $autor['nume']; ?>" required><br><br>

        <label for="nationalitate">Nationalitate:</label>
        <input type="text" id="nationalitate" name="nationalitate" value="<?php echo $autor['nationalitate']; ?>" required><br><br>

        <label for="an_nastere">An Naștere:</label>
        <input type="number" id="an_nastere" name="an_nastere" value="<?php echo $autor['an_nastere']; ?>" required><br><br>

        <input type="submit" value="Modifică Autor">
    </form>
</body>
</html>
