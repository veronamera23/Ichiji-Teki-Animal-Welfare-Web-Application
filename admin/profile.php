<?php include 'includes/admin_header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<?php


$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$stray_reports_sql = "SELECT * FROM stray_reports WHERE reporter_id='$user_id'";
$stray_reports = $conn->query($stray_reports_sql);

$adoptions_sql = "SELECT * FROM adoptions WHERE user_id='$user_id'";
$adoptions = $conn->query($adoptions_sql);
?>
<title>Profile</title>
<style>
    /* Global Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Profile Page Styles */
.profile {
    text-align: center;
    margin-top: 50px;
}

.profile h1 {
    font-size: 2em;
    margin-bottom: 20px;
    color: #333;
}

.profile p {
    margin-bottom: 10px;
    color: #666;
}

.profile h2 {
    font-size: 1.5em;
    margin-top: 30px;
    margin-bottom: 10px;
    color: #333;
}

.profile ul {
    list-style: none;
    padding: 0;
}

.profile ul li {
    margin-bottom: 5px;
}

.profile ul li:before {
    content: "•";
    margin-right: 5px;
    color: #666;
}

/* Footer Styles */
.footer {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    margin-top: 50px;
    border-radius: 10px;
}


</style>
<section class="profile">
    <h1><?php echo $user['username']; ?>'s Profile</h1>
    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
    <p><strong>Role:</strong> <?php echo ucfirst($user['role']); ?></p>

    <?php if ($user['role'] === 'user'): ?>
        <h2>Strays Reported</h2>
        <ul>
            <?php while ($report = $stray_reports->fetch_assoc()): ?>
                <li><?php echo $report['type']; ?> - <?php echo $report['status']; ?></li>
            <?php endwhile; ?>
        </ul>

        <h2>Animals Adopted</h2>
        <ul>
            <?php while ($adoption = $adoptions->fetch_assoc()): ?>
                <li><?php
                    $animal_id = $adoption['animal_id'];
                    $animal_sql = "SELECT * FROM animals WHERE id='$animal_id'";
                    $animal_result = $conn->query($animal_sql);
                    $animal = $animal_result->fetch_assoc();
                    echo $animal['name'];
                ?> - <?php echo $adoption['status']; ?></li>
            <?php endwhile; ?>
        </ul>
    <?php elseif ($user['role'] === 'volunteer'): ?>
        <h2>Strays Verified</h2>
        <ul>
            <?php
            $verified_strays_sql = "SELECT * FROM stray_reports WHERE verified_by='$user_id'";
            $verified_strays = $conn->query($verified_strays_sql);
            while ($report = $verified_strays->fetch_assoc()): ?>
                <li><?php echo $report['type']; ?> - <?php echo $report['status']; ?></li>
            <?php endwhile; ?>
        </ul>

        <h2>Animals Managed</h2>
        <ul>
            <?php
            $managed_animals_sql = "SELECT * FROM animals WHERE created_by='$user_id' OR updated_by='$user_id' OR deleted_by='$user_id'";
            $managed_animals = $conn->query($managed_animals_sql);
            while ($animal = $managed_animals->fetch_assoc()): ?>
                <li><?php echo $animal['name']; ?> - <?php echo $animal['status']; ?></li>
            <?php endwhile; ?>
        </ul>
    <?php elseif ($user['role'] === 'admin'): ?>
        <h2>Strays Verified</h2>
        <ul>
            <?php
            $verified_strays_sql = "SELECT * FROM stray_reports WHERE verified_by='$user_id'";
            $verified_strays = $conn->query($verified_strays_sql);
            while ($report = $verified_strays->fetch_assoc()): ?>
                <li><?php echo $report['type']; ?> - <?php echo $report['status']; ?></li>
            <?php endwhile; ?>
        </ul>

        <h2>Animals Managed</h2>
        <ul>
            <?php
            $managed_animals_sql = "SELECT * FROM animals WHERE created_by='$user_id' OR updated_by='$user_id' OR deleted_by='$user_id'";
            $managed_animals = $conn->query($managed_animals_sql);
            while ($animal = $managed_animals->fetch_assoc()): ?>
                <li><?php echo $animal['name']; ?> - <?php echo $animal['status']; ?></li>
            <?php endwhile; ?>
        </ul>

        <h2>Volunteers Approved</h2>
        <ul>
            <?php
            $approved_volunteers_sql = "SELECT * FROM volunteers WHERE approved_by='$user_id'";
            $approved_volunteers = $conn->query($approved_volunteers_sql);
            while ($volunteer = $approved_volunteers->fetch_assoc()): ?>
                <li><?php
                    $volunteer_id = $volunteer['user_id'];
                    $volunteer_sql = "SELECT * FROM users WHERE id='$volunteer_id'";
                    $volunteer_result = $conn->query($volunteer_sql);
                    $volunteer_user = $volunteer_result->fetch_assoc();
                    echo $volunteer_user['username'];
                ?></li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
</section>