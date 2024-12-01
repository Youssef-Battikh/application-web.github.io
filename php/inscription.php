<?php
// login session check
include 'config.php';
if (!empty($_SESSION["id"])) {
    header("location: ../routines.html");
}
// Form Check
if (isset($_POST["submit"])) {
    $name = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    if ($name == "" || $email == "" || $password == "") {
        $error = urlencode('Please fill up the form.');
    } else {
        // Duplicated username or email check
        $duplicate = $conn->prepare("SELECT * FROM users WHERE name = ? OR email = ?");
        $duplicate->bind_param("ss", $name, $email);
        $duplicate->execute();
        $result = $duplicate->get_result();

        if ($result->num_rows > 0) {
            $error = urlencode('Username or Email already taken.');
        } else {
            // Password hash
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Database insertion
            $query = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $query->bind_param("sss", $name, $email, $hashed_password);

            if ($query->execute()) {
                echo "<script>alert('Sign up successful! Please log in.');</script>";
                echo "<script>window.location.href = '../login.php';</script>";
            } else {
                $error = urlencode('Something went wrong. Please try again later.');
            }
        }
        $duplicate->close();
        if (isset($query)) {
            $query->close();
        }
    }
}
$conn->close();
if (!$error == '') {
    header('Location: ../signup.php?error=' . $error);
}
?>