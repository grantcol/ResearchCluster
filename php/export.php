<?php 
session_start();
include "funcs.php";

$keys = $_POST["keys"];
$printable = $_SESSION["xml_p"];
$subset = array();
foreach($keys as $k) { $subset[] = $printable[$k]; }
writeTable($subset);
if(isset($_SESSION["xml_p"])) echo "SET";
else echo "NOT SET";
?>