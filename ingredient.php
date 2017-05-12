<?php
	// Désactiver le rapport d'erreurs
	error_reporting(0);
	
	$bdd = new PDO('mysql:host=localhost;dbname=cuisinez', 'root', '', array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
	
	$GLOBAL_INGREDIENTS = array();
	$GLOBAL_RECETTES = array();
	
	// Récupération des ingrédients pour l'affichages.
	
	$sql = "SELECT i.`id`, i.`label_ingredient`, i.`type_ingredient`, ti.label_type_ingredient FROM `ingredient` i left join type_ingredient ti on i.type_ingredient = ti.`id` order by i.`type_ingredient`";
    foreach  ($bdd->query($sql) as $row) {
		$GLOBAL_INGREDIENTS[$row['label_type_ingredient']][] = array(
			'id_ingredient' => $row['id'],
			'label_ingredient' => $row['label_ingredient'],
		);
	}
	
	//var_dump($GLOBAL_INGREDIENTS);

	if(isset($_POST['submit_ingredients_button']) && !empty($_POST['submit_ingredients_button'])){
			
		// Récupération des derniéres recettes pour l'affichages des derniéres recettes en home.
		$ids_recette = "";
		$sql = "SELECT r.id FROM recette r left join ligne_recette lr on r.id = lr.id_recette left join ingredient i on lr.id_ingredient = i.id	WHERE i.id in ('".implode("','",array_keys($_POST['ingredientspost']))."')";
		foreach($bdd->query($sql) as $row) {
			$ids_recette .= "'".$row['id']."',";
		}
		$ids_recette = substr($ids_recette,0,-1);
		$sql = "SELECT id, label_recette, description_recette, horodateAjout_recette FROM recette WHERE id in(".$ids_recette.")";
		foreach($bdd->query($sql) as $row) {
			$GLOBAL_RECETTE[$row['id']] = array(
				'titre' => $row['label_recette'],
				'description' => (strlen($row['description_recette']) > 100)? substr($row['description_recette'],0,100)." [...]": $row['description_recette'] ,
				'date' => date('d/m/Y',strtotime($row['horodateAjout_recette']))
			);
		}
		//var_dump($GLOBAL_RECETTES);
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
						<li class="active"><a href="ingredient.php">Les Ingrédients</a></li>
						<li><a href="recettes.php">Les Recéttes</a></li>
						<li><a href="lequipe.php">L'équipe</a></li>
					</ul>
				</nav>

			</div>
		</div>
		<!-- Header -->
		<div id="main">

			<div class="container">
				<form action="ingredient.php" method="post" name="submit_ingredients">
					<div class="row" style="margin: 0px auto;">
						<?php 
						foreach ($GLOBAL_INGREDIENTS as $type_ingredient => $ingredients) {
						?>
							<section class="3u">
								<header>
									<h2><?php echo $type_ingredient ; ?></h2>
								</header>
								<?php 
								foreach ($ingredients as $key => $ingredient) {
								?>
									<input type="checkbox" name="ingredientspost[<?php echo $ingredient['id_ingredient'] ; ?>]" id="<?php echo $ingredient['id_ingredient'] ; ?>" <?php if(isset($_POST['ingredientspost'][$ingredient['id_ingredient']])) echo "checked=checked"; ?> /><label for="<?php echo $ingredient['id_ingredient'] ; ?>"><?php echo $ingredient['label_ingredient'] ?></label><br />
								<?php 
								}
								?>					
							</section>
						<?php 
						}
						?>
					</div>
					<div class="row" style="margin: 0px auto;">
						<input name="submit_ingredients_button" type="submit" class="button" value="Rechercher les recettes" style="width: 100%;padding: 0.8em 1.5em;">
					</div>
				</form>
				<?php 
				if(isset($GLOBAL_RECETTE) && !empty($GLOBAL_RECETTE) && isset($_POST['submit_ingredients_button']) && !empty($_POST['submit_ingredients_button'])) { 
				?>
					<br />
					<br />
					<div class="row" style="width:1000px;margin: 0px auto;">
						<?php 
						foreach ($GLOBAL_RECETTE as $key => $recette) {
						?>
							<section class="3u">
								<header>
									<h1><?php echo $recette['titre'] ; ?></h1>
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
				<?php 
				}elseif(isset($_POST['submit_ingredients_button']) && !empty($_POST['submit_ingredients_button'])){
				?>
					<div class="row" style="margin: 0px auto;text-align:center;">
						<h1 style="width: 1200px;padding-left: 0px;">Aucune recettes ne correspond aux filtres recherché.</h1>
					</div>
				<?php 
				}
				?>
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

