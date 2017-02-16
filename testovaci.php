<?php

mb_internal_encoding("UTF-8");

function nactiTridu($trida) {
	require("tridy/$trida.php");
}

spl_autoload_register("nactiTridu");

$kontejner = new Kontejner();

$kontejner->nactiDB();

$suroviny = $kontejner->getSuroviny();
$jidla = $kontejner->getJidla();

foreach($jidla as $jidlo) {
	echo($jidlo.' -- ');
	$typy = $jidlo->getTyp();
	foreach($typy as $typ) {
		echo(JidloTyp::getTyp($typ).' ');
	}
	$surovinyIds = array_keys($jidlo->getReceptura());
	echo('<table border=1>');
	foreach($surovinyIds as $idSurovina) {
		echo ('<tr><td>'.$suroviny[$idSurovina].'</td><td>'.
				$jidlo->getReceptura()[$idSurovina].'</td><td>'.
				$suroviny[$idSurovina]->getJednotka().'</td><td>'.
				$suroviny[$idSurovina]->getTyp().'</td></tr>');
	}
	echo('</table>');
}
echo('<br /><br />');

foreach($suroviny as $surovina) {
	echo($surovina.'<br />');
}
/*
$receptura = array(1 => 4000, 2 => 2, 3 => 2000, 4 => 5, 5 => 200, 6 => 1, 7 => 1);
$brgul = new Jidlo('Bramborový guláš', $receptura, array(3, 4));
$kontejner->pridejJidloDoDB($brgul);

/*
2000g tocenak 3
4000g brambory 1
2ks chleba 2
1ks koreni cervena paprika 7
5ks cibule 4
1ks koreni majoranka 6
200g mouka 5
*/


