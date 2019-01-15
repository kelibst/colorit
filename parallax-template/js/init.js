(function($){
  $(function(){

  	 $('.tabs').tabs();
    $('.sidenav').sidenav();
    $('.parallax').parallax();
    $('.slider').slider({
    	indicators: false,
    	height:600,
    	interval:5000,
    transition:800,
    });
    $('a[href^="#"]').on('click', function(e){
		e.preventDefault();
		var target =this.hash;
		var $target = $(target);

		//scrool and show the anchor links
		$('html, body').animate({
			'scrollTop': $target.offset().top
		}, 600,'swing');
	});
    
$('.fixed-action-btn').floatingActionButton();
  }); // end of document ready
})(jQuery); // end of jQuery name space


