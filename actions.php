<?php

$action = $_GET['act'];

require('db_connect.php');

if($action == "purge"):
  $stm = $conn -> prepare("TRUNCATE TABLE data");
  $stm -> execute();
endif;

header('Location: /atmospheric/');
die();
?>
