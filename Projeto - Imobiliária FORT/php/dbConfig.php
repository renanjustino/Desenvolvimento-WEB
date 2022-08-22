<?php
// Database configuration
$dbHost     = "host";
$dbUsername = "user";
$dbPassword = "pass";
$dbName     = "dbname";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>