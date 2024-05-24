<?php
session_start();
require_once "database.php";

if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1) {
    if(isset($_GET["id"])) {
        $user_id = $_GET["id"];
        
        // SQL upit za brisanje korisnika iz baze
        $delete_query = "DELETE FROM users WHERE id = '$user_id'";
        
        // Izvršavanje upita
        if (mysqli_query($conn, $delete_query)) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user: " . mysqli_error($conn);
        }
    } else {
        echo "User ID not provided.";
    }
} else {
    echo "Unauthorized access.";
}
?>
