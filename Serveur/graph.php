<!doctype html>
<html>
	<head>
		<title>TemperatureLogger</title>
		<script src="Chart.js"></script>
	</head>
	<body>
		<div>
		<h2>TemperatureLogger</h2>
			<canvas id="canvas" height="200px" width="900px"></canvas>
		</div>
<?php
$db = 'db.sqlite';
$table = "temperature_table";
$base= new SQLite3($db); 

// Requête pour récupérer les données
$requete = "SELECT * FROM $table";
$resultat = $base->query($requete);  

// Traitement
$date=""; $temperature=""; $temperature_2="";
while($donnees = $resultat->fetchArray())
{
  $date[] = $donnees["date"];
  $temperature[] = $donnees["temperature"];
  $temperature_2[] = $donnees["temperature_2"];
}
 
?>
	<script>
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
		var lineChartData = {
			labels : [<?php foreach($date as $afficher_date) { $afficher_date2 = date("d-m H:i:s", $afficher_date); echo('"'.$afficher_date2 .'",');} ?>],
			datasets : [
				{
					label: "Temperature",
					fillColor : "rgba(151,187,205,0.2)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : [<?php foreach($temperature as $afficher_temperature) { echo($afficher_temperature .',');} ?>]
				},
				{
					label: "Temperature_2",
					fillColor: "rgba(220,220,220,0.2)",
					strokeColor: "rgba(220,220,220,1)",
					pointColor: "rgba(220,220,220,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(220,220,220,1)",
					data: [<?php foreach($temperature_2 as $afficher_temperature) { echo($afficher_temperature .',');} ?>]
				}
			]

		}

	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
	}
	</script>
	</body>
</html>
