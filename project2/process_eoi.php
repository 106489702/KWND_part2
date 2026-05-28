<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: apply.php");
    exit();
}
//the website can only be reached via POST form submit

if (!isset($_POST['jobRef'], $_POST['firstName'], $_POST['lastName'])) {
    header("Location: apply.php");
    exit();
}
//ensure POST exists -> prevents empty POST requests

function sanitise($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$jobRef       = sanitise($_POST['jobRef']);
$firstName    = sanitise($_POST['firstName']);
$lastName     = sanitise($_POST['lastName']);
$dob          = sanitise($_POST['dob']);         
$gender       = sanitise($_POST['gender'] ?? '');
$streetAddress = sanitise($_POST['streetAddress']);
$suburbTown   = sanitise($_POST['suburbTown']);
$state        = sanitise($_POST['state'] ?? '');
$postcode     = sanitise($_POST['postcode']);
$email        = sanitise($_POST['email']);
$phone        = sanitise($_POST['phone']);
$otherSkills  = sanitise($_POST['otherSkills'] ?? '');


$skills_raw   = $_POST['skills'] ?? [];
$skills_clean = array_map('sanitise', $skills_raw);

$errors = [];
//if the array contains anything, error messages appear and no input gets inserted

if (empty($jobRef)) {
    $errors[] = "Job Reference Number is required.";
} elseif (!preg_match('/^[A-Za-z0-9]{5}$/', $jobRef)) {
    $errors[] = "Job Reference must be exactly 5 alphanumeric characters (e.g. ABC01).";
}

// ── First Name ─────────────────────────────────────
// Required. Letters only. 1–20 characters.
if (empty($firstName)) {
    $errors[] = "First Name is required.";
} elseif (!preg_match('/^[A-Za-z]{1,20}$/', $firstName)) {
    $errors[] = "First Name must contain letters only (max 20 characters).";
}

// ── Last Name ──────────────────────────────────────
// Required. Letters only. 1–20 characters.
if (empty($lastName)) {
    $errors[] = "Last Name is required.";
} elseif (!preg_match('/^[A-Za-z]{1,20}$/', $lastName)) {
    $errors[] = "Last Name must contain letters only (max 20 characters).";
}

// ── Date of Birth ──────────────────────────────────
// Required. Format must be dd/mm/yyyy.
// Convert to Y-m-d for MySQL DATE column.
// Age must be between 15 and 80.
$dob_mysql = null; // Will hold the converted date for DB insert

if (empty($dob)) {
    $errors[] = "Date of Birth is required.";
} elseif (!preg_match('/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/[0-9]{4}$/', $dob)) {
    $errors[] = "Date of Birth must be in dd/mm/yyyy format.";
} else {
    // Convert dd/mm/yyyy → DateTime object for age calculation
    $dobDate = DateTime::createFromFormat('d/m/Y', $dob);
    if (!$dobDate) {
        $errors[] = "Date of Birth is not a valid date.";
    } else {
        $today = new DateTime();
        $age   = $today->diff($dobDate)->y;
        if ($age < 15 || $age > 80) {
            $errors[] = "Applicant must be between 15 and 80 years old.";
        }
        // Format for MySQL: Y-m-d
        $dob_mysql = $dobDate->format('Y-m-d');
    }
}

// ── Gender ─────────────────────────────────────────
// Required. Must match one of the three allowed values.
$allowed_genders = ['Male', 'Female', 'Other'];
if (empty($gender) || !in_array($gender, $allowed_genders)) {
    $errors[] = "Please select a gender.";
}

// ── Street Address ─────────────────────────────────
// Required. Max 40 characters.
if (empty($streetAddress)) {
    $errors[] = "Street Address is required.";
}

// ── Suburb/Town ────────────────────────────────────
// Required. Max 40 characters.
if (empty($suburbTown)) {
    $errors[] = "Suburb/Town is required.";
}

// ── State ──────────────────────────────────────────
// Required. Must be a valid Australian state abbreviation.
$allowed_states = ['VIC','NSW','QLD','SA','WA','TAS','ACT','NT'];
if (empty($state) || !in_array($state, $allowed_states)) {
    $errors[] = "Please select a valid State.";
}

// ── Postcode ───────────────────────────────────────
// Required. Exactly 4 digits.
// Must match the selected state's postcode range.
if (empty($postcode)) {
    $errors[] = "Postcode is required.";
} elseif (!preg_match('/^[0-9]{4}$/', $postcode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
} else {
    $pc = intval($postcode);
    $valid_postcode = false;
    switch ($state) {
        case 'VIC': $valid_postcode = ($pc >= 3000 && $pc <= 3999) || ($pc >= 8000 && $pc <= 8999); break;
        case 'NSW': $valid_postcode = ($pc >= 2000 && $pc <= 2999) || ($pc >= 1000 && $pc <= 1999); break;
        case 'QLD': $valid_postcode = ($pc >= 4000 && $pc <= 4999) || ($pc >= 9000 && $pc <= 9999); break;
        case 'SA':  $valid_postcode = ($pc >= 5000 && $pc <= 5999); break;
        case 'WA':  $valid_postcode = ($pc >= 6000 && $pc <= 6999); break;
        case 'TAS': $valid_postcode = ($pc >= 7000 && $pc <= 7999); break;
        case 'ACT': $valid_postcode = ($pc >= 2600 && $pc <= 2639); break;
        case 'NT':  $valid_postcode = ($pc >= 800  && $pc <= 999);  break;
    }
    if (!$valid_postcode) {
        $errors[] = "Postcode does not match the selected State.";
    }
}

// ── Email ──────────────────────────────────────────
// Required. Must pass PHP's built-in email format check.
if (empty($email)) {
    $errors[] = "Email address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

// ── Phone ──────────────────────────────────────────
// Required. 8–12 digits, no spaces (matches your Part 1 pattern).
if (empty($phone)) {
    $errors[] = "Phone Number is required.";
} elseif (!preg_match('/^[0-9]{8,12}$/', $phone)) {
    $errors[] = "Phone Number must be 8–12 digits (numbers only).";
}

// ── Skills ─────────────────────────────────────────
// At least one checkbox must be selected.
// Each value must be from the allowed list (prevents tampering).
$allowed_skills = ['HTML','CSS','JavaScript','Figma','Branding','Content Creation'];
if (empty($skills_clean)) {
    $errors[] = "Please select at least one skill.";
} else {
    foreach ($skills_clean as $skill) {
        if (!in_array($skill, $allowed_skills)) {
            $errors[] = "Invalid skill value submitted.";
            break;
        }
    }
}

// ── Other Skills ───────────────────────────────────
// Optional but cap at 300 characters
if (strlen($otherSkills) > 300) {
    $errors[] = "Other Skills must be under 300 characters.";
}

// ══════════════════════════════════════════════════════
// VALIDATION FAILED — show all errors, stop here
// ══════════════════════════════════════════════════════
if (!empty($errors)) {
    include 'header.inc';
    ?>
    <main>
      <h2>Please Fix the Following Errors</h2>
      <ul class="errorList">
        <?php foreach ($errors as $err): ?>
          <li><?php echo $err; ?></li>
        <?php endforeach; ?>
      </ul>
      <p><a href="apply.php">← Go back and fix your application</a></p>
    </main>
    <?php
    include 'footer.inc';
    exit();
}

// ══════════════════════════════════════════════════════
// ALL VALIDATION PASSED — connect to the database
// ══════════════════════════════════════════════════════
require_once 'settings.php';

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("ERROR: Could not connect to database. " . mysqli_connect_error());
}

// ══════════════════════════════════════════════════════
// CREATE EOI TABLE IF IT DOESN'T EXIST
// IF NOT EXISTS means this is safe to run every time
// ══════════════════════════════════════════════════════
$create_sql = "
CREATE TABLE IF NOT EXISTS `eoi` (
  `EOINumber`   INT(11)      NOT NULL AUTO_INCREMENT,
  `JobRef`      VARCHAR(5)   NOT NULL,
  `FirstName`   VARCHAR(20)  NOT NULL,
  `LastName`    VARCHAR(20)  NOT NULL,
  `DOB`         DATE         NOT NULL,
  `Gender`      ENUM('Male','Female','Other') NOT NULL,
  `Street`      VARCHAR(40)  NOT NULL,
  `SuburbTown`  VARCHAR(40)  NOT NULL,
  `State`       ENUM('VIC','NSW','QLD','SA','WA','TAS','ACT','NT') NOT NULL,
  `Postcode`    CHAR(4)      NOT NULL,
  `Email`       VARCHAR(60)  NOT NULL,
  `Phone`       VARCHAR(12)  NOT NULL,
  `Skills`      VARCHAR(300) NOT NULL,
  `OtherSkills` VARCHAR(300) DEFAULT NULL,
  `Status`      ENUM('New','Current','Final') NOT NULL DEFAULT 'New',
  PRIMARY KEY (`EOINumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

if (!mysqli_query($conn, $create_sql)) {
    die("ERROR: Could not create eoi table. " . mysqli_error($conn));
}

// ══════════════════════════════════════════════════════
// PREPARE & INSERT USING PREPARED STATEMENT
// ? placeholders keep data separate from the SQL query
// This completely prevents SQL injection
// ══════════════════════════════════════════════════════
$skills_string = implode(', ', $skills_clean); // e.g. "HTML, CSS, Figma"

$stmt = mysqli_prepare($conn,
    "INSERT INTO eoi
     (JobRef, FirstName, LastName, DOB, Gender, Street, SuburbTown, State, Postcode, Email, Phone, Skills, OtherSkills)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    die("ERROR: Prepare failed. " . mysqli_error($conn));
}

// 's' = string for each of the 13 fields
mysqli_stmt_bind_param($stmt, 'sssssssssssss',
    $jobRef,
    $firstName,
    $lastName,
    $dob_mysql,      // ← Y-m-d format for MySQL DATE column
    $gender,
    $streetAddress,
    $suburbTown,
    $state,
    $postcode,
    $email,
    $phone,
    $skills_string,
    $otherSkills
);

// ══════════════════════════════════════════════════════
// EXECUTE & SHOW RESULT
// ══════════════════════════════════════════════════════
if (mysqli_stmt_execute($stmt)) {

    $eoi_number = mysqli_insert_id($conn); // The auto-generated EOINumber

    include 'header.inc';
    ?>
    <main>
      <section class="formIntro">
        <h2>Application Submitted Successfully!</h2>
        <p>
          Thank you, <strong><?php echo $firstName . ' ' . $lastName; ?></strong>!
          Your Expression of Interest has been received.
        </p>
        <table>
          <tr><th>EOI Number</th>  <td>#<?php echo $eoi_number; ?></td></tr>
          <tr><th>Job Reference</th><td><?php echo $jobRef; ?></td></tr>
          <tr><th>Name</th>        <td><?php echo $firstName . ' ' . $lastName; ?></td></tr>
          <tr><th>Email</th>       <td><?php echo $email; ?></td></tr>
          <tr><th>Status</th>      <td>New</td></tr>
        </table>
        <p>We will contact you shortly regarding your application.</p>
        <a href="index.php">← Return to Home</a>
      </section>
    </main>
    <?php
    include 'footer.inc';

} else {
    include 'header.inc';
    echo "<main><h2>Submission Failed</h2>";
    echo "<p>There was a problem saving your application. Please try again.</p>";
    echo "<p>" . mysqli_stmt_error($stmt) . "</p></main>";
    include 'footer.inc';
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
