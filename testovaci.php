<?php

mb_internal_encoding("UTF-8");

function nactiTridu($trida) {
	require("tridy/$trida.php");
}

spl_autoload_register("nactiTridu");

$kontejner = new Kontejner();

$kontejner->nactiDB();

foreach($kontejner->getJidla() as $jidlo) {
	echo($jidlo);
	echo($jidlo->getReceptura());
}

foreach($kontejner->getSuroviny() as $surovina) {
	echo($surovina);
}


