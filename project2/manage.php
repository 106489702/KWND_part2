<?php include 'header.inc'; ?> 

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
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
                    <label for="jobRef">Job Reference</label>
                    <input type="text" id="jobRef" name="jobRef">
                </div>
                <div class="formRow">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName">
                </div>
                <div class="formRow">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName">
                </div>
                <div class="formRow">
                    <label for="sortField">Sort Results By</label>
                    <select id="sortField" name="sortField">
                        <option value="">Please Select</option>
                        <option value="EOInumber">EOI Number</option>
                        <option value="jobRefNumber">Job Reference</option>
                        <option value="firstName">First Name</option>
                        <option value="lastName">Last Name</option>
                        <option value="status">Status</option>
                    </select>
                </div>
                <div class="formButtons fullWidth">
                    <input type="submit" value="Search EOIs">
                </div>
            </div>
        </form>
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
                    <input type="submit" value="Delete EOIs">
                </div>
            </div>
        </form>
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
                    <input type="submit" value="Update Status">
                </div>
            </div>
        </form>
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
            <tr>
                <td>1</td>
                <td>ABC01</td>
                <td>John</td>
                <td>Smith</td>
                <td>New</td>
            </tr>
            <tr>
                <td>2</td>
                <td>DEF02</td>
                <td>Sarah</td>
                <td>Lee</td>
                <td>Current</td>
            </tr>
            <tr>
                <td>3</td>
                <td>ABC01</td>
                <td>Tom</td>
                <td>Brown</td>
                <td>Final</td>
            </tr>
        </table>
    </section>

    <p><a href="logout.php">Logout</a></p>

</main>

<?php include 'footer.inc'; ?>