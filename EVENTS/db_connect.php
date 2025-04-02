<?php
$conn = new mysqli("localhost", "root", "", "eventxpert");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>