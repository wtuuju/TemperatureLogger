<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width"/>
		<title>Temperature logger</title>
	</head>
 
	<body>
	<h1>Temperature logger</h1>
	<div>
	<p>
	Période à afficher : <br />
		<form method="post" action="graph.php">
			<input type="radio" name="periode" value="2heures" id="2heures" /> <label for="2heures">2 Dernières heures</label>
			<input type="radio" name="periode" value="jour" id="jour" /> <label for="jour">Jour</label>
			<input type="radio" name="periode" value="semaine" id="semaine" /> <label for="semaine">Semaine</label>
			<input type="radio" name="periode" value="mois" id="mois" /> <label for="mois">Mois</label>
			
			<br /><br />
			
			<label for="periodeperso">Personalisé (heure) : </label><input type="number" name="periodeperso" id="periodeperso" min="0" step="0.5" value="0"/><br />
			<input type="submit" value="Envoyer" />
		</form>
	</p>
	</div>
	<div>
<?php
if (!empty($_POST['periode']) OR !empty($_POST['periodeperso'])) {
	if (!empty($_POST['periode'])) {
		$periode = htmlspecialchars($_POST['periode']);
			
		switch ($periode) { 
    
			case "2heures":
				$periode_secondes = 3600*2;
				$SkipLabel = 0;
			break;
			
			case "jour":
				$periode_secondes = 3600*24;
				$SkipLabel = 3;
			break;   
			
			case "semaine":
				$periode_secondes = 3600*24*7;
				$SkipLabel = 20;
			break;
			
			case "mois":
				$periode_secondes = 3600*24*30;
				$SkipLabel = 50;
			break;
    
			default:
				$periode_secondes = 3600*2;
				$SkipLabel = 0;
		}
	}
	elseif (!empty($_POST['periodeperso'])){
		$periodeperso = htmlspecialchars($_POST['periodeperso']);
		$periode = $periodeperso;
		
		$periode_secondes = $periode * 3600;
		$SkipLabel = 0;
	}
	else {
		$periode = 2;
		$periode_secondes = $periode * 3600;
		$SkipLabel = 0;
	}
}
else {
	$periode = 2;
	$periode_secondes = $periode * 3600;
	$SkipLabel = 0;
}
?>
	<p>Période affiché : <?php echo($periode); ?> (<?php echo($periode_secondes); ?> secondes)<br /></p>
<?php

/* Include all the classes */
include("pChart2.1.3/class/pData.class.php");
include("pChart2.1.3/class/pDraw.class.php");
include("pChart2.1.3/class/pImage.class.php");
 
$myData = new pData();
 
$db = 'db.sqlite';
$table = "temperature_table";
$base= new SQLite3($db); 

// Requête pour récupérer les données
$limite = time() - $periode_secondes;
$requete = "SELECT * FROM $table WHERE date > '$limite'";
$resultat = $base->query($requete);  

// Traitement
$date=""; $temperature="";
while($donnees = $resultat->fetchArray())
{
  $date[] = $donnees["date"];
  $temperature[] = $donnees["temperature"];
}
 
/* Save the data in the pData array */
$myData->addPoints($date,"Timestamp");
$myData->addPoints($temperature,"Temperature");

/* Put the timestamp column on the abscissa axis */
$myData->setAbscissa("Timestamp");

/* Name this axis "Time" */
$myData->setXAxisName("Time");
 
/* Specify that this axis will display time values */
$myData->setXAxisDisplay(AXIS_FORMAT_TIME,"d/m - H:i:s");

/* First Y axis will be dedicated to the temperatures */
$myData->setAxisName(0,"Temperature");
$myData->setAxisUnit(0,"°C");
 
/* Add data in your dataset */
$myData->addPoints($temperature);
 
/* Create a pChart object and associate your dataset */
$myPicture = new pImage(1800,500,$myData);
 
/* Choose a nice font */
$myPicture->setFontProperties(array("FontName"=>"pChart2.1.3/fonts/Forgotte.ttf","FontSize"=>11));
 
/* Define the boundaries of the graph area */
$myPicture->setGraphArea(50,10,1800,400);
 
/* Draw the scale, keep everything automatic */
$myPicture->drawScale(array("XMargin"=>20,"LabelSkip"=>$SkipLabel,"DrawXLines"=>FALSE,"DrawYLines"=>ALL,"GridR"=>0,"GridG"=>0,"GridB"=>255,"GridAlpha"=>50));
 
/* Draw the scale, keep everything automatic */
$myPicture->drawLineChart(array("DisplayValues"=>FALSE));
 
/* Build the PNG file and send it to the web browser */
$myPicture->Render("basic.png");
?>
	<p><img src="basic.png"></p>
	</div>
	</body>
</html>