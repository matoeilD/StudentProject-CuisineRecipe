<?php

	$GLOBAL_INGREDIENTS = array();
	$GLOBAL_RECETTE = array();
	
	$sql = "SELECT i.id, label_ingredient, type_ingredient, label_type_ingredient FROM ingredient i left join type_ingredient ti on type_ingredient = ti.id order by type_ingredient, label_ingredient";
	$results_I = $bdd->query($sql) ;
	$ingredients = $results_I->fetchAll();
	
    foreach  ($ingredients as $row) 
	{
		$GLOBAL_INGREDIENTS[$row['label_type_ingredient']][] = array(
			'id_ingredient' => $row['id'],
			'label_ingredient' => $row['label_ingredient']);
	}
	
	$idR = $_GET['id'];
	
	$sql = "SELECT r.id , label_recette, temps_recette, description_recette, date, image, pseudo FROM recette r LEFT JOIN utilisateur u ON id_auteur=u.id WHERE r.id = ".$idR."";
		
	foreach($bdd->query($sql) as $row) 
	{
		$GLOBAL_RECETTE = array(
			'id' => $row['id'],
			'titre' => $row['label_recette'],
			'description' => $row['description_recette'],
			'temps' => $row['temps_recette'],
			'date' => date('d/m/Y',strtotime($row['date'])),
			'ingredients' => array(),
			'image'=>$row['image'],
			'auteur'=>$row['pseudo']
			);
	}
		//requete pour les ingrédeints de la recette
		
		$sql = "SELECT lr.quantite, i.label_ingredient FROM recette r left join ligne_recette lr on r.id = lr.id_recette left join ingredient i on lr.id_ingredient = i.id WHERE r.id = '".$GLOBAL_RECETTE['id']."'";
		
		foreach($bdd->query($sql) as $row) 
		{
			$GLOBAL_RECETTE['ingredients'][] = array(
				'quantite' => $row['quantite'],
				'label_ingredient' => $row['label_ingredient']
			);
		}
?>


<link href="../plugins/summernote/summernote.css" rel="stylesheet">

<div id="mainadmin" class="row">

	<div class="col-xs-12 col-md-6 col-md-offset-3">
		<h2 class=" text-center">Modifier une recette</h2>
		<br>
		<form id="formR" action="traitements.php" method="post" enctype="multipart/form-data" >
		
			<div class="col-xs-12" id="infosR">
				<div class="col-xs-12 text-center">
					<div class="col-xs-6">Auteur : <?php echo $GLOBAL_RECETTE['auteur'];?></div>
					<div class="col-xs-6">Création : <?php echo $GLOBAL_RECETTE['date'];?></div>
				</div>
				<div class="col-xs-6"><input class="form-control" type="text" name="labelR" placeholder="nom de la recette" value="<?php echo $GLOBAL_RECETTE['titre'] ; ?>" maxlength="100" required></div>
				<div class="col-xs-6"><input class="form-control" type="number" name="temps" placeholder="temps de préparation (en minutes)" value="<?php echo $GLOBAL_RECETTE['temps'] ; ?>" min="0" max="999"></div>
				<div class="col-xs-12" id="photo"><label for="image">Photo d'illustration<input class="form-control" type="file" name="image" accept="image/*"></label></div>
				<div class="col-xs-12 form-group">
					<div id="image_preview" class="">
						<div class="thumbnail <?php if(empty($GLOBAL_RECETTE['image'])) echo "hidden" ; ?>">
							<img src="../<?php echo $GLOBAL_RECETTE['image'] ; ?>" alt="">
							<div class="caption col-xs-12  text-center">
								<p><button type="button" class="btn btn-default btn-danger">Annuler</button></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="summernote" class="row "><?php echo $GLOBAL_RECETTE['description'] ; ?></div><input type="hidden" name="description" >
			
			<div class="col-xs-12" >
				<?php foreach ($GLOBAL_INGREDIENTS as $type_ingredient => $ingredients) { ?>
					<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 ingredient">
						<header>
							<h3><?php echo $type_ingredient ; ?></h3>
						</header>
						<?php 
						foreach ($ingredients as $key => $ingredient) {
						?>
							<input <?php  
							foreach($GLOBAL_RECETTE['ingredients'] as $ingredientR)
							{
								if($ingredient['label_ingredient'] == $ingredientR['label_ingredient']) echo "checked"; 
							}
							?> type="checkbox" name="idqte<?php echo $ingredient['id_ingredient'] ; ?>" id="<?php echo $ingredient['id_ingredient'] ; ?>" value="<?php echo $ingredient['id_ingredient'] ; ?>" > <label for="<?php echo $ingredient['id_ingredient'] ; ?>"><?php echo $ingredient['label_ingredient'] ?></label><br />
							<input class="form-control" type="text" name="qte<?php echo $ingredient['id_ingredient'] ; ?>" <?php  
							foreach($GLOBAL_RECETTE['ingredients'] as $ingredientR)
							{
								if($ingredient['label_ingredient'] == $ingredientR['label_ingredient']) 
								{
									echo "value=".$ingredientR['quantite']." "; 
								}
							}
							?> placeholder="quantité">	
						<?php 
						}
						?>					
					</div>
				<?php 
				}
				?>
				<input type="hidden" name="tabI">
				<input type="hidden" name="idR" value="<?php echo $GLOBAL_RECETTE['id']; ?>">
			</div>
		
			<div class="col-xs-12 "><button class="form-control btn btn-primary" type="submit" name="modifR">Enregistrer <span class="glyphicon glyphicon-ok"></span></button></div>
			
		</form>
	</div>
	
</div>

<script src="../plugins/summernote/summernote.min.js"></script>
<script src="../plugins/summernote/lang/summernote-fr-FR.js"></script>