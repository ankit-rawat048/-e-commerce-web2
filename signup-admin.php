<?php
if (isset($_POST['submit'])) {
    // DB connection
    $conn = new mysqli('localhost', 'u713383587_ashu', '5pC!|GVyU14B', 'u713383587_shriganga');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data and sanitize
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Encrypt password using password_hash()
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert query
    $sql = "INSERT INTO login (email, password) VALUES ('$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "New user registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <form method="POST" action="">
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit" name="submit">Register</button>
    </form>
</body>
</html>
