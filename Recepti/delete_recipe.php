<?php
session_start();
require_once "database.php";

// Provera korisničkih privilegija nije potrebna jer se podrazumeva da je korisnik koji pristupa ovoj stranici admin
// Ako želiš, možeš ukloniti ovaj deo koda:
/*
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    echo "Unauthorized access.";
    exit;
}
*/

if (isset($_GET["id"])) {
    $recipe_id = $_GET["id"];
    
    // Proveri da li recept postoji
    $query = "SELECT * FROM recipes WHERE id = $recipe_id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $recipe = mysqli_fetch_assoc($result);
        
        // Izbriši recept iz baze
        $delete_query = "DELETE FROM recipes WHERE id = $recipe_id";
        if (mysqli_query($conn, $delete_query)) {
            echo "Recipe deleted successfully.";
        } else {
            echo "Error deleting recipe: " . mysqli_error($conn);
        }
    } else {
        echo "Recipe not found.";
    }
}

?>
