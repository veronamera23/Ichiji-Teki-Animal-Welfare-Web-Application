<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption</title>
    <link rel="stylesheet" href="adoption-design/styles.css">
</head>
<body>
<section class="adoption">
    <h1>Adoption</h1>

    <h2>Recently Available Animals for Adoption</h2>
    <div class="animal-cards">
        <?php
        $sql = "SELECT * FROM animals WHERE status='available' AND deleted_at IS NULL ORDER BY created_at DESC LIMIT 3";
        $result = $conn->query($sql);
        if ($result->num_rows > 0): ?>
            <?php while ($animal = $result->fetch_assoc()): ?>
                <div class="card">
                    <img src="images/<?php echo $animal['image']; ?>" alt="<?php echo $animal['name']; ?>">
                    <h3><?php echo $animal['name']; ?></h3>
                    <p>Type: <?php echo ucfirst($animal['type']); ?></p>
                    <p>Status: <?php echo ucfirst($animal['status']); ?></p>
                    <a href="animal_profile.php?id=<?php echo $animal['id']; ?>">View Profile</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No animals available for adoption.</p>
        <?php endif; ?>
    </div>
    <a href="animal_profiles.php" class="profile-button">Check All Animal Profiles</a>

    <h2>Adoption FAQs</h2>
    <div class="faqs">
        <h3>What is the adoption process?</h3>
        <p>The adoption process involves submitting an application, meeting with the animal, and a home visit. Once approved, you can take your new pet home.</p>
        
        <h3>How long does the adoption process take?</h3>
        <p>The process usually takes about 1-2 weeks, depending on the number of applications and the specifics of the animal you are adopting.</p>
        
        <h3>What are the adoption fees?</h3>
        <p>Adoption fees vary based on the type of animal and its age. Typically, the fees range from $50 to $150.</p>
        
        <h3>What does the adoption fee include?</h3>
        <p>The adoption fee includes vaccinations, spaying/neutering, and a health checkup.</p>
    </div>
    <br>
    <h2>Fosterage FAQs</h2>
    <div class="faqs">
        <h3>What is fosterage?</h3>
        <p>Fosterage is a temporary arrangement where you provide a home for an animal until it is adopted.</p>
        
        <h3>How long do foster animals stay in a home?</h3>
        <p>The duration can vary from a few weeks to several months, depending on the animal's needs and the availability of permanent homes.</p>
        
        <h3>What are the responsibilities of a foster parent?</h3>
        <p>Foster parents provide daily care, food, and socialization for the animal. They also may need to take the animal to vet appointments.</p>
        
        <h3>Are there any costs involved in fostering?</h3>
        <p>The organization typically covers the costs of food and medical care, although donations are always appreciated.</p>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>
