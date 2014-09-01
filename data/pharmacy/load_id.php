<?php
session_start();
$_SESSION['purchase_id2'] = $_GET['purchase'];

echo $_SESSION['purchase_id2'];
?>