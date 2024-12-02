<?php
require_once 'php/config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['routine_nbr'])) {
    $routine_nbr = $_POST['routine_nbr'];
    $user_id = $_SESSION['user_id'];

    // First, check if the routine belongs to the logged-in user
    $check_sql = "SELECT id FROM routine WHERE nbr = ? AND id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $routine_nbr, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Routine not found or not owned by user']);
        exit();
    }

    // If the routine belongs to the user, proceed with deletion
    $conn->begin_transaction();

    try {
        // Delete related entries in routine_exercises
        $delete_exercises_sql = "DELETE FROM routine_exercises WHERE routine_nbr = ?";
        $delete_exercises_stmt = $conn->prepare($delete_exercises_sql);
        $delete_exercises_stmt->bind_param("i", $routine_nbr);
        $delete_exercises_stmt->execute();

        // Delete the routine
        $delete_routine_sql = "DELETE FROM routine WHERE nbr = ?";
        $delete_routine_stmt = $conn->prepare($delete_routine_sql);
        $delete_routine_stmt->bind_param("i", $routine_nbr);
        $delete_routine_stmt->execute();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error deleting routine']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>