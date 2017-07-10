jQuery(function($){
	$(window).load(function() {

			/*main function*/
			function PortfolioIsotope() {
				var $container = $('.portfolio-content');
				$container.imagesLoaded(function(){
					$container.isotope({
						itemSelector: '.altitude-pro-portfolio .entry'
					});
				});
			} PortfolioIsotope();

			/*filter*/
			$('.filter a').click(function(){
			  var selector = $(this).attr('data-filter');
				$('.portfolio-content').isotope({ filter: selector });
				$(this).parents('ul').find('a').removeClass('active');
				$(this).addClass('active');
			  return false;
			});

			/*resize*/
			var isIE8 = $.browser.msie && +$.browser.version === 8;
			if (isIE8) {
				document.body.onresize = function () {
					PortfolioIsotope();
				};
			} else {
				$(window).resize(function () {
					PortfolioIsotope();
				});
			}

			// Orientation change
			window.addEventListener("orientationchange", function() {
				PortfolioIsotope();
			});

	});
});