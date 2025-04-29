<?php
session_start();

include '../includes/db_connect.php';
include '../includes/functions.php';
include 'includes/volunteer_header.php';


if (!isVolunteer()) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stray_id = $_POST['stray_id'];
    $status = $_POST['status'];
    $verified_by = $_SESSION['user_id'];

    if ($status == 'verified' || $status == 'rejected') {
        // Fetch the stray report details
        $sql = "SELECT * FROM stray_reports WHERE id='$stray_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $reporter_id = $row['reporter_id'];
            $type = $row['type'];
            $color = $row['color'];
            $location = $row['location'];
            $time = $row['time'];
            $needs = $row['needs'];
            $image = $row['image'];

            if ($status == 'verified') {
                // Insert into animals table
                $insert_sql = "INSERT INTO animals (name, type, age, breed, health_status, description, image, status, created_by)
                               VALUES ('Unknown', '$type', 'Unknown', 'Unknown', 'Healthy', 'Color: $color, Location: $location, Time: $time, Needs: $needs', '$image', 'available', '$verified_by')";

                if ($conn->query($insert_sql) === TRUE) {
                    // Update stray report status
                    $update_sql = "UPDATE stray_reports SET status='$status', verified_by='$verified_by', verified_at=NOW() WHERE id='$stray_id'";
                    if ($conn->query($update_sql) === TRUE) {
                        echo "Stray report verified and animal added successfully.";
                    } else {
                        echo "Error updating stray report: " . $conn->error;
                    }
                } else {
                    echo "Error inserting animal: " . $conn->error;
                }
            } else {
                // Update stray report status to rejected
                $update_sql = "UPDATE stray_reports SET status='$status', verified_by='$verified_by', verified_at=NOW() WHERE id='$stray_id'";
                if ($conn->query($update_sql) === TRUE) {
                    echo "Stray report rejected.";
                } else {
                    echo "Error updating stray report: " . $conn->error;
                }
            }
        } else {
            echo "Stray report not found.";
        }
    } else {
        echo "Invalid status selected.";
    }
}
?>

<section class="admin-form">
    <h1>Verify Stray Reports</h1>
    <div class="stray-reports">
        <?php
        $sql = "SELECT s.id AS stray_id, s.type, s.color, s.location, s.time, s.needs, s.image, u.username, u.email 
                FROM stray_reports s JOIN users u ON s.reporter_id = u.id WHERE s.status='unverified'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='stray-report'>";
                echo "<h3>Reported by: " . $row['username'] . "</h3>";
                echo "<p>Email: " . $row['email'] . "</p>";
                echo "<p>Type: " . $row['type'] . "</p>";
                echo "<p>Color: " . $row['color'] . "</p>";
                echo "<p>Location: " . $row['location'] . "</p>";
                echo "<p>Time: " . $row['time'] . "</p>";
                echo "<p>Needs: " . $row['needs'] . "</p>";
                echo "<img src='../images/" . $row['image'] . "' alt='Animal Image' width='150'>";
                echo "<form action='verify_stray.php' method='post'>";
                echo "<input type='hidden' name='stray_id' value='" . $row['stray_id'] . "'>";
                echo "<select name='status' required>";
                echo "<option value='verified'>Verify</option>";
                echo "<option value='rejected'>Reject</option>";
                echo "</select>";
                echo "<button type='submit'>Submit</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No stray reports to verify.";
        }
        ?>
    </div>
    <button type="button" onclick="history.back()">Back</button>

</section>

<?php include '../includes/footer.php'; ?>