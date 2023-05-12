<?php
$db_username = "ora_chouterr";
$db_password = "a69416048";
$db_conn_string = "dbhost.students.cs.ubc.ca:1522/stu";

$conn = oci_connect($db_username, $db_password, $db_conn_string);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$table_name = $_POST['table_name'];
$primary_key = $_POST['primary_key'];
$id = $_POST['id'];

$sql = "DELETE FROM $table_name WHERE $primary_key = '$id'";
$stid = oci_parse($conn, $sql);

if (oci_execute($stid)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . oci_error($stid);
}

oci_free_statement($stid);
oci_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Record</title>
</head>
<body>
<h1>Delete Record</h1>
<form action="delete.php" method="post">
    <label for="table_name">Table Name:</label>
    <input type="text" name="table_name"><br><br>
    <label for="primary_key">Primary Key:</label>
    <input type="text" name="primary_key"><br><br>
    <label for="id">ID:</label>
    <input type="text" name="id"><br><br>
    <input type="submit" value="Delete">
</form>
</body>
</html>