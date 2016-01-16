<?php

class DomainFinder {

    public function __construct( $tlds, $words, $maxSize, $minSize ) {

    	$this->tlds = $tlds;
    	$this->words = $words;
    	$this->maxSize = $maxSize;
    	$this->minSize = $minSize;

    }


	private function checkWord($word, $tld) {

		$termination = substr($word, -2);
		$begin 		 = substr($word, 0, -2);

	    if (strcasecmp($tld, $termination) == 0) {
	    	echo "<span>" . $begin . "<b>." . $tld ."</b></span>";
	    }

	}

	private function cleanWord($word) {

			$cleanWord 	 = preg_replace('/\s+/', '', $word);
			$cleanWord   = htmlspecialchars($cleanWord);
			$cleanWord 	 = strtolower($cleanWord);

			return $cleanWord;

	}

	public function giveResults() {

		foreach ( $this->words as $word ) 
		{

			$cleanWord = $this->cleanWord($word);

			if (strlen($cleanWord) > $this->minSize && strlen($cleanWord) < $this->maxSize) 
			{

			  foreach ( $this->tlds as $tld ) 
			  {
			  	
			  	$this->checkWord($cleanWord, $tld);

			  }
			} 

		}

	}

}

?>