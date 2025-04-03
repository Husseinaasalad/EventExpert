<?php
include 'db_connect.php';
requireLogin();

$event_id = $conn->real_escape_string($_GET['id']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $event_date = $conn->real_escape_string($_POST['event_date']);
    $location = $conn->real_escape_string($_POST['location']);
    $description = $conn->real_escape_string($_POST['description']);
    
    $sql = "UPDATE events SET title='$title', event_date='$event_date', location='$location', description='$description' 
            WHERE event_id='$event_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: events.php");
    }
}

$sql = "SELECT * FROM events WHERE event_id='$event_id'";
$event = $conn->query($sql)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - EventXpert</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main class="container">
        <section class="contact-form">
            <h2>Edit Event</h2>
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="title" value="<?php echo $event['title']; ?>" required>
                </div>
                <div class="form-group">
                    <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" required>
                </div>
                <div class="form-group">
                    <input type="text" name="location" value="<?php echo $event['location']; ?>" required>
                </div>
                <div class="form-group">
                    <textarea name="description"><?php echo $event['description']; ?></textarea>
                </div>
                <button type="submit">Update Event</button>
            </form>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>