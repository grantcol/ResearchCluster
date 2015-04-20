<?php

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

function buildRequest() {
	return "http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?querytext=java&au=Wang&hc=10&rs=11&sortfield=ti&sortorder=asc";
}

$req = buildRequest();
$response = execRequest( $req );
$xml = new SimpleXMLElement($response);
var_dump($xml, true);
/*foreach($xml as $ent)
{
	echo $ent;
}*/
//$response = file_get_contents( buildRequest() );
//var_dump($response);
/*foreach ($response as $key ) {
	echo $key;
}*/

?>