<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';
include 'includes/admin_header.php';


if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

$animal = null;
$animal_id = isset($_POST['animal_id']) ? $_POST['animal_id'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $animal_id = $_POST['animal_id'];
    // Fetch the animal details by ID
    $sql = "SELECT * FROM animals WHERE id='$animal_id' AND deleted_at IS NULL";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $animal = $result->fetch_assoc();
    } else {
        $error = "Animal not found or already deleted.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $animal_id = $_POST['animal_id'];
    $deleted_by = $_SESSION['user_id'];

    // Soft delete the animal by setting the deleted_at column
    $sql = "UPDATE animals SET deleted_at=NOW(), deleted_by='$deleted_by' WHERE id='$animal_id'";
    if ($conn->query($sql) === TRUE) {
        $message = "Animal deleted successfully.";
        $animal = null; // Reset animal details after deletion
    } else {
        $error = "Error deleting animal: " . $conn->error;
    }
}
?>

<section class="admin-form">
    <h1>Delete Animal</h1>

    <form action="delete_animal.php" method="post">
        <label for="animal_id">Animal ID:</label>
        <input type="text" name="animal_id" id="animal_id" value="<?php echo htmlspecialchars($animal_id); ?>" required>
        <button type="submit" name="search">Search</button>

    </form>

    <?php if ($animal): ?>
        <h2>Animal Details</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($animal['name']); ?></p>
        <p><strong>Type:</strong> <?php echo htmlspecialchars($animal['type']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($animal['age']); ?></p>
        <p><strong>Breed:</strong> <?php echo htmlspecialchars($animal['breed']); ?></p>
        <p><strong>Health Status:</strong> <?php echo htmlspecialchars($animal['health_status']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($animal['description']); ?></p>
        <img src="../images/<?php echo htmlspecialchars($animal['image']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" width="150">
        
        <form action="delete_animal.php" method="post">
            <input type="hidden" name="animal_id" value="<?php echo htmlspecialchars($animal['id']); ?>">
            <p>Are you sure you want to delete this animal?</p>
            <button type="submit" name="confirm_delete">Yes, Delete</button>
            <a href="delete_animal.php">Cancel</a>
        </form>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    <button type="button" onclick="history.back()">Back</button>
</section>

<?php include '../includes/footer.php'; ?>