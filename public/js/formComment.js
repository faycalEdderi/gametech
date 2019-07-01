
let formComment = $('.form-comment');
formComment.on('submit', submitFormComment);


function submitFormComment(e) {
	
	e.preventDefault();
	let formData = new FormData( e.target );
	$.ajax({
		method: 'post',
		dataType: 'json',
		data: formData,
		url: '/user/commentaire/add',
		success: commentAddSuccess,
		processData: false,
		contentType: false
	});

}
function commentAddSuccess(response){
	
	$('.comment-list').empty();
	formComment[0].reset();
	response.forEach( commentaire => {

		$('.comment-list').append(`
			<hr>
			<p>${commentaire.userName}</p>
			<p>${commentaire.message}</p>
			
		`);
	} );

	location.reload(true);
	
}








