<?php
session_start();

include("db.php"); 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_carte_req = $_GET['id'];

    $sql_select_carte = "SELECT * FROM car_req WHERE id_carte_req = $id_carte_req";
    $result_select_carte = $conn->query($sql_select_carte);

    if ($result_select_carte->num_rows > 0) {
        $row = $result_select_carte->fetch_assoc();
        $titlu = $row["titlu"];
        $id_autor_req = $row["id_autor_req"];
        $an_publicatie = $row["an_publicatie"];
        $disponibilitate = $row["disponibilitate"];
        $url_poza_coperta = $row["url_poza_coperta"];

        $sql_aproba_carte = "INSERT INTO carti (titlu, id_autor, an_publicatie, disponibilitate, url_poza_coperta) VALUES ('$titlu', $id_autor_req, '$an_publicatie', $disponibilitate, '$url_poza_coperta')";
        if ($conn->query($sql_aproba_carte) === TRUE) {
            $sql_sterge_cerere = "DELETE FROM car_req WHERE id_carte_req = $id_carte_req";
            if ($conn->query($sql_sterge_cerere) === TRUE) {
                header("Location: gestionare_carti_req.php");
                exit();
            } else {
                echo "Eroare la ștergerea cererii de carte: " . $conn->error;
            }
        } else {
            echo "Eroare la adăugarea cărții: " . $conn->error;
        }
    } else {
        echo "Cartea cu ID-ul specificat nu există în cererile de carte.";
    }
} else {
    echo "ID-ul cărții specificat este invalid.";
}

$conn->close();
?>
