<?php

require_once('Surovina.php');
require_once('Db.php');
require_once('Jidlo.php');

/**
 * Pomocna trida pro manipulaci s jidly a surovinami.
 * 
 * Udrzuje 'kopii' databaze ulozenou v objektech. Nabizi zakladni funkce
 * pro manipulaci s nimi. Vzdy pri pridani suroviny se rovnou ulozi do DB
 * a kontejner se aktualizuje. Je to sice docela neefektivni, ale neocekavam
 * prilis mnoho dat.
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
	 * Vrati vsechna id surovin
	 */
	public function getSurovinyIds() {
		return array_keys($this->suroviny);
	}
	
	/**
	 * Vrati vsechna id jidel
	 */
	public function getJidlaIds() {
		return array_keys($this->jidla);
	}
	
	/**
	 * Vrati nejvyssi id, ktere je aktualne pouzito pro nejakou surovinu.
	 * 
	 * Nenahlizi do databaze, pouze do kontejneru (mel by byt aktualni).
	 */
	public function surovinyMaxId() {
		return max($this->vratSurovinyIds());
	}
	
	/**
	 * Vrati nejvyssi id, ktere je aktualne pouzito pro nejake jidlo.
	 * 
	 * Nenahlizi do databaze, pouze do kontejneru (mel by byt aktualni).
	 */
	public function jidlaMaxId() {
		return max($this->vratJidlaIds());
	}
	
	/**
	 * Prida nove vytvorenou surovinu do DB a aktualizuje kontejner.
	 * 
	 */
	public function pridejSurovinuDoDB($surovina) {
		Db::insert('surovina', array(
					'nazev' => $surovina->getNazev(),
					'jednotka' => $surovina->getJednotka(),
					'typ' => $surovina->getTyp()));
		$this->nactiDB();
	}
	
	/**
	 * Prida nove vytvorene jidlo do DB a aktualizuje kontejner.
	 * 
	 */
	public function pridejJidloDoDB($jidlo) {
		Db::insert('jidlo', array(
					'nazev' => $jidlo->getNazev()));
		$idJidlo = Db::querySingle('
								SELECT id_jidlo
								FROM jidlo
								WHERE nazev = ?', $jidlo->getNazev());
		foreach($jidlo->getTyp() as $typ) {
			Db::insert('jidlo_typ', array(
						'id_jidlo' => $idJidlo,
						'id_typ' => $typ));
		}
		$surovinyIds = array_keys($jidlo->getReceptura());
		foreach($surovinyIds as $idSurovina) {
			Db::insert('receptura', array(
						'id_jidlo' => $idJidlo,
						'id_surovina' => $idSurovina,
						'mnozstvi' => $jidlo->getReceptura()[$idSurovina]));
		}
		$this->nactiDB();
	}
	
	/**
	 * Do prida surovinu do receptury jidla. Lze pouzit i pro modifikaci
	 * mnozstvi.
	 * 
	 * - $idSurovina (int) - id suroviny, ktera ma byt pridana
	 * - $mnozstvi (int) - mnozstvi suroviny v receptu
	 * - $idJidlo (int) - id jidla, jehoz receptura je upravovana
	 */
	public function pridejSurovinuDoReceptu($idSurovina, $mnozstvi, $idJidlo) {
		Db::insert('receptura', array('id_jidlo' => $idJidlo,
									'id_surovina' => $idSurovina,
									'mnozstvi' => $mnozstvi));
		$this->nactiDB();
	}
	
	/**
	 * Odebere surovinu z receptury daneho jidla.
	 * 
	 * Po upraveni databaze aktualizuje kontejner.
	 */
	public function odeberSurovinuZReceptu($idSurovina, $idJidlo) {
		$pocet = Db::query('DELETE FROM receptura
							WHERE id_surovina = ? AND id_jidlo = ?',
							$idSurovina, $idJidlo);
		if ($pocet == 0) {
			return 'nebyl ovlivnen zadny radek';
		}
		if ($pocet != 1) {
			return 'mozna nastala chyba: bylo ovlivneno moc radku';
		}
		$this->nactiDB();
	}
		
	/**
	 * Nacte do kontejneru aktualni stav databaze.
	 * 
	 */
	public function nactiDB() {
		Db::connect('127.0.0.1', 'skaut_jidelnicek', 'root', '1234');
		
		$surovinyDB = Db::queryAll('SELECT * FROM surovina');
		foreach($surovinyDB as $surovinaDB) {
			$surovina = new Surovina($surovinaDB['nazev'], $surovinaDB['jednotka'],
									$surovinaDB['typ']);
			$this->suroviny[$surovinaDB['id_surovina']] = $surovina;

		}
		
		$jidlaDB = Db::queryAll('SELECT * FROM jidlo');
		foreach($jidlaDB as $jidloDB) {
			$jidloTypDb = Db::queryAll('
							SELECT id_typ
							FROM jidlo_typ
							WHERE id_jidlo = ?', $jidloDB['id_jidlo']);
			$jidloTyp = array();
			foreach($jidloTypDb as $typ) {
				$jidloTyp[] = $typ['id_typ'];
			}
			$recepturaDB = Db::queryAll('
							SELECT id_surovina, mnozstvi
							FROM receptura
							WHERE id_jidlo = ?', $jidloDB['id_jidlo']);
			$recepturaKont = array();
			foreach($recepturaDB as $surovinaRec) {
				$recepturaKont[$surovinaRec['id_surovina']] = $surovinaRec['mnozstvi'];
			}
			$jidlo = new Jidlo($jidloDB['nazev'], $recepturaKont, $jidloTyp);
			$this->jidla[$jidloDB['id_jidlo']] = $jidlo;
		}
	}
}
