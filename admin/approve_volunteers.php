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
    $volunteer_id = $_POST['volunteer_id'];
    $status = $_POST['status'];
    $approved_by = $_SESSION['user_id'];

    $sql = "UPDATE volunteers SET status='$status', approved_by='$approved_by', approved_at=NOW() WHERE id='$volunteer_id'";
    if ($conn->query($sql) === TRUE) {
        if ($status == 'approved') {
            $user_sql = "UPDATE users SET role='volunteer' WHERE id=(SELECT user_id FROM volunteers WHERE id='$volunteer_id')";
            if ($conn->query($user_sql) === TRUE) {
                echo "Volunteer status and role updated successfully.";
            } else {
                echo "Error updating user role: " . $conn->error;
            }
        } else {
            echo "Volunteer status updated successfully.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<section class="admin-form">
    <h1>Approve Volunteers</h1>
    <div class="volunteer-applications">
        <?php
        $sql = "SELECT v.id AS volunteer_id, v.reason, v.skills, u.username, u.email FROM volunteers v JOIN users u ON v.user_id = u.id WHERE v.status='pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='volunteer-application'>";
                echo "<h3>Username: ".$row['username']."</h3>";
                echo "<p>Email: ".$row['email']."</p>";
                echo "<p>Reason: ".$row['reason']."</p>";
                echo "<p>Skills: ".$row['skills']."</p>";
                echo "<form action='approve_volunteers.php' method='post'>";
                echo "<input type='hidden' name='volunteer_id' value='".$row['volunteer_id']."'>";
                echo "<select name='status' required>";
                echo "<option value='approved'>Approve</option>";
                echo "<option value='rejected'>Reject</option>";
                echo "</select>";
                echo "<button type='submit'>Submit</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No volunteer applications.";
        }
        ?>
    </div>
    <button type="button" onclick="history.back()">Back</button>
</section>

<?php include '../includes/footer.php'; ?>
