<?php
include 'config.php';
if (!empty($_SESSION["id"])) {
    header("location: ../pages/routines.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    if ($email == "" || $password == "") {
        $error = urlencode('Please fill up the form.');
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
                header("Location: ../pages/routines.php");
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
header('Location: ../pages/login.php?error=' . $error);
?>