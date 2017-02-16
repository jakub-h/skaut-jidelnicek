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
		function nactiTridu($trida) {
			require("tridy/$trida.php");
		}
		spl_autoload_register("nactiTridu");


		/**
		 * Nacteni kontejneru
		 */
		$kontejner = new Kontejner();

		$kontejner->nactiDB();

		$suroviny = $kontejner->getSuroviny();
		$jidla = $kontejner->getJidla();
		$surovinyIds = $kontejner->getSurovinyIds();
		$jidlaIds = $kontejner->getJidlaIds();
		
		/**
		 * Vyber jidla, ktere mame upravit
		 */
		if (!$_GET) {
			echo('<form method="get">Nazev jidla:<select name="id_jidlo">');
			foreach($jidlaIds as $idJidlo) {
				echo('<option value="'.htmlspecialchars($idJidlo).
				'">'.$jidla[$idJidlo].'</option>');
			}
			echo('</select><br />');
			echo('<input type="submit" value="Potvrdit"></form>');
		}
		
		
		 
		else {
			
			/**
			 * Pridani suroviny do databaze.
			 */
			if ($_POST) {
				$kontejner->pridejSurovinuDoReceptu($_POST['id_surovina'],
											$_POST['mnozstvi'], $_GET['id_jidlo']);
				$suroviny = $kontejner->getSuroviny();
				$jidla = $kontejner->getJidla();
				$surovinyIds = $kontejner->getSurovinyIds();
				$jidlaIds = $kontejner->getJidlaIds();
			}
			
			/**
			 * Vypis surovin
			 */
			$nazevJidla = $jidla[$_GET['id_jidlo']];
			echo('<h2>Seznam surovin pro '.$nazevJidla.'</h2>');
			$receptura = $jidla[$_GET['id_jidlo']]->getReceptura();
			$recepturaKeys = array_keys($receptura);
			echo('<table border=1>');
			foreach($recepturaKeys as $idSurovina) {
				echo('<tr><td>'.$suroviny[$idSurovina].'</td>
				<td>'.htmlspecialchars($receptura[$idSurovina]).'</td>
				<td>'.$suroviny[$idSurovina]->getJednotka().'</td>
				<td>'.$suroviny[$idSurovina]->getTyp().'</td></tr>');
			}
			echo('</table>');
			
			/**
			 * Formular pro pridani suroviny.
			 */
			echo('<h2>Pridani suroviny do receptury</h2>');
			echo('<form method="post">Surovina - jednotka:<br /><select name="id_surovina">');
			foreach($surovinyIds as $idSurovina) {
				echo('<option value="'.htmlspecialchars($idSurovina).'">'.
				$suroviny[$idSurovina].' - '.$suroviny[$idSurovina]->getJednotka().
				'</option>');
			}
			echo('</select><br />Mnozstvi: <input type="number" name="mnozstvi">');
			
			echo('<input type="submit" value="Pridat do receptu"></form>');
			
			
		}
		
		?>
	</body>
</html>
