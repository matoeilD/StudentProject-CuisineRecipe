$(document).ready(function() 
{
	//initialisation du plugin summernote
  $('#summernote').summernote({
  lang:'fr-FR'
  });
  
  //récupération des données de summernote et des ingrédients
  $('#formR').submit(function()
  {
	  $('[name=description]').val($('#summernote').summernote('code'));
	  
	  var tabI = [];
	  
	  $('input[name^="qte"]').each(function()
	  {
			var idqte = "id"+$(this).attr('name');
			
			if($(this).val()=="")
			{
				$('input[name="'+idqte+'"]').remove();
				$('input[name="'+$(this).attr('name')+'"]').remove();
			}
			else
			{
				tabI.push($('input[name="'+idqte+'"]').val()+"-"+$('input[name="'+$(this).attr('name')+'"]').val() );
				$('input[name="'+idqte+'"]').remove();
				$('input[name="'+$(this).attr('name')+'"]').remove();
			}
		});
	  $('[name="tabI"').attr('value',tabI);		  
  })
  
  // prévisualisation de la photo de recette
    $('#formR').find('input[name="image"]').on('change', function (e) {
        var files = $(this)[0].files;
 
        if (files.length > 0) {
            // On part du principe qu'il n'y a qu'un seul fichier
            // étant donné que l'on a pas renseigné l'attribut "multiple"
            var file = files[0],
                $image_preview = $('#image_preview');
 
            // Ici on injecte les informations recoltées sur le fichier pour l'utilisateur
            $image_preview.find('.thumbnail').removeClass('hidden');
            $image_preview.find('img').attr('src', window.URL.createObjectURL(file));
        }
    });
 
    // Bouton "Annuler" pour cacher la photo prévisualisée
    $('#image_preview').find('button[type="button"]').on('click', function (e) {
        e.preventDefault();
 
        $('.envoi-photo').find('input[name="image"]').val('');
        $('#image_preview').find('.thumbnail').addClass('hidden');
    });
	
	//masquage/affichage des quantités pour les ingrédients
	$('input[name^="qte"]').each(function()
	{
		if(!$(this).val())
			$(this).hide();
	});
	$('input[type=checkbox]').change(function()
	{
		var id ="qte"+$(this).val();
		$('input[name="'+id+'"]').slideToggle("slow", function() 
		{
			if ($(this).is(':visible')) 
			{
				$(this).focus();
			}
		});
		
	});

});