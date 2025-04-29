<!-- <?php
include 'includes/db_connect.php';
include 'includes/functions.php';

session_start();
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $partnership_type = $_POST['partnership_type'];
    $details = $_POST['details'];

    $sql = "INSERT INTO partnerships (user_id, partnership_type, details, status) 
            VALUES ('$user_id', '$partnership_type', '$details', 'pending')";
    if ($conn->query($sql) === TRUE) {
        echo "Partnership request submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<section class="partnership-form">
    <h1>Partnership Application</h1>
    <form action="partnership_form.php" method="post" enctype="multipart/form-data">
        <label for="partnership_type">Type of Partnership:</label>
        <select name="partnership_type" id="partnership_type" required>
            <option value="event">Event</option>
            <option value="promotional">Promotional</option>
            <option value="other">Other</option>
        </select>

        <div id="event_details" style="display: none;">
            <label for="event_type">Type of Event:</label>
            <input type="radio" name="event_type" value="fundraising" required> Fundraising
            <input type="radio" name="event_type" value="volunteer_recruitment" required> Volunteer Recruitment
            <input type="radio" name="event_type" value="other" required> Other

            <label for="event_date">Initial Planned Date of Event:</label>
            <input type="date" name="event_date" id="event_date" required>

            <label for="event_location">Initial Planned Location:</label>
            <input type="text" name="event_location" id="event_location" required>

            <label for="event_discussion_time">Available Time for Event Discussion:</label>
            <input type="time" name="event_discussion_time" id="event_discussion_time" required>

            <label for="event_proposal">Upload Event Proposal:</label>
            <input type="file" name="event_proposal" id="event_proposal" required>
        </div>

        <div id="promotional_details" style="display: none;">
            <label for="promotional_activities">Type of Promotional Activities:</label>
            <input type="checkbox" name="promotional_activities[]" value="social_media"> Social Media
            <input type="checkbox" name="promotional_activities[]" value="press_ad"> Press Ad
            <input type="checkbox" name="promotional_activities[]" value="email_marketing"> Email Marketing

            <label for="promo_discussion_time">Available Time for Promotional Discussion:</label>
            <input type="time" name="promo_discussion_time" id="promo_discussion_time" required>

            <label for="promotional_proposal">Upload Promotional Proposal:</label>
            <input type="file" name="promotional_proposal" id="promotional_proposal" required>
        </div>

        <div id="other_details" style="display: none;">
            <label for="partnership_proposal">Upload Partnership Proposal:</label>
            <input type="file" name="partnership_proposal" id="partnership_proposal" required>
        </div>

        <label for="details">Details:</label>
        <textarea name="details" id="details" required></textarea>

        <button type="submit">Submit</button>
    </form>
</section>

<script>
document.getElementById('partnership_type').addEventListener('change', function() {
    document.getElementById('event_details').style.display = 'none';
    document.getElementById('promotional_details').style.display = 'none';
    document.getElementById('other_details').style.display = 'none';

    if (this.value === 'event') {
        document.getElementById('event_details').style.display = 'block';
    } else if (this.value === 'promotional') {
        document.getElementById('promotional_details').style.display = 'block';
    } else if (this.value === 'other') {
        document.getElementById('other_details').style.display = 'block';
    }
});
</script>

<?php include 'includes/footer.php'; ?> -->
