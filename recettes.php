<?php

	$GLOBAL_RECETTE = array();
	
	// Récupération des derniéres recettes pour l'affichages des derniéres recettes en home.
	
	$sql = "SELECT r.id, label_recette, description_recette, r.date, image, AVG(note) noteAVG FROM recette r left join commentaire on r.id=idR GROUP BY r.id ORDER BY r.date DESC";
	
    foreach  ($bdd->query($sql) as $row) {
		$GLOBAL_RECETTE[$row['id']] = array(
			'titre' => $row['label_recette'],
			'description' => resume($row['description_recette']) ,
			'date' => date('d/m/Y',strtotime($row['date'])),
			'image' => $row['image'],
			'note'=> round($row['noteAVG'])
		);
	}
	
?>

<div id="main" class="row">
	<div id="correction" >
		
			<?php foreach ($GLOBAL_RECETTE as $key => $recette) { ?>
			<div class="col-xs-12 col-sm-4 col-md-3 recette">
				<a href="<?php echo 'index.php?page=recette&idRecette='.$key ?>#haut">
				<div class="col-xs-12">
					<header>
						<div class="col-xs-12"><h2><?php echo $recette['titre'] ; ?></h2></div>
						<div class="col-xs-6 col-xs-offset-3 divNoteRO"><select class="noteRO">
						<?php 
						for($i=1; $i<6; $i++)
						{
							echo '<option value="'.$i.'"';
							if($i==$recette['note']) echo 'selected';
							echo '>'.$i.'</option>';
						}
						?>
						</select></div>
					</header>
					<div class="col-xs-12"><img src="<?php echo $recette['image'] ;?>" alt=""></div>
					<div class="col-xs-12"><p><?php echo $recette['description'] ; ?></p></div>
					<div class="col-xs-12"><p>Ajouté le <?php echo $recette['date'] ; ?></p></div>
					<div class="col-xs-8 col-xs-offset-2 visible-xs-block"> <hr> </div>
				</div>
				</a>
			</div>
			<?php } ?>
			
	</div>
</div>
