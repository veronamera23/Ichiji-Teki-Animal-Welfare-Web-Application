<link rel="stylesheet" href="volunteer-designed/styles.css">

<?php
session_start();

include 'includes/db_connect.php';
include 'includes/functions.php';
include 'includes/header.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $reason = $_POST['reason'];
    $agree_to_time = $_POST['agree_to_time'];
    $skills = implode(', ', $_POST['skills']);

    $sql = "INSERT INTO volunteers (user_id, reason, agree_to_time, skills, status) 
            VALUES ('$user_id', '$reason', '$agree_to_time', '$skills', 'pending')";
    if ($conn->query($sql) === TRUE) {
        echo "Volunteer application submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<hr class="top" id="top">

<div class="volbanner">
        <img src="volunteer-designed/volpic3.jpg" alt="Volunteer Banner">
</div>

<section class="volunteer-application">
    <h1>Volunteer Application</h1>
    <form action="volunteer_application.php" method="post">
        <label for="reason">Why Volunteer? Short background in volunteerism:</label>
        <textarea name="reason" id="reason" required></textarea>

        <label for="agree_to_time">Agree to allot time for volunteer work?</label>
        <select name="agree_to_time" id="agree_to_time" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
            <br>
        </select>

        <label for="skills">Skills</label>
            <div class="skilloptions">
                <div class="skill-item">
                    <input type="checkbox" name="skills[]" id="communication" value="communication">
                    <label for="communication">Communication</label>
                </div>
                <div class="skill-item">
                    <input type="checkbox" name="skills[]" id="organization" value="organization">
                    <label for="organization">Organization</label>
                </div>
                <div class="skill-item">
                    <input type="checkbox" name="skills[]" id="teamwork" value="teamwork">
                    <label for="teamwork">Teamwork</label>
                </div>
            </div>
        </div>

        <button type="submit">Submit</button>
    </form>
</section>

<hr class="bottom" id="bottom">

<?php include 'includes/footer.php'; ?>
