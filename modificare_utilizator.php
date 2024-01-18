<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Biblioteca online cu o selecție vastă de cărți și autori. Citește și descoperă noi titluri în colecția noastră." />
    <title>Modificare Utilizator</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=6651754646"></script>
</head>
<body>
    <h1>Modificare Utilizator</h1>

    <?php
    include('db.php');

    if (isset($_GET['id'])) {
        $id_utilizator = $_GET['id'];

        $sql = "SELECT * FROM utilizatori WHERE id_utilizator = $id_utilizator";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $utilizator = mysqli_fetch_assoc($result);
        } else {
            echo "Utilizatorul nu a fost găsit.";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nume = $_POST['nume'];
            $prenume = $_POST['prenume'];
            $email = $_POST['email'];
            $rol_user = $_POST['rol_user'];

            $sql = "UPDATE utilizatori SET nume = '$nume', prenume = '$prenume', email = '$email', rol_user = '$rol_user' WHERE id_utilizator = $id_utilizator";

            if (mysqli_query($conn, $sql)) {
                echo "Utilizatorul a fost actualizat cu succes!";
                header("refresh:2;url=gestionare_utilizatori.php");
            } else {
                echo "Eroare la actualizare: " . mysqli_error($conn);
            }
        }
    } else {
        echo "ID-ul utilizatorului lipsește.";
        exit;
    }
    ?>

    <form method="POST" action="">
        <label for="nume">Nume:</label>
        <input type="text" id="nume" name="nume" value="<?php echo $utilizator['nume']; ?>" required><br><br>

        <label for="prenume">Prenume:</label>
        <input type="text" id="prenume" name="prenume" value="<?php echo $utilizator['prenume']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $utilizator['email']; ?>" required><br><br>

        <label for="rol_user">Rol Utilizator:</label>
        <select id="rol_user" name="rol_user" required>
            <option value="utilizator" <?php echo $utilizator['rol_user'] === 'utilizator' ? 'selected' : ''; ?>>Utilizator</option>
            <option value="bibliotecar" <?php echo $utilizator['rol_user'] === 'bibliotecar' ? 'selected' : ''; ?>>Bibliotecar</option>
        </select><br><br>

        <input type="submit" value="Modifică Utilizator">
    </form>
</body>
</html>
