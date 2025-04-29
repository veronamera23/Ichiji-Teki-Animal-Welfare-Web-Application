<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>
<link rel="stylesheet" href="reg-designed/styles.css">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful.";
        header('Location: login.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<hr class="top" id="top">

<section class="register">
    <h1>Register</h1>

    <div class="reg-container">
        <div class="regbanner">
            <img src="regpic1.png" alt="Registration Image">
        </div>
        
        <form action="register.php" method="post">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <br>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <br>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <br>
            <button type="submit">Register</button>
        </form>
    </div>
</section>

<hr class="bottom" id="bottom">

<?php include 'includes/footer.php'; ?>
