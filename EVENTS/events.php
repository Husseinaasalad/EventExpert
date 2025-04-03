<?php
include 'db_connect.php';
requireLogin();

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $event_date = $conn->real_escape_string($_POST['event_date']);
    $location = $conn->real_escape_string($_POST['location']);
    $description = $conn->real_escape_string($_POST['description']);
    $status = $conn->real_escape_string($_POST['status']);
    
    $sql = "INSERT INTO events (user_id, title, event_date, location, description, status) 
            VALUES ('$user_id', '$title', '$event_date', '$location', '$description', '$status')";
    $conn->query($sql);
    
    if (isset($_POST['tasks'])) {
        $event_id = $conn->insert_id;
        foreach ($_POST['tasks'] as $task) {
            $task_name = $conn->real_escape_string($task['name']);
            $due_date = $conn->real_escape_string($task['due_date']);
            $conn->query("INSERT INTO event_tasks (event_id, task_name, due_date) VALUES ('$event_id', '$task_name', '$due_date')");
        }
    }
}

if (isset($_GET['delete'])) {
    $event_id = $conn->real_escape_string($_GET['delete']);
    $conn->query("DELETE FROM events WHERE event_id = '$event_id' AND user_id = '$user_id'");
    $conn->query("DELETE FROM event_tasks WHERE event_id = '$event_id'");
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
    <?php include 'header.php'; ?>
    <main class="container">
        <section class="events">
            <h2>Plan Your Events</h2>
            <form method="POST" class="contact-form event-planner">
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
                <div class="form-group">
                    <select name="status" required>
                        <option value="planned">Planned</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="tasks-container">
                    <h3>Tasks</h3>
                    <div id="tasks">
                        <div class="task-input">
                            <input type="text" name="tasks[0][name]" placeholder="Task Name">
                            <input type="date" name="tasks[0][due_date]">
                        </div>
                    </div>
                    <button type="button" id="add-task">Add Task</button>
                </div>
                <button type="submit" name="create">Create Event</button>
            </form>

            <div class="events-grid">
                <?php
                $result = $conn->query("SELECT * FROM events WHERE user_id = $user_id ORDER BY event_date ASC");
                while ($event = $result->fetch_assoc()) {
                    echo "
                        <div class='event-card'>
                            <h3>{$event['title']}</h3>
                            <p>Date: {$event['event_date']}</p>
                            <p>Location: {$event['location']}</p>
                            <p>Status: {$event['status']}</p>
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
    <?php include 'footer.php'; ?>
    <script>
        document.getElementById('add-task').addEventListener('click', function() {
            const tasks = document.getElementById('tasks');
            const count = tasks.children.length;
            const newTask = document.createElement('div');
            newTask.className = 'task-input';
            newTask.innerHTML = `
                <input type="text" name="tasks[${count}][name]" placeholder="Task Name">
                <input type="date" name="tasks[${count}][due_date]">
            `;
            tasks.appendChild(newTask);
        });
    </script>
</body>
</html>