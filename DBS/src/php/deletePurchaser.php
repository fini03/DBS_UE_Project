<?php

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

$purchaser_id = '';
$success = '';
$help = false;

if (isset($_POST['purchaser_id'])) {
    $purchaser_id = $_POST['purchaser_id'];
    $help = true;
}
$database->deletePurchaser($purchaser_id, $success);
?>