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
		
		/**
		 * Pripojeni se k databazi
		 */
		Db::connect('127.0.0.1', 'skautsky_jidelnicek', 'root', '1234');
		
		/**
		 * Vyber jidla, ktere mame upravit
		 */
		if (!$_GET) {
			$jidla = Db::queryAll('SELECT * FROM jidlo');
			echo('<form method="get">Nazev jidla:<select name="id_jidlo">');
			foreach($jidla as $jidlo) {
				echo('<option value="'.htmlspecialchars($jidlo['id_jidlo']).
				'">'.htmlspecialchars($jidlo['nazev']).'</option>');
			}
			echo('</select><br />');
			echo('<input type="submit" value="Potvrdit"></form>');
		}
		
		
		 
		else {
			
			/**
			 * Vypis surovin
			 */
			$nazevJidla = Db::querySingle('
				SELECT nazev
				FROM jidlo
				WHERE id_jidlo = ?', $_GET['id_jidlo']);
			echo('<h2>Seznam surovin pro '.$nazevJidla.'</h2><table border="1">');
			$suroviny = Db::queryAll('
				SELECT id_surovina, mnozstvi
				FROM receptura
				WHERE id_jidlo = ?', $_GET['id_jidlo']);
			foreach($suroviny as $surovina) {
				$nazev = Db::querySingle('
					SELECT nazev
					FROM surovina
					WHERE id_surovina = ?', $surovina['id_surovina']);
				echo('<tr><td>'.htmlspecialchars($nazev).'</td>');
				echo('<td>'.htmlspecialchars($surovina['mnozstvi']).'</td>');
				echo('</tr>');
			}
			echo('</table>');
			
			echo('<h2>Pridani suroviny do seznamu</h2>');
			echo('<form method="post"><select name="surovina_nazev">');
			$vsechnySuroviny = Db::queryAll('SELECT * FROM surovina');
			foreach($vsechnySuroviny as $surovina) {
				echo('<option value="'.htmlspecialchars($surovina['id_surovina']).
				'">'.htmlspecialchars($surovina['nazev']).'</option>');
			}	
			echo('</select></form>');
		}
		
		?>
	</body>
</html>
