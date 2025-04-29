<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'volunteer') {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Panel</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="../profile.php">Profile</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
</header>





