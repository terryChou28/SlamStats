<?php
$db_username = "ora_chouterr";
$db_password = "a69416048";
$db_conn_string = "dbhost.students.cs.ubc.ca:1522/stu";

$conn = oci_connect($db_username, $db_password, $db_conn_string);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$min_wins = isset($_GET['min_wins']) ? $_GET['min_wins'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number of Wins Greater Than</title>
</head>
<body>
<h1>Number of Wins Greater Than</h1>
<form action="numofwinsgreaterthan.php" method="get">
    <label for="min_wins">Number of Regular Season Wins Greater Than:</label>
    <input type="number" id="min_wins" name="min_wins" value="<?php echo $min_wins; ?>" min="0">
    <button type="submit">Submit</button>
</form>

<?php if ($min_wins !== ''): ?>
    <h2>Teams with Regular Season Wins Greater than <?php echo htmlentities($min_wins, ENT_QUOTES); ?></h2>
    <table border="1">
        <tr>
            <th>Team Name</th>
            <th>Total Wins</th>
        </tr>
        <?php
        $sql = "SELECT t.tname AS team_name, SUM(ss.wins) AS total_wins
                FROM Teams t
                INNER JOIN Season_Standings ss ON t.tid = ss.tid
                GROUP BY t.tid, t.tname
                HAVING SUM(ss.wins) > :min_wins";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":min_wins", $min_wins);
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
<?php endif; ?>

</body>
</html>

<?php
oci_close($conn);
?>