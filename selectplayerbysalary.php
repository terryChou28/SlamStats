<?php
$db_username = "ora_chouterr";
$db_password = "a69416048";
$db_conn_string = "dbhost.students.cs.ubc.ca:1522/stu";

$conn = oci_connect($db_username, $db_password, $db_conn_string);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$min_salary = isset($_GET['min_salary']) ? $_GET['min_salary'] : '';
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Select Players by Salary</title>
    </head>
    <body>
    <h1>Select Players by Salary</h1>
    <form action="selectplayerbysalary.php" method="get">
        <label for="min_salary">Salary Larger Than:</label>
        <input type="number" id="min_salary" name="min_salary" value="<?php echo $min_salary; ?>" min="0">
        <button type="submit">Submit</button>
    </form>

    <?php if ($min_salary !== ''): ?>
        <h2>Players with Salary Higher than <?php echo htmlentities($min_salary, ENT_QUOTES); ?></h2>
        <table border="1">
            <tr>
                <th>Player Name</th>
                <th>Salary</th>
            </tr>
            <?php
            $sql = "SELECT p.pname, p.salary
                FROM Players_Play_For p
                WHERE p.salary >= :min_salary";
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ":min_salary", $min_salary);
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