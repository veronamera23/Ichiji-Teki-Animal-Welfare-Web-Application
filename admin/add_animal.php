<?php include 'includes/admin_header.php'; ?>
<?php include '../includes/db_connect.php'; ?>

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
    $target_dir = "../images/";
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['image']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" 
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO animals (name, type, age, breed, health_status, description, image, created_by) 
                    VALUES ('$name', '$type', '$age', '$breed', '$health_status', '$description', '$image', '$created_by')";
            if ($conn->query($sql) === TRUE) {
                echo "Animal added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<style>
    .add-animal {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .add-animal h1 {
        text-align: center;
        font-size: 2em;
        margin-bottom: 20px;
        color: #333;
    }

    .add-animal form {
        display: flex;
        flex-direction: column;
    }

    .add-animal label {
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .add-animal input, .add-animal select, .add-animal textarea {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1em;
    }

    .add-animal button {
        padding: 10px 20px;
        font-size: 1em;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .add-animal button:hover {
        background-color: #0056b3;
    }

    .add-animal button[type="button"] {
        background-color: #6c757d;
        margin-top: 10px;
    }

    .add-animal button[type="button"]:hover {
        background-color: #5a6268;
    }
</style>

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
        <input type="text" name="breed">

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
