<?php

mb_internal_encoding("UTF-8");

function nactiTridu($trida) {
	require("classes/$trida.php");
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
		echo(JidloTyp::getTyp($typ['id_typ']).' ');
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

$mrkev = new Surovina('mrkev', 'ks', 'zelenina', true);
$paprika = new Surovina('červená paprika', 'ks', 'koření', true);
echo($kontejner->pridejSurovinu($kontejner->surovinyMaxId() + 1, $mrkev));

$kontejner->zapisDoDB();



