<?php
$db_username = "ora_chouterr";
$db_password = "a69416048";
$db_conn_string = "dbhost.students.cs.ubc.ca:1522/stu";

$conn = oci_connect($db_username, $db_password, $db_conn_string);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values from the form
    $tid = $_POST["tid"];    //CHANGE THIS!
    $tname = $_POST["tname"];     //CHANGE THIS!
    $division = $_POST["division"];     //CHANGE THIS!

    // Insert data into Teams table
    $sql = "INSERT INTO Teams (tid, tname, division) VALUES (:tid, :tname, :division)";    //CHANGE THIS!
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":tid", $tid);     //CHANGE THIS!
    oci_bind_by_name($stid, ":tname", $tname);     //CHANGE THIS!
    oci_bind_by_name($stid, ":division", $division);     //CHANGE THIS!

    oci_execute($stid);
    oci_commit($conn);
    oci_free_statement($stid);
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert into Teams Table</title>
</head>
<body>
<form method="POST">
    <label for="tid">Team ID:</label><br>
    <input type="text" id="tid" name="tid"><br>
    <label for="tname">Team Name:</label><br>
    <input type="text" id="tname" name="tname"><br>
    <label for="division">Division:</label><br>
    <input type="text" id="division" name="division"><br><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>