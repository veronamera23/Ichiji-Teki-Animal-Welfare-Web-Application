<?php 
    include 'includes/header.php';
    include 'includes/db_connect.php';

    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form submission
        $user_id = $_SESSION['user_id'];
        $animal_id = $_POST['animal_id'];
        $feeding_responsibility = $_POST['feeding_responsibility'];
        $allergic_household = $_POST['allergic_household'];
        $income_sources = implode(", ", $_POST['income_sources']);
        $house_picture = $_FILES['house_picture']['name'];
        $target = "images/" . basename($house_picture);

        if (move_uploaded_file($_FILES['house_picture']['tmp_name'], $target)) {
            // Insert adoption details into database
            $sql = "INSERT INTO adoptions (user_id, animal_id, feeding_responsibility, allergic_household, income_sources, house_picture, status) 
                    VALUES ('$user_id', '$animal_id', '$feeding_responsibility', '$allergic_household', '$income_sources', '$house_picture', 'pending')";
            if ($conn->query($sql) === TRUE) {
                // Redirect back to home.php after successful submission
                header('Location: index.php');
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to upload house picture.";
        }
    }

    // Retrieve animal details based on ID from GET parameter
    $animal_id = $_GET['id'];
    $sql = "SELECT * FROM animals WHERE id='$animal_id'";
    $result = $conn->query($sql);
    $animal = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt <?php echo $animal['name']; ?></title>
    <!-- Link to the CSS file -->
    <link rel="stylesheet" href="adoptform-designed/styles.css">
</head>

<body>
    <div class="container">
        <section class="adoption-form">
            <h1>Adopt <?php echo $animal['name']; ?></h1>
            <form action="adoption_form.php?id=<?php echo $animal['id']; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="animal_id" value="<?php echo $animal['id']; ?>">
                <div>
                    <label for="feeding_responsibility">Who will be responsible for feeding, grooming, and generally caring for your pet?</label>
                    <input type="text" name="feeding_responsibility" id="feeding_responsibility" required>
                </div>

                <div>
                    <label for="allergic_household">Are any members of your household allergic to animals?</label>
                    <p>YES</p>
                    <input type="radio" name="allergic_household" value="yes" required>
                    <p>NO</p>
                    <input type="radio" name="allergic_household" value="no" required>
                </div>
                <br>    
                <div>
                    <label>Sources of income:</label>
                    <p>SALARY</p>
                    <input type="checkbox" name="income_sources[]" value="salary">
                    <p>BUSINESS</p>
                    <input type="checkbox" name="income_sources[]" value="business">
                    <p>OTHERS</p>
                    <input type="checkbox" name="income_sources[]" value="others">
                </div>

                <div>
                    <label for="house_picture">Upload a picture of your house:</label>
                    <input type="file" name="house_picture" id="house_picture" required>
                </div>

                <button type="submit">Submit</button>
            </form>
        </section>
    </div>
</body>

</html>

<?php include 'includes/footer.php'; ?>
