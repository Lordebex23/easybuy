<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "easybuy");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT id, full_name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session and redirect
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with this email.";
    }

    $stmt->close();
}

$conn->close();
?>
