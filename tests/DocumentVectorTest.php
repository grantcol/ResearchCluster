<?php 
//include "Document.php";
/*class DocumentVector
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
}*/

class DocumentVectorTest extends PHPUnit_Framework_TestCase
{
	/** 
	 * @dataProvider strProvider
	 */
	public function testConstruct($dcont, $count) {
		$docVector = null;
		$this->assertEquals($docVector, null);

		$docVector = new DocumentVector($dcont);
		$this->assertEquals(count($docVector->mVSpace), $count);
	}

	/** 
	 * @dataProvider freqProvider
	 */
	public function testGetFreq($dv, $term, $count) {
		$this->assertEquals($dv->getFreq($term), $count);
	}

	//Data Providers

	//This provider can be reused in the SongTest class
	public function strProvider() {
		return array(
			array( "repeat repeat repeat repeat repeat repeat", 1),
			array( "tobias jesso jr rocked at the bootleg on april fifth", 10),
			array( "chipotle cilantro white rice is straight fire fire", 7),
		);
	}

	public function freqProvider() {
		return array(
			array(new DocumentVector("repeat repeat repeat repeat repeat repeat"), "repeat", 6),
			array(new DocumentVector("tobias jesso jr rocked at the bootleg on april fifth"), "jesso", 1), 
			array(new DocumentVector("chipotle cilantro white rice is straight fire fire"), "fire", 2)
		);
	}
}

?>