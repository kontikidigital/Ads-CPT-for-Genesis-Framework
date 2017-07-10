jQuery(function($){

	var $container = $('.portfolio-content');

	var $grid = $container.imagesLoaded( function() {
	// init Isotope after all images have loaded
		$grid.isotope({
			// options...
			itemSelector: '.entry',
			percentPosition: true,
			layoutMode: 'fitRows',
			fitRows: {
				gutter: '.gutter-sizer' // horizontal gap between grid items
			}
		});
	});

	// filter items on button click
	$('.portfolio-cats').on( 'click', 'button', function() {
		var filterValue = $(this).attr('data-filter');
		$grid.isotope({ filter: filterValue });
		$(this).parent('div').find('button').removeClass('active');
		$(this).addClass('active');
	});

});