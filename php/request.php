<?php 
//request.php

function execRequest( $query ) {
	//Set up a cURL resource for the semantic request
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $query
	));
	$responseData = curl_exec($curl);
	curl_close($curl);
	return $responseData;
}
function getHTML( $url ) {
	$clean_url = explode('<a href="', $url);
	$clean_url = explode('">', $clean_url[1]);
	echo $clean_url[0];
	$test = getURL($clean_url[0]);
	var_dump($test);
}

function getUrl( $url, $username = false , $password = false ) {
  $ch = curl_init(); 
  curl_setopt($ch, CURLOPT_URL, $url); 
  curl_setopt($ch, CURLOPT_HEADER, TRUE); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: text/plaintext',
                                            'Conection: keep-alive'
                                            ));
  if( $username && $password ) {
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password"); 
  }

  $buffer = curl_exec($ch); 
  curl_close($ch); 

  return $buffer;
}
$test = getUrl("http://dl.acm.org/results.cfm?h=1&cfid=653548043&cftoken=15364582");
echo $test;
//getHTML($test);
//var_dump(getHTML($test));
/*header('Content-type: text/plaintext');
$test = file_get_contents("http://ieeexplore.ieee.org.libproxy.usc.edu/search/searchresult.jsp?newsearch=true&queryText=robot");
var_dump($test);*/
?> 