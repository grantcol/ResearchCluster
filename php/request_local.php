<?php 
//request_local.php
include "funcs.php";
$query 	= $_POST["query"];
$type	= $_POST["type"];
$freq	= $_POST["freq"];
saveSearch($query);

$req = null;
if($type == "Topic") { $req = buildRequest($query); }
else if($type == "Author") { $rq = buildAuthRequest($query); }
else if($type == "Publication") { $req = buildPubRequest($query); }

$req 	= buildRequest($query);
$res 	= execRequest($req);
$xml 	= new SimpleXMLElement($res);
$r 		= cluster(docify($xml));
$cloud 	= getWordCloud($r);
echo json_encode($cloud);

?>