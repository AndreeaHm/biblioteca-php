<?php
include('db.php');

if (isset($_GET['id'])) {
    $id_carte = $_GET['id'];
    
    $sql = "DELETE FROM carti WHERE id_carte = $id_carte";
    
    if (mysqli_query($conn, $sql)) {
        echo "Cartea a fost ștearsă cu succes!";
        
        header("refresh:2;url=gestionare_carti.php");
    } else {
        echo "Eroare la ștergere: " . mysqli_error($conn);
    }
} else {
    echo "ID-ul cărții lipsește.";
}
?>
