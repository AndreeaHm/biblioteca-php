<?php
include('db.php');

if (isset($_GET['id'])) {
    $id_utilizator = $_GET['id'];
    
    $sql = "DELETE FROM utilizatori WHERE id_utilizator = $id_utilizator";
    
    if (mysqli_query($conn, $sql)) {
        echo "Utilizatorul a fost șters cu succes!";
    } else {
        echo "Eroare la ștergere: " . mysqli_error($conn);
    }

    header("refresh:2;url=gestionare_utilizatori.php");
} else {
    echo "ID-ul utilizatorului lipsește.";
}
?>
