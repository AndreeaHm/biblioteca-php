<?php
session_start();

include("db.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_carte_req = $_GET['id'];

    $sql_select_carte = "SELECT * FROM car_req WHERE id_carte_req = $id_carte_req";
    $result_select_carte = $conn->query($sql_select_carte);

    if ($result_select_carte->num_rows > 0) {
        $sql_sterge_cerere = "DELETE FROM car_req WHERE id_carte_req = $id_carte_req";
        if ($conn->query($sql_sterge_cerere) === TRUE) {
            header("Location: gestionare_carti_req.php");
            exit();
        } else {
            echo "Eroare la ștergerea cererii de carte: " . $conn->error;
        }
    } else {
        echo "Cererea de carte cu ID-ul specificat nu există.";
    }
} else {
    echo "ID-ul cererii de carte specificat este invalid.";
}

$conn->close();
?>
