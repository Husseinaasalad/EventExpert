<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    $event_type = $conn->real_escape_string($_POST['event_type']);
    
    $sql = "INSERT INTO contact_messages (name, email, message, event_type) 
            VALUES ('$name', '$email', '$message', '$event_type')";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Message sent successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventXpert - Contact Us</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main class="container">
        <section class="contact-form">
            <h2>Contact Us</h2>
            <?php 
            if (isset($success)) echo "<p class='success'>$success</p>";
            if (isset($error)) echo "<p class='error'>$error</p>";
            ?>
            <form method="POST" id="contactForm">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Message" required></textarea>
                </div>
                <div class="form-group">
                    <select name="event_type" required>
                        <option value="">Event Type</option>
                        <option>Wedding</option>
                        <option>Conference</option>
                        <option>Party</option>
                    </select>
                </div>
                <button type="submit">Send Message</button>
                <?php if (!isLoggedIn()): ?>
                    <p>Want to create an account? <a href="signup.php">Sign Up</a></p>
                <?php endif; ?>
            </form>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>