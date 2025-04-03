<?php
include 'db_connect.php';
include_once 'session.php'; // Add this line to include session.php

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate name (letters and spaces only)
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "Name should contain only letters and spaces.";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate password (at least 5 characters, with uppercase, lowercase, and digits)
    if (strlen($password) < 5 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $errors[] = "Password must be at least 5 characters long and contain uppercase letters, lowercase letters, and digits.";
    }

    // If no validation errors, proceed with registration
    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $success = "Registration successful! Redirecting to login page...";
            header("Refresh: 2; url=login.php");
        } else {
            $errors[] = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - EventXpert</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="signup-container">
            <h2>Sign Up</h2>
            <?php 
            if (!empty($success)) {
                echo "<p class='success'>$success</p>";
            }
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
            ?>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Enter your name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit">Sign Up</button>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>