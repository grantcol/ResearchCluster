<?php 
//Document.php

class Document 
{
	public $mTitle;
	public $mAuthor;
	public $mDB;
	public $mContent;
	public $mUrl;

	function __construct($title, $auth, $db, $cont, $url) {
		$this->mTitle 	= $title;
		$this->mAuthor 	= $auth;
		$this->mDB 		= $db;
		$this->mContent = $this->vectorize($cont);
		$this->url 		= $url;
	}

	//will vectorize the string of doc contents into a DocumentVector
	function vectorize($cont) { return new DocumentVector($cont); }
}

class DocumentVector
{
	public $mVSpace;

	function __construct($dcont) {
		//vectorize the string
		$e = explode(" ", $dcont);
		foreach($e as $word){
			$this->mVSpace[$word]++;
		}
	}

	function getFreq($term) { return $this->mVSpace[$term]; }
}

class DocumentCluster
{
	public $mCluster;
	public $mCenTerm;
	public $mCluster_W;

	function __construct($ct) {
		$this->mCenTerm 	= $ct;
		$this->mCluster 	= new Array();
		$this->mCluster_W 	= new Array();
	}

	function addDocument($newDoc) {
		if(is_a($newDoc, 'DocumentVector')){
			$this->mCluster[] = $newDoc;
		}
		else {
			echo "BAD DOCTYPE";
		}
	}

	function addDocuments($newDocs) {
		foreach ($newDocs as $d) {
			$this->addDocument($d);
		}
	}

	function joinDocuments() {
		$joined = new Array(); 
		foreach($this->mCluster as $dv) {
			foreach($dv->mVSpace as $w => $c ) {
				$joined[$w] += $c;
			}
		}
		return $joined;
	}

	function getDocFreq($word) {
		$DF = 0;
		foreach( $this->mCluster as $dv ) {
			$exists = $dv->getFreq($word);
			if($exists > 0){
				$DF++;
			}
		}
		return $DF;
	}

	function TFIDF() {
		//compute the tf-idf value for the doc cluster 
		//w_i = TF_i * log(N/DF_i)
		$joined = $this->joinDocuments();
		foreach( $joined as $word => $t_freq ){

			$DF_i  						= $this->getDocFreq($word);
			$IDF_i 						= count($this->mCluster)/$DF_i;
			$TF_i 						= $t_freq;
			$this->mCluster_W[$word] 	= $TF_i * $IDF_i;

		}
	}

}






?>