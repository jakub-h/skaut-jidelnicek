<?php

/**
 * Pomocna trida pro manipulaci s jidly a surovinami.
 * 
 * Udrzuje 'kopii' databaze ulozenou v objektech. Nabizi zakladni funkce
 * pro manipulaci s nimi.
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

	/**
	 * Konstruktor.
	 * 
	 * @param $suroviny (array) (Surovina.php)
	 * @param $jidla (array) (Jidlo.php)
	 * 
	 * Vytvori kontejner ze zadanych asoc. poli:
	 * - klice jsou jednotlive id
	 * - hodnoty jsou konkretni instance objektu
	 */
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
	
	/**
	 * Zjisti, zda byl kontejner zmenen od nacteni z databaze a jestli
	 * je tedy nutne jej opet zapisovat do DB.
	 */
	public function jeZmena() {
		return $this->zmena;
	}
	
	/**
	 * Zmeni atribut kontejneru $zmena na true.
	 */
	public function zmen() {
		$this->zmena = true;
	}
	
	/**
	 * Zkontroluje, zda je dana surovina v kontejneru pod danym id.
	 */
	public function jeSurovinaVKontejneru($id, $surovina) {
		$key = array_search($surovina, $this->suroviny);
		if ($key) {
			if ($key == $id) {
				return true;
			}
			return "jine id";
		}
		return false;
	}
	
	/**
	 * Zkontroluje, zda je dane jidlo v kontejneru pod danym id.
	 */
	public function jeJidloVKontejneru($id, $jidlo) {
		$key = array_search($jidlo, $this->jidla);
		if ($key) {
			if ($key == $id) {
				return true;
			}
			return "jine id";
		}
		return false;
	}
	
	/**
	 * Prida surovinu do kontejneru.
	 * 
	 * @param $id (int) id dane suroviny
	 * @param $surovina (Surovina.php) surovina, ktera ma byt pridana
	 * 
	 * Pokud se surovina v kontejneru nachazi (i s jinym id), je vyhozena
	 * patricna vyjimka (KontejnerException).
	 */
	public function pridejSurovinu($id, $surovina) {
		if (!jeSurovinaVKontejneru($id, $surovina) {
			$this->suroviny[$id] = $surovina;
		}
		else {
			throw new KontejnerException('surovina jiz je v kontejneru');
		}
		$this->zmen();
	}
	
	/**
	 * Prida jidlo do kontejneru.
	 * 
	 * @param $id (int) id daneho jidla
	 * @param $jidlo (Jidlo.php) surovina, ktere ma byt pridana
	 * 
	 * Pokud se jidlo v kontejneru nachazi (i s jinym id), je vyhozena
	 * patricna vyjimka (KontejnerException).
	 */
	public function pridejJidlo($id, $jidlo) {
		if (!jeJidloVKontejneru($id, $jidlo) {
			$this->jidla[$id] = $jidlo;
		}
		else {
			throw new KontejnerException('jidlo jiz je v kontejneru');
		}
		$this->zmen();
	}
	
	//TODO co se udela s odebranou surovinou? kam s ni? jak poznam, ze ji mam vymazat?
	public function odeberSurovinu($id) {
		//TODO unset()
	
	
}
