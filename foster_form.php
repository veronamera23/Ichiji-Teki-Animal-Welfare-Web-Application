<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';
include 'includes/header.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$animal_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $animal_id = $_POST['animal_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $feeding_responsibility = $_POST['feeding_responsibility'];
    $allergic_household = $_POST['allergic_household'];
    $income_sources = implode(', ', $_POST['income_sources']);
    $house_picture = $_FILES['house_picture']['name'];
    $target = "images/" . basename($house_picture);

    if (move_uploaded_file($_FILES['house_picture']['tmp_name'], $target)) {
        $sql = "INSERT INTO fosters (user_id, animal_id, start_date, end_date, feeding_responsibility, allergic_household, income_sources, house_picture, status) 
                VALUES ('$user_id', '$animal_id', '$start_date', '$end_date', '$feeding_responsibility', '$allergic_household', '$income_sources', '$house_picture', 'pending')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Foster application submitted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload house picture.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foster a Pet</title>
    <link rel="stylesheet" href="foster-design/styles.css">
</head>
<body>

<header>
    <!-- Your header content goes here -->
</header>

<section class="foster-form">
    <h1>Foster a Pet</h1>
    <form action="foster_form.php" method="post" enctype="multipart/form-data">
        <?php if (empty($animal_id)): ?>
            <label for="animal_id">Animal to Foster:</label>
            <select name="animal_id" id="animal_id" required>
                <option value="">Select an animal</option>
                <?php
                $sql = "SELECT id, name FROM animals WHERE deleted_at IS NULL AND status='available'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($animal = $result->fetch_assoc()) {
                        echo "<option value='" . $animal['id'] . "'>" . $animal['name'] . "</option>";
                    }
                }
                ?>
            </select>
        <?php else: ?>
            <input type="hidden" name="animal_id" value="<?php echo $animal_id; ?>">
            <p>Fostering: <?php
                $sql = "SELECT name FROM animals WHERE id='$animal_id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $animal = $result->fetch_assoc();
                    echo htmlspecialchars($animal['name']);
                } else {
                    echo "Unknown";
                }
            ?></p>
        <?php endif; ?>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required>

        <label for="feeding_responsibility">Who is responsible for feeding?</label>
        <input type="text" name="feeding_responsibility" id="feeding_responsibility" required>

        <label for="allergic_household">Are any members of your household allergic to animals?</label>
        <input type="radio" name="allergic_household" id="allergic_household_yes" value="yes" required>
        <label for="allergic_household_yes">Yes</label>
        <input type="radio" name="allergic_household" id="allergic_household_no" value="no" required>
        <label for="allergic_household_no">No</label>

        <label for="income_sources">Sources of Income:</label>
        <input type="checkbox" name="income_sources[]" value="Salary" id="income_salary">
        <label for="income_salary">Salary</label>
        <input type="checkbox" name="income_sources[]" value="Business" id="income_business">
        <label for="income_business">Business</label>
        <input type="checkbox" name="income_sources[]" value="Other" id="income_other">
        <label for="income_other">Other</label>

        <label for="house_picture">Upload House Picture:</label>
        <input type="file" name="house_picture" id="house_picture" required>

        <button type="submit">Submit</button>
    </form>
</section>

<footer>
    <!-- Your footer content goes here -->
</footer>

</body>
</html>
