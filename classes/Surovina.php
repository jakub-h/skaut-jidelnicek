<?php

/**
 * Reprezentuje jednu surovinu.
 * 
 * Atributy:
 * - nazev (string) psany s diakritikou
 * - jednotka (string) - ks, g, l
 * - typ (string) - 'mlecne vyrobky', 'maso', atd. (psane s diakritikou)
 */
class Surovina {
	
	private $nazev;
	private $jednotka;
	private $typ;
	
	/**
	 * Konstruktor.
	 * 
	 * @param $nazev (string) nazev suroviny
	 * @param $jednotka (string) jednotka ve ktere je merena surovina (ks, g, l)
	 * @param $typ (string) typ suroviny (mlecne vyrobky, maso, pecivo,...)
	 * 
	 * obdobne i u setteru.
	 */
	public function __construct($nazev, $jednotka, $typ) {
		$this->nazev = $nazev;
		$this->jednotka = $jednotka;
		$this->typ = $typ;
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
	}
	
	public function setJednotka($novaJednotka) {
		$this->jednotka = $novaJednotka;
	}
	
	public function setTyp($novyTyp) {
		$this->typ = $novyTyp;
	}
	
	public function __toString() {
		return $this->getNazev();
	}
}
