<?php 
//request_local.php
include "Document.php";

function cluster($documents) {
	//given a document cluster return an ordered list
	$cluster = new DocumentCluster();
	$cluster->addDocuments($documents);
	$cluster->joinDocuments();
	$cluster->TFIDF();

	return $cluster->mCluster_W;
}

function getWordCloud($cluster_w) {
	$count = 0;
	$max = count($cluster_w);
	$cloud = "";
	foreach($cluster_w as $word => $freq) {
		if($count <= 250 && $count <= $max)
			$count++;
		else 
			break;
		$w = " <span><a href='#' style= font-size:".getSize($freq)."px;>".$word."</a></span>";
		$cloud .= $w;
	}
	return $cloud;
}
function getSize($freq){
	if($freq > 1) return $freq/2;
	else if($freq <= 1) return 10;
}
function getTestDocuments() {
	$dim;
	if($query == "Machine Learning"){
		$dim = array("test002.txt", "test003.txt");
	}
	else if($query == "Web"){
		$dim = array("test004.txt");
	}
	else if($query == "Robot"){
		$dim = array("test001.txt");
	}
	else{
		$dim = array("test001.txt", "test002.txt", "test003.txt", "test004.txt");
	}

	$docs = array();
	foreach($dim as $d) {
		$cont = file_get_contents($d);
		$doc = new Document($d, "a", "d", $cont, "url");
		$docs[] = $doc;
	}
	return $docs;
}
$query = $_POST["query"];
$r = cluster(getTestDocuments());
$cloud = getWordCloud($r);
echo json_encode($cloud);

?>