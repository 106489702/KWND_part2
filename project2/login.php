<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("settings.php");
$conn = mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT username, password FROM kwnd_db.users WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION["admin"] = $username;
        header("Location: manage.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'header.inc'; ?>

<main>
    <h1>Admin Login</h1>

    <form method="post" action="login.php">
        <p>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </p>

        <p>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </p>

        <p>
            <input type="submit" value="Login">
        </p>
    </form>

    <p><?php echo $error; ?></p>
</main>

<?php include 'footer.inc'; ?>

</body>
</html>
