<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

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

<section class="animal-profiles">
    <h1 style="text-align: center; font-size: 36px;">Animal Profiles</h1>
    <form action="animal_profiles.php" method="get" style="display: flex; justify-content: center; align-items: center;">
        <input type="text" name="search" placeholder="Search..." value="<?php echo $search_query; ?>" style="width: 30%; margin-right: 10px; border-radius: 8px;">
        <select name="type" style="width: 30%; margin-right: 10px; border-radius: 8px;">
            <option value="">All Types</option>
            <option value="dog" <?php if ($type_filter == 'dog') echo 'selected'; ?>>Dog</option>
            <option value="cat" <?php if ($type_filter == 'cat') echo 'selected'; ?>>Cat</option>
            <option value="bird" <?php if ($type_filter == 'bird') echo 'selected'; ?>>Bird</option>
            <option value="reptile" <?php if ($type_filter == 'reptile') echo 'selected'; ?>>Reptile</option>
            <option value="other" <?php if ($type_filter == 'other') echo 'selected'; ?>>Other</option>
        </select>
        <select name="status" style="width: 30%; margin-right: 10px; border-radius: 8px;">
            <option value="">All Statuses</option>
            <option value="available" <?php if ($status_filter == 'available') echo 'selected'; ?>>Available</option>
            <option value="adopted" <?php if ($status_filter == 'adopted') echo 'selected'; ?>>Adopted</option>
            <option value="fostered" <?php if ($status_filter == 'fostered') echo 'selected'; ?>>Fostered</option>
        </select>
        <button type="submit" style="border-radius: 10px;">Search</button>
    </form>

    <div class="animal-cards-container" style="display: flex; justify-content: center;">
        <div class="animal-cards" style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: center;">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($animal = $result->fetch_assoc()): ?>
                    <div class="card" style="border: 3px solid #ccc; border-radius: 8px; padding: 16px; width: 300px; text-align: center;">
                        <div style="width: 100%; height: 200px; overflow: hidden;">
                            <img src="images/<?php echo $animal['image']; ?>" alt="<?php echo $animal['name']; ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                        </div>
                        <h3><?php echo $animal['name']; ?></h3>
                        <p>Type: <?php echo ucfirst($animal['type']); ?></p>
                        <p>Status: <?php echo ucfirst($animal['status']); ?></p>
                        <form action="animal_profile.php" method="get">
                            <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">
                            <button type="submit" style="margin-top: 10px; padding: 8px 16px; border: none; border-radius: 8px; background-color: #4CAF50; color: white; cursor: pointer;">View Profile</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No animals found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
