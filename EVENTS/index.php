<?php
include 'db_connect.php';
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventXpert - Professional Management System</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
        <section class="hero">
            <div class="hero-text">
                <h2>Transform Your Event Planning</h2>
                <p>Streamline your event planning with our all-in-one platform. Whether it's a corporate event or a wedding, we simplify the process.</p>
                <ul>
                    <li>Comprehensive features for all planners: Our platform provides a complete set of tools to simplify event planning, from scheduling and budgeting to vendor coordination and attendee management.</li>
                    <li>Hassle-free ticketing and registration: Easily set up ticketing and registration with automated confirmations, secure payment processing, and seamless check-in options for attendees.</li>
                    <li>Integrated marketing tools for visibility: Maximize your event’s reach with built-in marketing tools, including email campaigns, social media integration, and SEO-optimized event pages.</li>
                    <li>Real-time collaboration and feedback: Enhance teamwork with live document sharing, task management, and instant feedback to streamline event coordination.</li>
                </ul>
            </div>
            <div class="hero-images">
                <img src="https://www.thetamarindtree.in/wp-content/uploads/2024/09/SAL04106-1500x1000.jpg" alt="Wedding Event" class="hero-image">
                <img src="https://images.pexels.com/photos/50675/banquet-wedding-society-deco-50675.jpeg" alt="Corporate Event" class="hero-image">
                <img src="https://k-authentic.com/wp-content/uploads/2023/04/small-birthday-party-places-in-nagpur-to-host-your-glittering-evening.jpg" alt="Birthday Party" class="hero-image">
                <img src="https://eventhousekenya.com/wp-content/uploads/2020/02/mobile-banner.jpg" alt="Conference Setup" class="hero-image">
                <img src="https://www.theborneopost.com/newsimages/2024/09/sbw-160924-pb-trees-p1.jpeg" alt="Award Ceremony" class="hero-image">
            </div>
        </section>
        <section class="gallery-section">
            <h2>Our Work in Action</h2>
            <p>At Elite Events Management, we bring events to life with precision, creativity, and seamless execution. Specializing in corporate conferences, product launches, weddings, and large-scale celebrations.</p>
            <div class="gallery-grid" id="gallery"></div>
        </section>
    </main>
    <div class="modal" id="imageModal">
        <span class="close">×</span>
        <img class="modal-content" id="modalImage">
        <div class="caption" id="modalCaption"></div>
    </div>
    <footer class="footer">
        <p>© <?php echo date("Y"); ?> EventXpert. All rights reserved.</p>
    </footer>
</body>
</html>