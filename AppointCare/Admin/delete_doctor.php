<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $con->query("DELETE FROM doctors WHERE id = $id");
}

header("Location: doctors.php");
exit;
?>
