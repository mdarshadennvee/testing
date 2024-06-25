<!DOCTYPE html>
<html>
<head>
    <title>XSS Vulnerability Test</title>
</head>
<body>
    <h1>XSS Vulnerability Test</h1>
    <form method="GET" action="">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name">
        <input type="submit" value="Submit">
    </form>
    <?php
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        // This line contains an XSS vulnerability
        echo "<p>Hello, " . $name . "!</p>";
    }
    ?>
</body>
</html>
