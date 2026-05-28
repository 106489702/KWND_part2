<?php include 'header.inc'; ?>

<main>
  <h1>Job Positions</h1>
  <p>
    KWND Creative is looking for dedicated web developers and designers who are
    interested in working with creative digital media webpages.
  </p>

  <aside>
    <h2>Inclusive Employment Statement</h2>
    <p>
      KWND Creative welcomes applications from people of all backgrounds and
      encourages Aboriginal and Torres Strait Islander peoples to apply.
      We are committed to a respectful and diverse workplace.
    </p>
  </aside>

  <!-- ══════════════════════════════════════════
       SEARCH BAR
       Submits GET so the search term stays in the URL.
       Empty search = show all jobs.
  ══════════════════════════════════════════ -->
  <section id="jobSearch">
    <form action="jobs.php" method="get" id="searchForm">
      <label for="site-search">Search Jobs:</label>
      <input type="search" id="site-search" name="search"
             placeholder="e.g. Developer, Designer, ABC01"
             value="<?php echo isset($_GET['search'])
                          ? htmlspecialchars($_GET['search']) : ''; ?>">
      <button type="submit">Search</button>
      <?php if (!empty($_GET['search'])): ?>
        <a href="jobs.php">Clear Search</a>
      <?php endif; ?>
    </form>
  </section>

  <?php
  // ══════════════════════════════════════════
  // DATABASE CONNECTION
  // ══════════════════════════════════════════
  require_once 'settings.php';

  $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
  if (!$conn) {
      echo "<p class='error'>Could not connect to database: "
           . mysqli_connect_error() . "</p>";
  } else {

      // ══════════════════════════════════════════
      // BUILD QUERY
      // If a search term was submitted, filter results.
      // Prepared statement prevents SQL injection.
      // Searches across Title, JobRef, and Description.
      // ══════════════════════════════════════════
      $search_term = trim($_GET['search'] ?? '');

      if (!empty($search_term)) {
          $stmt = mysqli_prepare($conn,
              "SELECT * FROM jobs
               WHERE Title       LIKE ?
               OR    JobRef      LIKE ?
               OR    Description LIKE ?
               ORDER BY JobID ASC"
          );
          $like = '%' . $search_term . '%';
          mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
      } else {
          // No search — fetch all jobs
          $result = mysqli_query($conn, "SELECT * FROM jobs ORDER BY JobID ASC");
      }

      // ══════════════════════════════════════════
      // DISPLAY RESULTS
      // ══════════════════════════════════════════
      if (mysqli_num_rows($result) === 0) {
          echo "<p>No jobs found matching <strong>"
               . htmlspecialchars($search_term) . "</strong>.</p>";
      } else {
          while ($job = mysqli_fetch_assoc($result)):
              // Convert pipe-separated strings back into arrays for <li> rendering
              $responsibilities = explode('|', $job['Responsibilities']);
              $essentials       = explode('|', $job['EssentialReq']);
              $preferables      = explode('|', $job['PreferableReq']);
  ?>

      <!-- Each job is its own section, id uses the JobRef for anchor links -->
      <section id="<?php echo htmlspecialchars($job['JobRef']); ?>">

        <h2><?php echo htmlspecialchars($job['Title']); ?></h2>
        <h3>Reference Number: <?php echo htmlspecialchars($job['JobRef']); ?></h3>

        <p><?php echo htmlspecialchars($job['Description']); ?></p>

        <p>
          <strong>Salary:</strong>
          <?php echo htmlspecialchars($job['SalaryRange']); ?><br>
          <strong>Reporting line:</strong>
          <?php echo htmlspecialchars($job['ReportingLine']); ?>
        </p>

        <h3>Key Responsibilities</h3>
        <ol>
          <?php foreach ($responsibilities as $item): ?>
            <li><?php echo htmlspecialchars(trim($item)); ?></li>
          <?php endforeach; ?>
        </ol>

        <h3>Requirements</h3>

        <h4>Essentials</h4>
        <ul>
          <?php foreach ($essentials as $item): ?>
            <li><?php echo htmlspecialchars(trim($item)); ?></li>
          <?php endforeach; ?>
        </ul>

        <h4>Preferables</h4>
        <ul>
          <?php foreach ($preferables as $item): ?>
            <li><?php echo htmlspecialchars(trim($item)); ?></li>
          <?php endforeach; ?>
        </ul>

        <!-- Link directly to the apply form with the job ref pre-filled -->
        <a href="apply.php?jobRef=<?php echo urlencode($job['JobRef']); ?>">
          Apply for this position →
        </a>

      </section>

  <?php
          endwhile;
      }

      // Close prepared statement if it was used
      if (!empty($search_term) && isset($stmt)) {
          mysqli_stmt_close($stmt);
      }
      mysqli_close($conn);
  }
  ?>

</main>

<?php include 'footer.inc'; ?>
