<?php

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isVolunteer() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'volunteer';
}

?>
