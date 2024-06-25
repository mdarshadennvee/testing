<?php
// Assume user input via a form
$username = $_POST['username'];
$password = $_POST['password'];

// Vulnerable SQL query construction
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // User authenticated successfully
        echo "Login successful!";
    } else {
        // No matching user found
        echo "Invalid username or password.";
    }
} else {
    // SQL query execution failed
    echo "Error: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>
