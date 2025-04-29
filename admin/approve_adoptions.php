<?php
session_start();
include 'includes/admin_header.php';

include '../includes/db_connect.php';
include '../includes/functions.php';

if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adoption_id = $_POST['adoption_id'];
    $status = $_POST['status'];
    $approved_by = $_SESSION['user_id'];

    // Fetch the adoption details
    $sql = "SELECT * FROM adoptions WHERE id='$adoption_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $adoption = $result->fetch_assoc();
        $animal_id = $adoption['animal_id'];

        // Update adoption status
        $update_adoption_sql = "UPDATE adoptions SET status='$status', approved_by='$approved_by', approved_at=NOW() WHERE id='$adoption_id'";
        if ($conn->query($update_adoption_sql) === TRUE) {
            if ($status == 'approved') {
                // Update animal status to 'adopted'
                $update_animal_sql = "UPDATE animals SET status='adopted' WHERE id='$animal_id'";
                if ($conn->query($update_animal_sql) === TRUE) {
                    echo "Adoption approved and animal status updated to adopted.";
                } else {
                    echo "Error updating animal status: " . $conn->error;
                }
            } else {
                echo "Adoption request has been rejected.";
            }
        } else {
            echo "Error updating adoption status: " . $conn->error;
        }
    } else {
        echo "Adoption request not found.";
    }
}
?>

<section class="admin-form">
    <h1>Approve Adoptions</h1>
    <div class="adoption-requests">
        <?php
        $sql = "SELECT a.id AS adoption_id, a.status, a.feeding_responsibility, a.allergic_household, a.income_sources, a.house_picture, u.username, u.email, an.name AS animal_name 
                FROM adoptions a 
                JOIN users u ON a.user_id = u.id 
                JOIN animals an ON a.animal_id = an.id 
                WHERE a.status='pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='adoption-request'>";
                echo "<h3>User: " . $row['username'] . " (Email: " . $row['email'] . ")</h3>";
                echo "<p>Animal: " . $row['animal_name'] . "</p>";
                echo "<p>Feeding Responsibility: " . $row['feeding_responsibility'] . "</p>";
                echo "<p>Allergic Household: " . $row['allergic_household'] . "</p>";
                echo "<p>Income Sources: " . $row['income_sources'] . "</p>";
                echo "<img src='../images/" . $row['house_picture'] . "' alt='House Picture' width='150'>";
                echo "<form action='approve_adoptions.php' method='post'>";
                echo "<input type='hidden' name='adoption_id' value='" . $row['adoption_id'] . "'>";
                echo "<select name='status' required>";
                echo "<option value='approved'>Approve</option>";
                echo "<option value='rejected'>Reject</option>";
                echo "</select>";
                echo "<button type='submit'>Submit</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No adoption requests.";
        }
        ?>
    </div>
    <button type="button" onclick="history.back()">Back</button>
</section>

<?php include '../includes/footer.php'; ?>
