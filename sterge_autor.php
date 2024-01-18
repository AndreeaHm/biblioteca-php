<?php
include('db.php');

if (isset($_GET['id'])) {
    $id_autor = $_GET['id'];
    mysqli_begin_transaction($conn);

    try {
        $sql_sterge_carti = "DELETE FROM carti WHERE id_autor = $id_autor";
        if (!mysqli_query($conn, $sql_sterge_carti)) {
            throw new Exception("Eroare la ștergerea cărților: " . mysqli_error($conn));
        }

        $sql_sterge_autor = "DELETE FROM autori WHERE id_autor = $id_autor";
        if (!mysqli_query($conn, $sql_sterge_autor)) {
            throw new Exception("Eroare la ștergerea autorului: " . mysqli_error($conn));
        }

        mysqli_commit($conn);
        header("refresh:2;url=gestionare_autori.php");
        echo "Autorul și cărțile asociate au fost șterse cu succes!";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Eroare: " . $e->getMessage();
    }
} else {
    echo "ID-ul autorului lipsește.";
}
?>
