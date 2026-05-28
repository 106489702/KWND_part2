
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'header.inc'; ?>
<?php include 'nav.inc'; ?>


<main>
    <h1>HR Manager Page</h1>

    <p>You are successfully logged in as admin.</p>

    <p>This page is protected. Only logged-in users can access it.</p>

    <p><a href="logout.php">Logout</a></p>
</main>

<?php include 'footer.inc'; ?>

</body>
</html>
