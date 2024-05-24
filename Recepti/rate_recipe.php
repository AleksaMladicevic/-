<?php
session_start();
require_once "database.php";

if (isset($_POST['recipe_id']) && isset($_POST['rating'])) {
    $recipe_id = $_POST['recipe_id'];
    $rating = $_POST['rating'];
    $user_id = $_SESSION['user_id'];

    // Unesi ocenu u bazu
    $query = "INSERT INTO ratings (user_id, recipe_id, rating) VALUES ('$user_id', '$recipe_id', '$rating')";
    mysqli_query($conn, $query);
}
?>
