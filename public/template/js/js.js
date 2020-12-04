$(document).ready(function($) {
//Mobile Nav

	
	$('.nav-mobile ul').hide();
	
	$('ul.button-menu').show();

	$('ul.button-menu').on('click', function(){
		$('.nav-mobile ul.nav-mobile-menu').toggle();
	});

	$('ul.nav-mobile-menu div').on('click', function(){
		$('.nav-mobile ul li ul li ul').toggle();
		$(this).next('ul li ul').toggle();
	});


	$('.all-sport-menu, .radio-menu').hide();
// Sport Menu
	$('.sport-title').on('click', function(){
		$('.all-sport-menu').stop().toggle();
		$('i.sport-icon').toggleClass("fa-chevron-right").toggleClass("fa-chevron-down");
	});

	$('.sport-menu').mouseleave( function(){
		$('.all-sport-menu').hide();
		$('i.sport-icon').addClass("fa-chevron-right").removeClass("fa-chevron-down");
	});
// Sport Radio
	$('.radio-title').on('click', function(){
		$('.radio-menu').stop().toggle();
		$('i.radio-icon').toggleClass("fa-chevron-right").toggleClass("fa-chevron-down");

	});

	$('.radio-title').mouseleave( function(){
		$('.radio-menu').hide();
		$('i.radio-icon').addClass("fa-chevron-right").removeClass("fa-chevron-down");
	});

// Accordion Standart
	$('.accordion-standart').each(function() { 
		var accordion = $(this); 
		accordion.find('.accordion-title').on('click', function(){ 
			accordion.find('.accordion-content').stop().slideUp(); 
			$(this).parent().siblings().find('.accordion-title').removeClass('active-accordion'); 
			$(this).toggleClass('active-accordion'); 
			$(this).closest('li').find('.accordion-content').not(':animated').slideToggle(); 
		}); 
	});

// Accordion Multiple
	$('.accordion-multiple .accordion-title').on('click', function(){	
		$(this).toggleClass('active-accordion');
		$(this).closest('li').find('.accordion-content').not(':animated').slideToggle();
	});	

//Alerts
	$('.close').on('click', function(){
		$(this).parent().fadeOut();
	});
	
//Vertical Hover Tab
	$('.tab-content div').hide(); 
	$('.tab-content div:first-child').show(); 
	$('.tab-nav li:first-child').addClass('active'); 

	$('.hover-tab').each(function() { 
		$(this).find('li').on('mouseenter', function() { 
		var index = $(this).parent().children().index($(this)); 
		$(this).addClass('active').siblings('.active').removeClass('active'); 
		$(this).closest('.module-content').find('.tab-content div').eq(index).show().siblings().hide(); 
		}); 
	});

//Vertical Click Tab
	$('.tab-content div').hide(); 
	$('.tab-content div:first-child').show(); 
	$('.tab-nav li:first-child').addClass('active'); 

	$('.click-tab').each(function() { 
		$(this).find('li').on('click', function() { 
		var index = $(this).parent().children().index($(this)); 
		$(this).addClass('active').siblings('.active').removeClass('active'); 
		$(this).closest('.module-content').find('.tab-content div').eq(index).show().siblings().hide(); 
		}); 
	});

//StickyNav
	function isMobile() {
		return ( 'ontouchstart' in document.documentElement ? true : false );
	}
	function StickyNav() {

		if ( isMobile() )
			return;
		
		var nav = $('nav');
		
		var sticky = nav.clone().prop('id','stickynav');
		sticky.html( '<div class="shell">'+ sticky.html() +'</div>' );
		$('body').prepend(sticky);

		$(window).on('scroll', function() {
			var scrollTop = $(this).scrollTop();

			if ( scrollTop > 60 ) {
				$('#stickynav').addClass('animate').css( "visibility", "visible" );;
				$('header nav').css( "visibility", "hidden" );
			}
			else {
				$('#stickynav').removeClass('animate').css( "visibility", "hidden" );;
				$('header nav').css( "visibility", "visible" );
			}
		});

	}

	$(function() {
		StickyNav();
	});

//Carousel
	$(".owl-carousel").owlCarousel();

 	var owl = $(".owl-carousel");
 
	owl.owlCarousel({
	transitionStyle : "fade"
	});

//Countdown
 $('[data-countdown]').each(function() {
     var $this = $(this), finalDate = $(this).data('countdown');
     $this.countdown(finalDate, function(event) {
         $this.html(event.strftime(
         	'<div>%D<span>Days</span></div><div>%H<span>hours</span></div><div>%M<span>min</span></div><div>%S<span>sec</span></div>'
         	));
     });
});

//Countdown
 $('[data-countdown-mini]').each(function() {
     var $this = $(this), finalDate = $(this).data('countdown-mini');
     $this.countdown(finalDate, function(event) {
         $this.html(event.strftime(
         	'<div>%D<span>Days</span></div><div>%H<span>hours</span></div>'
         	));
     });
});

  fluidvids.init({
 		 selector: 'iframe', // runs querySelectorAll()
 		 players: ['www.youtube.com', 'player.vimeo.com'] // players to support
	});
});					

