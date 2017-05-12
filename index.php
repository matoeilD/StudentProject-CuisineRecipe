<?php
	//error_reporting(0);
	session_start();
	//connexion à la base de données
	include('connexion.php');
	include('fonctions.php');
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Cuisinez</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="plugins/jquery-bar-rating/dist/themes/bootstrap-stars.css">

	</head>
	<body>
<div class="container-fluid">

	<div class="row">
		<div id="header" class="navbar navbar-fixed-top" >
			<div class="navigation">

					<div id="logo" class="col-xs-6">
						<div class="col-xs-12"><h1><a href="index.php">Cuisinez</a></h1></div>
						<div class="col-xs-12" style="top:-13px;"><?php 
						if(isset($_SESSION['id']) && $_SESSION['droits']=="admin") 
							echo '	<div class="dropdown col-xs-12">
											<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">'.$_SESSION['pseudo'].' (admin)<span class="caret"></span></button>
												<ul class="dropdown-menu">
													<li><a href="admin/admin.php">Mode admin</a></li>
													<li><a href="admin/traitements.php?deco=ok">Déconnexion</a></li>
												</ul>
										</div> '; 
						else if(isset($_SESSION['id']) && $_SESSION['droits']=="user") 
							echo '<div class="dropdown col-xs-12">
											<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">'.$_SESSION['pseudo'].' <span class="caret"></span></button>
												<ul class="dropdown-menu">
													<li><a href="admin/user.php">Mes recettes</a></li>
													<li><a href="admin/traitements.php?deco=ok">Déconnexion</a></li>
												</ul>
										</div> '; 
						else echo'<h4><a href="index.php?page=identification">Connexion/Inscription</a></h4>'; ?></div>
	
					</div>
					
					<div id="nav" class="col-xs-6">


							<div class=" col-xs-6 col-sm-3 <?php if((isset($_GET['page']) && $_GET['page'] == "accueil") || !isset($_GET['page']))  echo 'active';  ?>"><a href="index.php?page=accueil">Accueil</a></div>
							<div class=" col-xs-6 col-sm-3 <?php if(isset($_GET['page']) && $_GET['page'] == "ingredient")  echo 'active';  ?>"><a href="index.php?page=ingredient">Ingrédients</a></div>
							<div class=" col-xs-6 col-sm-3 <?php if(isset($_GET['page']) && $_GET['page'] == "recettes")  echo 'active';  ?>"><a href="index.php?page=recettes">Recettes</a></div>
							<div class=" col-xs-6 col-sm-3 <?php if(isset($_GET['page']) && $_GET['page'] == "equipe") echo 'active';  ?>"><a href="index.php?page=equipe">L'équipe</a></div>

						
					</div>

			</div>
		</div>
	</div>

	

	<div class="row" id="haut">	
		<?php
			if(isset($_GET['page'])) $page=$_GET['page']; else $page= "";
			
			switch ($page) 
			{
				default:
					echo'<div class="row"><div class="col-xs-12" id="banner"><img  src="images/banner.jpg"></div></div>';
					echo'<div class="row">'; include('accueil.php'); echo '</div>';
					break;	
				case "accueil":
					include('accueil.php');
					break;
				case "ingredient":
					include('ingredient.php');
					break;
				case "recettes":
					include('recettes.php');
					break;
				case "equipe":
					include('lequipe.php');
					break;
				case "recette":
					include('recette.php');
					break;
				case "identification":
					include('identification.php');
					break;
			}
		?>
		<br>
	</div>	
	
	<div>
			<div id="copyright" class="col-xs-12 col-lg-6 col-lg-offset-3">
					Copyright 2017
			</div>
	</div>
	
</div>		
		
		<script src="js/jquery-3.2.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="plugins/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
		<script type="text/javascript">
		   $(function() {
			  $('#note').barrating({
				theme: 'bootstrap-stars'
			  });
			  
			  $('.noteRO').barrating({
				theme: 'bootstrap-stars',
				readonly:true
			  });
		   });
		</script>

	</body>
</html>

