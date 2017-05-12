<?php

	
	if(isset($_GET['idRecette']))
	{
	
		
		$GLOBAL_RECETTE = array();
		
		// requete des infos de la recette
		
		$sql = "SELECT pseudo, r.id , label_recette, temps_recette, description_recette, r.date, image, AVG(note) noteAVG FROM utilisateur u LEFT JOIN recette r ON u.id=id_auteur LEFT JOIN commentaire ON r.id=idR WHERE r.id = ".$_GET['idRecette'];
		
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
				'note'=> round($row['noteAVG']),
				'auteur'=>$row['pseudo']
				);
			
			//requete pour les ingrédeints de la recette
			
			$sql = "SELECT lr.quantite, i.label_ingredient FROM recette r left join ligne_recette lr on r.id = lr.id_recette left join ingredient i on lr.id_ingredient = i.id WHERE r.id = '".$GLOBAL_RECETTE['id']."'";
			
			foreach($bdd->query($sql) as $row) 
			{
				$GLOBAL_RECETTE['ingredients'][] = array(
					'quantite' => $row['quantite'],
					'label_ingredient' => $row['label_ingredient']
				);
			}
		}
		//var_dump($GLOBAL_RECETTE);
	}else
	{
		header('Location: index.php'); 
		//echo "ERREUR";
	}
	
?>
		<div id="main">

				<div id="correction" class="row">
					<div id="recetteC">
							<header>
								<div class="col-xs-12"><h2><?php echo $GLOBAL_RECETTE['titre'] ; ?></h2></div>
								<div class="col-xs-6 col-xs-offset-3 divNoteRO">
									<select class="noteRO">
									<?php 
									for($i=1; $i<6; $i++)
									{
										echo '<option value="'.$i.'"';
										if($i==$GLOBAL_RECETTE['note']) echo 'selected';
										echo '>'.$i.'</option>';
									}
									?>
									</select>
								</div>
								<div class="col-xs-8 col-xs-offset-2 text-center">
									<div class="col-xs-6"><h4>Auteur : <?php echo $GLOBAL_RECETTE['auteur'] ; ?></h4></div>
									<div class="col-xs-6"><h4>Création : <?php echo $GLOBAL_RECETTE['date'] ; ?></h4></div>
								</div>
								
							</header>

							
							<br><br>
							
							<div class="col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
							<img src="<?php echo $GLOBAL_RECETTE['image'] ; ?>" alt="">
							</div>
							
							<div class="col-xs-12">
								<header>
									<h3>Ingrédients :</h3>
								</header>
								<?php 

									foreach($GLOBAL_RECETTE['ingredients'] as $key => $ingredient) 
									{ 
										if($ingredient['label_ingredient']!=null && $ingredient['quantite']!=null)
											echo '<p>'.$ingredient['label_ingredient']." : ".$ingredient['quantite'].'</p>';
										else
											echo '<p>pas d\'ingrédients</p>';
									}
								?>
							</div>
					</div>
					
					<div id="contenu" class="col-xs-12">

						<p><?php echo $GLOBAL_RECETTE['description'] ; ?></p>
						
					</div>
					
				</div>
				
				<?php include('commentaires.php'); ?>
			
		</div>

