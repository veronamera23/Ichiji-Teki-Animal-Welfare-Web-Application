<!-- <?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';
include '../includes/functions.php';

if (!isVolunteer()) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $reason = $_POST['reason'];

    $sql = "INSERT INTO sign_off_requests (user_id, reason, status) VALUES ('$user_id', '$reason', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "Sign-off request submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<?php include '../includes/footer.php'; ?> -->