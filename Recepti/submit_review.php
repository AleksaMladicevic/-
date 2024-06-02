<?php
session_start();
require_once "database.php";

if(isset($_POST["submit_review"])) {
    $recipe_id = $_POST["recipe_id"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $user_email = $_SESSION["user"];

    // Dohvati user_id
    $query_user = "SELECT id FROM users WHERE email = '$user_email'";
    $result_user = mysqli_query($conn, $query_user);
    $user = mysqli_fetch_assoc($result_user);
    $user_id = $user["id"];

    $query = "INSERT INTO recipe_reviews (recipe_id, user_id, rating, comment) VALUES ('$recipe_id', '$user_id', '$rating', '$comment')";

    if(mysqli_query($conn, $query)) {
        header("Location: home.php");
        exit;
    } else {
        die("Greška u unosu recenzije: " . mysqli_error($conn));
    }
} else {
    header("Location: home.php");
    exit;
}
?>
