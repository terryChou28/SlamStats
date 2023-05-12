<?php
$db_username = "ora_chouterr";
$db_password = "a69416048";
$db_conn_string = "dbhost.students.cs.ubc.ca:1522/stu";

$conn = oci_connect($db_username, $db_password, $db_conn_string);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teams Table</title>
        <style>
            .table-container {
                display: none;
            }

            .table-container.active {
                display: block;
            }
        </style>
    </head>
    <body>
    <div id="table-navigation">
        <button onclick="switchTable(0)">Teams</button>
        <button onclick="switchTable(1)">Teams_City</button>
        <button onclick="switchTable(2)">Playoffs_Standings</button>
        <button onclick="switchTable(3)">Season_Standings</button>
        <button onclick="switchTable(4)">Stadium</button>
        <button onclick="switchTable(5)">Games_Play_In_Stadium</button>
        <button onclick="switchTable(6)">Play</button>
        <button onclick="switchTable(7)">Coaches</button>
        <button onclick="switchTable(8)">Players_Play_For</button>
        <button onclick="switchTable(9)">Regular_Season_Statistics</button>
        <button onclick="switchTable(10)">Playoffs_Statistics</button>
        <button onclick="window.location.href='teaminsert.php'">TeamInsert</button>
        <button onclick="window.location.href='delete.php'">Delete</button>
        <button onclick="window.location.href='coachesupdate.php'">CoachesUpdate</button>
        <button onclick="window.location.href='selectplayerbysalary.php'">SelectPlayerBySalary</button>
        <button onclick="window.location.href='selectteambystadiumcapacity.php'">SelectTeamByStadiumCapacity</button>
        <button onclick="window.location.href='salaryfinder.php'">SalaryFinder</button>
        <button onclick="window.location.href='numofwinsgreaterthan.php'">NumOfWinsGreaterThan</button>
        <button onclick="window.location.href='playerbetterthanaverage.php'">TeamsBetterThanAverage</button>
        <button onclick="window.location.href='findcompleteteam.php'">FindCompleteTeam</button>

    </div>
    <div id="tables">
        <div id="table1" class="table-container">
            <table border="1">
                <tr>
                    <th>Team ID</th>
                    <th>Team Name</th>
                    <th>Division</th>
                </tr>
                <?php
                $sql = "SELECT tid, tname, division FROM Teams";
                $stid = oci_parse($conn, $sql);
                
                oci_execute($stid);
                
                while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                    foreach ($row as $item) {
                        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                oci_free_statement($stid);
                ?>
            </table>
        </div>
        <div id="table2" class="table-container">
            <table border="1">
                <tr>
                    <th>Team ID</th>
                    <th>City</th>
                </tr>
                <?php
                $sql2 = "SELECT tid, cname FROM TEAMS_CITY";
                $stid2 = oci_parse($conn, $sql2);
                
                oci_execute($stid2);
                
                while ($row2 = oci_fetch_array($stid2, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                    foreach ($row2 as $item2) {
                        echo "    <td>" . ($item2 !== null ? htmlentities($item2, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                oci_free_statement($stid2);
                ?>
            </table>
        </div>
        <div id="table3" class="table-container">
        <table border="1">
            <tr>
                <th>Season</th>
                <th>Ranking</th>
                <th>Wins</th>
                <th>Losses</th>
                <th>Seeds</th>
                <th>Round</th>
                <th>Team ID</th>
            </tr>
            <?php
            $sql3 = "SELECT sid, ranking, wins, losses, seeds, round, tid FROM PlAYOFFS_STANDINGS";
            $stid3 = oci_parse($conn, $sql3);
            
            oci_execute($stid3);
            
            while ($row3 = oci_fetch_array($stid3, OCI_ASSOC + OCI_RETURN_NULLS)) {
                echo "<tr>\n";
                foreach ($row3 as $item3) {
                    echo "    <td>" . ($item3 !== null ? htmlentities($item3, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                }
                echo "</tr>\n";
            }
            oci_free_statement($stid3);
            ?>
        </table>
        </div>
        <div id="table4" class="table-container">
        <table border="1">
            <tr>
                <th>Season</th>
                <th>Ranking</th>
                <th>Wins</th>
                <th>Losses</th>
                <th>Conference Records</th>
                <th>Team ID</th>
            </tr>
            <?php
            $sql4 = "SELECT sid, ranking, wins, losses, conference_records, tid FROM SEASON_STANDINGS";
            $stid4 = oci_parse($conn, $sql4);
            
            oci_execute($stid4);
            
            while ($row4 = oci_fetch_array($stid4, OCI_ASSOC + OCI_RETURN_NULLS)) {
                echo "<tr>\n";
                foreach ($row4 as $item4) {
                    echo "    <td>" . ($item4 !== null ? htmlentities($item4, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                }
                echo "</tr>\n";
            }
            oci_free_statement($stid4);
            ?>
        </table>
        </div>
        <div id="table5" class="table-container">
            <table border="1">
                <tr>
                    <th>Stadium</th>
                    <th>Team ID</th>
                    <th>Capacity</th>
                </tr>
                <?php
                $sql5 = "SELECT sname, tid, capacity, tid FROM STADIUM";
                $stid5 = oci_parse($conn, $sql5);
                
                oci_execute($stid5);
                
                while ($row5 = oci_fetch_array($stid5, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                    foreach ($row5 as $item5) {
                        echo "    <td>" . ($item5 !== null ? htmlentities($item5, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                oci_free_statement($stid5);
                ?>
            </table>
        </div>
        <div id="table6" class="table-container">
            <table border="1">
                <tr>
                    <th>Game ID</th>
                    <th>Score</th>
                    <th>Game Date</th>
                    <th>Game Time</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Stadium</th>
                </tr>
                <?php
                $sql6 = "SELECT gid, score, g_date, g_time, home_team, away_team, sname FROM GAMES_PLAY_IN_STADIUM";
                $stid6 = oci_parse($conn, $sql6);
                
                oci_execute($stid6);
                
                while ($row6 = oci_fetch_array($stid6, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                    foreach ($row6 as $item6) {
                        echo "    <td>" . ($item6 !== null ? htmlentities($item6, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                oci_free_statement($stid6);
                ?>
            </table>
        </div>
        <div id="table7" class="table-container">
            <table border="1">
                <tr>
                    <th>Team ID</th>
                    <th>Game ID</th>
                </tr>
                <?php
                $sql7 = "SELECT tid, gid FROM PLAY";
                $stid7 = oci_parse($conn, $sql7);
                
                oci_execute($stid7);
                
                while ($row7 = oci_fetch_array($stid7, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                    foreach ($row7 as $item7) {
                        echo "    <td>" . ($item7 !== null ? htmlentities($item7, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                oci_free_statement($stid7);
                ?>
            </table>
        </div>
        <div id="table8" class="table-container">
            <table border="1">
                <tr>
                    <th>Coach ID</th>
                    <th>Experience</th>
                    <th>Name</th>
                    <th>Salary</th>
                    <th>Team ID</th>
                </tr>
                <?php
                $sql8 = "SELECT CID, EXPERIENCE, CNAME, SALARY, TID FROM COACHES";
                $stid8 = oci_parse($conn, $sql8);
                
                oci_execute($stid8);
                
                while ($row8 = oci_fetch_array($stid8, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                    foreach ($row8 as $item8) {
                        echo "    <td>" . ($item8 !== null ? htmlentities($item8, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                oci_free_statement($stid8);
                ?>
            </table>
        </div>
        <div id="table9" class="table-container">
            <table border="1">
                <tr>
                    <th>Player ID</th>
                    <th>Salary</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Height</th>
                    <th>Position</th>
                    <th>Team ID</th>
                </tr>
                <?php
                $sql9 = "SELECT PID, SALARY, PNAME, PNUMBER, HEIGHT, POSITION, TID FROM Players_Play_For";
                $stid9 = oci_parse($conn, $sql9);
                
                oci_execute($stid9);
                
                while ($row9 = oci_fetch_array($stid9, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                    foreach ($row9 as $item9) {
                        echo "    <td>" . ($item9 !== null ? htmlentities($item9, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                oci_free_statement($stid9);
                ?>
            </table>
        </div>
        <div id="table10" class="table-container">
            <table border="1">
                <tr>
                    <th>Stat ID</th>
                    <th>Season Points</th>
                    <th>Player ID</th>
                </tr>
                <?php
                $sql10 = "SELECT STATID, SEASON_POINTS, PID FROM REGULAR_SEASON_STATISTICS";
                $stid10 = oci_parse($conn, $sql10);
                
                oci_execute($stid10);
                
                while ($row10 = oci_fetch_array($stid10, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                    foreach ($row10 as $item10) {
                        echo "    <td>" . ($item10 !== null ? htmlentities($item10, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                oci_free_statement($stid10);
                ?>
            </table>
        </div>
        <div id="table11" class="table-container">
            <table border="1">
                <tr>
                    <th>Stat ID</th>
                    <th>Playoffs Points</th>
                    <th>Player ID</th>
                </tr>
                <?php
                $sql11 = "SELECT STATID, PLAYOFF_POINTS, PID FROM PLAYOFFS_STATISTICS";
                $stid11 = oci_parse($conn, $sql11);
                
                oci_execute($stid11);
                
                while ($row11 = oci_fetch_array($stid11, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                    foreach ($row11 as $item11) {
                        echo "    <td>" . ($item11 !== null ? htmlentities($item11, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                oci_free_statement($stid11);
                ?>
            </table>
        </div>
    </div>

    <script>
        let currentTableIndex = 0;

        function switchTable(index) {
            if (index === currentTableIndex) return;

            document.getElementsByClassName("table-container")[currentTableIndex].classList.remove("active");
            currentTableIndex = index;
            document.getElementsByClassName("table-container")[currentTableIndex].classList.add("active");
        }

        window.onload = function () {
            switchTable(0);
        };
    </script>
    </body>
    </html>

<?php
oci_free_statement($stid);
oci_close($conn);
?>
