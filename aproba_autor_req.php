<?php
session_start();

include("db.php");

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_autor_req = $_GET['id'];
    
    $sql_select_autor = "SELECT * FROM aut_req WHERE id_autor_req = $id_autor_req";
    $result_select_autor = $conn->query($sql_select_autor);

    if ($result_select_autor->num_rows > 0) {
        $row = $result_select_autor->fetch_assoc();
        $nume = $row["nume"];
        $nationalitate = $row["nationalitate"];
        $an_nastere = $row["an_nastere"];
        
        $sql_aproba_autor = "INSERT INTO autori (nume, nationalitate, an_nastere) VALUES ('$nume', '$nationalitate', '$an_nastere')";
        if ($conn->query($sql_aproba_autor) === TRUE) {
            $sql_sterge_cerere = "DELETE FROM aut_req WHERE id_autor_req = $id_autor_req";
            if ($conn->query($sql_sterge_cerere) === TRUE) {
                echo "Autorul a fost aprobat și adăugat cu succes în tabela autori.";
                 header("Location: gestionare_autori_req.php");
                exit();
            } else {
                echo "Eroare la ștergerea cererii: " . $conn->error;
            }
        } else {
            echo "Eroare la adăugarea autorului: " . $conn->error;
        }
    } else {
        echo "Autorul cu ID-ul specificat nu există în cererile de autorizare.";
    }
} else {
    echo "ID-ul autorului specificat este invalid.";
}

$conn->close();
?>
