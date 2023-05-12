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
    <title>Find Complete Team</title>
</head>
<body>
<h1>Find Complete Team</h1>

<h2>Teams with at least one player in every position</h2>
<table border="1">
    <tr>
        <th>Team Name</th>
    </tr>
    <?php
    $sql = "SELECT T.tname
            FROM Teams T
            WHERE NOT EXISTS (
                (SELECT DISTINCT P.position
                 FROM Players_Play_For P)
                MINUS
                (SELECT DISTINCT P2.position
                 FROM Players_Play_For P2
                 WHERE P2.tid = T.tid)
            )";
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

</body>
</html>

<?php
oci_close($conn);
?>
