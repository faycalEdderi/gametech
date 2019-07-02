

$('#menuBurger').click(function(){

	$('.menuResponsive').toggle().finish();
	$('.user').toggle().finish();
				
});




$(window).resize(function() {
	if (window.matchMedia('(max-width: 1000px)').matches) {
		
		$('.menuResponsive').hide().finish();
		$('.user').hide().finish();
		$('#menuBurger').show(1000);
		
	}else{

		$('.menuResponsive').show(1000);
		$('.user').show(1000);
		$('#menuBurger').hide(1000);

	}
});



	