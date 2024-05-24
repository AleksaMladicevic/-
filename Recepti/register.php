<?php
session_start();

require_once "database.php";

if(isset($_POST["register"])) {
    // Provera da li je ključ "username" postavljen u POST zahtevu
    if(isset($_POST["username"])) {
        $username = $_POST["username"];
    } else {
        // Postavljamo $username na prazan string ako ključ "username" nije postavljen
        $username = "";
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Provera da li su svi podaci uneseni
    if(empty($username) || empty($email) || empty($password)) {
        $error_message = "Please enter username, email, and password.";
    } else {
        // Provera da li email već postoji u bazi
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {
            $error_message = "Email already exists.";
        } else {
            // Hashovanje lozinke pre čuvanja u bazi
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Ubacivanje korisnika u bazu
            $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            if(mysqli_query($conn, $insert_query)) {
                $_SESSION["user"] = $email;
                header("Location: home.php");
                exit;
            } else {
                $error_message = "Error registering user.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                        <h2 class="card-title text-center mb-4">Register</h2>
                        <?php if (isset($error_message)) { ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php } ?>
                        <form action="register.php" method="post">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="username" placeholder="Full Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="register">Register</button>
                        </form>
                        <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
