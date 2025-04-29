<!-- <?php include '../includes/admin_header.php'; ?>
<?php include '../includes/db_connect.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $approved_by = $_SESSION['user_id'];
    $sql = "UPDATE partnerships SET status='$status', approved_by='$approved_by' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Partnership status updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<section class="admin-form">
    <h1>Approve Partnerships</h1>
    <div class="partnership-applications">
        <?php
        $sql = "SELECT * FROM partnerships WHERE status='pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $user_id = $row['user_id'];
                $user_sql = "SELECT * FROM users WHERE id='$user_id'";
                $user_result = $conn->query($user_sql);
                $user = $user_result->fetch_assoc();
                echo "<div class='partnership-application'>";
                echo "<h3>".$user['username']."</h3>";
                echo "<p>".$row['details']."</p>";
                echo "<form action='approve_partnerships.php' method='post'>";
                echo "<input type='hidden' name='id' value='".$row['id']."'>";
                echo "<select name='status' required>";
                echo "<option value='approved'>Approve</option>";
                echo "<option value='rejected'>Reject</option>";
                echo "</select>";
                echo "<button type='submit'>Submit</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No partnership applications.";
        }
        ?>
    </div>
</section>

<?php include '../includes/footer.php'; ?> -->
