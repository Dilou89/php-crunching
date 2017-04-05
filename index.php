<!DOCTYPE html>
<html>
<head>
	<title>Dictionnaire</title>
</head>
<body>
	<?php 
	$string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
	$dico = explode("\n", $string);
	"<br/>";


//nombre de mots
	echo "le nombre de mots est :".count($dico)."<br/>";
	$count = 0;
	foreach($dico as $key => $value){
		$str=strlen($value)."<br/>";
		if($str==15){
			$count++;
		}
	}

	echo "le nombre de mots de 15 caractères est = ".$count."<br/>";
// nombre de mots contenant w :

	$count=0;
	foreach($dico as $value){
		$find="w";
		$pos = strpos($value, $find);
		if($pos===false){		
		}
		else{
			$count++;
		}
	}

	echo "le nombre de mots de contenant w = ".$count."<br/>";

//Combien de mots finissent par la lettre « q » ?

	$count = 0;
	foreach($dico as $value){

		if($value{strlen($value)-1}==="q"){
			$count++;}

		}
		echo "le nombre de mots se terminant par q = ".$count;
		echo"<hr>";
// 	Les Films

		$string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
		$brut = json_decode($string, true);
	$top = $brut["feed"]["entry"]; # liste de films $top;
	$count=0;



	echo "<h3>Le top des 10</h3>";
	for($i=1; $i<=10; $i++){ 
		$titre = $top[$i]["im:name"]["label"];
		echo $i.' '.$titre."<br/>";	
	}
//Quel est le classement du film « Gravity » ?
	for($i=0; $i<=100; $i++){
		$class=$top[$i]["im:name"]["label"];
		if($class==='Gravity'){
			echo "<h3>le classement de Gravity est : ".$i. "</h3>";
		}
	}
//Quel est le réalisateur du film « The LEGO Movie » ?
	for($i=0; $i<=100; $i++){
		$titre=$top[$i]["im:name"]["label"];
		if($titre=="The LEGO Movie"){
			echo "<h3>Le réalisateur de The Logo Movie est : ".$top[$i]["im:artist"]["label"]."</h3>";
		}
	}
 //Combien de films sont sortis avant 2000 ?
	for ($i=0; $i <=100 ; $i++){ 

		$date=$top[$i]["im:releaseDate"]["label"];
		if(date_parse($date)['year']<2000){
			$count++;
		}

	}
	echo "<h3>le nombre de film avant 2000 :".$count."</h3>";



	$toptri = $top;
	function comp($a, $b) {
		if ($a['im:releaseDate']['label'] == $b['im:releaseDate']['label']) {
			return 0;
		}
		return ($a['im:releaseDate']['label'] < $b['im:releaseDate']['label']) ? -1 : 1;
	}

	usort($toptri, "comp");
	echo "<h3> le film le plus ancien est ".$toptri[0]['im:name']['label']. "</h3>";
	echo "<h3>le film plus récent est ".$toptri[count($toptri)-1]['im:name']['label']."</h3>";
	

	echo"<hr>";
	$listcat = array();
	foreach ($top as $key => $film) {
		$cat=$film['category']['attributes']['label'];
		array_push($listcat, $cat);
		
	}
	$valeur = array_count_values($listcat);
	echo "la catégorie la plus représentée dans le top est: ";
	print_r(array_keys($valeur, max($valeur)))."</br></br>";

	
	echo"<hr>";
	echo"<h3>Quel est le réalisateur le plus présent dans le top100 ? </br></h3>";

	$listreal = array();
	foreach ($top as $key=>$name) {
		$real=$name['im:artist']['label'];
		array_push($listreal, $real);
		// var_dump($listreal);

	}
	$valeur = array_count_values($listreal);

	print_r(array_keys($valeur, max($valeur)));
	echo"<hr>";
	echo"<h3>Combien cela coûterait-il d'acheter le top10 sur iTunes ? de le louer ? </br></h3>";

	$pricetop10=array();
	$top10=array_slice($top, 1, 10);
	foreach ($top10 as $key => $price) {
		$price = $film["im:price"]["attributes"]['amount'];
		array_push($pricetop10, $price);
		
	}
	echo "Cout d'achat des films sur itunes = " . array_sum($pricetop10) . "\n€";
	echo"<hr>";
	echo"<h3>Quel est le mois ayant vu le plus de sorties au cinéma ?</br></h3>";

	$dateSort=array();
	for ($i=1; $i <=100 ; $i++) { 
		$sorti=$top[$i]["im:releaseDate"]['label'];
		//var_dump($sorti);
		array_push($dateSort, date_parse($sorti)["month"]);
	}
	//var_dump($dateSort);
	
	sort($dateSort);
	echo"Le mois où il y a eu le plus de sorties est :";
	print_r(end($dateSort));

	?>


</body>
</html>