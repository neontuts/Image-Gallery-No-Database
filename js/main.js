//	Script For Smooth Scrolling
$(document).ready(function () {
	$('#gallery-link').on('click', function(event) {
	  if (this.hash !== '') {
	    event.preventDefault();

	    const hash = this.hash;

	    $('html, body').animate(
	      {
	        scrollTop: $(hash).offset().top
	      },
	      800,
	      function() {
	        window.location.hash = hash;
	      }
	    );
	  }
	});
});

//	Scroll To Top of the Page using JQuery ScrollUp plugin
$(function () {
	$.scrollUp({
		scrollImg: true
	});
});
