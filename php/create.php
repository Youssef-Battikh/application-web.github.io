<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/index.php");
    exit();
}
$muscle_groups = ["trapz", "shoulders", "chest", "abs", "back", "biceps", "triceps", "forearms", "quadraceps", "calves", "hamstring"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $routine_name = $_POST['routine_name'];
    $routine_description = $_POST['routine_description'];
    $user_id = $_SESSION['user_id'];
    // routine table insertion
    $sql = "INSERT INTO routine (name, description, id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $routine_name, $routine_description, $user_id);
    $stmt->execute();
    $routine_nbr = $stmt->insert_id;
    $stmt->close();
    // exercise table insertion by day
    if (isset($_POST['exercises'])) {
        $day = 1;
        foreach ($_POST['exercises'] as $day_exercises) {
            if (isset($day_exercises['rest_day']) && $day_exercises['rest_day'] == 'on') {
                // reset day insertion
                $sql = "INSERT INTO routine_exercises (routine_nbr, day, exercise_name, sets) VALUES (?, ?, 'rest', 0)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $routine_nbr, $day);
                $stmt->execute();
                $stmt->close();
            } else if (!empty($day_exercises['muscle']) && !empty($day_exercises['exercise'])) {
                for ($i = 0; $i < count($day_exercises['muscle']); $i++) {
                    $muscle = $day_exercises['muscle'][$i];
                    $exercise = $day_exercises['exercise'][$i];
                    $sets = $day_exercises['sets'][$i];
                    if (!empty($exercise)) {
                        $sql = "INSERT INTO routine_exercises (routine_nbr, day, exercise_name, sets) VALUES (?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("iisi", $routine_nbr, $day, $exercise, $sets);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            } else {
                // empty day insertion
                $sql = "INSERT INTO routine_exercises (routine_nbr, day, exercise_name, sets) VALUES (?, ?, 'empty', 0)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $routine_nbr, $day);
                $stmt->execute();
                $stmt->close();
            }
            $day++;
        }
    }
    header("Location: ../pages/view_routine.php?routine_nbr=" . $routine_nbr);
    exit();
}
?>