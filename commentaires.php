<hr width="75%">
<div id="correction" class="row">

	<div class="col-xs-12 col-md-6 col-md-offset-3">
	<h2>Nouveau commentaire</h2><br>
	
		<form method="post" action="admin/traitements.php" class="form-group">
			<div class="col-xs-6">Auteur : <?php if(isset($_SESSION['id'])) echo $_SESSION['pseudo']; else echo 'Anonyme'; ?></div>
			<div class="col-xs-6"><select name="note" id="note">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
			</div>
			
			<textarea class="form-control" name="contenu" placeholder="Commentaire" required></textarea>
			<input type="hidden" name="idR" value="<?php echo $GLOBAL_RECETTE['id']; ?>">
			<input type="hidden" name="idU" value="<?php if(isset($_SESSION['id'])) echo $_SESSION['id']; else echo '0'; ?>">
			
			<button class="btn btn-success col-xs-12" type="submit" name="com">Laisser un commentaire</button>
			
		</form>
	</div>
	
	<div class="col-xs-12 col-md-6 col-md-offset-3"><br>
	<h2>Commentaires</h2>
<?php

	$reqCom = $bdd->query("SELECT pseudo, note, date, contenu FROM commentaire left join utilisateur u on idU=u.id WHERE idR=".$GLOBAL_RECETTE['id']." ORDER BY date DESC");
	
	$nbCom = $reqCom->rowCount();
	
	if($nbCom>0)
	{
		$commentaires = $reqCom->fetchAll();
		
		foreach ($commentaires as $commentaire)
		{ ?>
		
		<div class="col-xs-12"><hr>
			<div class="col-xs-8"><h4>Commentaire de : <?php if(!empty($commentaire['pseudo'])) echo $commentaire['pseudo']; else echo 'Anonyme'; ?></h4></div>
			<div class="col-xs-4"><select class="noteRO">
				<?php 
				for($i=1; $i<6; $i++)
				{
					echo '<option value="'.$i.'"';
					if($i==$commentaire['note']) echo 'selected';
					echo '>'.$i.'</option>';
				}
				?>
			</select>
			</div>
			
			<br>
			<div class="col-xs-12"><p><?php echo $commentaire['contenu']; ?></p></div>
			<div class="col-xs-6">Ecrit le : <?php echo date('d/m/Y',strtotime($commentaire['date'])) ;?></div>
		</div>	
		<?php }
	}
	else echo '<div class="col-xs-12 text-center"><h3>Aucun commentaire</h3></div>';

?>
</div>



