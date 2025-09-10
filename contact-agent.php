<?php
session_start();

// check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // agar login nahi hai to login page bhejo (redirect ke sath)
    header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

// agar login hai to sidha agent1.html pe bhej do
header("Location: agent1.html");
exit;
