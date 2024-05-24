<?php
session_start();
require_once "database.php";

// Inicijalizacija promenljive $result_users
$result_users = null;

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Provera da li su svi podaci uneseni
    if (empty($email) || empty($password)) {
        $error_message = "Please enter email and password.";
    } else {
        // Provera korisnika u bazi po emailu
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);
                // Provera lozinke
                if (password_verify($password, $user["password"])) {
                    $_SESSION["user"] = $user["email"];
                    $_SESSION["user_id"] = $user["id"]; // Dodajemo ovu liniju

                    if ($user["is_admin"] == 1) {
                        header("Location: admin.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit;
                } else {
                    $error_message = "Incorrect email or password.";
                }
            } else {
                $error_message = "User not found.";
            }
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}

// Dodavanje novog recepta
if (isset($_POST["add_recipe"])) {
    // Obrada unosa slike
    $image_path = null;
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $name = $_FILES['image']['name'];
        $destination = 'images/' . $name;
        move_uploaded_file($tmp_name, $destination);
        $image_path = $destination;
    }

    $title = $_POST["title"];
    $description = $_POST["description"];
    $instructions = $_POST["instructions"];

    // Provera da li su svi podaci uneseni
    if (empty($title) || empty($description) || empty($instructions)) {
        $_SESSION["error_message"] = "Molimo unesite naslov, opis i instrukcije.";
    } else {
        // Provera da li je recept već dodat (opciono)
        $check_recipe_query = "SELECT * FROM recipes WHERE title = '$title' AND description = '$description' AND instructions = '$instructions'";
        $check_result = mysqli_query($conn, $check_recipe_query);
        if(mysqli_num_rows($check_result) > 0) {
            $_SESSION["error_message"] = "Recept već postoji.";
            // Resetovanje poruke o uspehu
            unset($_SESSION["success_message"]);
        } else {
            // SQL upit za unos novog recepta u bazu podataka
            $insert_query = "INSERT INTO recipes (title, description, instructions, image) VALUES ('$title', '$description', '$instructions', '$image_path')";
            
            // Izvršavanje upita
            if (mysqli_query($conn, $insert_query)) {
                $_SESSION["success_message"] = "Recept uspešno dodat.";
                // Resetovanje poruke o grešci
                unset($_SESSION["error_message"]);
            } else {
                $_SESSION["error_message"] = "Greška pri dodavanju recepta: " . mysqli_error($conn);
            }
        }
        
    }
}

// Rukovanje unosom ocene i komentara
if (isset($_POST["submit_review"])) {
    $recipe_id = $_POST["recipe_id"];
    $user_id = $_SESSION["user_id"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    if (empty($rating) || empty($comment)) {
        $_SESSION["error_message"] = "Molimo unesite i ocenu i komentar.";
    } else {
        $insert_review_query = "INSERT INTO recipe_reviews (recipe_id, user_id, rating, comment) VALUES ('$recipe_id', '$user_id', '$rating', '$comment')";
        if (mysqli_query($conn, $insert_review_query)) {
            $_SESSION["success_message"] = "Ocena uspešno dodata.";
            // Resetovanje poruke o grešci
            unset($_SESSION["error_message"]);
        } else {
            $_SESSION["error_message"] = "Greška pri dodavanju ocene: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 50px;
            background: url('images/wood-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        .container {
            position: relative;
            z-index: 2;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .delete-btn {
            color: white;
            background-color: red;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .alert {
            margin-top: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
        <h2 class="mb-4">Admin Panel - All Users</h2>
        <p>Hello, <?php echo isset($_SESSION["user"]) ? $_SESSION["user"] : "Guest"; ?>! <a href="logout.php">Logout</a></p>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="instructions" class="form-label">Instructions</label>
                <textarea class="form-control" id="instructions" name="instructions" placeholder="Instructions" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary" name="add_recipe">Add Recipe</button>
        </form>
        <hr>
        <h2 class="mb-4">All Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php
            $query_users = "SELECT * FROM users";
            $result_users = mysqli_query($conn, $query_users);
            if ($result_users && mysqli_num_rows($result_users) > 0) {
                while ($row = mysqli_fetch_assoc($result_users)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td><button class='delete-btn' onclick='deleteUser(" . $row['id'] . ")'>Delete</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found.</td></tr>";
            }
            ?>
        </table>
        <hr>
        <h2 class="mb-4">All Recipes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Instructions</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php
            $query_recipes = "SELECT * FROM recipes";
            $result_recipes = mysqli_query($conn, $query_recipes);
            if ($result_recipes && mysqli_num_rows($result_recipes) > 0) {
                while ($row = mysqli_fetch_assoc($result_recipes)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['instructions'] . "</td>";
                    echo "<td><img src='" . $row['image'] . "' alt='" . $row['title'] . "' style='max-width:100px'></td>";
                    echo "<td><button class='delete-btn' onclick='deleteRecipe(" . $row['id'] . ")'>Delete</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No recipes found.</td></tr>";
            }
            ?>
        </table>
        <hr>
        <h2 class="mb-4">All Reviews</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Recipe ID</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
            <?php
            $query_reviews = "SELECT * FROM recipe_reviews";
            $result_reviews = mysqli_query($conn, $query_reviews);
            if ($result_reviews && mysqli_num_rows($result_reviews) > 0) {
                while ($row = mysqli_fetch_assoc($result_reviews)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['recipe_id'] . "</td>";
                    echo "<td>" . $row['rating'] . "</td>";
                    echo "<td>" . $row['comment'] . "</td>";
                    echo "<td><button class='delete-btn' onclick='deleteReview(" . $row['id'] . ")'>Delete</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No reviews found.</td></tr>";
            }
            ?>
        </table>
        <?php if(isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>
        <?php if(isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>
    </div>

    <script>
    function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("GET", "delete_user.php?id=" + userId, true);
            xhttp.send();
        }
    }

    function deleteRecipe(recipeId) {
    if (confirm("Are you sure you want to delete this recipe?")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                location.reload();
            }
        };
        xhttp.open("GET", "delete_recipe.php?id=" + recipeId, true);
        xhttp.send();
    }
}

    function deleteReview(reviewId) {
        if (confirm("Are you sure you want to delete this review?")) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("GET", "delete_review.php?id=" + reviewId, true);
            xhttp.send();
        }
    }
    </script>
</body>
</html>


