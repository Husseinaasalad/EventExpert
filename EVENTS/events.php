<?php
include 'db_connect.php';
include 'session.php';
requireLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $event_date = $conn->real_escape_string($_POST['event_date']);
    $location = $conn->real_escape_string($_POST['location']);
    $description = $conn->real_escape_string($_POST['description']);
    
    $sql = "INSERT INTO events (title, event_date, location, description) 
            VALUES ('$title', '$event_date', '$location', '$description')";
    $conn->query($sql);
}

if (isset($_GET['delete'])) {
    $event_id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM events WHERE event_id = '$event_id'";
    $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - EventXpert</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <h1 class="logo"><a href="index.php">EventXpert</a></h1>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="signup.php">Sign Up</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="container">
        <section class="events">
            <h2>Manage Events</h2>
            <form method="POST" class="contact-form">
                <div class="form-group">
                    <input type="text" name="title" placeholder="Event Title" required>
                </div>
                <div class="form-group">
                    <input type="date" name="event_date" required>
                </div>
                <div class="form-group">
                    <input type="text" name="location" placeholder="Location" required>
                </div>
                <div class="form-group">
                    <textarea name="description" placeholder="Description"></textarea>
                </div>
                <button type="submit" name="create">Create Event</button>
            </form>

            <div class="events-grid">
                <?php
                $sql = "SELECT * FROM events ORDER BY event_date ASC";
                $result = $conn->query($sql);
                while ($event = $result->fetch_assoc()) {
                    echo "
                        <div class='event-card'>
                            <h3>{$event['title']}</h3>
                            <p>Date: {$event['event_date']}</p>
                            <p>Location: {$event['location']}</p>
                            <p>{$event['description']}</p>
                            <a href='edit_event.php?id={$event['event_id']}' class='btn-edit'>Edit</a>
                            <a href='events.php?delete={$event['event_id']}' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </div>
                    ";
                }
                ?>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>© <?php echo date("Y"); ?> EventXpert. All rights reserved.</p>
    </footer>
</body>
</html>