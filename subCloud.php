<?php 
session_start();
include "php/funcs.php";

$sXml 	= $_SESSION["curr_query_xml"];
$keys 	= $_POST["keys"];
$subset = array();
$count = 0;
foreach($keys as $k) { $subset[$count] = $sXml[$k]; $count++; }
$r 		= cluster(docify_s($subset));
$cloud 	= getWordCloud($r);
echo json_encode($cloud);
?>