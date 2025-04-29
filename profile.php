<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<?php
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

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
<link rel="stylesheet" href="profile-design/styles.css">
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

<?php include 'includes/footer.php'; ?>
