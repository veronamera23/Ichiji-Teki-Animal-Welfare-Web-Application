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
    $donation_id = $_POST['donation_id'];
    $status = $_POST['status'];
    $approved_by = $_SESSION['user_id'];

    $sql = "UPDATE donations SET status='$status', approved_by='$approved_by', approved_at=NOW() WHERE id='$donation_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Donation status updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<section class="admin-form">
    <h1>Approve Donations</h1>
    <div class="donation-requests">
        <?php
        $sql = "SELECT d.*, u.username, u.email 
                FROM donations d 
                JOIN users u ON d.user_id = u.id 
                WHERE d.status='pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='donation-request'>";
                echo "<h3>Username: " . $row['username'] . "</h3>";
                echo "<p>Email: " . $row['email'] . "</p>";
                echo "<p>Donation Type: " . $row['donation_type'] . "</p>";
                
                if ($row['donation_type'] == 'monetary') {
                    echo "<p>Frequency: " . $row['frequency'] . "</p>";
                    echo "<p>Payment Mode: " . $row['payment_mode'] . "</p>";
                    echo "<p>Account Name: " . $row['account_name'] . "</p>";
                    echo "<p>Account Number: " . $row['account_number'] . "</p>";
                    echo "<p>Bank: " . $row['bank'] . "</p>";
                    echo "<p>Amount: " . $row['amount'] . "</p>";
                    echo "<p>Use: " . $row['use'] . "</p>";
                } elseif ($row['donation_type'] == 'in-kind') {
                    echo "<p>Wishlists: " . $row['wishlists'] . "</p>";
                }
                
                echo "<p>Details: " . $row['details'] . "</p>";
                echo "<form action='approve_donations.php' method='post'>";
                echo "<input type='hidden' name='donation_id' value='" . $row['id'] . "'>";
                echo "<select name='status' required>";
                echo "<option value='approved'>Approve</option>";
                echo "<option value='rejected'>Reject</option>";
                echo "</select>";
                echo "<button type='submit'>Submit</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No donation requests.";
        }
        ?>
    </div>
    <button type="button" onclick="history.back()">Back</button>
</section>

<?php include '../includes/footer.php'; ?>