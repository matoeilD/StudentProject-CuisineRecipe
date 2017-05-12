<?php
	// Désactiver le rapport d'erreurs
	error_reporting(0);
	
	if(isset($_GET['idRecette']) && !empty($_GET['idRecette'])){
	
		$bdd = new PDO('mysql:host=localhost;dbname=cuisinez', 'root', '', array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
		
		$GLOBAL_RECETTE = array();
		
		// Récupération des derniéres recettes pour l'affichages des derniéres recettes en home.
		
		$sql = "SELECT id , label_recette, temps_recette, description_recette, horodateAjout_recette FROM recette WHERE id = '".$_GET['idRecette']."'";
		
		foreach($bdd->query($sql) as $row) {
			$GLOBAL_RECETTE = array(
				'id' => $row['id'],
				'titre' => $row['label_recette'],
				'description' => $row['description_recette'],
				'temps' => $row['temps_recette'],
				'date' => date('d/m/Y',strtotime($row['horodateAjout_recette'])),
				'ingredients' => array()
			);
			
			$sql = "SELECT lr.quantite, i.label_ingredient FROM recette r left join ligne_recette lr on r.id = lr.id_recette left join ingredient i on lr.id_ingredient = i.id WHERE r.id = '".$GLOBAL_RECETTE['id']."'";
			
			foreach($bdd->query($sql) as $row) {
				$GLOBAL_RECETTE['ingredients'][] = array(
					'quantite' => $row['quantite'],
					'label_ingredient' => $row['label_ingredient']
				);
			}
		}
		//var_dump($GLOBAL_RECETTE);
	}else{
		header('Location: index.php'); 
	}
	
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
						<li><a href="index.php">Accueil</a></li>
						<li><a href="ingredient.php">Les Ingrédients</a></li>
						<li><a href="recettes.php">Les Recéttes</a></li>
						<li><a href="lequipe.php">L'équipe</a></li>
					</ul>
				</nav>

			</div>
		</div>
		<!-- Header -->

		<!-- Main -->
		<div id="main">
			<!-- Welcome -->		
			<div id="welcome" class="container">
				<div class="row">
					<div id="sidebar" class="3u">
						<section>
							<a href="#" class="image full"><img src="images/pics<?php echo $GLOBAL_RECETTE['id'] ; ?>.jpg" alt=""></a>
							<header>
								<h2>Ingrédients :</h2>
							</header>
							<?php 
							foreach($GLOBAL_RECETTE['ingredients'] as $key => $ingredient) { 
							?>
								<span><?php echo $ingredient['quantite']." - ".$ingredient['label_ingredient'];?></span><br />
							<?php 
							}
							?>
						</section>
					</div>
					
					<div id="content" class="9u skel-cell-important">
						<section>
							<header>
								<h2><?php echo $GLOBAL_RECETTE['titre'] ; ?></h2>
							</header>
							<p><?php echo $GLOBAL_RECETTE['description'] ; ?></p>
						</section>
					</div>
					
				</div>
			</div>
			<!-- /Welcome -->
			
		</div>


		<!-- Copyright -->
		<div id="copyright">
			<div class="container">
				VARGES Marion | TSOUCALAS Christina | ARNOUNI Nesrind | ALIAOUI Aicha 
			</div>
		</div>
	</body>
</html>
