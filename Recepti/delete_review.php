<?php
require_once "database.php";

if (isset($_GET['id'])) {
    $review_id = $_GET['id'];

    // SQL upit za brisanje recenzije koristeći pripremljeni upit
    $delete_query = "DELETE FROM recipe_reviews WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $review_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Review deleted successfully.";
    } else {
        echo "Error deleting review: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>
