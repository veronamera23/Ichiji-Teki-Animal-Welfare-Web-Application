<?php

include '../includes/db_connect.php';
include 'includes/admin_header.php';
include '../includes/functions.php';


if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['animal_id'])) {
        $animal_id = $_POST['animal_id'];
        
        // Fetch the current details of the animal
        $sql = "SELECT * FROM animals WHERE id='$animal_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $animal = $result->fetch_assoc();
        } else {
            echo "Animal not found.";
        }
    } else {
        // Update the animal details
        $animal_id = $_POST['id'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $age = $_POST['age'];
        $breed = $_POST['breed'];
        $health_status = $_POST['health_status'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $image = $_FILES['image']['name'];
        $target = "../images/" . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $update_sql = "UPDATE animals SET 
                           name='$name', 
                           type='$type', 
                           age='$age', 
                           breed='$breed', 
                           health_status='$health_status', 
                           description='$description', 
                           image='$image', 
                           status='$status', 
                           updated_by='{$_SESSION['user_id']}', 
                           updated_at=NOW() 
                           WHERE id='$animal_id'";
        } else {
            // If image is not updated
            $update_sql = "UPDATE animals SET 
                           name='$name', 
                           type='$type', 
                           age='$age', 
                           breed='$breed', 
                           health_status='$health_status', 
                           description='$description', 
                           status='$status', 
                           updated_by='{$_SESSION['user_id']}', 
                           updated_at=NOW() 
                           WHERE id='$animal_id'";
        }

        if ($conn->query($update_sql) === TRUE) {
            echo "Animal details updated successfully.";
        } else {
            echo "Error updating animal: " . $conn->error;
        }
    }
}
?>

<section class="admin-form">
    <h1>Update Animal Details</h1>
    <?php if (isset($animal)): ?>
    <form action="update_animal.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $animal['name']; ?>" required>

        <label for="type">Type of Animal:</label>
        <select name="type" id="type" required>
            <option value="dog" <?php echo ($animal['type'] == 'dog') ? 'selected' : ''; ?>>Dog</option>
            <option value="cat" <?php echo ($animal['type'] == 'cat') ? 'selected' : ''; ?>>Cat</option>
            <option value="bird" <?php echo ($animal['type'] == 'bird') ? 'selected' : ''; ?>>Bird</option>
            <option value="reptile" <?php echo ($animal['type'] == 'reptile') ? 'selected' : ''; ?>>Reptile</option>
            <option value="other" <?php echo ($animal['type'] == 'other') ? 'selected' : ''; ?>>Other</option>
        </select>

        <label for="age">Age:</label>
        <input type="text" name="age" id="age" value="<?php echo $animal['age']; ?>" required>

        <label for="breed">Breed:</label>
        <input type="text" name="breed" id="breed" value="<?php echo $animal['breed']; ?>">

        <label for="health_status">Health Status:</label>
        <input type="text" name="health_status" id="health_status" value="<?php echo $animal['health_status']; ?>">

        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo $animal['description']; ?></textarea>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="available" <?php echo ($animal['status'] == 'available') ? 'selected' : ''; ?>>Available</option>
            <option value="adopted" <?php echo ($animal['status'] == 'adopted') ? 'selected' : ''; ?>>Adopted</option>
            <option value="fostered" <?php echo ($animal['status'] == 'fostered') ? 'selected' : ''; ?>>Fostered</option>
        </select>

        <label for="image">Upload Photo:</label>
        <input type="file" name="image" id="image">
        <img src="../images/<?php echo $animal['image']; ?>" alt="Animal Image" width="150">

        <button type="submit">Update</button>
        <button type="button" onclick="history.back()">Back</button>
    </form>
    <?php else: ?>
    <form action="update_animal.php" method="post">
        <label for="animal_id">Animal ID:</label>
        <input type="text" name="animal_id" id="animal_id" required>
        <button type="submit">Search</button>
    </form>
    <button type="button" onclick="history.back()">Back</button>

    <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>