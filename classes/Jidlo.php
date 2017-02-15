<?php

/**
 * Reprezentuje jedno jidlo (grenadyr, brgul, vanocka s marmeladou, atd.).
 * 
 * Atributy:
 * - $nazev (string) jidla (psany s diakritikou)
 * - $receptura (array) Asociativni pole. Klice jsou id jednotlivych suroviny,
 * 		hodnoty jsou mnozstvi danych surovin.
 * - $typ (array(int)) Urcuje 'typ' jidla (1 = snidane, 2 = svacina,
 * 		3 = obed, 4 = vcere - viz JidloTyp.php).
 * 		Jidlo muze mit i vic typu.
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
	}
	
	public function setReceptura($novaReceptura) {
		$this->receptura = $novaReceptura;
	}
	
	public function setTyp($novyTyp) {
		$this->typ = $novyTyp;
	}

	public function __toString() {
		return $this->getNazev();
	}
	
}

