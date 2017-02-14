<?php

require_once('Surovina.php');
require_once('Db.php');
require_once('Jidlo.php');
require_once('KontejnerException.php');
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
	 * Bezparametricky konstruktor.
	 * 
	 * $suroviny a $jidla jsou prazdna pole.
	 * - klice jsou jednotlive id
	 * - hodnoty jsou konkretni instance objektu
	 */
	public function __construct() {
		$this->suroviny = array();
		$this->jidla = array();
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
	
	public function surovinyMaxId() {
		return max(array_keys($this->suroviny));
	}
	
	public function jidlaMaxId() {
		return max(array_keys($this->jidla));
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
		$test = $this->jeSurovinaVKontejneru($id, $surovina);
		if (!$test) {
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
	 * @param $jidlo (Jidlo.php) jidlo, ktere ma byt pridano
	 * 
	 * Pokud se jidlo v kontejneru nachazi (i s jinym id), je vyhozena
	 * patricna vyjimka (KontejnerException).
	 */
	public function pridejJidlo($id, $jidlo) {
		if (!$this->jeJidloVKontejneru($id, $jidlo)) {
			$this->jidla[$id] = $jidlo;
		}
		else {
			throw new KontejnerException('jidlo jiz je v kontejneru');
		}
		$this->zmen();
	}
	
	
	public function odeberSurovinu($id) {
		unset($this->suroviny[$id]);
		$this->zmen();
	}
	
	public function odeberSurovinuZJidla($idSur, $idJidlo) {
		unset($this->jidla[$idJidlo]->receptura[$idSur]);
		$this->zmen();
	}
	
	public function upravRecepturu($idJidlo, $mnozstvi, $idSur) {
		$this->jidla->receptura[$idSur] = $mnozstvi;
		$this->zmen();
	}
	
	public function nactiDB() {
		Db::connect('127.0.0.1', 'skautsky_jidelnicek', 'root', '1234');
		
		$surovinyDB = Db::queryAll('SELECT * FROM surovina');
		foreach($surovinyDB as $surovinaDB) {
			$surovina = new Surovina($surovinaDB['nazev'], $surovinaDB['jednotka'],
									$surovinaDB['typ'], false);
			try {
				$this->pridejSurovinu($surovinaDB['id_surovina'], $surovina);
				$this->zmena = false;
			} catch (KontejnerException $e) {
				echo ('chyba: surovina jiz je v kontejneru s jinym id');
			}
		}
		
		$jidlaDB = Db::queryAll('SELECT * FROM jidlo');
		foreach($jidlaDB as $jidloDB) {
			$jidloTyp = Db::queryAll('
							SELECT id_typ
							FROM jidlo_typ
							WHERE id_jidlo = ?', $jidloDB['id_jidlo']);
			$recepturaDB = Db::queryAll('
							SELECT id_surovina, mnozstvi
							FROM receptura
							WHERE id_jidlo = ?', $jidloDB['id_jidlo']);
			$recepturaKont = array();
			foreach($recepturaDB as $surovinaRec) {
				$recepturaKont[$surovinaRec['id_surovina']] = $surovinaRec['mnozstvi'];
			}
			$jidlo = new Jidlo($jidloDB['nazev'], $recepturaKont, $jidloTyp, false);
			$this->pridejJidlo($jidloDB['id_jidlo'], $jidlo);
		}
	}
	
	public function zapisDoDB() {
		if (!$this->jeZmena()) {
			return false;
		}
		
		Db::connect('127.0.0.1', 'skautsky_jidelnicek', 'root', '1234');
		Db::query('DELETE FROM receptura');
		Db::query('DELETE FROM jidlo_typ');
		Db::query('DELETE FROM surovina');
		Db::query('DELETE FROM jidlo');
		
		$surovinyIds = array_keys($this->suroviny);
		foreach($surovinyIds as $idSurovina) {
			Db::insert('surovina', array(
					'id_surovina' => $idSurovina,
					'nazev' => $this->suroviny[$idSurovina]->getNazev(),
					'jednotka' => $this->suroviny[$idSurovina]->getJednotka(),
					'typ' => $this->suroviny[$idSurovina]->getTyp()));
		}
		
		$jidlaIds = array_keys($this->jidla);
		foreach($jidlaIds as $idJidlo) {
			Db::insert('jidlo', array(
					'id_jidlo' => $idJidlo,
					'nazev' => $this->jidla[$idJidlo]->getNazev()));
			foreach($this->jidla[$idJidlo]->getTyp() as $idTyp) {
				Db::insert('jidlo_typ', array(
					'id_jidlo' => $idJidlo,
					'id_typ' => $idTyp));
			}	
			$surovinyRecIds = array_keys($this->jidla[$idJidlo]->getReceptura());
			foreach($surovinyRecIds as $idSurovina) {
				Db::insert('receptura', array(
					'id_jidlo' => $idJidlo,
					'id_surovina' => $idSurovina,
					'mnozstvi' => $this->jidla[$idJidlo]->getReceptura()[$idSurovina]));
			}
		}
		return true;
	}
}
