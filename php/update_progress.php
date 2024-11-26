<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $progress = $_POST['progress'];
    $userId = $_SESSION['user_id'];

    // Update progress in the database
    $stmt = $conn->prepare("UPDATE goals SET progress = ? WHERE user_id = ?");
    $stmt->bind_param("ii", $progress, $userId);

    if ($stmt->execute()) {
        echo "Progress updated successfully!";
    } else {
        echo "Error updating progress!";
    }
}
?>

<form method="POST">
    Progress: <input type="number" name="progress" min="0" max="100" required><br>
    <button type="submit">Update Progress</button>
</form>
