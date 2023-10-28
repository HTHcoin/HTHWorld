<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="world.php">HTH Services</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <?php
        // Check if a session is already active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        error_reporting(0);
        include('includes/config.php');

        if (strlen($_SESSION['alogin']) == 0) {
            echo '<li><a href="login.php">Login</a></li>';
        } else {
            echo '<li><a href="homepage.php">Dashboard</a></li>';
        }
        ?>
    </ul>
</nav>
