// cibler le formulaire de commentaire
let formComment = $('.form-comment');

// écouteur sur l'événement submit
formComment.on('submit', submitFormComment);

// gestionnaire de l'événement submit
function submitFormComment(e) {
	// preventDefault : bloquer la soumission du formulaire
	e.preventDefault();

	// FormData : récupérer la saisie d'un formulaire
	let formData = new FormData( e.target );

	/*
		envoi ajax
			method: type d'envoi
			dataType: type de données renvoyées dans la réponse http
			data: données envoyées dans la requête http
			url: url d'envoi des données
			success: fonction de réception de données
			processData: conserver les données envoyées sous forme d'objet
			contentType: appliquer les en-têtes http correctes
	 */
	$.ajax({
		method: 'post',
		dataType: 'json',
		data: formData,
		url: '/commentaire/add',
		success: commentAddSuccess,
		processData: false,
		contentType: false
	});

	
	location.reload();

	//console.log(formData.entries().next());
}

// fonction appelée après la réponse http
// le paramètre permet de récupérer les données de la réponse http
function commentAddSuccess(response){
	// empty : vider le contenu d'une balise
	$('.comment-list').empty();

	// réinitialiser le formulaire
	formComment[0].reset();

	// boucle sur la réponse http
	response.forEach( commentaire => {
		
		

		// append: ajouter du html en fin de balise sans supprimer le contenu précédent
		$('.comment-list').append(`
			<hr>
			<p>${commentaire.userName}</p>
			<p>${commentaire.message}</p>
			
		`);
	} );


	

	
}








