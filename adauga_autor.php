<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Adaugă Autor</title>
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
    <h1>Adaugă Autor Nou</h1>

    <?php
    include('db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nume = $_POST['nume'];
        $an_nastere = $_POST['an_nastere'];
        $nationalitate = $_POST['nationalitate'];

        $sql = "INSERT INTO autori (nume, an_nastere, nationalitate)
                VALUES ('$nume', $an_nastere, '$nationalitate')";

        if (mysqli_query($conn, $sql)) {
            echo "Autorul a fost adăugat cu succes!";
            header("refresh:2;url=gestionare_autori.php");
        } else {
            echo "Eroare la adăugare: " . mysqli_error($conn);
        }
    }
    ?>

    <form method="POST" action="">
        <label for="nume">Nume:</label>
        <input type="text" id="nume" name="nume" required><br><br>

        <label for="an_nastere">An Naștere:</label>
        <input type="number" id="an_nastere" name="an_nastere" required><br><br>

        <label for="nationalitate">Naționalitate:</label>
        <input type="text" id="nationalitate" name="nationalitate" required><br><br>

        <input type="submit" value="Adaugă Autor">
    </form>
</body>
</html>
