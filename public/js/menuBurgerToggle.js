

	$('#menuBurger').click(function(){

				$('.menuResponsive').toggle().finish();
				$('.user').toggle().finish();

				



				
			});

	$(window).resize(function() {
		if (window.matchMedia('(max-width: 1200px)').matches) {
			// functionality for screens smaller than 1200px
			$('.menuResponsive').hide(1000);
			$('.user').hide(1000);
			
		}else{

			$('.menuResponsive').show(1000);
			$('.user').show(1000);

		}
	});



	