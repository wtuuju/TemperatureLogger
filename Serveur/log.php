<?php
$motdepasse = "azerty";

if (isset($_GET['motdepasse']) && isset($_GET['date']) && isset($_GET['temperature']) && isset($_GET['temperature_2'])) {
	if ($_GET['motdepasse'] == $motdepasse) {
		// On sécurise et enregistre dans la variable $temp_received la temperature reçu
			$temperature = htmlspecialchars($_GET['temperature']);
			$temperature_2 = htmlspecialchars($_GET['temperature_2']);

		// On sécurise et enregistre dans la variable $time_received le timestamp reçu
			$date = htmlspecialchars($_GET['date']);

		// Connexion à la BDD
			$db = 'db.sqlite';
			$table = "temperature_table";
			$base= new SQLite3($db); 

		// Requete pour récupérer le dernier enregistrement
			$requete = "SELECT * FROM $table WHERE ID = (SELECT MAX(ID) FROM $table)";
			
			$resultat = $base->query($requete); 
			while($donnees = $resultat->fetchArray()) {
				$dernierReleve_date = $donnees["date"];
			}

			$differenceTemps = $date - $dernierReleve_date;

			if ($differenceTemps >= 60*5) {
				// Insertion dans la table temperature d'un nouvel enregistrement de temperature
				$requete = "INSERT INTO $table(date, temperature, temperature_2)  VALUES ('$date', '$temperature', '$temperature_2')";
				$execution = $base->exec($requete);
				echo("enregistre");
				http_response_code(200);
			}
			else {
			echo("non enregistree");
			}
	}
	else {
	http_response_code(403);
	}
}
else {
http_response_code(400);
}
?>
