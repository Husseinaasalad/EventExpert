<?php
// First, connect without specifying a database to check if the database exists
$conn = new mysqli("localhost", "root", "");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the eventxpert database exists, and create it if it doesn't
$conn->query("CREATE DATABASE IF NOT EXISTS eventxpert");

// Now connect to the eventxpert database
$conn = new mysqli("localhost", "root", "", "eventxpert");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create necessary tables if they don't exist
$conn->query("CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    event_date DATE,
    location VARCHAR(255),
    description TEXT,
    status ENUM('planned', 'ongoing', 'completed') DEFAULT 'planned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
)");

// Add user_id and status columns if they don't exist
$result = $conn->query("SHOW COLUMNS FROM events LIKE 'user_id'");
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE events ADD COLUMN user_id INT AFTER event_id");
    $conn->query("ALTER TABLE events ADD CONSTRAINT fk_events_user_id FOREIGN KEY (user_id) REFERENCES users(user_id)");
}

$result = $conn->query("SHOW COLUMNS FROM events LIKE 'status'");
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE events ADD COLUMN status ENUM('planned', 'ongoing', 'completed') DEFAULT 'planned' AFTER description");
}

$conn->query("CREATE TABLE IF NOT EXISTS event_tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    task_name VARCHAR(255),
    due_date DATE,
    completed BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (event_id) REFERENCES events(event_id)
)");

$conn->query("CREATE TABLE IF NOT EXISTS event_registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    event_id INT,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (event_id) REFERENCES events(event_id)
)");

$conn->query("CREATE TABLE IF NOT EXISTS contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    message TEXT,
    event_type VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>