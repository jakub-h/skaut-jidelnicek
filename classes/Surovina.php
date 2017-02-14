<?php

/**
 * Reprezentuje jednu surovinu.
 * 
 * Atribut nazev je string, jednotka je enum Jednotka.php,
 * typ je enum SurovinaTyp.php a zmena je boolean, udavajici, zda byla
 * surovina od nacteni z databaze modifikovana. Nove vytvorene suroviny 
 * (doposut nebyly v databazi) by vzdy mely mit zmenu true!
 */
class Surovina {
	
	private $nazev;
	private $jednotka;
	private $typ;
	private $zmena;
	
	/**
	 * Konstruktor.
	 * 
	 * @param $zmena (boolean) false, pokud obsah odpovida tomu, co je v databazi, jinak true
	 * @param $nazev (string) nazev suroviny
	 * @param $jednotka (Jednotka.php) jednotka ve ktere je merena surovina (ks, l, g,...)
	 * @param $typ (SurovinaTyp.php) typ suroviny (mlecne vyrobky, maso, pecivo,...)
	 * 
	 * obdobne i u setteru.
	 */
	public function __construct($nazev, $jednotka, $typ, $zmena) {
		$this->nazev = $nazev;
		$this->jednotka = $jednotka;
		$this->typ = $typ;
		$this->zmena = $zmena;
	}
	
	public function getNazev() {
		return htmlspecialchars($this->nazev);
	}
	
	public function getJednotka() {
		return htmlspecialchars($this->jednotka);
	}
	
	public function getTyp() {
		return htmlspecialchars($this->typ);
	}

	public function setNazev($novyNazev) {
		$this->nazev = $novyNazev;
		$this->zmen();
	}
	
	public function setJednotka($novaJednotka) {
		$this->jednotka = $novaJednotka;
		$this->zmen();
	}
	
	public function setTyp($novyTyp) {
		$this->typ = $novyTyp;
		$this->zmen();
	}
	
	/**
	 * Zjisti, zda byla surovina zmenena od nacteni z databaze (popr. zda
	 * vubec byla v databazi) a jestli je tedy nutne ji opet zapisovat do DB
	 */
	public function bylaZmenena() {
		return $this->zmena;
	}
	
	/**
	 * Zmeni atribut suroviny $zmena na true.
	 */
	public function zmen() {
		$this->zmena = true;
	}
	
	public function __toString() {
		return $this->getNazev();
	}
}
