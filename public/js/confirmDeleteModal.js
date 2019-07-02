// sélection des boutons supprimer du tableau
let btnDelete = Array.from( document.querySelectorAll('.issou') );

// sélection du bouton de la confirmation de la fenêtre modale
let btnConfirmModal = document.querySelector('.modal-confirm');

// parcourir les boutons supprimer et ajouter un événement clic
btnDelete.forEach( value => value.addEventListener('click', clickBtnDelete) );

function clickBtnDelete(event){
	// propriété target de l'événement permet de récupérer l'élement déclencheur
	// récupérer la valeur de l'attribut href du bouton supprimer
	let href = event.target.getAttribute('href');

	// définir l'attribut href du bouton de confirmation de la fenêtre modale
	btnConfirmModal.setAttribute('href', href);
}

