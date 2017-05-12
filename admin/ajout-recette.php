<?php

//if(isset($_GET['enregistrement'])) $ok="recette enregistrée";

	$GLOBAL_INGREDIENTS = array();
	
	// Récupération des ingrédients
	
	$sql = "SELECT i.id, label_ingredient, type_ingredient, label_type_ingredient FROM ingredient i left join type_ingredient ti on type_ingredient = ti.id order by type_ingredient, label_ingredient";
	$results_I = $bdd->query($sql) ;
	$ingredients = $results_I->fetchAll();
	
    foreach  ($ingredients as $row) 
	{
		$GLOBAL_INGREDIENTS[$row['label_type_ingredient']][] = array(
			'id_ingredient' => $row['id'],
			'label_ingredient' => $row['label_ingredient']);
	}
?>
<link href="../plugins/summernote/summernote.css" rel="stylesheet">
<script>

</script>

<div id="mainadmin" class="row">

	<div class="col-xs-12 col-md-6 col-md-offset-3">
		<h2 class=" text-center">Ajout d'une nouvelle recette</h2>
		<br>
		<form id="formR" action="traitements.php" method="post" enctype="multipart/form-data" >
		
			<div class="col-xs-12" id="infosR">
				<div class="col-xs-6"><input class="form-control" type="text" name="labelR" placeholder="nom de la recette" maxlength="100" required></div>
				<div class="col-xs-6"><input class="form-control" type="number" name="temps" placeholder="temps de préparation (en minutes)" min="0" max="999"></div>
				<div class="col-xs-12" id="photo"><label for="image">Photo d'illustration<input class="form-control" type="file" name="image" accept="image/*"></label></div>
				<div class="col-xs-12 form-group">
					<div id="image_preview" class="">
						<div class="thumbnail hidden">
							<img src="" alt="">
							<div class="caption col-xs-12  text-center">
								<p><button type="button" class="btn btn-default btn-danger">Annuler</button></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="summernote" class="row "><p>Description de la recette</p></div><input type="hidden" name="description" >
			
			<div class="col-xs-12" >
				<?php foreach ($GLOBAL_INGREDIENTS as $type_ingredient => $ingredients) { ?>
					<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 ingredient">
						<header>
							<h3><?php echo $type_ingredient ; ?></h3>
						</header>
						<?php 
						foreach ($ingredients as $key => $ingredient) {
						?>
							<input type="checkbox" name="idqte<?php echo $ingredient['id_ingredient'] ; ?>" id="<?php echo $ingredient['id_ingredient'] ; ?>" value="<?php echo $ingredient['id_ingredient'] ; ?>" /> <label for="<?php echo $ingredient['id_ingredient'] ; ?>"><?php echo $ingredient['label_ingredient'] ?></label><br />
							
							<input class="form-control" type="text" name="qte<?php echo $ingredient['id_ingredient'] ; ?>" value="" placeholder="quantité">	
						<?php 
						}
						?>					
					</div>
				<?php 
				}
				?>
				<input type="hidden" name="tabI">
			</div>
		
			<div class="col-xs-12 "><button class="form-control btn btn-primary" type="submit" name="ajoutR">Enregistrer <span class="glyphicon glyphicon-ok"></span></button></div>
			
		</form>
	</div>
	
</div>

<script src="../plugins/summernote/summernote.min.js"></script>
<script src="../plugins/summernote/lang/summernote-fr-FR.js"></script>