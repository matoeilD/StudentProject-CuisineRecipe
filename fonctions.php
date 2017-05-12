<?php

function resume($texte)
{
	 if(strlen($texte) > 100)
		 return substr($texte,0,100)." [...]"; 
	 else return $texte;
}

function tableauIngredients($tableau)
{
	$tabIngredients = explode(',',$tableau);
	
	foreach($tabIngredients as $tabI)
	{
		$ingredients[strstr($tabI,'-',true)]=[trim(strstr($tabI,'-'),"-")];
	}
	
	return $ingredients;
}

function uploadPhoto($idR,$bdd)
{
	if(isset($_FILES['image']))
		{
			if($_FILES['image']['size']!=0) ////////////////////////////////////////////////////////////////// ENVOI PHOTO \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
			{
				// parametres

				unset($erreur);
				$extensions = array('png', 'gif', 'jpg', 'jpeg', 'JPG');
				$taille_max = 5000000;
				$destination_dossier = 'images/';
			  
				if($_FILES['image']['name'] and !in_array(substr(strrchr($_FILES['image']['name'], '.'), 1), $extensions ))
				{
					$erreurs[] ="- type de fichier non valide";  
				}
				
				else if( file_exists($_FILES['image']['tmp_name']) and filesize($_FILES['image']['tmp_name']) > $taille_max)
				{
					$erreur[] ="- taille de fichier non valide";
				}
					
				// si aucune erreur
				if(!isset($erreur))
				{
					$ext = substr(strrchr($_FILES['image']['name'], "."), 1);
					
					$dest_fichier = 'recette_'.$idR.'.'.$ext;
					
					$chemin_img=$destination_dossier . $dest_fichier;
					
					$reqPHOTO0 = $bdd->query('SELECT COUNT(*) FROM recette WHERE image LIKE "'.$chemin_img.'"');
					$nbPHOTO0 = $reqPHOTO0->fetch();
					
					if($nbPHOTO0[0]<1) // si l'image n'est pas déjà sur le serveur on la copie
					{
						// copie du fichier
						move_uploaded_file($_FILES['image']['tmp_name'], '../'.$chemin_img);
						
						//insertion du chemein de l'image dans la base de données
						$insert_image = $bdd->query("UPDATE recette SET image='".$chemin_img."' WHERE id=".$idR."");
					}
					else
					{						
						//suppression du fichier deja présent sur le serveur
						unlink('../'.$chemin_img);
				
						// copie du nouveau fichier
						move_uploaded_file($_FILES['image']['tmp_name'], '../'.$chemin_img);
						
						//mise a jour du chemin de l'image dans la base de données
						$insert_image = $bdd->query("UPDATE recette SET image='".$chemin_img."' WHERE id=".$idR."");
					}
					
					echo  '<div class="col-xs-12 text-center"><h4 style="color:green;">(photo ajoutée/modifiée)</h4></div>';
				}			
				else echo '<div class="col-xs-12 text-center"><h4 style="color:red;">('.$erreur.')</h4></div>'; 
			}
			else echo '<div class="col-xs-12 text-center"><h4 style="color:orange;">(photo non ajoutée/modifiée)</h4></div>'; 
		}
}

?>