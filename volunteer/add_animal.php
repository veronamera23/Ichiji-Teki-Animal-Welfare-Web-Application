<?php
session_start();

include '../includes/db_connect.php';
include '../includes/functions.php';
include 'includes/volunteer_header.php';

if (!isVolunteer()) {
    header('Location: ../login.php');
    exit();
}
?>



<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $age = $_POST['age'];
    $breed = $_POST['breed'];
    $health_status = $_POST['health_status'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $created_by = $_SESSION['user_id'];
    $target = "../images/".basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO animals (name, type, age, breed, health_status, description, image, created_by) 
                VALUES ('$name', '$type', '$age', '$breed', '$health_status', '$description', '$image', '$created_by')";
        if ($conn->query($sql) === TRUE) {
            echo "Animal added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>

<section class="add-animal">
    <h1>Add Animal</h1>
    <form action="add_animal.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="type">Type:</label>
        <select name="type" id="type" required>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
            <option value="bird">Bird</option>
            <option value="reptile">Reptile</option>
            <option value="other">Other</option>
        </select>

        <label for="age">Age:</label>
        <input type="text" name="age" id="age" required>

        <label for="breed">Breed:</label>
        <input type="text" name="breed" id="breed">

        <label for="health_status">Health Status:</label>
        <textarea name="health_status" id="health_status" required></textarea>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" required>

        <button type="submit">Submit</button>
    </form>
    <button type="button" onclick="history.back()">Back</button>


</section>
<?php include '../includes/footer.php'; ?>
