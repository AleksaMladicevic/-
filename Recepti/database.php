<?php
// Podešavanja baze podataka
$host = "localhost";
$username = "root";
$password = ""; 
$database = "myrecipes";

// Kreiranje konekcije
$conn = mysqli_connect($host, $username, $password, $database);

// Provera konekcije
if (!$conn) {   
    die("Connection failed: " . mysqli_connect_error());
}
?>
