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
        <title>Players Better Than Average</title>
    </head>
    <body>
    <h1>Players Better Than Average</h1>

    <h2>Players with Regular Season Average Points Scored Above Overall Average</h2>
    <table border="1">
        <tr>
            <th>Player Name</th>
            <th>Average Points</th>
        </tr>
        <?php
--         $sql =
// "SELECT P.pname AS player_name, AVG(R.season_points) AS average_points
--             FROM Players_Play_For P
--             INNER JOIN Regular_Season_Statistics R ON P.pid = R.pid
--             GROUP BY P.pid, P.pname
--             HAVING AVG(R.season_points) > (
--                 SELECT AVG(season_points) AS overall_average_points
--                 FROM Regular_Season_Statistics
// --             )";
"SELECT T.name,AVG(Wins)
FROM
    Teams T
      INNER JOIN
    Season_Standings SS ON T.tid = SS.tid
GROUP BY
    T.id
HAVING
    AVG(SS.wins) > (
    SELECT
          AVG(wins) AS overall_average_wins
    FROM
        Season_Standings
);
        $stid = oci_parse($conn, $sql);
        oci_execute($stid)";

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

    </body>
    </html>

<?php
oci_close($conn);
?>