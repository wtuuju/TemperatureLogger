<?php
$password = "motdepasse";

if (isset($_GET['password']) && isset($_GET['temperature']) && isset($_GET['time'])) {
	if ($_GET['password'] == $password) {
		// On sécurise et enregistre dans la variable $temp_received la temperature reçu
			$temp_received = htmlspecialchars($_GET['temperature']);
		// On sécurise et enregistre dans la variable $time_received le timestamp reçu
			$time_received = htmlspecialchars($_GET['time']);
				
		// Connexion à la BDD
			$db = 'db.sqlite';
			$table = "temperature_table";
			$base= new SQLite3($db); 
				
		// Requete pour récupérer le dernier enregistrement
			$requete = "SELECT * FROM $table WHERE ID = (SELECT MAX(ID) FROM $table)";
			
			$resultat = $base->query($requete); 
			while($donnees = $resultat->fetchArray()) {
				$dernierReleve_date = $donnees["date"];
				$dernierReleve_temperature = $donnees["temperature"];
			}
		
			$differenceTemperature = $dernierReleve_temperature - $temp_received;
			$differenceTemps = $time_received - $dernierReleve_date;
			echo('difference : ' . $differenceTemperature . '<br />');
			
			if ( $differenceTemps >= 60*15 || $differenceTemperature >= 0.5 || $differenceTemperature <= -0.5) {
				// Insertion dans la table temperature d'un nouvel enregistrement de temperature
				$requete = "INSERT INTO $table(temperature, date)  VALUES ('$temp_received', '$time_received')";
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