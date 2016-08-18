$(document).ready(function(){
	$('a.lightbox').fancybox({
		transition: 'elastic',
		fixed: true,

		current: 'obrázek č. {current} z {total}',

		slideshow: false,
		slideshowSpeed: 3000,
		slideshowAuto: false
	});

	var slider = $('.bxslider').bxSlider({
		auto: true,
		autoStart: true,
		adaptiveHeight : true,
		pager:true,
		onSlideAfter: function() {
			slider.stopAuto();
			slider.startAuto();
		},
		controls: false
	});
});