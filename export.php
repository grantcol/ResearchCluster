<?php 
session_start();
include "php/funcs.php";

$keys = $_POST["keys"];
$printable = $_SESSION["xml_p"];
$subset = array();
foreach($keys as $k) { $subset[] = $printable[$k]; }
if(count($subset) > 0) 
	writeTable($subset);
var_dump($subset);
?>