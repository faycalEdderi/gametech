
let formComment = $('.form-comment');


formComment.on('submit', submitFormComment);


function submitFormComment(e) {

	e.preventDefault();

	
	let formData = new FormData( e.target );

	
	$.ajax({
		method: 'post',
		dataType: 'json',
		data: formData,
		url: '/publication/forum',
		success: commentAddSuccess,
		processData: false,
		contentType: false
	});

	
	

	function commentAddSuccess(response){

	$('.comment-list').empty();


	formComment[0].reset();


	response.forEach( affichage => {
		

		$('.comment-list').append(`
			<hr>
			<p>${affichage.userName}</p>
			<p>${affichage.message}</p>
			
		`);
	} );
//Recharge la page pour affichage des commentaires
location.reload();



	}


}
