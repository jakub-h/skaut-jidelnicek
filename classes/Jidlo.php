<?php

/**
 * Reprezentuje jedno jidlo (grenadyr, brgul, vanocka s marmeladou, atd.).
 * 
 * Atributy:
 * - $nazev (string) Jmeno jidla
 * - $receptura (array) Asociativni pole. Klice jsou id jednotlivych suroviny,
 * 		hodnoty jsou mnozstvi danych surovin.
 * - $typ (array(JidloTyp.php)) Urcuje 'typ' jidla (snidane, svacina,...).
 * 		Jidlo muze mit i vic typu - proto pole.
 * - $zmena (boolean) Udava, zda bylo jidlo od nacteni z databaze zmeneno
 * 		a je tedy nutno zapis v databazi upravit. Nove vytvorena jidla musi
 * 		mit vzdy $zmena true.
 * 
 * //TODO do budoucna se muze pridat i navod
 */ 
class Jidlo {
	
	private $nazev;
	private $receptura;
	private $typ;
	
	public function __construct($nazev, $receptura, $typ) {
		$this->nazev = $nazev;
		$this->receptura = $receptura;
		$this->typ = $typ;
	}
	
	public function getNazev() {
		return htmlspecialchars($this->nazev);
	}
	
	public function getReceptura() {
		return $this->receptura;
	}
	
	public function getTyp() {
		return $this->typ;
	}
	
	public function setNazev($novyNazev) {
		$this->nazev = $novyNazev;
		//$this->zmen();
	}
	
	public function setReceptura($novaReceptura) {
		$this->receptura = $novaReceptura;
		//$this->zmen();
	}
	
	public function setTyp($novyTyp) {
		$this->typ = $novyTyp;
		//$this->zmen();
	}
	
	/**
	 * Zjisti, zda bylo jidlo zmeneno od nacteni z databaze (popr. zda
	 * vubec bylo v databazi) a jestli je tedy nutne jej opet zapisovat do DB
	 *
	public function byloZmeneno() {
		return $this->zmena;
	}
	
	/**
	 * Zmeni atribut jidla $zmena na true.
	 *
	public function zmen() {
		$this->zmena = true;
	}
	*/
	public function __toString() {
		return $this->getNazev();
	}
	
}

