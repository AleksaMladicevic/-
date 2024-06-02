<?php
session_start();
require_once "database.php";

// Dobrodošlica i opis sajta
$welcome_message = "Dobrodošli na naš sajt za recepte! Naš cilj je da vam pružimo ukusne i inspirativne recepte za vaše kulinarske avanture.";

// Dohvatanje svih recepata iz baze podataka
$query_recipes = "SELECT * FROM recipes";
$result_recipes = mysqli_query($conn, $query_recipes);

// Provera greške u upitu za recepte
if (!$result_recipes) {
    die("Greška u upitu za recepte: " . mysqli_error($conn));
}

// Dohvatanje ocena i komentara za recepte
function getReviews($recipe_id, $conn) {
    $query_reviews = "SELECT rr.*, u.username, rr.rating FROM recipe_reviews rr JOIN users u ON rr.user_id = u.id WHERE recipe_id = $recipe_id";
    $result_reviews = mysqli_query($conn, $query_reviews);
    
    // Provera greške u upitu za recenzije
    if (!$result_reviews) {
        die("Greška u upitu za recenzije: ". mysqli_error($conn));
    }
    
    return $result_reviews;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 50px;
            background: url('images/wood-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            font-family: Arial, sans-serif;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }
        .container {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .recipe {
            display: flex;
            margin-bottom: 20px;
        }
        .recipe-text {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-right: 15px;
        }
        .recipe img {
            max-width: 250px;
            height: auto;
            border-radius: 5px;
        }
        .btn-submit-review {
            margin-top: 5px;
        }
        .logout-link {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            margin-top: -20px;
            background-color: #007bff;
            color: #fff;
        }
        textarea.form-control {
            width: 600px;
        }
        select.form-select {
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-end mb-3">
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
        <h2 class="mb-4">Dobrodošli na naš sajt za recepte!</h2>
        <p><?php echo $welcome_message; ?></p>
        
        <?php if(mysqli_num_rows($result_recipes) > 0): ?>
            <h3 class="mt-4">Najnoviji recepti:</h3>
            <?php while ($row = mysqli_fetch_assoc($result_recipes)): ?>
                <div class="recipe">
                    <div class="recipe-text">
                        <h4><?php echo $row['title']; ?></h4>
                        <p><?php echo $row['description']; ?></p>
                        <p><strong>Uputstva:</strong> <?php echo $row['instructions']; ?></p>

                        <!-- Prikaz recenzija za recept -->
                        <h5>Recenzije:</h5>
                        <?php 
                        $reviews = getReviews($row['id'], $conn);
                        if (mysqli_num_rows($reviews) > 0): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($review = mysqli_fetch_assoc($reviews)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($review['username']); ?></td>
                                            <td><?php echo $review['rating']; ?>/5</td>
                                            <td><?php echo htmlspecialchars($review['comment']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Još uvek nema recenzija za ovaj recept.</p>
                        <?php endif; ?>

                        <form action="submit_review.php" method="post">
                            <div class="mb-2">
                                <label for="rating_<?php echo $row['id']; ?>" class="form-label">Rating:</label>
                                <select name="rating" id="rating_<?php echo $row['id']; ?>" class="form-select">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="comment_<?php echo $row['id']; ?>" class="form-label">Comment:</label>
                                <textarea class="form-control comment-input" name="comment" id="comment_<?php echo $row['id']; ?>" rows="3"></textarea>
                            </div>
                            <input type="hidden" name="recipe_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="submit_review" id="submit_review_<?php echo $row['id']; ?>" class="btn btn-primary btn-submit-review" disabled>Submit Review</button>
                        </form>
                    </div>
                    <?php if(!empty($row['image'])): ?>
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Recept slika">
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Trenutno nema dostupnih recepata.</p>
        <?php endif; ?>
    </div>
    <script>
        document.querySelectorAll('.recipe').forEach(function(recipe) {
            var commentInput = recipe.querySelector(".comment-input");
            var submitButton = recipe.querySelector(".btn-submit-review");

            commentInput.addEventListener("input", function() {
                submitButton.disabled = this.value.trim() === "";
            });
        });
    </script>
</body>
</html>
