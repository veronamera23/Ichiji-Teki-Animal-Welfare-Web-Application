<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<?php
$animal_id = $_GET['id'];

// Fetch animal details
$sql = "SELECT * FROM animals WHERE id='$animal_id'";
$result = $conn->query($sql);
$animal = $result->fetch_assoc();

// Fetch adoption details
$adoption_sql = "SELECT a.*, u.username FROM adoptions a JOIN users u ON a.user_id = u.id WHERE a.animal_id='$animal_id' AND a.status='approved'";
$adoption_result = $conn->query($adoption_sql);
$adopted_by = ($adoption_result->num_rows > 0) ? $adoption_result->fetch_assoc() : null;

// Fetch foster details
$foster_sql = "SELECT f.*, u.username FROM fosters f JOIN users u ON f.user_id = u.id WHERE f.animal_id='$animal_id' AND f.status='approved'";
$foster_result = $conn->query($foster_sql);
$fostered_by = ($foster_result->num_rows > 0) ? $foster_result->fetch_assoc() : null;

// Fetch sponsorship details
$sponsorship_sql = "SELECT s.*, u.username FROM sponsorships s JOIN users u ON s.user_id = u.id WHERE s.animal_id='$animal_id' AND s.status='approved'";
$sponsorship_result = $conn->query($sponsorship_sql);
$sponsored_by = [];
while ($sponsorship = $sponsorship_result->fetch_assoc()) {
    $sponsored_by[] = [
        'username' => $sponsorship['username'],
        'entity_type' => $sponsorship['entity_type'],
        'sponsorship_type' => $sponsorship['sponsorship_type'],
        'details' => $sponsorship['details']
    ];
}
?>

<section class="animal-profile" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
    <div class="profile-header">
        <h1><?php echo htmlspecialchars($animal['name']); ?></h1>
        <img src="images/<?php echo htmlspecialchars($animal['image']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" style="border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 400px; height: auto;">
    </div>
    <div class="profile-details" style="border: 1px solid #ccc; border-radius: 4px; padding: 20px; margin-top: 20px; text-align: left;">
        <p><strong>Type:</strong> <?php echo ucfirst($animal['type']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($animal['age']); ?></p>
        <p><strong>Breed:</strong> <?php echo htmlspecialchars($animal['breed']); ?></p>
        <p><strong>Health Status:</strong> <?php echo htmlspecialchars($animal['health_status']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($animal['description']); ?></p>
        <p><strong>Status:</strong> <?php echo ucfirst($animal['status']); ?></p>

        <?php if ($adopted_by): ?>
            <p><strong>Adopted by:</strong> <?php echo htmlspecialchars($adopted_by['username']); ?> on <?php echo htmlspecialchars($adopted_by['approved_at']); ?></p>
        <?php endif; ?>

        <?php if ($fostered_by): ?>
            <p><strong>Fostered by:</strong> <?php echo htmlspecialchars($fostered_by['username']); ?> from <?php echo htmlspecialchars($fostered_by['start_date']); ?> to <?php echo htmlspecialchars($fostered_by['end_date']); ?></p>
        <?php endif; ?>

        <?php if (!empty($sponsored_by)): ?>
            <p><strong>Sponsored by:</strong></p>
            <ul>
                <?php foreach ($sponsored_by as $sponsor): ?>
                    <li>
                        <?php echo htmlspecialchars($sponsor['username']); ?> 
                        (<?php echo htmlspecialchars($sponsor['entity_type']); ?>, 
                        <?php echo htmlspecialchars($sponsor['sponsorship_type']); ?>): 
                        <?php echo htmlspecialchars($sponsor['details']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="profile-actions" style="margin-top: 20px;">
        <?php if ($animal['status'] == 'available'): ?>
            <button onclick="location.href='adoption_form.php?id=<?php echo $animal['id']; ?>'" class="btn btn-primary">Adopt</button>
            <button onclick="location.href='foster_form.php?id=<?php echo $animal['id']; ?>'" class="btn btn-primary">Foster</button>
            <button onclick="location.href='sponsor_form.php?animal_id=<?php echo $animal['id']; ?>'" class="btn btn-primary">Sponsor</button>
        <?php elseif ($animal['status'] == 'fostered'): ?>
            <button onclick="location.href='sponsor_form.php?animal_id=<?php echo $animal['id']; ?>'" class="btn btn-primary">Sponsor</button>
        <?php elseif ($animal['status'] == 'sponsored'): ?>
            <button onclick="location.href='adoption_form.php?id=<?php echo $animal['id']; ?>'" class="btn btn-primary">Adopt</button>
            <button onclick="location.href='foster_form.php?id=<?php echo $animal['id']; ?>'" class="btn btn-primary">Foster</button>
            <button onclick="location.href='sponsor_form.php?animal_id=<?php echo $animal['id']; ?>'" class="btn btn-primary">Sponsor</button>
        <?php endif; ?>
        <button onclick="location.href='animal_profiles.php'" class="btn btn-secondary">Back to Profiles</button>
    </div>
</section>


<style>
    .btn {
        border-radius: 6px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn:hover {
        background-color: #4CAF50;
        color: white;
    }
</style>

<?php include 'includes/footer.php'; ?>
