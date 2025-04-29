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
    $foster_id = $_POST['foster_id'];
    $status = $_POST['status'];
    $approved_by = $_SESSION['user_id'];

    $sql = "UPDATE fosters SET status='$status', approved_by='$approved_by', approved_at=NOW() WHERE id='$foster_id'";
    if ($conn->query($sql) === TRUE) {
        if ($status == 'approved') {
            // Update animal status to fostered
            $animal_id_sql = "SELECT animal_id FROM fosters WHERE id='$foster_id'";
            $animal_id_result = $conn->query($animal_id_sql);
            if ($animal_id_result->num_rows > 0) {
                $animal_id = $animal_id_result->fetch_assoc()['animal_id'];
                $update_animal_sql = "UPDATE animals SET status='fostered' WHERE id='$animal_id'";
                $conn->query($update_animal_sql);
            }
        }
        echo "Foster request " . ($status == 'approved' ? "approved" : "rejected") . " successfully.";
    } else {
        echo "Error updating foster request: " . $conn->error;
    }
}
?>

<section class="admin-form">
    <h1>Approve Foster Requests</h1>
    <div class="foster-requests">
        <?php
        $sql = "SELECT f.id AS foster_id, f.start_date, f.end_date, f.feeding_responsibility, f.allergic_household, f.income_sources, f.house_picture, f.created_at, u.username, u.email, a.name AS animal_name 
                FROM fosters f 
                JOIN users u ON f.user_id = u.id 
                JOIN animals a ON f.animal_id = a.id 
                WHERE f.status='pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='foster-request'>";
                echo "<h3>Animal: " . htmlspecialchars($row['animal_name']) . "</h3>";
                echo "<p>Applicant: " . htmlspecialchars($row['username']) . " (" . htmlspecialchars($row['email']) . ")</p>";
                echo "<p>Start Date: " . htmlspecialchars($row['start_date']) . "</p>";
                echo "<p>End Date: " . htmlspecialchars($row['end_date']) . "</p>";
                echo "<p>Feeding Responsibility: " . htmlspecialchars($row['feeding_responsibility']) . "</p>";
                echo "<p>Allergic Household: " . htmlspecialchars($row['allergic_household']) . "</p>";
                echo "<p>Income Sources: " . htmlspecialchars($row['income_sources']) . "</p>";
                echo "<p>House Picture: <img src='../images/" . htmlspecialchars($row['house_picture']) . "' alt='House Picture' width='150'></p>";
                echo "<p>Requested on: " . htmlspecialchars($row['created_at']) . "</p>";
                echo "<form action='approve_foster.php' method='post'>";
                echo "<input type='hidden' name='foster_id' value='" . htmlspecialchars($row['foster_id']) . "'>";
                echo "<button type='submit' name='status' value='approved'>Approve</button>";
                echo "<button type='submit' name='status' value='rejected'>Reject</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No foster requests to approve.";
        }
        ?>
    </div>
    <button type="button" onclick="history.back()">Back</button>
</section>

<?php include '../includes/footer.php'; ?>