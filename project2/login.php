<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("settings.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $sql = "SELECT * FROM users
            WHERE username='$username'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $_SESSION["admin"] = $username;

        header("Location: manage.php");
        exit();

    } else {

        $error = "Invalid username or password";

    }
}
?>

<?php include 'header.inc'; ?>
<?php include 'nav.inc'; ?>

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
