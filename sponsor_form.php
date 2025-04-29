<?php
session_start();
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$animal_id = isset($_GET['animal_id']) ? $_GET['animal_id'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $animal_id = $_POST['animal_id'];
    $entity_type = $_POST['entity_type'];
    $sponsorship_type = $_POST['sponsorship_type'];
    $details = $_POST['details'];

    $sql = "INSERT INTO sponsorships (user_id, animal_id, entity_type, sponsorship_type, details, status) 
            VALUES ('$user_id', '$animal_id', '$entity_type', '$sponsorship_type', '$details', 'pending')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Sponsorship request submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<title>Sponsor</title>
<link rel="stylesheet" href="sponsor-design/styles.css">
<section class="sponsor-form">
    <h1>Sponsor a Pet</h1>
    <form action="sponsor_form.php" method="post">
        <?php if (empty($animal_id)): ?>
            <label for="animal_id">Animal to Sponsor:</label>
            <select name="animal_id" id="animal_id" required>
                <option value="">Select an animal</option>
                <?php
                $sql = "SELECT id, name FROM animals WHERE deleted_at IS NULL AND (status='available' OR status='fostered')";
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
            <p>Sponsoring: <?php
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

        <label for="entity_type">Sponsor as:</label>
        <select name="entity_type" id="entity_type" required>
            <option value="individual">Individual</option>
            <option value="organization">Organization</option>
            <option value="company">Company</option>
        </select>

        <label for="sponsorship_type">Type of Sponsorship:</label>
        <select name="sponsorship_type" id="sponsorship_type" required>
            <option value="financial">Financial</option>
            <option value="food">Food</option>
            <option value="health">Health</option>
            <option value="housing">Housing</option>
        </select>

        <label for="details">Details:</label>
        <textarea name="details" id="details" required></textarea>

        <button type="submit">Submit</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
