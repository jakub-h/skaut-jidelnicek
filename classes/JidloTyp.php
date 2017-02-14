<?php

class JidloTyp {
	
	const SNIDANE = 1;
	const SVACINA = 2;
	const OBED = 3;
	const VECERE = 4;
	
	public static function getTyp($number) {
		switch($number) {
			case 1: return $this::SNIDANE;
			case 2: return $this::SVACINA;
			case 3: return $this::OBED;
			case 4: return $this::VECERE;
		}
	}
}
