<?php
	session_start();
	//connexion à la base de données
	include('../connexion.php');
	include('../fonctions.php');
	
	if(isset($_SESSION['id']) && $_SESSION['droits']=="admin")
		$mode = "admin";
	else if(isset($_SESSION['id']) && $_SESSION['droits']=="user")
		$mode = "user";
	
?><!DOCTYPE HTML>
<html>
	<head>
		<title>Cuisinez (traitements)</title>
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
						<div class="col-xs-12"><h1><a href="#">Cuisinez</a></h1></div>
						<div class="col-xs-12" style="top:-8px;"><h4><a href="#">(traitements)</a></h4></div>
					</div>
					
					

			</div>
		</div>
	</div>

	<div class="row">	
		<div id="mainadmin" class="row">
<?php
if(isset($_POST['coins'])) // inscription ou connexion
{
	$pseudo = $_POST['pseudo'];
	$pass = md5($_POST['pass']);
	
	//vérification de l'existence de l'utilisateur
	$reqU=$bdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE pseudo=:pseudo AND pass=:pass");
	
	$reqU->execute(array(
	"pseudo"=>$pseudo,
	"pass"=>$pass
	));
	
	$countU=$reqU->fetch();
	
	if($countU[0]<=0)
	{
		//si l'utilisateur n'existe pas on l'inscrit
		
		$insertU=$bdd->prepare("INSERT INTO utilisateur (pseudo,pass) VALUES (:pseudo,:pass)");
	
		$insertU->execute(array(
		"pseudo"=>$pseudo,
		"pass"=>$pass
		));
		
		//puis on le connecte
		
		$id=$bdd->lastInsertId();
		
		$reqU=$bdd->prepare("SELECT droits FROM utilisateur WHERE id=:id");
	
		$reqU->execute(array(
		"id"=>$id
		));
		
		$user=$reqU->fetch();
		
		$_SESSION['id']=$id;
		$_SESSION['droits']=$user['droits'];
		$_SESSION['pseudo']=$pseudo;
		
		echo '<div class="col-xs-12 text-center"><h2>Enregistrement et connexion en cours...</h2></div>';
		echo '<meta http-equiv="refresh" content="3; URL=../index.php">';
		exit;
		
	}
	else
	{
		//sinon on le connecte
		$reqU=$bdd->prepare("SELECT id,droits FROM utilisateur WHERE pseudo=:pseudo AND pass=:pass");
	
		$reqU->execute(array(
		"pseudo"=>$pseudo,
		"pass"=>$pass
		));
		
		$user=$reqU->fetch();
		
		$_SESSION['id']=$user['id'];
		$_SESSION['droits']=$user['droits'];
		$_SESSION['pseudo']=$pseudo;
		
		if($_SESSION['droits']=="admin")
		{
			echo '<div class="col-xs-12 text-center"><h2>Connexion en cours...(admin)</h2></div>';
			echo '<meta http-equiv="refresh" content="3; URL=admin.php">';
		}
		else
		{
			echo '<div class="col-xs-12 text-center"><h2>Connexion en cours...</h2></div>';
			echo '<meta http-equiv="refresh" content="3; URL=../index.php">';
		}
		exit;
	}
}
else if(isset($_GET['deco'])) // déconnexion et retour à la page d'accueil
{
	session_unset();
	session_destroy();
	
	echo '<div class="col-xs-12 text-center"><h2>Déconnexion en cours...</h2></div>';
	echo '<meta http-equiv="refresh" content="3; URL=../index.php">';
	exit;
}
else if(isset ($_POST['ajoutR']))	// ajout d'une nouvelle recette
{
	$ingredients = tableauIngredients($_POST['tabI']);
	$labelR = $_POST['labelR'];
	$temps = $_POST['temps'];
	$description = $_POST['description'];
	
	$reqR = $bdd->query('INSERT INTO recette (label_recette, description_recette, temps_recette, id_auteur)  VALUES ("'.$labelR.'","'.$description.'","'.$temps.'", "'.$_SESSION['id'].'")');
	
	$idR = $bdd->lastInsertId();
	
	foreach($ingredients as $key=>$qte) //utilisation du tableau d'ingrédients
	{
		$reqLR= $bdd->query('INSERT INTO ligne_recette (id_recette, id_ingredient, quantite) VALUES ("'.$idR.'","'.$key.'","'.$qte[0].'")');
	}
	
	echo '<div class="col-xs-12 text-center"><h2 style="color:green;">Recette ajoutée</h2></div>';
	if(isset($_FILES))
	{
		uploadPhoto($idR,$bdd);
	}	
	echo '<meta http-equiv="refresh" content="3; URL='.$mode.'.php">';

}
else if(isset ($_POST['ajoutI'])) // ajout d'un nouvel ingrédient
{
	$labelI = $_POST['labelI'];
	$type = $_POST['type'];
	$reqI = $bdd->query('INSERT INTO ingredient (label_ingredient, type_ingredient)  VALUES ("'.$labelI.'", "'.$type.'")');
		
	echo '<div class="col-xs-12 text-center"><h2 style="color:green;">Ingrédient ajouté</h2></div>';
	echo '<meta http-equiv="refresh" content="3; URL=admin.php?page=ajoutIT">';
}
else if(isset ($_POST['ajoutT'])) // ajout d'un nouveau type d'ingrédient
{
	$labelT = $_POST['labelT'];
	$reqT = $bdd->query('INSERT INTO type_ingredient (label_type_ingredient)  VALUES ("'.$labelT.'")');
	
	echo '<div class="col-xs-12 text-center"><h2 style="color:green;">Type d\'ingrédient ajouté</h2></div>';
	echo '<meta http-equiv="refresh" content="3; URL=admin.php?page=ajoutIT">';
}
else if(isset ($_POST['modifI'])) // modification d'un ingrédient
{
	$labelI = $_POST['labelI'];
	$idI = $_POST['idI'];
	$type = $_POST['type'];
	$reqI = $bdd->query('UPDATE ingredient SET label_ingredient="'.$labelI.'", type_ingredient= "'.$type.'" WHERE id = "'.$idI.'" LIMIT 1');

	echo '<div class="col-xs-12 text-center"><h2 style="color:orange;">Ingrédient modifié</h2></div>';	
	echo '<meta http-equiv="refresh" content="3; URL=admin.php?page=listeIT">';
}
else if(isset ($_POST['modifR'])) // modification d'une recette
{
	$idR = $_POST['idR'];
	$ingredients = tableauIngredients($_POST['tabI']);
	$labelR = $_POST['labelR'];
	$temps = $_POST['temps'];
	$description = $_POST['description'];
	
	// mise a jour de la recette
	$reqR = $bdd->prepare("UPDATE recette SET label_recette=:labelR, temps_recette= :temps, description_recette = :description WHERE id = :id LIMIT 1");
	$reqR->execute(array(
	"labelR"=>$labelR,
	"temps"=>$temps,
	"description"=>$description,
	"id"=>$idR
	));
	
	//suppression des lignes recettes associées avant mise a jour
	$reqDel = $bdd->query('DELETE FROM ligne_recette WHERE id_recette='.$idR.'');
	
	// mise a jour des lignes recettes par insertion
	foreach($ingredients as $key=>$qte) //utilisation du tableau d'ingrédients
	{
		$reqLR= $bdd->query('INSERT INTO ligne_recette (id_recette, id_ingredient, quantite) VALUES ("'.$idR.'","'.$key.'","'.$qte[0].'")');
	}
	
	echo '<div class="col-xs-12 text-center"><h2 style="color:orange;">Recette modifiée</h2></div>';
	
	//mise a jour de la photo
	if(isset($_FILES))
	{
		uploadPhoto($idR,$bdd);
	}	
	
	echo '<meta http-equiv="refresh" content="3; URL='.$mode.'.php">';
}
else if(isset ($_POST['modifT'])) // modification d'un type d'ingrédient
{
	$type = $_POST['type'];
	$labelT = $_POST['labelT'];
	$reqT = $bdd->query('UPDATE type_ingredient SET label_type_ingredient="'.$labelT.'" WHERE id = "'.$type.'" LIMIT 1');
	
	echo '<div class="col-xs-12 text-center"><h2 style="color:orange;">Type d\'ingrédient modifié</h2></div>';
	echo '<meta http-equiv="refresh" content="3; URL=admin.php?page=listeIT">';
}
else if(isset ($_POST['supprI'])) // suppression d'ingrédient
{
	// supprime les lignes_recette associées
	
	$id = $_POST['idI'];
	
	$reqD = $bdd->query('DELETE FROM ingredient WHERE id='.$id.' ');
	
	echo '<div class="col-xs-12 text-center"><h2 style="color:red;">Ingrédient supprimé</h2></div>';
	echo '<meta http-equiv="refresh" content="3; URL=admin.php?page=listeIT">';
}
else if(isset ($_POST['supprR'])) // suppression d'une recette
{
	//supprime les lignes_recette associées
	
	$id = $_POST['id'];
	
	$reqImage = $bdd->query('SELECT image FROM recette WHERE id='.$id.' ');
	$chemin = $reqImage->fetch();
	if(!empty($chemin[0])) unlink("../".$chemin[0]);
	
	$reqD = $bdd->query('DELETE FROM recette WHERE id='.$id.' ');
	
	echo '<div class="col-xs-12 text-center"><h2 style="color:red;">Recette supprimée</h2></div>';
	echo '<meta http-equiv="refresh" content="3; URL='.$mode.'.php?page=listeR">';
	
}
else if(isset ($_POST['supprT'])) // suppression d'un type d'ingrédient
{
	// supprime aussi les ingrédients liés au type + les lignes_recette associées
	
	$id = $_POST['type'];
	
	$reqD = $bdd->query('DELETE FROM type_ingredient WHERE id='.$id.' ');
	
	echo '<div class="col-xs-12 text-center"><h2 style="color:red;">Type d\'ingrédient supprimé</h2></div>';
	echo '<meta http-equiv="refresh" content="3; URL=admin.php?page=listeIT">';
}
else if(isset($_POST['com'])) // ajout d'un commentaire
{
	$idU = $_POST['idU'];
	$idR = $_POST['idR'];
	$contenu = $_POST['contenu'];
	$note = $_POST['note'];
	
	$insertCom = $bdd->prepare("INSERT INTO commentaire (idU, idR, contenu, note) VALUES (:idU, :idR, :contenu, :note)");
	
	$insertCom->execute(array(
	"idU"=>$idU,
	"idR"=>$idR,
	"contenu"=>$contenu,
	"note"=>$note));
	
	echo '<div class="col-xs-12 text-center"><h2 style="color:green;">Commentaire ajouté</h2></div>';
	echo '<meta http-equiv="refresh" content="3; URL=../index.php?page=recette&idRecette='.$idR.'">';
	exit;
}
else 
{
	echo '<div class="col-xs-12 text-center"><h2 style="color:red;">Erreur... retour à la page admin</h2><br></div>';
	echo '<meta http-equiv="refresh" content="3; URL=admin.php">';
}

?>
	</div>	
	
	<div>
			<div id="copyright" class="col-xs-12 col-lg-6 col-lg-offset-3">
				<br>Copyright 2017<br>
			</div>
	</div>
	
</div>		
		
		<script src="../js/jquery-3.2.1.min.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../plugins/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
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