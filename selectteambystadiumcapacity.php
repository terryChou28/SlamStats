<?php
$db_username = "ora_chouterr";
$db_password = "a69416048";
$db_conn_string = "dbhost.students.cs.ubc.ca:1522/stu";

$conn = oci_connect($db_username, $db_password, $db_conn_string);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$min_capacity = isset($_GET['min_capacity']) ? $_GET['min_capacity'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Teams by Stadium Capacity</title>
</head>
<body>
<h1>Select Teams by Stadium Capacity</h1>
<form action="selectteambystadiumcapacity.php" method="get">
    <label for="min_capacity">Capacity Larger Than:</label>
    <input type="number" id="min_capacity" name="min_capacity" value="<?php echo $min_capacity; ?>" min="0">
    <button type="submit">Submit</button>
</form>

<?php if ($min_capacity !== ''): ?>
    <h2>Teams with Stadium Capacity Greater than <?php echo htmlentities($min_capacity, ENT_QUOTES); ?></h2>
    <table border="1">
        <tr>
            <th>Team Name</th>
            <th>Stadium Name</th>
            <th>Stadium Capacity</th>
        </tr>
        <?php
        $sql = "SELECT t.tname AS team_name, s.sname AS stadium_name, s.capacity AS stadium_capacity
                FROM Teams t
                INNER JOIN Stadium s ON t.tid = s.tid
                WHERE s.capacity > :min_capacity";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":min_capacity", $min_capacity);
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
