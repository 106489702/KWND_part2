<?php
require_once("settings.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Opening job positions at KWND Creative">
    <meta name="keywords" content="Job positions, Front-End Web Developer, Designer">
    <meta name="author" content="KWND Creative">
    <title>Opening Job Positions at KWND Creative</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'header.inc'; ?>

<main>

<h1>Job Positions</h1>

<p>
    KWND Creative is looking for dedicated web developers and designers who are interested in working with creative digital media webpages.
</p>

<aside>
    <h2>Inclusive Employment Statement</h2>
    <p>
        KWND Creative welcomes applications from people of all backgrounds and encourages Aboriginal and Torres Strait Islander peoples to apply.
        We are committed to a respectful and diverse workplace.
    </p>
</aside>

<?php

$query = "SELECT * FROM jobs";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        echo "<section>";
        echo "<h2>" . htmlspecialchars($row['job_title']) . "</h2>";
        echo "<h3>Reference Number: " . htmlspecialchars($row['job_ref']) . "</h3>";

        echo "<p>" . htmlspecialchars($row['description']) . "</p>";

        echo "<p>";
        echo "<strong>Salary:</strong> " . htmlspecialchars($row['salary']) . "<br>";
        echo "<strong>Reporting line:</strong> " . htmlspecialchars($row['reporting_line']);
        echo "</p>";

        echo "<h3>Responsibilities</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['responsibilities'])) . "</p>";

        echo "<h3>Essential Requirements</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['essentials'])) . "</p>";

        echo "<h3>Preferable Requirements</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['preferables'])) . "</p>";

        echo "</section><hr>";
    }

} else {

    echo "<p>No jobs available.</p>";
}

mysqli_close($conn);

?>

</main>

<?php include 'footer.inc'; ?>

</body>
</html>