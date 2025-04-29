<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>
<link rel="stylesheet" href="animal_profiles-designed/styles.css">

<?php
$search_query = "";
$type_filter = "";
$status_filter = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['search'])) {
        $search_query = $_GET['search'];
    }
    if (isset($_GET['type'])) {
        $type_filter = $_GET['type'];
    }
    if (isset($_GET['status'])) {
        $status_filter = $_GET['status'];
    }
}

$sql = "SELECT * FROM animals WHERE 1=1 AND deleted_at IS NULL";

if (!empty($search_query)) {
    $sql .= " AND (name LIKE '%$search_query%' OR breed LIKE '%$search_query%' OR description LIKE '%$search_query%')";
}
if (!empty($type_filter)) {
    $sql .= " AND type='$type_filter'";
}
if (!empty($status_filter)) {
    $sql .= " AND status='$status_filter'";
}

$result = $conn->query($sql);
?>


<hr class="top" id="top">

<section class="animal-profiles">
    <h1>Animal Profiles</h1>
    <form action="animal_profiles.php" method="get" style="display: flex; justify-content: center; align-items: center;">
        <input class="search" type="text" name="search" placeholder="Search..." value="<?php echo $search_query; ?>" style="width: 30%; margin-right: 10px; border-radius: 8px;">
        <select class="type" name="type">
            <option value="">All Types</option>
            <option value="dog" <?php if ($type_filter == 'dog') echo 'selected'; ?>>Dog</option>
            <option value="cat" <?php if ($type_filter == 'cat') echo 'selected'; ?>>Cat</option>
            <option value="bird" <?php if ($type_filter == 'bird') echo 'selected'; ?>>Bird</option>
            <option value="reptile" <?php if ($type_filter == 'reptile') echo 'selected'; ?>>Reptile</option>
            <option value="other" <?php if ($type_filter == 'other') echo 'selected'; ?>>Other</option>
        </select>
        <select class="status" name="status">
            <option value="">All Statuses</option>
            <option value="available" <?php if ($status_filter == 'available') echo 'selected'; ?>>Available</option>
            <option value="adopted" <?php if ($status_filter == 'adopted') echo 'selected'; ?>>Adopted</option>
            <option value="fostered" <?php if ($status_filter == 'fostered') echo 'selected'; ?>>Fostered</option>
        </select>
        <button class="searchbutton" type="submit">Search</button>
    </form>

    <div class="animal-cards-container">
        <div class="animal-cards">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($animal = $result->fetch_assoc()): ?>
                    <div class="card">
                        

                        <div class="img-container">
                            <img src="images/<?php echo $animal['image']; ?>" alt="<?php echo $animal['name']; ?>">
                        </div>
                        

                        <div class="card-content">
                            <h3><?php echo $animal['name']; ?></h3>
                            <p>Type: <?php echo ucfirst($animal['type']); ?></p>
                            <p>Status: <?php echo ucfirst($animal['status']); ?></p>
                            <form action="animal_profile.php" method="get">
                                <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">
                                <button type="submit">View Profile</button>
                            </form>
                        </div>


                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No animals found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

