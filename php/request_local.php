<?php 
//request_local.php
include "funcs.php";
$query 	= $_POST["query"];
$req 	= buildRequest($query);
$res 	= execRequest($req);
$xml 	= new SimpleXMLElement($res);
$r 		= cluster(docify($xml));
$cloud 	= getWordCloud($r);
echo json_encode($cloud);

?>