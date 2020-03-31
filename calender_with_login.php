<?php
// session and login stuff
$admin = array(
    "username" => "admin",
    "password" => "admin"
);
session_start();

if (isset($_POST["logout"])) {
    session_destroy();
    session_start();
}

if (isset($_SESSION["active"])) {
    $username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
}
else {

    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $userPassword = isset($_POST["password"]) ? $_POST["password"] : "";

    if ($username == $admin["username"] && $userPassword == $admin["password"]) {
        $_SESSION["username"] = $username;
        $_SESSION["active"] = true;
    }
    else {
        echo '<form action="calender_logged_in.php" name="login" method="POST">
            <h1>Loggen Sie sich ein um den Kalender anzuzeigen</h1>
            <label>
                Username:
                <input name="username" type="text" required>
            </label>
            <br>
            <label>
                Password:
                <input name="password" type="password" required>
            </label>`
            <br>
            <button type="submit">
                Einloggen
            </button>
        </form>';
        if ($username != "") {
            echo "user and password unknown";
        }
        exit();
    }
}
// ab hier kennen wir den User
?>


<h1>Kalender</h1>
Hello <?php echo $username?><br>
<form name="logout" method="POST">
    <button name="logout" type="submit">
        Logout
    </button>
</form>

<?php
// gen calender stuff form here
$weekdays = array("Mon","Tue","Wed","Thu","Fri", "Sat", "Sun");
$months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

// start date of calender
$currentDay = 1;
$currentYear = date("Y");
$currentMonth = date("n");

// determine where first month starts
$firstWeekdayStr = date("D", mktime(0, 0, 0, $currentMonth, $currentDay, $currentYear));
for ($breakDay = 0; $breakDay < 7; $breakDay++) {
    if($weekdays[$breakDay] === $firstWeekdayStr)
    break;
}

// main loop
for ($monthCounter = 0; $monthCounter < 36; $monthCounter++) {
    //  | -- Month1 -- |
    echo "<table border=\"1\">
    <tr>";
        echo "<th bgcolor=\"lightblue\" colspan=\"7\">"
        .$months[$currentMonth - 1]." ".$currentYear.
        "</th>";
    echo "</tr>
    <tr>";
    //  | Mon | Tue | ... | Sun|
    foreach($weekdays as $wd) {
        echo "<th bgcolor=\"yellow\">$wd</th>";
    }
    echo "</tr>";

    // first week grey days
    echo "<tr>";
    for($k = 0; $k < $breakDay % 7; $k++){
        echo "<td bgcolor=\"grey\"></td>";
    }

    // rest of first week
    for($dayCounter = $breakDay; $dayCounter < 7; $dayCounter++){
        echo"<td>".$currentDay."</td>";
        $currentDay++;
    }
    echo "</tr>";

    // rest of the current month
    while(true){
        echo "<tr>";
        for($dayCounter = 0; $dayCounter < 7; $dayCounter++) {
            if (checkdate($currentMonth, $currentDay, $currentYear) === false) {
                break;
            }
            // check if it is today
            if(date("n") == $currentMonth
            && date("j") == $currentDay
            && date("Y") == $currentYear) {
                echo "<td bgcolor=\"red\">$currentDay</td>";
                $currentDay++;
            }
            else {
                echo "<td>$currentDay</td>";
                $currentDay++;
            }
            // save where to start next month
            $breakDay = $dayCounter + 1;
        }
        if (checkdate($currentMonth, $currentDay, $currentYear) === false) {
            for ($leftDays = $breakDay; $leftDays < 7; $leftDays++) {
                echo "<td bgcolor=\"grey\"></td>";
            }
            break;
        }
        echo "</tr>";
    }
    $currentDay = 1;
    $currentMonth++;
    // yearly roll around
    if ($currentMonth == 13) {
        $currentMonth = 1;
        $currentYear++;
    }
    echo "</tr></table>";
}
?>