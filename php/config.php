<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "fitness_planner",3306);

// Debug connection issues
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>