<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goal = $_POST['goal'];
    $userId = $_SESSION['user_id'];

    // Insert goal into database
    $stmt = $conn->prepare("INSERT INTO goals (user_id, goal) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $goal);

    if ($stmt->execute()) {
        echo "Goal set successfully!";
    } else {
        echo "Error setting goal!";
    }
}
?>

<form method="POST">
    Goal: <input type="text" name="goal" required><br>
    <button type="submit">Set Goal</button>
</form>
