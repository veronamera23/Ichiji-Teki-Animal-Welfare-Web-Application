<?php
session_start();

include 'includes/db_connect.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $donation_type = $_POST['donation_type'];
    $details = $_POST['details'];

    $sql = "INSERT INTO donations (user_id, donation_type, details, status) 
            VALUES ('$user_id', '$donation_type', '$details', 'pending')";
    if ($conn->query($sql) === TRUE) {
        echo "Donation request submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<section class="donate">
    <h1>Make a Donation</h1>
    <form action="donate.php" method="post">
        <label for="donation_type">Kind of Donation:</label>
        <select name="donation_type" id="donation_type" required>
            <option value="monetary">Monetary</option>
            <option value="in-kind">In-kind</option>
        </select>

        <label for="details">Details:</label>
        <textarea name="details" id="details" required></textarea>

        <button type="submit">Submit</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
