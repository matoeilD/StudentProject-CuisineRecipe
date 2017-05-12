<?php
	error_reporting(0);
	session_start();
	
	if(isset($_SESSION['id']) && $_SESSION['droits']=="admin")
	{

	include('../fonctions.php');

	include('../connexion.php');
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Cuisinez (mode admin)</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
		<script src="../js/jquery-3.2.1.min.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../js/script.js"></script>

	</head>
	<body>
<div class="container-fluid">

	<div class="row">
		<div id="header" class="navbar navbar-fixed-top" >
			<div class="navigation">

					<div id="logo" class="col-xs-6">
						<div class="col-xs-12"><h1><a href="../index.php">Cuisinez</a></h1></div>
						
						<div class="col-xs-12" style="top:-13px;">
							<div class="dropdown col-xs-12">
								<button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['pseudo']; ?> (admin)<span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a href="../index.php">Mode visiteur</a></li>
										<li><a href="traitements.php?deco=ok">Déconnexion</a></li>
									</ul>
							</div>
						</div>
					</div>
					
					<div id="navadmin" class="col-xs-6">

						<div class="dropdown col-xs-12 col-sm-6 col-md-6">
							<button type="button" class="btn btn-danger dropdown-toggle col-xs-12" data-toggle="dropdown">Gestion des recettes <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a href="admin.php?page=ajoutR">Ajouter une recette</a></li>
									<li><a href="admin.php?page=listeR">Liste des recettes</a></li>
								</ul>
						</div>	
								
						<div class="dropdown col-xs-12 col-sm-6 col-md-6">
							<button type="button" class="btn btn-danger dropdown-toggle col-xs-12" data-toggle="dropdown">Gestion des ingrédients <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a href="admin.php?page=ajoutIT">Ajouter un ingrédient/type</a></li>
									<li><a href="admin.php?page=listeIT">Liste des ingrédients/types</a></li>
								</ul>
						</div>			
						
					</div>

			</div>
		</div>
	</div>

	<div class="row">	
		<?php
			if(isset($_GET['page'])) $page=$_GET['page']; else $page= "recettes";
			
			switch ($page) 
			{
				default:
					include('liste-recettes.php');
					break;	
				case "ajoutR":
					include('ajout-recette.php');
					break;
				case "listeR":
					include('liste-recettes.php');
					break;
				case "ajoutIT":
					include('ajout-ingredient-type.php');
					break;
				case "listeIT":
					include('liste-ingredients-types.php');
					break;	
				case "modifRecette":
					include('modif-recette.php');
					break;		
			}
		?>
		<br>
	</div>	
	
		<!-- Copyright -->
	<div class="row">
			<div id="copyright" class="col-xs-12 col-lg-6 col-lg-offset-3">
				<br>Copyright 2017
			</div>
	</div>
	
</div>		

	</body>
</html>
<?php
	}
	else
	{
	?>
		ERREUR
	<?php
	}