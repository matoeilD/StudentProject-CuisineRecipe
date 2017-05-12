<?php
	// Désactiver le rapport d'erreurs
	error_reporting(0);
	
	$bdd = new PDO('mysql:host=localhost;dbname=cuisinez', 'root', '', array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
	$GLOBAL_RECETTE = array();
	
	// Récupération des derniéres recettes pour l'affichages des derniéres recettes en home.
	
	$sql = "SELECT id, label_recette, description_recette, horodateAjout_recette FROM recette order by horodateAjout_recette limit 0,4";
    foreach  ($bdd->query($sql) as $row) {
		$GLOBAL_RECETTE[$row['id']] = array(
			'titre' => $row['label_recette'],
			'description' => (strlen($row['description_recette']) > 100)? substr($row['description_recette'],0,100)." [...]": $row['description_recette'] ,
			'date' => date('d/m/Y',strtotime($row['horodateAjout_recette']))
		);
	}
	//var_dump($GLOBAL_RECETTE);
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Cuisinez</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
	</head>
	<body class="homepage">

		<!-- Header -->
		<div id="header">
			<div class="container">
				
				<!-- Logo -->
				<div id="logo">
					<h1><a href="index.php">Cuisinez</a></h1>
				</div>
				
				<!-- Nav -->
				<nav id="nav">
					<ul>
						<li  class="active"><a href="index.php">Accueil</a></li>
						<li><a href="ingredient.php">Les Ingrédients</a></li>
						<li><a href="recettes.php">Les Recéttes</a></li>
						<li><a href="lequipe.php">L'équipe</a></li>
					</ul>
				</nav>

			</div>
		</div>
		<!-- Header -->

		<!-- Banner -->
		<div id="banner">
			<div class="container">


			</div>
		</div>
		<!-- /Banner -->
		

		<div id="main">
			<div id="portfolio" class="container">
				<div class="row">
					<?php 
					foreach ($GLOBAL_RECETTE as $key => $recette) {
					?>
						<section class="3u">
							<header>
								<h2><?php echo $recette['titre'] ; ?></h2>
							</header>
							<a href="<?php echo 'recette.php?idRecette='.$key ?>" class="image full"><img src="images/pics<?php echo $key ; ?>.jpg" alt=""></a>
							<p><?php echo $recette['description'] ; ?></p>
							<p>Ajouté le <?php echo $recette['date'] ; ?></p>
							<a href="<?php echo 'recette.php?idRecette='.$key ?>" class="button">Read More</a>
						</section>
					<?php 
					}
					?>
				</div>
			</div>
			
		
		</div>
	
	
		<!-- Copyright -->
		<div id="copyright">
			<div class="container">
				VARGES Marion | TSOUCALAS Christina | ARNOUNI Nesrind | ALIAOUI Aicha 
			</div>
		</div>
	</body>
</html>

