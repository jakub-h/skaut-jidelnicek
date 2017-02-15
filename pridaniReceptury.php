<!DOCTYPE html>
<html lang="cs-cz">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Uprava receptury</title>
	</head>
	
	<body>
		<h1>Uprava receptury v databazi</h1>
		
		<?php
		/**
		 * Import knihoven
		 */
		mb_internal_encoding("UTF-8");
		function importClass($class) {
			require("classes/$class.php");
		}
		spl_autoload_register("importClass");

		$kontejner = new Kontejner();

		$kontejner->nactiDB();

		$suroviny = $kontejner->getSuroviny();
		$jidla = $kontejner->getJidla();
		$surovinyIds = array_keys($suroviny);
		$jidlaIds = array_keys($jidla);
		
		/**
		 * Vyber jidla, ktere mame upravit
		 */
		if (!$_GET) {
			echo('<form method="get">Nazev jidla:<select name="id_jidlo">');
			foreach($jidlaIds as $idJidlo) {
				echo('<option value="'.htmlspecialchars($idJidlo).
				'">'.htmlspecialchars($jidla[$idJidlo]).'</option>');
			}
			echo('</select><br />');
			echo('<input type="submit" value="Potvrdit"></form>');
		}
		
		
		 
		else {
			
			/**
			 * Vypis surovin
			 */
			$nazevJidla = $jidla[$_GET['id_jidlo']]->getNazev();
			echo('<h2>Seznam surovin pro '.$nazevJidla.'</h2>');
			$receptura = $jidla[$_GET['id_jidlo']]->getReceptura();
			$recepturaKeys = array_keys($receptura);
			echo('<table border=1>');
			foreach($recepturaKeys as $idSurovina) {
				echo('<tr><td>'.$suroviny[$idSurovina]->getNazev().'</td>
				<td>'.htmlspecialchars($receptura[$idSurovina]).'</td>
				<td>'.$suroviny[$idSurovina]->getJednotka().'</td>
				<td>'.$suroviny[$idSurovina]->getTyp().'</td></tr>');
			}
			echo('</table>');
			/*
			echo('<h2>Pridani suroviny do seznamu</h2>');
			echo('<form method="post"><select name="surovina_nazev">');
			foreach($suroviny as $surovina) {
				echo('<option value="'..
				'">'.htmlspecialchars($surovina['nazev']).'</option>');
			}	
			echo('</select></form>');
			*/
		}
		
		?>
	</body>
</html>
