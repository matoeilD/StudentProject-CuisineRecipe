<?php

	$GLOBAL_INGREDIENTS = array();
	$GLOBAL_RECETTES = array();
	
	// Récupération des ingrédients pour l'affichage.
	
	$sql = "SELECT i.id, label_ingredient, type_ingredient, label_type_ingredient FROM ingredient i left join type_ingredient ti on type_ingredient = ti.id order by type_ingredient, label_ingredient";
	$results_I = $bdd->query($sql) ;
	$ingredients = $results_I->fetchAll();
	
    foreach  ($ingredients as $row) 
	{
		$GLOBAL_INGREDIENTS[$row['label_type_ingredient']][] = array(
			'id_ingredient' => $row['id'],
			'label_ingredient' => $row['label_ingredient']);
	}
	

	if(isset($_POST['submit_ingredients_button']) && !empty($_POST['ingredientspost']))
	{
			
		// Récupération des recettes en fonction des ingrédients choisis
		
		$sql = "SELECT r.id, label_recette, description_recette, r.date, image, AVG(note) noteAVG FROM recette r left join commentaire on r.id=idR 
		WHERE r.id in (SELECT DISTINCT r.id FROM recette r left join ligne_recette on r.id = id_recette left join ingredient i on id_ingredient = i.id 
		WHERE i.id in ('".implode("','",array_keys($_POST['ingredientspost']))."')) GROUP BY r.id ORDER BY r.date DESC";
		
		$results_R = $bdd->query($sql);
		$recettes = $results_R->fetchAll();
		
		foreach($recettes as $row) 
		{
			$GLOBAL_RECETTE[$row['id']] = array(
				'titre' => $row['label_recette'],
				'description' => resume($row['description_recette']) ,
				'date' => date('d/m/Y',strtotime($row['date'])),
				'image' => $row['image'],
				'note'=> round($row['noteAVG'])
				);
		}

	}
?>
<div id="main" class="row">


		<form action="index.php?page=ingredient#bas" method="post" name="submit_ingredients">
			<div class="col-xs-12" >
				<?php foreach ($GLOBAL_INGREDIENTS as $type_ingredient => $ingredients) { ?>
					<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 ingredient">
						<header>
							<h3><?php echo $type_ingredient ; ?></h3>
						</header>
						<?php 
						foreach ($ingredients as $key => $ingredient) {
						?>
							<input type="checkbox" name="ingredientspost[<?php echo $ingredient['id_ingredient'] ; ?>]" id="<?php echo $ingredient['id_ingredient'] ; ?>" <?php if(isset($_POST['ingredientspost'][$ingredient['id_ingredient']])) echo "checked=checked"; ?> /> <label for="<?php echo $ingredient['id_ingredient'] ; ?>"><?php echo $ingredient['label_ingredient'] ?></label><br />
						<?php 
						}
						?>					
					</div>
				<?php 
				}
				?>
			</div>
			
			<div class="col-xs-12">
				<input name="submit_ingredients_button" type="submit" class="btn btn-danger col-xs-12 " value="Rechercher les recettes" ><br><br>
			</div>
			
		</form>
		
		<br /><br />
		
		<?php if(isset($GLOBAL_RECETTE) && !empty($GLOBAL_RECETTE) && isset($_POST['submit_ingredients_button'])) { ?>
			
		<div id="correction" class="row" >
			<?php foreach ($GLOBAL_RECETTE as $key => $recette) { ?>
				<div class="col-xs-12 col-sm-4 col-md-3 recette">
					<a href="<?php echo 'index.php?page=recette&idRecette='.$key ?>#haut">
					<div class="col-xs-12">
						<header>
								<div class="col-xs-12"><h2><?php echo $recette['titre'] ; ?></h2></div>
								<div class="col-xs-6 col-xs-offset-3 divNoteRO">
									<select class="noteRO">
									<?php 
									for($i=1; $i<6; $i++)
									{
										echo '<option value="'.$i.'"';
										if($i==$recette['note']) echo 'selected';
										echo '>'.$i.'</option>';
									}
									?>
									</select>
								</div>
							</header>
						<div class="col-xs-12"><img src="<?php echo $recette['image'] ;?>" alt=""></div>
						<div class="col-xs-12"><p><?php echo $recette['description'] ; ?></p></div>
						<div class="col-xs-12"><p>Ajouté le <?php echo $recette['date'] ; ?></p></div>
					</div>
					</a>
				</div>
			<?php } ?>
		</div>
		<div id="bas"></div>
		<?php } elseif(isset($_POST['submit_ingredients_button']) && !empty($_POST['ingredientspost'])){ ?>
		<div id="correction" class="row">
		<meta http-equiv="refresh" content="2; URL=index.php?page=ingredient">
			<h1>Aucune recette ne correspond aux ingrédients sélectionnés.</h1>
		</div>
		<?php } elseif(isset($_POST['submit_ingredients_button']) && empty($_POST['ingredientspost'])){ ?>
		<div id="correction" class="row">
			<meta http-equiv="refresh" content="2; URL=index.php?page=ingredient">
			<h1>Aucun ingrédient sélectionné.</h1>
		</div>
		<?php } ?>
	
</div>

