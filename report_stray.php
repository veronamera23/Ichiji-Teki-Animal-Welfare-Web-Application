<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<?php
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reporter_id = $_SESSION['user_id'];
    $type = $_POST['type'];
    $color = $_POST['color'];
    $location = $_POST['location'];
    $time = $_POST['time'];
    $needs = $_POST['needs'];
    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO stray_reports (reporter_id, type, color, location, time, needs, image, status) 
                VALUES ('$reporter_id', '$type', '$color', '$location', '$time', '$needs', '$image', 'unverified')";
        if ($conn->query($sql) === TRUE) {
    // Redirect back to home.php with success parameter
         header('Location: index.php?report_success=true');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload image.<br>";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Stray</title>
    <link rel="stylesheet" href="report-design/styles.css">
</head>

<section class="report-stray">
    <h1>Report a Stray</h1>
    <form action="report_stray.php" method="post" enctype="multipart/form-data">
        <label for="type">Type of Animal:</label>
        <select name="type" id="type" required>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
            <option value="bird">Bird</option>
            <option value="reptile">Reptile</option>
            <option value="other">Other</option>
        </select>

        <label for="color">Color:</label>
        <input type="text" name="color" id="color" required>

        <label for="location">Location:</label>
        <input type="text" name="location" id="location" required>

        <label for="time">Time:</label>
        <input type="text" name="time" id="time" required>

        <label for="needs">Immediate Needs:</label>
        <textarea name="needs" id="needs" required></textarea>

        <label for="image">Upload Photo:</label>
        <input type="file" name="image" id="image" required>

        <button type="submit">Submit</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
