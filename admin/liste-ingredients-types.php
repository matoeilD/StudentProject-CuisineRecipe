<?php

	$GLOBAL_INGREDIENTS = array();
	
	// Récupération des ingrédients pour l'affichage.
	
	$sql = "SELECT i.id, label_ingredient, type_ingredient, label_type_ingredient FROM ingredient i left join type_ingredient ti on type_ingredient = ti.id order by label_type_ingredient, label_ingredient";
	$results_I = $bdd->query($sql) ;
	$ingredients = $results_I->fetchAll();
	
    foreach  ($ingredients as $row) 
	{
		$GLOBAL_INGREDIENTS[$row['label_type_ingredient']][] = array(
			'id_ingredient' => $row['id'],
			'type'=>$row['type_ingredient'],
			'label_ingredient' => $row['label_ingredient']);
	}
	
	$sql = "SELECT * FROM type_ingredient ORDER BY label_type_ingredient";
	
	$results = $bdd->query($sql);
	$types = $results->fetchAll();
	
?>
	<div class="row" id="mainadmin">	
		<div class="col-xs-12" >
				<?php $i =1;
				foreach ($GLOBAL_INGREDIENTS as $type_ingredient => $ingredients) { 
					if($i>4 && ($i%4 == 1)) $alignement = '<div class="visible-xs-block visible-md-block visible-lg-block" style="clear:left;"></div>'; 
					else if($i>3 && ($i%3 == 1))  $alignement='<div class="visible-sm-block" style="clear:left;"></div>'; 
					else if($i>2 && ($i%2 == 1))  $alignement='<div class="visible-xs-block" style="clear:left;"></div>'; 
					else $alignement='';
				
					echo $alignement; ?>
				
					<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 typesAdmin">
						<header><form class="form-group " action="traitements.php" method="post">
							<div class="col-xs-8"><input class="form-control" type="text" name="labelT" value="<?php echo $type_ingredient ; ?>" placeholder="type d'ingrédient" required></div>
							<div class="col-xs-2"><button class="btn btn-default" type="submit" name="modifT"><span class="glyphicon glyphicon-edit"></span></button></div>
							<div class="col-xs-2"><button class="btn btn-default" type="submit" name="supprT" onclick="return confirm('Le type d\'ingrédient sera supprimé ainsi que les ingrédients liés, continuer ?')"><span class="glyphicon glyphicon-trash" ></span></button></div>
							<div class="col-xs-12"><br></div>
							<input type="hidden" name="type" value="<?php echo $ingredients[0]['type']; ?>">
							</form>
						</header>
						<?php 
						foreach ($ingredients as $key => $ingredient) {
						?>
						<form class="form-group " action="traitements.php" method="post">
						<div class="col-xs-12 ingredientsAdmin">
								<div class="col-xs-8 col-xs-offset-1"><input class="form-control" type="text" name="labelI" value="<?php echo $ingredient['label_ingredient'] ; ?>" placeholde="ingrédient" required></div>
								<div class="col-xs-2"><button class="btn btn-default" type="submit" name="modifI"><span class="glyphicon glyphicon-edit"></span></button></div>
								
								<div class="col-xs-8 col-xs-offset-1"><select class="form-control" name="type">
								<?php 
									foreach($types as $type)
									{
										if($ingredient['type']==$type['id'])
											echo '<option value="'.$type['id'].'" selected>'.$type['label_type_ingredient'].'</option>';
										else
											echo '<option value="'.$type['id'].'">'.$type['label_type_ingredient'].'</option>';
									}
								?></select></div>
								<input type="hidden" name="idI" value="<?php echo $ingredient['id_ingredient'] ; ?>">
								
								<div class="col-xs-2"><button class="btn btn-default" type="submit" name="supprI" onclick="return confirm('L\'ingrédient sera supprimé, continuer ?')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div>
						</div>
						</form>
						<?php 
						}
						?>					
					</div>
				<?php 
				$i++; }
				?>
		</div>
	</div>