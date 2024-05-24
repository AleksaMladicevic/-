<?php
session_start();
require_once "database.php";

// Provera da li je forma za dodavanje ocene i komentara poslata
if(isset($_POST['submit_review'])) {
    // Dobijanje podataka iz forme
    $recipe_id = $_POST['recipe_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    
    // Upisivanje podataka u bazu podataka
    $query = "INSERT INTO recipe_reviews (recipe_id, rating, comment) VALUES ('$recipe_id', '$rating', '$comment')";
    $result = mysqli_query($conn, $query);
    
    if($result) {
        // Uspesno upisivanje u bazu podataka
        $success_message = "Vaša ocena i komentar su uspešno dodati!";
    } else {
        // Greška prilikom upisivanja u bazu podataka
        $error_message = "Došlo je do greške prilikom dodavanja ocene i komentara.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card text-center">
            <div class="card-header">
                Poruka
            </div>
            <div class="card-body">
                <?php if(isset($success_message)): ?>
                    <h5 class="card-title text-success"><?php echo $success_message; ?></h5>
                <?php elseif(isset($error_message)): ?>
                    <h5 class="card-title text-danger"><?php echo $error_message; ?></h5>
                <?php endif; ?>
                <a href="home.php" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
