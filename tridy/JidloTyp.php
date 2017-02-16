<?php

class JidloTyp {
	
	const SNIDANE = 1;
	const SVACINA = 2;
	const OBED = 3;
	const VECERE = 4;
	
	public static function getTyp($number) {
		switch($number) {
			case 1: return self::SNIDANE;
			case 2: return self::SVACINA;
			case 3: return self::OBED;
			case 4: return self::VECERE;
		}
	}
}
