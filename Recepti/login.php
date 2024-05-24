<?php
session_start();
require_once "database.php";

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
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            // Provera lozinke
            if (password_verify($password, $user["password"])) {
                $_SESSION["user"] = $user["email"];
                $_SESSION["is_admin"] = $user["is_admin"];
            
                if ($_SESSION["is_admin"] == 1) {
                    header("Location: admin.php");
                } else {
                    header("Location: home.php");
                }
                exit;
            } else {
                $error_message = "Incorrect email or password.";
            }
            
        } else {
            $error_message = "User not found.";
        }
    }
}

// Dohvatanje svih korisnika iz baze podataka
$query_users = "SELECT * FROM users";
$result_users = mysqli_query($conn, $query_users);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 50px;
            background: url('images/Bgimage1.jpg') no-repeat center center fixed;
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
            background: rgba(0, 0, 0, 0.5); /* Adjust the opacity as needed */
            z-index: 1;
        }
        .container {
            position: relative;
            z-index: 2;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
        }
        .card-body {
            padding: 30px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            width: 100%;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Login</h2>
                        <?php if (isset($error_message)) { ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php } ?>
                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="login">Login</button>
                        </form>
                        <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

