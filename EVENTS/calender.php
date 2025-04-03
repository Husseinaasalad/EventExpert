<?php
include 'db_connect.php';
requireLogin();
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar - EventXpert</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    <main class="container">
        <section class="calendar-section">
            <h2>Event Calendar</h2>
            <div id="calendar"></div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    <?php
                    $result = $conn->query("SELECT * FROM events WHERE user_id = $user_id");
                    while ($event = $result->fetch_assoc()) {
                        echo "{ 
                            title: '{$event['title']}', 
                            start: '{$event['event_date']}',
                            extendedProps: {
                                location: '{$event['location']}',
                                status: '{$event['status']}'
                            }
                        },";
                    }
                    ?>
                ],
                eventClick: function(info) {
                    alert('Event: ' + info.event.title + '\nLocation: ' + info.event.extendedProps.location + '\nStatus: ' + info.event.extendedProps.status);
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>