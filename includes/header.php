<link rel="stylesheet" href="header.css">

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'db_connect.php';
require_once 'functions.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Rescue</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="animal_profiles.php">Animal Profiles</a></li>

            <?php if (isLoggedIn() && isAdmin()): ?>
                <li><a href="admin/index.php">Admin Panel</a></li>
            <?php endif; ?>
            <?php if (isLoggedIn() && isVolunteer()): ?>
                <li><a href="volunteer/index.php">Volunteer Panel</a></li>
            <?php endif; ?>
            <?php if (isLoggedIn()): ?>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
