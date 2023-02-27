<?php

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

$employee_id = '';
$success = '';
$help = false;

if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];
    $help = true;
}
$database->deleteEmployee($employee_id, $success);
?>