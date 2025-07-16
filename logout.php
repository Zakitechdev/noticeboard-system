<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Prevent browser caching after logout (optional but recommended)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page
header("Location: login.php");
exit();
