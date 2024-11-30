<?php
// login session check
include 'config.php';
if (!empty($_SESSION["id"])) {
    header("location: ../routines.html");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = urlencode('Invalid email format.');
    } else {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["name"];
                header("Location: ../routines.php");
                exit();
            } else {
                $error = urlencode('Invalid password.');
            }
        } else {
            $error = urlencode('No user found with this email.');
        }
        $stmt->close();
    }
}

$conn->close();
header('Location: ../login.php?error=' . $error);
?>