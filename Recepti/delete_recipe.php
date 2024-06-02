<?php
session_start();
require_once "database.php";

if (isset($_GET["id"])) {
    $recipe_id = $_GET["id"];
    
    // Proveri da li recept postoji
    $query = "SELECT * FROM recipes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $recipe_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $recipe = mysqli_fetch_assoc($result);
        
        // Izbriši recept iz baze
        $delete_query = "DELETE FROM recipes WHERE id = ?";
        $stmt2 = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($stmt2, "i", $recipe_id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        // Preusmeri korisnika nakon brisanja
        header("Location: admin.php");
        exit;
    } else {
        echo "Recipe not found.";
    }
}

