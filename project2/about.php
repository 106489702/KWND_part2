<<<<<<< HEAD
    <?php include 'header.inc'; 
      require_once 'settings.php';
      $conn = mysqli_connect("localhost", "root", "", "kwnd_db");
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }  
    ?> 
=======
    <?php include '../header.inc'; ?> 
>>>>>>> 37818e90ccd2d5c497baa47bbfa6f2eb30e9ef34
    <main>
        <h2 class="headingCenter" id="classTimesHeading">Class Times</h2>
        <div class="times"> <!--Class Times-->
          <div>Monday</div>
          <div>12:30pm to 1:30pm</div>

          <div>Friday</div>
          <div>2:30pm to 4:30pm</div>
        </div>

        <h2 class="headingCenter" id="meetOurMembersHeading">Meet our Members</h2>
        <div> <!--Member Photo and Quotes (eng + alt lang)-->
          <ul class="meetOurMembers">
            <figure>
              <img id="groupPhoto" src="images/groupphoto.webp" alt="members in KWND" width="10000px">
              <figcaption id="groupCaption">Group Photo of Duy, Kerrigan, Will and Nguyen of KWND (from left to right)</figcaption>
            </figure>

            <ul class="membersList">
              <li class="listHeading">Quotes</li>
              <li class="dashlessList"><strong>Kerrigan</strong>
                <ul class="dashlessList">
                  <li class="quoteList">Spanish: <em>Yo no recuerdo palabras cuando estoy contigo.</em></li> <!--Different Laguage-->
                  <li class="quoteList">Translation: <em>I can't remember words when I'm with you.</em></li> <!--English Laguage-->
                </ul>
              </li>
              <li class="dashlessList"><strong>Will</strong>
                <ul class="dashlessList">
                  <li class="quoteList">Italian: <em>Lo sapevi che quando premi un pulsante invia un segnale?</em></li> <!--Different Laguage-->
                  <li class="quoteList">Translation: <em>Did you know when you push a button it sends a signal?</em></li> <!--English Laguage-->
                </ul>
              </li>
              <li class="dashlessList"><strong>Duy</strong>
                <ul class="dashlessList">
                  <li class="quoteList">Vietnamese: <em>không bao giờ bỏ cuộc</em></li> <!--Different Laguage-->
                  <li class="quoteList">Translation: <em>Never give up</em></li> <!--English Laguage-->
                </ul>
              </li>
              <li class="dashlessList"><strong>Nguyen</strong>
                <ul class="dashlessList">
                  <li class="quoteList">Vietnamese: <em>Đi qua ngọn lửa.</em></li> <!--Different Laguage-->
                  <li class="quoteList">Translation: <em>Walk through the fire</em></li> <!--English Laguage-->
                </ul>
              </li>
            </ul>
        </div>

        <h2 class="headingCenter">Contributions</h2>
        <div> <!--Contribution List-->
          <dl class="contributionDefList bottomPaddingDL">
            <?php
              $sql = "SELECT first_name, last_name, contribution, assessment_part FROM contributions ORDER BY last_name, first_name";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $rowspans = [];
                foreach ($rows as $row) {
                  $key = $row["first_name"] . " " . $row["last_name"];
                  $rowspans[$key] = ($rowspans[$key] ?? 0) + 1;
                }
                echo "<table>";
                echo "<tr>
                  <th>Name</th>
                  <th>Contribution</th>
                  <th>Assessment Part</th>
                </tr>";
                $seen = [];
                foreach ($rows as $row) {
                  $name = htmlspecialchars($row["first_name"] . " " . $row["last_name"]);
                  echo "<tr>";
                    if (!isset($seen[$name])) {
                      echo "<td rowspan='" . $rowspans[$row["first_name"] . " " . $row["last_name"]] . "'>" . $name . "</td>";
                      $seen[$name] = true;
                    } 
                    echo "<td>" . htmlspecialchars($row["contribution"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["assessment_part"]) . "</td>";
                  echo "</tr>";
                }
                echo "</table>";
              } 
              else {
                echo "<p>No contributions found.</p>";
              }
              mysqli_close($conn);
            ?>
          </dl>
        </div>
        
        <h2 class="headingCenter" id="funFactsHeading">Fun Facts</h2>
          <table class="hobbyTable" id="hobbyTable"> <!--Fun Facts table-->
            <!--Header-->
            <tr>
              <td></td>
              <th>Hobby</th>
              <th>Dream Job</th>
              <th>Favourite Food</th>
            </tr>
            <!--Kerrigans Answers-->
            <tr>
              <td><strong>Kerrigan</strong></td>
              <td>Pixel Art</td>
              <td>Indie Game Dev</td>
              <td>Chicken Goujons</td>
            </tr>
            <!--Wills Answers-->
            <tr>
              <td><strong>Will</strong></td>
              <td>Warhammer</td>
              <td>Technologies Teacher</td>
              <td>Spaggeti Bolonaise</td>
            </tr>
            <!--Duys Answers-->
            <tr>
              <td><strong>Duy</strong></td>
              <td>Video games</td>
              <td>Car Engineer</td>
              <td>Banh Mi</td>
            </tr>
            <!--Nguyens Answers-->
            <tr>
              <td><strong>Nguyen</strong></td>
              <td>Soccer</td>
              <td>Mechanical Design Engineer</td>
              <td>Croissant</td>
            </tr>
          </table>
        
        <h2 class="headingCenter" id="studentIdsHeading">Student ID's</h2>
        <div class="idContainer">  <!--ID Cards-->
          <div class="idCard"> <!--Kerrigan La-Brooy-->

            <div class="cardTop">
              <div class="cardLeft">
                <img class="studentPhoto" src="images/studentphoto.webp" alt="Kerrigan's Student Photo"> <!--picture from https://www.vecteezy.com/free-png/generic-person-icon -->
                <div class="idName">Kerrigan La-Brooy</div>
                <div class="idDescription">Games and Interactivity/<br>Computer Science<br>Year 1</div>
              </div>

              <div class="cardRight">
                <img class="swinLogo" src="images/swinlogo.webp" alt="Swinburne Logo"> <!--picture from https://it.wikipedia.org/wiki/File:Logo_of_Swinburne_University_of_Technology.svg -->
              </div>
            </div>

            <div class="cardBottom">
              <div class="idNumber">106515788</div>
            </div>

          </div>
          <div class="idCard"> <!--William Luck-->

            <div class="cardTop">
              <div class="cardLeft">
                <img class="studentPhoto" src="images/studentphoto.webp" alt="Will's Student Photo"> <!--picture from https://www.vecteezy.com/free-png/generic-person-icon -->
                <div class="idName">William Luck </div>
                <div class="idDescription">Computer Science<br>Year 1</div>
              </div>

              <div class="cardRight">
                <img class="swinLogo" src="images/swinlogo.webp" alt="Swinburne Logo"> <!--picture from https://it.wikipedia.org/wiki/File:Logo_of_Swinburne_University_of_Technology.svg -->
              </div>
            </div>

            <div class="cardBottom">
              <div class="idNumber">106489702</div>
            </div>

          </div>
          <div class="idCard"> <!--Khuong Duy Phan-->

            <div class="cardTop">
              <div class="cardLeft">
                <img class="studentPhoto" src="images/studentphoto.webp" alt="Duy's Student Photo"> <!--picture from https://www.vecteezy.com/free-png/generic-person-icon -->
                <div class="idName">Khuong Duy Phan</div>
                <div class="idDescription">Data science<br>Year 1</div>
              </div>

              <div class="cardRight">
                <img class="swinLogo" src="images/swinlogo.webp" alt="Swinburne Logo"> <!--picture from https://it.wikipedia.org/wiki/File:Logo_of_Swinburne_University_of_Technology.svg -->
              </div>
            </div>

            <div class="cardBottom">
              <div class="idNumber">105559662</div>
            </div>

          </div>
          <div class="idCard"> <!--Nguyen Pham-->

            <div class="cardTop">
              <div class="cardLeft">
                <img class="studentPhoto" src="images/studentphoto.webp" alt="Nguyen's Student Photo"> <!--picture from https://www.vecteezy.com/free-png/generic-person-icon -->
                <div class="idName">Nguyen Pham</div>
                <div class="idDescription">Engineering/<br>Computer Science<br>Year 2</div>
              </div>

              <div class="cardRight">
                <img class="swinLogo" src="images/swinlogo.webp" alt="Swinburne Logo"> <!--picture from https://it.wikipedia.org/wiki/File:Logo_of_Swinburne_University_of_Technology.svg -->
              </div>
            </div>

            <div class="cardBottom">
              <div class="idNumber">105914465</div>
            </div>

          </div>
        </div>
          
    </main>
    <?php include '../footer.inc'; ?> 