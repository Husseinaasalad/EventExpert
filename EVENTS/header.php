<?php
include_once 'session.php';
?>

<header class="header">
    <h1 class="logo"><a href="index.php">EventXpert</a></h1>
    <nav>
        <ul class="nav-links">
            <?php if (isLoggedIn()): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="calendar.php">Calendar</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="index.php">Home</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>