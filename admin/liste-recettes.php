<?php

$GLOBAL_RECETTE = array();

	// Récupération des derniéres recettes pour listing et modif/suppr
	
	if($_SESSION['droits']=="admin")
	{
		$sql = "SELECT id, label_recette, image, date FROM recette order by date DESC";
		foreach  ($bdd->query($sql) as $row) 
		{
			$GLOBAL_RECETTE[$row['id']] = array(
				'titre' => $row['label_recette'],
				'image' => $row['image']);
		}
		
		$mode = "admin";
	}
	elseif($_SESSION['droits']=="user")
	{
		$sql = "SELECT id, label_recette, image, date FROM recette WHERE id_auteur=".$_SESSION['id']." ORDER BY date DESC";
		foreach  ($bdd->query($sql) as $row) 
		{
			$GLOBAL_RECETTE[$row['id']] = array(
				'titre' => $row['label_recette'],
				'image' => $row['image']);
		}
		
		$mode = "user";
	}
	
?>

<div class="col-xs-12" id="mainadmin">
		
			<?php if(empty($GLOBAL_RECETTE))
							echo '<h2>Vous n\'avez aucune recette pour le moment</h2>';
						else
				foreach ($GLOBAL_RECETTE as $key => $recette) { ?>
			<div class="col-xs-6 col-sm-3 recetteadmin">
			<form id="suppR" class="form-group" method="post" action="traitements.php">
				<div class="col-xs-12">
					<header>
						<h3><?php echo $recette['titre'] ; ?></h3>
					</header>
					<div class="col-xs-12"><img src="../<?php echo $recette['image'] ;?>" alt=""></div>
				</div>

				
				<div class="col-xs-12">
					<br><button class="col-xs-12 btn btn-warning" type="button" name="modifRecette"onclick="window.open('<?php echo $mode; ?>.php?page=modifRecette&id=<?php echo $key; ?>', '_self')">Modifier</button>
					<br><br><button class="col-xs-12 btn btn-danger" type="submit" name="supprR" onclick="return confirm('La recette sera supprimée, continuer ?')">Supprimer</button>
				</div>
				<input type="hidden" name="id" value="<?php echo $key; ?>">
			</form>
			</div>
			<?php } ?>
			
</div>