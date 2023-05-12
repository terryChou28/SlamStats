<?php
$db_username = "ora_chouterr";
$db_password = "a69416048";
$db_conn_string = "dbhost.students.cs.ubc.ca:1522/stu";

$conn = oci_connect($db_username, $db_password, $db_conn_string);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

function executeQuery($conn, $choice) {
    switch ($choice) {
        case 'average':
            $sql = "SELECT
                        Teams.tname AS team_name,
                        AVG(Players_Play_For.salary) AS average_salary
                    FROM
                        Teams
                            INNER JOIN
                        Players_Play_For ON Teams.tid = Players_Play_For.tid
                    GROUP BY
                        Teams.tid, Teams.tname";
            $resultHeader = "Average Salary";
            break;
        case 'max':
            $sql = "SELECT
                        Teams.tname AS team_name,
                        MAX(Players_Play_For.salary) AS highest_salary
                    FROM
                        Teams
                            INNER JOIN
                        Players_Play_For ON Teams.tid = Players_Play_For.tid
                    GROUP BY
                        Teams.tid, Teams.tname";
            $resultHeader = "Highest Salary";
            break;
        case 'min':
            $sql = "SELECT
                        Teams.tname AS team_name,
                        MIN(Players_Play_For.salary) AS lowest_salary
                    FROM
                        Teams
                            INNER JOIN
                        Players_Play_For ON Teams.tid = Players_Play_For.tid
                    GROUP BY
                        Teams.tid, Teams.tname";
            $resultHeader = "Lowest Salary";
            break;
        default:
            throw new InvalidArgumentException('Invalid choice');
    }

    $stid = oci_parse($conn, $sql);
    oci_execute($stid);

    return [$stid, $resultHeader];
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salary Finder</title>
    </head>
<body>
    <h1>Salary Finder</h1>
    <form method="post">
        <label for="choice">Select a salary statistic:</label>
        <select name="choice" id="choice">
            <option value="average">Average Salary</option>
            <option value="max">Highest Salary</option>
            <option value="min">Lowest Salary</option>
        </select>
        <input type="submit" value="Submit">
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $choice = $_POST['choice'];
    list($stid, $resultHeader) = executeQuery($conn, $choice);
    ?>
    <h2><?php echo $resultHeader ?> of Players for Each Team</h2>
    <table border="1">
    <tr>
        <th>Team Name</th>
        <th><?php echo $resultHeader ?></th>
    </tr>
    <?php
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo "<tr>\n";
        foreach ($row as $item) {
            echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
        }
        echo "</tr>\n";
    }
    oci_free_statement($stid);
    oci_close($conn);
    ?>
    </table>
    <?php
}
?>
</body>
</html>