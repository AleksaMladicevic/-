<?php
session_start();
require_once "database.php";

if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1) {
    if(isset($_GET["id"])) {
        $user_id = $_GET["id"];
        
        // SQL upit za brisanje korisnika iz baze koristeći pripremljeni upit
        $delete_query = "DELETE FROM users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        
        // Izvršavanje pripremljenog upita
        if (mysqli_stmt_execute($stmt)) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user: " . mysqli_error($conn);
        }
        
        // Zatvaranje pripremljenog upita
        mysqli_stmt_close($stmt);
    } else {
        echo "User ID not provided.";
    }
} else {
    echo "Unauthorized access.";
}
?>
