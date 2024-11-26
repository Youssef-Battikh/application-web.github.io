<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user goals
$stmt = $conn->prepare("SELECT * FROM goals WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$goals = $stmt->get_result();
?>

<h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>

<h2>Your Fitness Goals</h2>
<?php while ($goal = $goals->fetch_assoc()) { ?>
    <p>Goal: <?php echo $goal['goal']; ?></p>
    <p>Progress: <?php echo $goal['progress']; ?>%</p>
<?php } ?>

<a href="set_goal.php">Set New Goal</a>
<a href="update_progress.php">Update Progress</a>
