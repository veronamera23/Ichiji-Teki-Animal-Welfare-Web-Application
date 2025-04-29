<?php include 'includes/admin_header.php'; ?>

<style>
    .dashboard {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .dashboard h1 {
        text-align: center;
        font-size: 2.5em;
        margin-bottom: 20px;
        color: #333;
    }

    .cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .card {
        flex: 1 1 calc(33.333% - 40px);
        background: #e0e0e0; /* Darker background */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }

    .card a {
        display: block;
        padding: 20px;
        font-size: 1.5em; /* Larger font size */
        color: #000; /* Black text color */
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        background: #cccccc; /* Slightly darker on hover */
    }

    .card a:hover {
        color: #0056b3; /* Different hover color for text */
    }

    @media (max-width: 768px) {
        .card {
            flex: 1 1 calc(50% - 20px);
        }
    }

    @media (max-width: 480px) {
        .card {
            flex: 1 1 100%;
        }
    }
</style>

<section class="dashboard">
    <h1>Admin Dashboard</h1>
    <div class="cards">
        <div class="card">
            <a href="add_animal.php">Add Animal</a>
        </div>
        <div class="card">
            <a href="update_animal.php">Update Animal</a>
        </div>
        <div class="card">
            <a href="delete_animal.php">Delete Animal</a>
        </div>
        <div class="card">
            <a href="verify_stray.php">Verify Stray Reports</a>
        </div>
        <div class="card">
            <a href="approve_volunteers.php">Approve Volunteers</a>
        </div>
        <div class="card">
            <a href="approve_sponsorships.php">Approve Sponsorships</a>
        </div>
        <div class="card">
            <a href="approve_donations.php">Approve Donations</a>
        </div>
        <!-- <div class="card">
            <a href="approve_partnerships.php">Approve Partnerships</a>
        </div> -->
        <div class="card">
            <a href="approve_foster.php">Approve Foster Applications</a>
        </div>
        <div class="card">
            <a href="approve_adoptions.php">Approve Adoption Applications</a>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
