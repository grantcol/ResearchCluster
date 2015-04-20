<?php 
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

class DocumentTest extends PHPUnit_Framework_TestCase
{
	/** 
	 * @dataProvider docProvider
	 */
	public function testConstruct($title, $auth, $db, $cont, $url) {
		$doc = null;
		$this->assertEquals($doc, null);

		$doc = new Documemnt("testDoc");
		$this->assertEquals($doc->mTitle, $title);
		$this->assertEquals($doc->mAuthor, $auth);
		$this->assertEquals($doc->mDB, $db);
		$this->assertEquals($doc->url, $url);
	}
	//Data Providers

	//This provider can be reused in the SongTest class
	public function docProvider() {
		return array(
			array( "title01", "author01", "db01", "contStr01", "url01"),
			array( "title02", "author02", "db02", "contStr02", "url02"),
			array( "title03", "author03", "db03", "contStr03", "url03"),
		);
	}
}

?>