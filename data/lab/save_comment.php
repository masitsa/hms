<?php

include "../../classes/class_lab.php";

$comment = $_GET['comment'];
$visit_charge_id = $_GET['visit_charge_id'];

$save = new Lab;
$save->save_comment($comment, $visit_charge_id);

?>