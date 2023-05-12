<?php
$db_username = "ora_chouterr";
$db_password = "a69416048";
$db_conn_string = "dbhost.students.cs.ubc.ca:1522/stu";

$conn = oci_connect($db_username, $db_password, $db_conn_string);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cid = $_POST['cid'];
    $experience = $_POST['experience'];
    $name = $_POST['name'];
    $salary = $_POST['salary'];
    $tid = $_POST['tid'];

    $sql = "UPDATE COACHES SET EXPERIENCE = :experience, CNAME = :name, SALARY = :salary, TID = :tid WHERE CID = :cid";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ':experience', $experience);
    oci_bind_by_name($stid, ':name', $name);
    oci_bind_by_name($stid, ':salary', $salary);
    oci_bind_by_name($stid, ':tid', $tid);
    oci_bind_by_name($stid, ':cid', $cid);

    $result = oci_execute($stid, OCI_DEFAULT);

    if ($result) {
        oci_commit($conn);
        echo "Update successful!";
    } else {
        oci_rollback($conn);
        $error = oci_error($stid);
        echo "Update failed: " . $error['message'];
    }

    oci_free_statement($stid);
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Coach</title>
</head>
<body>
<form action="coachesupdate.php" method="post">
    <label for="cid">CID:</label>
    <input type="text" name="cid" id="cid">

    <label for="experience">Experience:</label>
    <input type="text" name="experience" id="experience">

    <label for="name">Name:</label>
    <input type="text" name="name" id="name">

    <label for="salary">Salary:</label>
    <input type="text" name="salary" id="salary">

    <label for="tid">TID:</label>
    <input type="text" name="tid" id="tid">

    <input type="submit" value="Update">
</form>
</body>
</html>