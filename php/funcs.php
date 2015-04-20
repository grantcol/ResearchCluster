<?php 
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
		$w = " <span><a href='table.php?word=".$word."' style= font-size:".getSize($freq)."px;>".$word."</a></span>";
		$cloud .= $w;
	}
	return $cloud;
}

function getSize($freq){
	if($freq > 1) return $freq/2;
	else if($freq <= 1) return 10;
}

function getTestDocuments($query) {
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

function linkify($str) {
	$title = explode(" ", $str);
	$lTitle = "";
	foreach($title as $word)
	{
		$lTitle .= "<a href='cloud.php?type=word&word=".$word."'>".$word."</a> ";
	}
	return $lTitle;
}

function execRequest( $query ) {
	//Set up a cURL resource for the semantic request
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $query
	));
	$responseData = curl_exec($curl);

	if($errno = curl_errno($curl)) {
	    $error_message = curl_strerror($errno);
	    echo "cURL error ({$errno}):\n {$error_message}";
	}
	curl_close($curl);
	return $responseData;
}

function buildRequest($word) {
	$word = explode(" ", $word)[0];
	return "http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?querytext=".$word."&hc=10&rs=11&sortfield=ti&sortorder=asc";
}

function buildAuthRequest($auth) {
	return "http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?au=".$auth."&hc=10&rs=11&sortfield=ti&sortorder=asc"; 
}

function buildPubRequest($pub) {
	return "http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?pu=".$pub."&hc=10&rs=11&sortfield=ti&sortorder=asc";
}

function docify($xml) {
	$docs = array();
	foreach($xml->document as $doc) {
		$newDoc = new Document($doc->title, $doc->authors, $doc->pubtitle, $doc->abstract, $doc->pdf);
		$docs[] = $newDoc;
	}
	return $docs;
}

function searchIEEE($query, $type) {
	$req = NULL;
	if($type == "word")
		$req = buildRequest($query);
	else if($type == "auth")
		$req = buildAuthRequest($query);
	else if($type == "pub")
		$req = buildPubRequest($query);	
	$res 	= execRequest($req);
	$xml 	= new SimpleXMLElement($res);
	$r 		= cluster(docify($xml));
	$cloud 	= getWordCloud($r);
	return json_encode($cloud);
}


?>