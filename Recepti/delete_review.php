<?php
require_once "database.php";

if (isset($_GET['id'])) {
    $review_id = $_GET['id'];

    // SQL upit za brisanje recenzije
    $delete_query = "DELETE FROM recipe_reviews WHERE id = $review_id";

    if (mysqli_query($conn, $delete_query)) {
        echo "Review deleted successfully.";
    } else {
        echo "Error deleting review: " . mysqli_error($conn);
    }
}
?>
