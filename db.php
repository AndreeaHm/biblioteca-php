<?php
$servername = "sql206.infinityfree.com";
$username = "if0_35367853";
$password = "aLSR8mrKo31IdLH";
$dbname = "if0_35367853_Biblioteca";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
}
?>
