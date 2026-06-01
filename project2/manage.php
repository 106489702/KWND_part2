
<?php include 'header.inc'; ?> 

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

require_once("settings.php");
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM eoi";
$result = (mysqli_query($conn, $query));
?>

<main>

    <div class="formIntro">
        <h1>HR Manager Page</h1>

        <p>You are successfully logged in as admin.</p>

        <p>This page is protected. Only logged-in users can access it.</p>
    </div>

    <section id="applicationForm">

    <h2>Search EOIs</h2>

        <form method="post" action="manage.php">

            <div class="formGrid">

                <div class="formRow">
                    <label for="searchType">Search By</label>

                    <select id="searchType" name="searchType">
                        <option value="jobRef">Job Reference</option>
                        <option value="firstName">First Name</option>
                        <option value="lastName">Last Name</option>
                        <option value="fullName">First + Last Name</option>
                    </select>
                </div>

                <div class="formRow">
                    <label for="jobRef">Job Reference</label>
                    <input type="text"
                        id="jobRef"
                        name="jobRef">
                </div>

                <div class="formRow">
                    <label for="firstName">First Name</label>
                    <input type="text"
                        id="firstName"
                        name="firstName">
                </div>

                <div class="formRow">
                    <label for="lastName">Last Name</label>
                    <input type="text"
                        id="lastName"
                        name="lastName">
                </div>

                <div class="formRow">
                    <label for="sortField">Sort Results By</label>

                    <select id="sortField" name="sortField">
                        <option value="">EOI Number</option>
                        <option value="JobRef">Job Reference</option>
                        <option value="FirstName">First Name</option>
                        <option value="LastName">Last Name</option>
                        <option value="Status">Status</option>
                    </select>
                </div>

                <div class="formButtons fullWidth">
                    <input type="submit"
                        name="search"
                        value="Search EOIs">
                </div>

            </div>

        </form>
    
        <?php 
            if (isset($_POST["search"])) {

            $searchType = $_POST["searchType"];

            switch ($searchType) {

                case "jobRef":

                    $jobRef = mysqli_real_escape_string(
                        $conn,
                        $_POST["jobRef"]
                    );

                    $query = "
                        SELECT *
                        FROM eoi
                        WHERE JobRef = '$jobRef'
                    ";

                    break;

                case "firstName":

                    $firstName = mysqli_real_escape_string(
                        $conn,
                        $_POST["firstName"]
                    );

                    $query = "
                        SELECT *
                        FROM eoi
                        WHERE FirstName = '$firstName'
                    ";

                    break;

                case "lastName":

                    $lastName = mysqli_real_escape_string(
                        $conn,
                        $_POST["lastName"]
                    );

                    $query = "
                        SELECT *
                        FROM eoi
                        WHERE LastName = '$lastName'
                    ";

                    break;

                case "fullName":

                    $firstName = mysqli_real_escape_string(
                        $conn,
                        $_POST["firstName"]
                    );

                    $lastName = mysqli_real_escape_string(
                        $conn,
                        $_POST["lastName"]
                    );

                    $query = "
                        SELECT *
                        FROM eoi
                        WHERE FirstName = '$firstName'
                        AND LastName = '$lastName'
                    ";

                    break;

                default:

                    $query = "SELECT * FROM eoi";
            }

            if (!empty($_POST["sortField"])) {

                $allowedSorts = array(
                    "JobRef",
                    "FirstName",
                    "LastName",
                    "Status"
                );

                $sortField = $_POST["sortField"];

                if (in_array($sortField, $allowedSorts)) {
                    $query .= " ORDER BY $sortField";
                }
            }

            $result = mysqli_query($conn, $query);
        }
        ?>
    </section>

    <section id="applicationForm">
        <h2>Delete EOIs by Job Reference</h2>
        <form method="post" action="manage.php">
            <div class="formGrid">
                <div class="formRow fullWidth">
                    <label for="deleteRef">Job Reference</label>
                    <input type="text"
                           id="deleteRef"
                           name="deleteRef"
                           placeholder="ABC01">
                </div>
                <div class="formButtons fullWidth">
                    <input type="submit" name="delete" value="Delete EOIs">
                </div>
            </div>
        </form>
        <?php 
        if (isset($_POST["delete"])) {

            $deleteRef = mysqli_real_escape_string(
                $conn,
                $_POST["deleteRef"]
            );

            $query = "
                DELETE FROM eoi
                WHERE JobRef = '$deleteRef'
            ";

            mysqli_query($conn, $query);

            // Refresh displayed results
            $query = "SELECT * FROM eoi";
            $result = mysqli_query($conn, $query);
        }
        ?>
    </section>

    <section id="applicationForm">
    <h2>Update EOI Status</h2>

        <form method="post" action="manage.php">
            <div class="formGrid">

                <div class="formRow">
                    <label for="eoiID">EOI Number</label>
                    <input type="number"
                        id="eoiID"
                        name="eoiID">
                </div>

                <div class="formRow">
                    <label for="status">New Status</label>
                    <select id="status" name="status">
                        <option value="New">New</option>
                        <option value="Current">Current</option>
                        <option value="Final">Final</option>
                    </select>
                </div>

                <div class="formButtons fullWidth">
                    <input type="submit"
                        name="updateStatus"
                        value="Update Status">
                </div>

            </div>
        </form>

        <?php
        if (isset($_POST["updateStatus"])) {

            $eoiID = mysqli_real_escape_string(
                $conn,
                $_POST["eoiID"]
            );

            $status = mysqli_real_escape_string(
                $conn,
                $_POST["status"]
            );

            $query = "
                UPDATE eoi
                SET Status = '$status'
                WHERE EOINumber = '$eoiID'
            ";

            mysqli_query($conn, $query);

            // Refresh displayed results
            $query = "SELECT * FROM eoi";
            $result = mysqli_query($conn, $query);
        }
        ?>
    </section>

    <section id="applicationForm">
        <h2>EOI Results</h2>
        <table class="hobbyTable" id="hobbyTable">
            <tr>
                <th>EOI Number</th>
                <th>Job Ref</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Status</th>
            </tr>

            <?php 
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row["EOINumber"]; ?></td>
                <td><?php echo $row["JobRef"]; ?></td>
                <td><?php echo $row["FirstName"]; ?></td>
                <td><?php echo $row["LastName"]; ?></td>
                <td><?php echo $row["Status"]; ?></td>
            </tr>
            <?php 
                }
            ?>
        </table>
    </section>

    <p><a href="logout.php">Logout</a></p>

</main>

<?php include 'footer.inc'; ?>