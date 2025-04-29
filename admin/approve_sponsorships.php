<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';
include 'includes/admin_header.php';


if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sponsorship_id = $_POST['sponsorship_id'];
    $status = $_POST['status'];
    $approved_by = $_SESSION['user_id'];

    $sql = "UPDATE sponsorships SET status='$status', approved_by='$approved_by', approved_at=NOW() WHERE id='$sponsorship_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Sponsorship request " . ($status == 'approved' ? "approved" : "rejected") . " successfully.";
    } else {
        echo "Error updating sponsorship: " . $conn->error;
    }
}
?>

<section class="admin-form">
    <h1>Approve Sponsorships</h1>
    <div class="sponsorship-requests">
        <?php
        $sql = "SELECT s.id AS sponsorship_id, s.entity_type, s.sponsorship_type, s.details, s.created_at, u.username, u.email, a.name AS animal_name 
                FROM sponsorships s 
                JOIN users u ON s.user_id = u.id 
                JOIN animals a ON s.animal_id = a.id 
                WHERE s.status='pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='sponsorship-request'>";
                echo "<h3>Animal: " . htmlspecialchars($row['animal_name']) . "</h3>";
                echo "<p>Sponsor: " . htmlspecialchars($row['username']) . " (" . htmlspecialchars($row['email']) . ")</p>";
                echo "<p>Entity Type: " . htmlspecialchars($row['entity_type']) . "</p>";
                echo "<p>Sponsorship Type: " . htmlspecialchars($row['sponsorship_type']) . "</p>";
                echo "<p>Details: " . htmlspecialchars($row['details']) . "</p>";
                echo "<p>Requested on: " . htmlspecialchars($row['created_at']) . "</p>";
                echo "<form action='approve_sponsorships.php' method='post'>";
                echo "<input type='hidden' name='sponsorship_id' value='" . htmlspecialchars($row['sponsorship_id']) . "'>";
                echo "<button type='submit' name='status' value='approved'>Approve</button>";
                echo "<button type='submit' name='status' value='rejected'>Reject</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No sponsorship requests to approve.";
        }
        ?>
    </div>
    <button type="button" onclick="history.back()">Back</button>
</section>

<?php include '../includes/footer.php'; ?>