<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header('Location: admin/index.php');
            } elseif ($user['role'] == 'volunteer') {
                header('Location: volunteer/index.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="login-design/styles.css"
</head>
<body>
    <div class="content">
        <hr class="top">
        <section class="login">
            <h1>Login</h1>
            <div class="login-container">
                <form action="login.php" method="post">
                    <label for="email">EMAIL</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                    <label for="password">PASSWORD</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <button type="submit">Login</button>
                    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
                </form>
            </div>
        </section>
    </div>
    <footer>
        <?php include 'includes/footer.php'; ?>
    </footer>

</body>
</html>