<?php

/**
 * Pomocna trida pro manipulaci s jidly a surovinami.
 * 
 * Obsluhuje pripojeni k databazi (pomoci Db.php), nacteni vsech dat,
 * vytvoreni prislusnych objektu, manipulaci s nimi a nasledne ulozeni
 * zpet do databaze.
 * 
 * Atributy:
 * - $suroviny (array) Pole vsech dostupnych surovin. Klice jsou
 * 				id jednotlivych surovin, hodnoty jsou instance (Surovina.php)
 * - $jidla (array) Pole vsech dostupnych jidel. Klice jsou id jednotlivych
 * 				jidel, hodnoty jsou instance (Jidlo.php)
 */ 
class Kontejner {
	
	private $suroviny;
	private $jidla;
	private $zmena = false;

	public function __construct($suroviny, $jidla) {
		$this->suroviny = $suroviny;
		$this->jidla = $jidla;
	}
	
	public function getSuroviny() {
		return $this->suroviny;
	}
	
	public function getJidla() {
		return $this->jidla;
	}
	
	public function jeZmena() {
		return $this->zmena;
	}
	
	public function zmen() {
		$this->zmena = true;
	}
	
	public function pridejSurovinu($id, $surovina) {
		if (!array_key_exists($id, $this->suroviny) {
			$this->suroviny[$id] = $surovina;
		}
		//else {
		//TODO	throw new Exception (
	}
}
