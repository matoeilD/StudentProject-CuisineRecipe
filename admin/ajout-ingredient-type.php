<?php

?>
<div id="mainadmin" class="row  text-center">

	<div class="col-xs-12 col-md-6 ">
		<h2>Ajout d'un nouvel ingrédient</h2>
		<br>
		<form class="form-group col-xs-12" action="traitements.php" method="post">
			<div class="col-xs-4"><input class="form-control" type="text" name="labelI" placeholder="nom de l'ingrédient" maxlength="50" required></div>
			<div class="col-xs-4"><select class="form-control" name="type">
			<?php 
				$sql = "SELECT * FROM type_ingredient ORDER BY label_type_ingredient";
				
				$results = $bdd->query($sql);
				$types = $results->fetchAll();
				
				foreach($types as $type)
				{
					echo '<option value="'.$type['id'].'">'.$type['label_type_ingredient'].'</option>';
				}
				?>
			</select></div>
			<div class="col-xs-4"><button class="btn btn-primary col-xs-12" type="submit" name="ajoutI">Enregistrer <span class="glyphicon glyphicon-ok"></span></button></div>
		</form>
	</div>
	
	<div class="col-xs-12 col-md-6">
		<h2>Ajout d'un nouveau type d'ingrédient</h2>
		<br>
		<form class="form-group col-xs-12" action="traitements.php" method="post">
			<div class="col-xs-4 col-xs-offset-3"><input class="form-control" type="text" name="labelT" placeholder="nom du type" maxlength="50" required></div>
			<div class="col-xs-2"><button class="btn btn-primary" type="submit" name="ajoutT">Enregistrer <span class="glyphicon glyphicon-ok"></span></button></div>
		</form>
	</div>
	
</div>