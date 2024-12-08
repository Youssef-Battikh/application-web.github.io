<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fitness_planner", 3306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>