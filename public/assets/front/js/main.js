(function ($) {
	"use strict";

	// Sticky menu 
	var $window = $(window);
	$window.on('scroll', function () {
		var scroll = $window.scrollTop();
		if (scroll < 300) {
			$(".sticky").removeClass("is-sticky");
		} else {
			$(".sticky").addClass("is-sticky");
		}
	});

	// slide effect dropdown
	function dropdownAnimation() {
		$('.dropdown').on('show.bs.dropdown', function (e) {
			$(this).find('.dropdown-menu').first().stop(true, true).slideDown(500);
		});

		$('.dropdown').on('hide.bs.dropdown', function (e) {
			$(this).find('.dropdown-menu').first().stop(true, true).slideUp(500);
		});
	}
	dropdownAnimation();

	// mini cart toggler
	$(".mini-cart-btn").on("click", function (event) {
		event.stopPropagation();
		event.preventDefault();
		$(".cart-list").slideToggle();
		$(".settings-list").slideUp();
	});

	// setting toggler
	$(".settings-btn").on("click", function (event) {
		event.stopPropagation();
		event.preventDefault();
		$(".settings-list").slideToggle();
		$(".cart-list").slideUp();
	});


	// searh option js
	function searchToggler() {
		var trigger = $('.search-trigger'),
			container = $('.search_active');
		trigger.on('click', function (e) {
			e.preventDefault();
			container.toggleClass('is-visible');
		});

		$('.close__wrap').on('click', function () {
			container.removeClass('is-visible');
		});
	}
	searchToggler();


	// Sidebar Category
	var categoryChildren = $('.sidebar-category li .children');
	categoryChildren.slideUp();
	categoryChildren.parents('li').addClass('has-children');
	$('.sidebar-category').on('click', 'li.has-children > a', function (e) {
		if ($(this).parent().hasClass('has-children')) {
			if ($(this).siblings('ul:visible').length > 0) $(this).siblings('ul').slideUp();
			else {
				$(this).parents('li').siblings('li').find('ul:visible').slideUp();
				$(this).siblings('ul').slideDown();
			}
		}
		if ($(this).attr('href') === '#') {
			e.preventDefault();
			return false;
		}
	});


	// responsive menu js
	jQuery('#mobile-menu').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "991"
	});

	// tooltip active js
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})


	// Hero main slider active js
	$('.hero-slider-active').slick({
		autoplay: true,
		infinite: true,
		fade: true,
		dots: false,
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-double-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-double-right"></i></button>',
		responsive: [{
			breakpoint: 768,
			settings: {
				arrows: true,
			}
		}, ]
	});

	// product carousel other
	$('.product-carousel-other').each(function () {
		var $this = $(this);
		var $row = $this.attr("data-row") ? parseInt($this.attr("data-row"), 10) : 1;
		$this.slick({
			infinite: true,
			arrows: true,
			dots: false,
			centerMode: true,
			centerPadding: '60px',
			slidesToShow: 1,
			slidesToScroll: 1,
			rows: $row,
			prevArrow: '<button class="slick-prev"><i class="fa fa-angle-double-left"></i></button>',
			nextArrow: '<button class="slick-next"><i class="fa fa-angle-double-right"></i></button>',
			responsive: [{
				breakpoint: 1600,
				settings: {
					slidesToShow: 2,
					centerMode: true,
					centerPadding: '40px',
				}
			},
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2,
					centerMode: true,
					centerPadding: '40px',
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
				}
			},
			]
		});
	});
	// product carousel one
	$('.product-carousel-one').each(function () {
		var $this = $(this);
		var $row = $this.attr("data-row") ? parseInt($this.attr("data-row"), 10) : 1;
		$this.slick({
			infinite: true,
			arrows: true,
			dots: false,
			slidesToShow: 5,
			slidesToScroll: 1,
			rows: $row,
			prevArrow: '<button class="slick-prev"><i class="fa fa-angle-double-left"></i></button>',
			nextArrow: '<button class="slick-next"><i class="fa fa-angle-double-right"></i></button>',
			responsive: [{
					breakpoint: 1600,
					settings: {
						slidesToShow: 4,
					}
				},
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2,
						arrows: false,
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 2,
						arrows: false,
					}
				},
			]
		});
	});

	// product carousel one js
	$('.feature-category-carousel').each(function () {
		var $this = $(this);
		var $row = $this.attr("data-row") ? parseInt($this.attr("data-row"), 10) : 1;
		$this.slick({
			infinite: true,
			autoplay: true,
			arrows: true,
			dots: false,
			slidesToShow: 5,
			slidesToScroll: 1,
			rows: $row,
			prevArrow: '<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
			nextArrow: '<button class="slick-next"><i class="fa fa-angle-right"></i></button>',
			responsive: [{
					breakpoint: 1600,
					settings: {
						slidesToShow: 4,
					}
				},
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2,
						arrows: false,
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						arrows: false,
					}
				},
			]
		});
	});

	// product carousel two js
	$('.feature-category-carousel2').each(function () {
		var $this = $(this);
		var $row = $this.attr("data-row") ? parseInt($this.attr("data-row"), 10) : 1;
		$this.slick({
			infinite: true,
			arrows: true,
			dots: false,
			slidesToShow: 4,
			slidesToScroll: 1,
			rows: $row,
			prevArrow: '<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
			nextArrow: '<button class="slick-next"><i class="fa fa-angle-right"></i></button>',
			responsive: [{
					breakpoint: 1600,
					settings: {
						slidesToShow: 3,
					}
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2,
						arrows: false,
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						arrows: false,
					}
				},
			]
		});
	});

	// blog carousel active js
	$('.blog-carousel-active').slick({
		autoplay: false,
		infinite: true,
		fade: false,
		dots: false,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="fa fa-angle-double-left"></i></button>',
		nextArrow: '<button class="slick-next"><i class="fa fa-angle-double-right"></i></button>',
		slidesToShow: 4,
		responsive: [{
				breakpoint: 1600,
				settings: {
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			},
		]
	});

	// blog carousel active-2 js
	$('.blog-carousel-active-2').slick({
		autoplay: false,
		infinite: true,
		fade: false,
		dots: false,
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
		slidesToShow: 1,
		responsive: [{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			},
		]
	});

	// New arrivals carousel active js
	$('.category-active').slick({
		autoplay: false,
		infinite: true,
		fade: false,
		dots: false,
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
		slidesToShow: 2,
		responsive: [{
				breakpoint: 1200,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			},
		]
	});



	// blog carousel active js
	$('.feed-instagram-active').slick({
		autoplay: false,
		infinite: true,
		fade: false,
		dots: false,
		arrows: true,
		prevArrow: '<button class="slick-prev"><i class="fa fa-angle-double-left"></i></button>',
		nextArrow: '<button class="slick-next"><i class="fa fa-angle-double-right"></i></button>',
		slidesToShow: 6,
		responsive: [{
			breakpoint: 1600,
			settings: {
				slidesToShow: 6,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 6,
			}
		},
		{
			breakpoint: 576,
			settings: {
				slidesToShow: 2,
				arrows: false,
			}
		},
		]
	});


	// prodct details slider active
	$('.product-large-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		fade: true,
		arrows: true,
		asNavFor: '.pro-nav',
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
	});

	// product details slider nav active
	$('.pro-nav').slick({
		slidesToShow: 4,
		vertical: true,
		verticalScrolling: true,
		slidesToScroll: 1,
		asNavFor: '.product-large-slider',
		centerMode: true,
		arrows: false,
		centerPadding: 0,
		focusOnSelect: true,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>'
	});

	// Related product active js
	$('.releted-product').slick({
		autoplay: false,
		infinite: true,
		fade: false,
		dots: false,
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
		slidesToShow: 4,
		responsive: [{
				breakpoint: 1600,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			},
		]
	});

	// prodct details slider active
	$('.product-box-slider').slick({
		autoplay: false,
		infinite: true,
		fade: false,
		dots: false,
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
		slidesToShow: 4,
		responsive: [{
				breakpoint: 1600,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
				}
			},
		]
	});

	// blog gallery slider
	var gallery = $('.blog-gallery-slider');
	gallery.slick({
		arrows: true,
		autoplay: true,
		autoplaySpeed: 5000,
		pauseOnFocus: false,
		pauseOnHover: false,
		fade: true,
		dots: false,
		infinite: true,
		slidesToShow: 1,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>'
	});

	// testimonial carousel active js
	$('.testimonial-carousel-active').slick({
		autoplay: true,
		infinite: true,
		fade: false,
		dots: false,
		arrows: true,
		slidesToShow: 2,
		prevArrow: '<button class="slick-prev"><i class="fa fa-angle-double-left"></i></button>',
		nextArrow: '<button class="slick-next"><i class="fa fa-angle-double-right"></i></button>',
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
				}
			},
		]
	});

	// daily deals slider active
	$('.deals-slider-active').slick({
		autoplay: false,
		infinite: true,
		fade: false,
		dots: false,
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
		slidesToShow: 2,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
				}
			},
		]
	});

	// image zoom effect
	$('.img-zoom').zoom();

	// quantity change js
	$('.pro-qty').prepend('<span class="dec qtybtn">-</span>');
	$('.pro-qty').append('<span class="inc qtybtn">+</span>');
	$('.qtybtn').on('click', function () {
		var $button = $(this);
		var oldValue = $button.parent().find('input').val();
		if ($button.hasClass('inc')) {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 0) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 0;
			}
		}
		$button.parent().find('input').val(newVal);
	});

	// nice select active js
	$('select').niceSelect();

	// paraxify active
	var parallaxActive = '.single-lookbook-section',
		myParaxify;
	if (parallaxActive.length) {
		myParaxify = paraxify(parallaxActive, {
			speed: 1,
			boost: 1
		});
	}

	// modal fix
	$('.modal').on('shown.bs.modal', function (e) {
		$('.pro-nav').resize();
	})

	//// pricing filter
	//var rangeSlider = $(".price-range"),
	//	amount = $("#amount"),
	//	minPrice = rangeSlider.data('min'),
	//	maxPrice = rangeSlider.data('max');
	//rangeSlider.slider({
	//	range: true,
	//	min: minPrice,
	//	max: maxPrice,
	//	values: [minPrice, maxPrice],
	//	slide: function (event, ui) {
	//		amount.val("$" + ui.values[0] + " - $" + ui.values[1]);
	//	}
	//});
	//amount.val(" $" + rangeSlider.slider("values", 0) +
	//	" - $" + rangeSlider.slider("values", 1));


	// product view mode change js
	$('.product-view-mode a').on('click', function (e) {
		e.preventDefault();
		var shopProductWrap = $('.shop-product-wrap');
		var viewMode = $(this).data('target');
		$('.product-view-mode a').removeClass('active');
		$(this).addClass('active');
		shopProductWrap.removeClass('grid list').addClass(viewMode);
	})


	// Checkout Page accordion
	$("#create_pwd").on("change", function () {
		$(".account-create").slideToggle("100");
	});

	$("#ship_to_different").on("change", function () {
		$(".ship-to-different").slideToggle("100");
	});


	// Payment Method Accordion
	$('input[name="paymentmethod"]').on('click', function () {
		var $value = $(this).attr('value');
		$('.payment-method-details').slideUp();
		$('[data-method="' + $value + '"]').slideDown();
	});



	// newsletter popup
	/* $('.popup-close').on('click', function (e) {
		e.preventDefault();
		$('#subscribe-popup').fadeOut('slow');
	});
	$('.subscribe-btn').on('click', function (e) {
		$('#subscribe-popup').fadeOut('slow');
	});
	$('.popup-subscribe-box-body').on('click', function (e) {
		e.stopPropagation();
	});

	$(window).on('load', function(){
		setTimeout(function(){
			$('.popup-subscribe-box').addClass('open');
		},10000);
	}); */

	

	// Product Hover Visibility
	$('.product-item.item-black').hover(
		function () {
			$(this).closest('.slick-slider').addClass('hover');
			$(this).closest('.tab-pane').addClass('hover');
		},
		function () {
			$(this).closest('.slick-slider').removeClass('hover');
			$(this).closest('.tab-pane').removeClass('hover');
		}
	);

	// Countdown Activation
	$('[data-countdown]').each(function() {
		var $this = $(this), finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function(event) {
			$this.html(event.strftime('<div class="single-countdown"><span class="single-countdown__time">%D</span><span class="single-countdown__text">Days</span></div><div class="single-countdown"><span class="single-countdown__time">%H</span><span class="single-countdown__text">Hrs</span></div><div class="single-countdown"><span class="single-countdown__time">%M</span><span class="single-countdown__text">Min</span></div><div class="single-countdown"><span class="single-countdown__time">%S</span><span class="single-countdown__text">Sec</span></div>'));
		});
	});


	// scroll to top
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > 600) {
			$('.scroll-top').removeClass('not-visible');
		} else {
			$('.scroll-top').addClass('not-visible');
		}
	});
	$('.scroll-top').on('click', function (event) {
		$('html,body').animate({
			scrollTop: 0
		}, 1000);
	});

}(jQuery));






/* range */
function rangeSlider(value) {
	document.getElementById('rangeValue').innerHTML = value;
}

/* range2 */
const inputLeft = document.getElementById("input-left");
const inputRight = document.getElementById("input-right");

const thumbLeft = document.querySelector(".slider > .thumb.left");
const thumbRight = document.querySelector(".slider > .thumb.right");
const range = document.querySelector(".slider > .range");

const setLeftValue = () => {
	const _this = inputLeft;
	const [min, max] = [parseInt(_this.min), parseInt(_this.max)];

	_this.value = Math.min(parseInt(_this.value), parseInt(inputRight.value) - 1);

	const percent = ((_this.value - min) / (max - min)) * 100;
	thumbLeft.style.left = percent + "%";
	range.style.left = percent + "%";
};

const setRightValue = () => {
	const _this = inputRight;
	const [min, max] = [parseInt(_this.min), parseInt(_this.max)];

	_this.value = Math.max(parseInt(_this.value), parseInt(inputLeft.value) + 1);

	const percent = ((_this.value - min) / (max - min)) * 100;
	thumbRight.style.right = 100 - percent + "%";
	range.style.right = 100 - percent + "%";
};
if(inputLeft && inputRight){

	inputLeft.addEventListener("input", setLeftValue);
	inputRight.addEventListener("input", setRightValue);
}

function rangeLeftSlider(value) {
	document.getElementById('range2LeftValue').innerHTML = value;
}
function rangeRightSlider(value) {
	document.getElementById('range2RightValue').innerHTML = value;
}


$(".link").each(function () {
	$(this).on("mouseover", function () {
		$(".container").addClass("hover");
		$(".container-item").removeClass("active");
		$(this).parent().addClass("active");
	}).on("mouseleave", function () {
		$(".container").removeClass("hover");
	});
});

