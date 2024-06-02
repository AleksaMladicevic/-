<?php
session_start();
require_once "database.php";

if (isset($_POST['recipe_id']) && isset($_POST['rating'])) {
    $recipe_id = $_POST['recipe_id'];
    $rating = $_POST['rating'];
    $user_id = $_SESSION['user_id'];

    // Provera da li je korisnik već ocenio ovaj recept
    $check_query = "SELECT * FROM ratings WHERE user_id = '$user_id' AND recipe_id = '$recipe_id'";
    $check_result = mysqli_query($conn, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        // Korisnik je već ocenio ovaj recept, možda želite da ažurirate ocenu umesto da je dodate ponovo
        // Na primer, možete koristiti UPDATE upit umesto INSERT upita
        echo "You have already rated this recipe.";
    } else {
        // Unesi ocenu u bazu
        $query = "INSERT INTO ratings (user_id, recipe_id, rating) VALUES ('$user_id', '$recipe_id', '$rating')";
        if(mysqli_query($conn, $query)) {
            echo "Rating submitted successfully.";
        } else {
            echo "Error submitting rating: " . mysqli_error($conn);
        }
    }
}
?>
