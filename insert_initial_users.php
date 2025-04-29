<?php
include 'includes/db_connect.php';

// Insert initial users
$users = [
    ['username' => 'Yvonne', 'email' => 'yvonne@gmail.com', 'password' => 'yvonne', 'role' => 'admin'],
    ['username' => 'Christine', 'email' => 'christine@gmail.com', 'password' => 'christine', 'role' => 'volunteer'],
    ['username' => 'Adrian', 'email' => 'adrian@gmail.com', 'password' => 'adrian', 'role' => 'user']
];

foreach ($users as $user) {
    $username = $user['username'];
    $email = $user['email'];
    $password = password_hash($user['password'], PASSWORD_DEFAULT);
    $role = $user['role'];

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')
            ON DUPLICATE KEY UPDATE email=email";

    if ($conn->query($sql) === TRUE) {
        echo "User $username inserted successfully.<br>";
    } else {
        echo "Error inserting user $username: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
