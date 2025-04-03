<?php
include 'db_connect.php';
include_once 'session.php'; // Add this line to include session.php
requireLogin();

// Ensure user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EventXpert</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    <main class="container">
        <section class="dashboard-overview">
            <h2>Your Event Dashboard</h2>
            <div class="stats-grid">
                <?php
                $user_id = $_SESSION['user_id'];
                $stats = [
                    'planned' => 0,
                    'ongoing' => 0,
                    'completed' => 0
                ];

                // Check if user_id column exists
                $result = $conn->query("SHOW COLUMNS FROM events LIKE 'user_id'");
                if ($result->num_rows > 0) {
                    $stmt = $conn->prepare("SELECT COUNT(*) FROM events WHERE user_id = ? AND status = 'planned'");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $stats['planned'] = $stmt->get_result()->fetch_row()[0];
                    $stmt->close();

                    $stmt = $conn->prepare("SELECT COUNT(*) FROM events WHERE user_id = ? AND status = 'ongoing'");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $stats['ongoing'] = $stmt->get_result()->fetch_row()[0];
                    $stmt->close();

                    $stmt = $conn->prepare("SELECT COUNT(*) FROM events WHERE user_id = ? AND status = 'completed'");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $stats['completed'] = $stmt->get_result()->fetch_row()[0];
                    $stmt->close();
                } else {
                    echo "<p class='error'>Error: The events table is missing the user_id column. Please contact support.</p>";
                }
                ?>
                <div class="stat-card">
                    <h3><?php echo $stats['planned']; ?></h3>
                    <p>Planned Events</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $stats['ongoing']; ?></h3>
                    <p>Ongoing Events</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $stats['completed']; ?></h3>
                    <p>Completed Events</p>
                </div>
            </div>
            <div class="upcoming-events">
                <h3>Upcoming Events</h3>
                <div class="events-grid">
                    <?php
                    if ($result->num_rows > 0) {
                        $stmt = $conn->prepare("SELECT * FROM events WHERE user_id = ? AND event_date >= CURDATE() ORDER BY event_date ASC LIMIT 3");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($event = $result->fetch_assoc()) {
                                echo "
                                    <div class='event-card'>
                                        <h4>{$event['title']}</h4>
                                        <p>Date: {$event['event_date']}</p>
                                        <p>Location: {$event['location']}</p>
                                        <p>Status: {$event['status']}</p>
                                    </div>
                                ";
                            }
                        } else {
                            echo "<p>No upcoming events found.</p>";
                        }
                        $stmt->close();
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>