<?php
// 1. Connect to the database
$host = 'localhost';
$username = 'root'; // default XAMPP user
$password = '';     // default XAMPP password is empty
$dbname = 'easybuy'; // your database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Receive form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // 3. Validate input
    if (empty($fullName) || empty($email) || empty($password)) {
        echo "Please fill all fields.";
        exit();
    }

    // 4. Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 5. Insert into database
    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fullName, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Account created successfully! You can now <a href='login.html'>log in</a>.";
    } else {
        // Error for duplicate email or other issues
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
