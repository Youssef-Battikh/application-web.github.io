<?php
require_once '../php/config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $routine_nbr = intval($_POST['routine_nbr']);

    // Check if the user already liked this routine
    $check_stmt = $conn->prepare("SELECT * FROM liked_workouts WHERE liker_id = ? AND routine_nbr = ?");
    $check_stmt->bind_param("ii", $user_id, $routine_nbr);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Already liked — so unlike it
        $delete_stmt = $conn->prepare("DELETE FROM liked_workouts WHERE liker_id = ? AND routine_nbr = ?");
        $delete_stmt->bind_param("ii", $user_id, $routine_nbr);
        $delete_stmt->execute();
        $delete_stmt->close();

        echo json_encode(['success' => true, 'message' => 'Unliked', 'liked' => false]);
    } else {
        // Not yet liked — insert like
        $insert_stmt = $conn->prepare("INSERT INTO liked_workouts (liker_id, routine_nbr) VALUES (?, ?)");
        $insert_stmt->bind_param("ii", $user_id, $routine_nbr);
        $insert_stmt->execute();
        $insert_stmt->close();

        echo json_encode(['success' => true, 'message' => 'Liked', 'liked' => true]);
    }

    $check_stmt->close();
}
?>