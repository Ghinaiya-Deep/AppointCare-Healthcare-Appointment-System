<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $con->query("DELETE FROM departments WHERE id = $id");
}

header("Location: departments.php");
exit;
?>
