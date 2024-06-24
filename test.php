<?php
// Example PHP file with security issues

// 1. SQL Injection Vulnerability
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "User: " . $row['username'] . "<br>";
        }
    }
}

// 2. Cross-Site Scripting (XSS) Vulnerability
if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    echo "User comment: " . $comment . "<br>";
}

// 3. Insecure File Upload
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    move_uploaded_file($file['tmp_name'], 'uploads/' . $file['name']);
    echo "File uploaded successfully.";
}

// 4. Hardcoded Credentials
$admin_password = 'admin123';

// 5. Insecure Direct Object Reference (IDOR)
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    if (file_exists('documents/' . $file)) {
        readfile('documents/' . $file);
    } else {
        echo "File not found.";
    }
}

// 6. Unrestricted File Inclusion
if (isset($_GET['page'])) {
    include($_GET['page'] . '.php');
}

?>
