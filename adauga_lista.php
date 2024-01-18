<?php
session_start();

include 'db.php';
$email = $_SESSION['email'];

if (isset($_GET['id_carte'])) {
    $id_carte = $_GET['id_carte'];

    $query = "SELECT id FROM lista_lectura WHERE email_utilizator = ? AND id_carte = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $email, $id_carte);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $query = "INSERT INTO lista_lectura (email_utilizator, id_carte) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $email, $id_carte);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Cartea a fost adăugată în lista de lectură.";
        } else {
            $_SESSION['error_message'] = "Eroare la adăugarea cărții în lista de lectură.";
        }
    } else {
        $_SESSION['error_message'] = "Această carte este deja în lista dvs. de lectură.";
    }
    
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
