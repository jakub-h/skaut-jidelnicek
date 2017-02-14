<!DOCTYPE html>
<html lang="cs-cz">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Skautsky jidelnicek</title>	
	</head>
	<body>
		<?php
		mb_internal_encoding("UTF-8");
		
		function importClass($class) {
			require("classes/$class.php");
		}
		
		spl_autoload_register("importClass");
	
		Db::connect('127.0.0.1', 'skautsky_jidelnicek', 'root', '1234');
		
		$kontejner = new Kontejner();

		$kontejner->nactiDB();

		foreach($kontejner->getJidla() as $jidlo) {
			echo($jidlo);
			echo($jidlo->getReceptura());
		}

		foreach($kontejner->getSuroviny() as $surovina) {
			echo($surovina);
		}
		
		?>
	
	</body>









</html>
