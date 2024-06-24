<?php
// Sample PHP code with security bugs

// SQL Injection Vulnerability
function getUserData($userId) {
    $conn = new mysqli("localhost", "username", "password", "database");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE id = " . $userId;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"] . " - Name: " . $row["name"] . "<br>";
        }
    } else {
        echo "0 results";
    }

    $conn->close();
}

// XSS Vulnerability
function displayUserInput($input) {
    echo "User input: " . $input;
}

// Command Injection Vulnerability
function executeCommand($cmd) {
    system("ls " . $cmd);
}

// Unrestricted File Upload
function uploadFile($file) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    move_uploaded_file($file["tmp_name"], $target_file);
    echo "File uploaded: " . $target_file;
}

// Calling the functions
getUserData($_GET['user_id']);
displayUserInput($_GET['input']);
executeCommand($_GET['cmd']);
if ($_FILES) {
    uploadFile($_FILES['file']);
}
?>
