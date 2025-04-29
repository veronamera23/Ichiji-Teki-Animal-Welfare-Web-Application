
<?php
session_start();


require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
include 'includes/header.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $donation_type = $_POST['donation_type'];
    $details = $_POST['details'];

    $frequency = NULL;
    $payment_mode = NULL;
    $account_name = NULL;
    $account_number = NULL;
    $bank = NULL;
    $amount = NULL;
    $use = NULL;
    $wishlists = NULL;

    // Additional fields for monetary donations
    if ($donation_type == 'monetary') {
        $frequency = $_POST['frequency'];
        $payment_mode = $_POST['payment_mode'];
        $account_name = $_POST['account_name'];
        $account_number = $_POST['account_number'];
        $bank = $_POST['bank'];
        $amount = $_POST['amount'];
        $use = $_POST['use'];

        $sql = "INSERT INTO donations (user_id, donation_type, frequency, payment_mode, account_name, account_number, bank, amount, `use`, details, status) 
                VALUES ('$user_id', '$donation_type', '$frequency', '$payment_mode', '$account_name', '$account_number', '$bank', '$amount', '$use', '$details', 'pending')";
    } elseif ($donation_type == 'in-kind') {
        $wishlists = implode(', ', $_POST['wishlists']);

        $sql = "INSERT INTO donations (user_id, donation_type, wishlists, details, status) 
                VALUES ('$user_id', '$donation_type', '$wishlists', '$details', 'pending')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Donation request submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<title>Donation</title>
<link rel="stylesheet" href="donate-design/style.css">

<hr class="top" id="top">

<div class="volbanner">
        <img src="donate-design/donpic1.jpg" alt="Donation Banner">
</div>

<section class="donate">
    <h1>Make a Donation</h1>
    <form action="donate.php" method="post">
        <label for="donation_type">Kind of Donation:</label>
        <input type="radio" name="donation_type" value="monetary" id="donation_monetary" required> Money
        <input type="radio" name="donation_type" value="in-kind" id="donation_in_kind" required> In-kind

        <div class="monetary_fields" id="monetary_fields" style="display:none;">
            <label class= "frequency" for="frequency">Donation Frequency:</label>
            <select name="frequency" id="frequency">
                <option value="one-time">One-time</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
            </select>

            <label for="payment_mode">Mode of Payment:</label>
            <select name="payment_mode" id="payment_mode">
                <option value="cash">Cash</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>

            <label for="account_name">Account Name:</label>
            <input type="text" name="account_name" id="account_name">

            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" id="account_number">

            <label for="bank">Bank:</label>
            <input type="text" name="bank" id="bank">

            <label for="amount">Amount:</label>
            <input type="text" name="amount" id="amount">

            <label for="use">Where do you possibly want to see your contribution used?</label>
            <textarea name="use" id="use"></textarea>
        </div>

        <div id="in_kind_fields" style="display:none;">
            <label for="wishlists">Wishlists:</label>
            <input type="checkbox" name="wishlists[]" value="food"> Food
            <input type="checkbox" name="wishlists[]" value="shelter"> Shelter
            <input type="checkbox" name="wishlists[]" value="medical"> Medical
            <!-- Add more wishlists as needed -->
        </div>

        <label class="details" for="details">Additional Details:</label>
        <textarea name="details" id="details" ></textarea>

        <button type="submit">Submit</button>
        
    </form>
</section>

<hr class="bottom" id="bottom">

<script>
document.getElementById('donation_monetary').addEventListener('click', function() {
    document.getElementById('monetary_fields').style.display = 'block';
    document.getElementById('in_kind_fields').style.display = 'none';
});

document.getElementById('donation_in_kind').addEventListener('click', function() {
    document.getElementById('monetary_fields').style.display = 'none';
    document.getElementById('in_kind_fields').style.display = 'block';
});
</script>

<?php include 'includes/footer.php'; ?>




