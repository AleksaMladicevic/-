<?php
session_start();
require_once "database.php";

// Dodavanje novog recepta
if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["instructions"])) {
    // Obrada unosa slike
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $name = $_FILES['image']['name'];
        $destination = 'images/' . $name;
        move_uploaded_file($tmp_name, $destination);
        $image_path = $destination;
    }

    $title = $_POST["title"];
    $description = $_POST["description"];
    $instructions = $_POST["instructions"];

    // SQL upit za unos novog recepta u bazu podataka
    $insert_query = "INSERT INTO recipes (title, description, instructions, image) VALUES ('$title', '$description', '$instructions', '$image_path')";
    
    // Izvršavanje upita
    if (mysqli_query($conn, $insert_query)) {
        echo "Recept uspešno dodat.";
    } else {
        echo "Greška pri dodavanju recepta: " . mysqli_error($conn);
    }
}
?>
