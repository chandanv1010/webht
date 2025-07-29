(function($) {
	"use strict";
	var HT = {}; // Khai báo là 1 đối tượng
	var timer;
	var $carousel = $(".owl-slide");
	var _token = $('meta[name="csrf-token"]').attr('content');

	HT.swiperOption = (setting) => {
		// console.log(setting);
		let option = {}
		if(setting.animation.length){
			option.effect = setting.animation;
		}	
		if(setting.arrow === 'accept'){
			option.navigation = {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			}
		}
		if(setting.autoplay === 'accept'){
			option.autoplay = {
			    delay: 50000,
			    disableOnInteraction: false,
			}
		}
		if(setting.navigate === 'dots'){
			option.pagination = {
				el: '.swiper-pagination',
			}
		}
		return option
	}
	
	/* MAIN VARIABLE */
	HT.swiper = () => {
        if($('.panel-slide').length){
            // Kiểm tra đã có swiper chưa
            if(window.mainSwiper) {
                console.log('Swiper already exists');
                return; // Thoát luôn, không tạo mới
            }
            
            setTimeout(() => {
                let setting = JSON.parse($('.panel-slide').attr('data-setting'))
                let option = HT.swiperOption(setting)
                
                option.slidesPerView = 1;
                option.spaceBetween = 0;
                option.allowTouchMove = true;
                option.on = {
                    init: function () {
                        console.log(1234);
                        
                        document.querySelector('.panel-slide').classList.add('is-loaded');
                    }
                };
                
                // console.log('Creating Swiper with options:', option);
                window.mainSwiper = new Swiper(".panel-slide .swiper-container", option);
                // console.log('Swiper created successfully');
                
            }, 800);
        }
    }
	HT.carousel = () => {
		$carousel.each(function(){
			let _this = $(this);
			let option = _this.find('.owl-carousel').attr('data-owl');
			let owlInit = atob(option);
			owlInit = JSON.parse(owlInit);
			_this.find('.owl-carousel').owlCarousel(owlInit);
		});
		
	} 


	HT.category = () => {
		var swiper = new Swiper(".panel-category .swiper-container", {
			loop: true,
			pagination: {
				el: '.swiper-pagination',
			},
            autoplay: {
                delay : 2000,
            },
			spaceBetween: 15,
			slidesPerView: 1.5,
			breakpoints: {
				415: {
					slidesPerView: 1.5,
				},
				500: {
				  slidesPerView: 2,
				},
				768: {
				  slidesPerView: 3,
				},
				1280: {
					slidesPerView: 6,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
		
	}

	HT.service = () => {
		const swiper = new Swiper('.panel-service-1 .swiper-container', {
            centeredSlides: true,
            loop: true,
            speed: 500,
            slidesPerView: 1.5,
            spaceBetween: 120,
            // autoplay: {
            //     delay: 3000,
            // },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
        
                640: {
                    slidesPerView: 2.5,
                },
                768: {
                    slidesPerView: 2.75,
                },
                1080: {
                    slidesPerView: 3.25,
                },
                1280: {
                    slidesPerView: 2.75,
                },
            },
        });
		
	}


	HT.swiperCategory = () => {
		var swiper = new Swiper(".panel-category .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 20,
			slidesPerView: 1.5,
			breakpoints: {
				415: {
					slidesPerView: 1.5,
				},
				500: {
				  slidesPerView: 2.5,
				},
				768: {
				  slidesPerView: 4,
				},
				1280: {
					slidesPerView: 5,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
	}

	HT.swiperAsideFeature = () => {
		var swiper = new Swiper(".aside-feature .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 0,
			slidesPerView: 1,
			breakpoints: {
				415: {
					slidesPerView: 1,
				},
				500: {
				  slidesPerView: 1,
				},
				768: {
				  slidesPerView: 1,
				},
				1280: {
					slidesPerView: 1,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
	}

	HT.swiperBestSeller = () => {
		var swiper = new Swiper(".panel-bestseller .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 20,
			slidesPerView: 2,
			breakpoints: {
				415: {
					slidesPerView: 1,
				},
				500: {
				  slidesPerView: 2,
				},
				768: {
				  slidesPerView: 3,
				},
				1280: {
					slidesPerView: 4,
				}
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			
		});
	}

	
	HT.wow = () => {
		var wow = new WOW(
			{
			  boxClass:     'wow',      // animated element css class (default is wow)
			  animateClass: 'animated', // animation css class (default is animated)
			  offset:       0,          // distance to the element when triggering the animation (default is 0)
			  mobile:       true,       // trigger animations on mobile devices (default is true)
			  live:         true,       // act on asynchronously loaded content (default is true)
			  callback:     function(box) {
				// the callback is fired every time an animation is started
				// the argument that is passed in is the DOM node being animated
			  },
			  scrollContainer: null,    // optional scroll container selector, otherwise use window,
			  resetAnimation: true,     // reset animation on end (default is true)
			}
		  );
		  wow.init();


	}// arrow function

	HT.niceSelect = () => {
		if($('.nice-select').length){
			$('.nice-select').niceSelect();
		}
		
	}

	HT.select2 = () => {
		if($('.setupSelect2').length){
			$('.setupSelect2').select2();
		}
		
	}


	HT.loadDistribution = () => {
		$(document).on('click', '.agency-item', function(){
			let _this = $(this)

			$('.agency-item').removeClass('active')
			_this.addClass('active')

			$.ajax({
				url: 'ajax/distribution/getMap', 
				type: 'GET', 
				data: {
					id: _this.attr('data-id')
				}, 
				dataType: 'json', 
				success: function(res) {
					$('.agency-map').html(res)
				},
			});

		})
	}

    HT.skeleton = () => {
        
    }


	HT.removePagination = () => {
		$('.filter-content').on('slide', function() {
			$('.uk-flex .pagination').hide();
		});
	};


	HT.wrapTable = () => {
		var width = $(window).width()
		if(width < 600){
			$('table').wrap('<div class="uk-overflow-container"></div>')
		}
	}
   
    HT.addVoucher = () => {
        $(document).on('click','.info-voucher', function(e){
            e.preventDefault()
            let _this = $(this)
            _this.toggleClass('active');
        })
    }

    HT.advise = () => {
        $(document).on('click','.suggest-aj button', function(e){
            e.preventDefault()
            let _this = $(this)
            let option  = {
				name : $('#suggest input[name=name]').val(),
                gender : $('#suggest input[name=gender]').val(),
				phone : $('#suggest input[name=phone]').val(),
				address: $('#suggest input[name=address]').val(),
                post_id : $('#suggest input[name=post_id ]').val(),
                product_id : $('#suggest input[name=product_id ]').val(),
				_token: _token,
			}
            toastr.success('Gửi yêu cầu thành công , chúng tôi sẽ sớm liên hệ vs bạn !', 'Thông báo từ hệ thống')
			$.ajax({
				url: 'ajax/contact/advise', 
				type: 'POST', 
				data: option, 
				dataType: 'json', 
				beforeSend: function() {
					
				},
				success: function(res) {
                    console.log(res)
					if(res.code === 10){
                       
						setTimeout(function(){
							location.reload();
						}, 1000);
                    }else if(res.status === 422){
                        let errors = res.messages;
						for(let field in errors){
							let errorMessage = errors[field];
							$('.'+ field + '-error').text(errorMessage);
						}
					}
				},
			});
			
		})
    }

    HT.scroll = () => {
        $(document).ready(function() {
            $('a[href="#system"]').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#system').offset().top - 50
                }, 800); 
            });
        });
    }

    HT.requestConsult = () => {
        $(document).on('click', '#advise button', function(e){
            e.preventDefault()
            let phone =  $('#advise input[name=phone]').val()
            if (!phone || !/^(0[3|5|7|8|9][0-9]{8})$/.test(phone)) {
                alert('Vui lòng nhập số điện thoại hợp lệ (10 chữ số, bắt đầu bằng 0).');
                return;
            }
            toastr.success('Gửi thông tin thành công. Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất', 'Thông báo từ hệ thống')
            $.ajax({
				url: 'ajax/contact/requestConsult', 
				type: 'POST', 
				data: {
					'phone' : phone,
                    '_token' : _token
				}, 
				dataType: 'json', 
				success: function(res) {
					if(res.status == true){
                        // toastr.success(res.messages, 'Thông báo từ hệ thống !')
                        $('#advise input[name=phone]').val('')
                    }
				},
			});
        })
    }


    HT.scrollHeading = () => {
        $(document).on('click', '.widget-toc a', function(e) {
            e.preventDefault(); // Ngăn hành vi mặc định của thẻ a
            
            let _this = $(this);
            let href = _this.attr('href'); // Lấy giá trị href
            
            // Kiểm tra nếu href bắt đầu bằng #
            if (href && href.startsWith('#')) {
                let targetId = href.substring(1); // Loại bỏ dấu # đầu tiên
                
                // Sử dụng document.getElementById thay vì jQuery selector để tránh lỗi
                let targetElement = document.getElementById(targetId);
                
                // Kiểm tra xem element có tồn tại không
                if (targetElement) {
                    // Chuyển về jQuery object để sử dụng offset()
                    let $targetElement = $(targetElement);
                    
                    // Cuộn mượt đến element
                    $('html, body').animate({
                        scrollTop: $targetElement.offset().top - 100 // Trừ 100px để tạo khoảng cách
                    }, 800); // 800ms cho hiệu ứng cuộn mượt
                    
                    // Thêm class active cho liên kết được click
                    $('.widget-toc a').removeClass('active');
                    _this.addClass('active');
                } else {
                    console.log('Không tìm thấy element với ID:', targetId);
                }
            }
        });
    }


    HT.highlightTocOnScroll = () => {
        $(window).on('scroll', function() {
            let scrollTop = $(window).scrollTop();
            
            $('.widget-toc a').each(function() {
                let href = $(this).attr('href');
                if (href && href.startsWith('#')) {
                    let targetId = href.substring(1);
                    let targetElement = document.getElementById(targetId); // Sử dụng getElementById
                    
                    if (targetElement) {
                        let $targetElement = $(targetElement);
                        let elementTop = $targetElement.offset().top - 150;
                        let elementBottom = elementTop + $targetElement.outerHeight();
                        
                        if (scrollTop >= elementTop && scrollTop < elementBottom) {
                            $('.widget-toc a').removeClass('active');
                            $(this).addClass('active');
                        }
                    }
                }
            });
        });
    }

    HT.updateHeaderColor = (slideIndex) => {
        const updateHeaderBasedOnSlide = (currentSlideIndex) => {
            const $slides = $('.panel-slide .swiper-slide');
            const $header = $('.pc-header');
            
            console.log('Updating header color for slide index:', currentSlideIndex);
            
            const $currentSlide = $slides.eq(currentSlideIndex);
            
            if($currentSlide.length) {
                console.log('Current slide classes:', $currentSlide.attr('class'));
                
                if($currentSlide.hasClass('slide-item-2')) {
                    console.log('Slide 2 active - adding white-text-mode class');
                    
                    // CHỈ CẦN ADD CLASS - CSS SẼ LO PHẦN CÒN LẠI
                    $header.addClass('white-text-mode');
                    
                } else {
                    console.log('Other slide active - removing white-text-mode class');
                    
                    // CHỈ CẦN REMOVE CLASS
                    $header.removeClass('white-text-mode');
                }
            }
        };
        
        if(typeof slideIndex !== 'undefined') {
            updateHeaderBasedOnSlide(slideIndex);
        }
        
        return updateHeaderBasedOnSlide;
    };

    // HT.manualSlide = () => {
    //     if($('.panel-slide').length){
    //         console.log('Setting up manual slide system...');
            
    //         let currentSlide = 0;
    //         let $slides = $('.panel-slide .swiper-slide');
    //         let totalSlides = $slides.length;
    //         let $container = $('.panel-slide .swiper-container');
    //         let $wrapper = $('.panel-slide .swiper-wrapper');
            
    //         // Initialize header color updater
    //         const updateHeaderColor = HT.updateHeaderColor();
            
    //         console.log('Total slides found:', totalSlides);
            
    //         if(totalSlides <= 1) {
    //             console.log('Only 1 slide, hiding navigation');
    //             $('.panel-slide .swiper-button-next, .panel-slide .swiper-button-prev').hide();
    //             return;
    //         }
            
    //         // Reset CSS của wrapper và slides
    //         $wrapper.css({
    //             'display': 'block',
    //             'position': 'relative',
    //             'width': '100%',
    //             'height': '100%'
    //         });
            
    //         // Thiết lập slides - ẩn tất cả trừ slide đầu
    //         $slides.each(function(index) {
    //             $(this).css({
    //                 'position': 'absolute',
    //                 'top': '0',
    //                 'left': '0',
    //                 'width': '100%',
    //                 'height': '100%',
    //                 'opacity': index === 0 ? '1' : '0',
    //                 'transition': 'opacity 0.5s ease-in-out',
    //                 'z-index': index === 0 ? '2' : '1'
    //             });
    //         });
            
    //         // Set initial header color for first slide
    //         updateHeaderColor(0);
            
    //         // Function để chuyển slide
    //         const goToSlide = (newIndex) => {
    //             if(newIndex === currentSlide) return;
                
    //             // console.log('Changing from slide', currentSlide, 'to slide', newIndex);
                
    //             // Fade out current slide
    //             $slides.eq(currentSlide).css({
    //                 'opacity': '0',
    //                 'z-index': '1'
    //             });
                
    //             // Fade in new slide
    //             $slides.eq(newIndex).css({
    //                 'opacity': '1',
    //                 'z-index': '2'
    //             });
                
    //             currentSlide = newIndex;
                
    //             // *** FIX: TRUYỀN newIndex VÀO updateHeaderColor ***
    //             console.log('Updating header for slide index:', newIndex);
    //             updateHeaderColor(newIndex);
    //         };
            
    //         // Next button click
    //         $('.panel-slide .swiper-button-next').off('click').on('click', function(e) {
    //             e.preventDefault();
    //             console.log('Next button clicked, current slide:', currentSlide);
    //             let nextSlide = (currentSlide + 1) % totalSlides;
    //             console.log('Going to next slide:', nextSlide);
    //             goToSlide(nextSlide);
    //         });
            
    //         // Prev button click  
    //         $('.panel-slide .swiper-button-prev').off('click').on('click', function(e) {
    //             e.preventDefault();
    //             console.log('Prev button clicked, current slide:', currentSlide);
    //             let prevSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    //             console.log('Going to prev slide:', prevSlide);
    //             goToSlide(prevSlide);
    //         });
            
    //         // Debug: Log tất cả slides và classes
    //         // console.log('=== DEBUG SLIDES ===');
    //         // $slides.each(function(index) {
    //         //     console.log(`Slide ${index}:`, $(this).attr('class'));
    //         // });
    //         // console.log('==================');
            
    //         // Keyboard navigation
    //         $(document).on('keydown', function(e) {
    //             if($('.panel-slide').is(':visible')) {
    //                 if(e.key === 'ArrowRight') {
    //                     $('.panel-slide .swiper-button-next').click();
    //                 } else if(e.key === 'ArrowLeft') {
    //                     $('.panel-slide .swiper-button-prev').click();
    //                 }
    //             }
    //         });
            
    //         // Touch/swipe support
    //         let startX = 0;
    //         let startY = 0;
    //         let isTouch = false;
            
    //         $container.on('touchstart mousedown', function(e) {
    //             isTouch = true;
    //             startX = e.type === 'touchstart' ? e.originalEvent.touches[0].clientX : e.clientX;
    //             startY = e.type === 'touchstart' ? e.originalEvent.touches[0].clientY : e.clientY;
    //         });
            
    //         $container.on('touchend mouseup', function(e) {
    //             if(!isTouch) return;
                
    //             let endX = e.type === 'touchend' ? e.originalEvent.changedTouches[0].clientX : e.clientX;
    //             let endY = e.type === 'touchend' ? e.originalEvent.changedTouches[0].clientY : e.clientY;
                
    //             let deltaX = endX - startX;
    //             let deltaY = endY - startY;
                
    //             // Check if horizontal swipe is stronger than vertical
    //             if(Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
    //                 if(deltaX > 0) {
    //                     // Swipe right - previous slide
    //                     $('.panel-slide .swiper-button-prev').click();
    //                 } else {
    //                     // Swipe left - next slide
    //                     $('.panel-slide .swiper-button-next').click();
    //                 }
    //             }
                
    //             isTouch = false;
    //         });
            
    //         // console.log('Manual slide system initialized successfully');
    //     }
    // };

    HT.customer = () => {
        var swiper = new Swiper('.your-swiper-container', {
            loop: true,
            centeredSlides: true,
            slidesPerView: 1,         // Tổng cộng 3 + 0.5 + 0.5 = 4, nhưng sẽ giải thích bên dưới
            spaceBetween: 30,           // Khoảng cách giữa các slide
            grabCursor: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 1.5,     // 3 full + 0.75 + 0.75
                },
                1024: {
                    slidesPerView: 4,       // Nếu muốn 1/2 + 3 + 1/2 thì ta để là 5
                }
            }
        });
    };


    HT.manualSlide = () => {
        if ($('.panel-slide').length) {
            console.log('Setting up manual slide system...');

            let currentSlide = 0;
            let $slides = $('.panel-slide .swiper-slide');
            let totalSlides = $slides.length;
            let $container = $('.panel-slide .swiper-container');
            let $wrapper = $('.panel-slide .swiper-wrapper');

            const updateHeaderColor = HT.updateHeaderColor();

            if (totalSlides <= 1) {
                $('.panel-slide .swiper-button-next, .panel-slide .swiper-button-prev').hide();
                return;
            }

            // Ensure wrapper is styled correctly
            $wrapper.css({
                'position': 'relative',
                'width': '100%',
                'height': '100%'
            });

            // Setup all slides
            $slides.each(function(index) {
                if (index === 0) {
                    $(this).addClass('is-active');
                } else {
                    $(this).removeClass('is-active');
                }
            });

            updateHeaderColor(0);

            const goToSlide = (newIndex) => {
                if (newIndex === currentSlide) return;

                $slides.eq(currentSlide).removeClass('is-active');
                $slides.eq(newIndex).addClass('is-active');

                currentSlide = newIndex;
                updateHeaderColor(newIndex);
            };

            $('.panel-slide .swiper-button-next').off('click').on('click', function(e) {
                e.preventDefault();
                let nextSlide = (currentSlide + 1) % totalSlides;
                goToSlide(nextSlide);
            });

            $('.panel-slide .swiper-button-prev').off('click').on('click', function(e) {
                e.preventDefault();
                let prevSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                goToSlide(prevSlide);
            });

            // Keyboard navigation
            $(document).on('keydown', function(e) {
                if ($('.panel-slide').is(':visible')) {
                    if (e.key === 'ArrowRight') {
                        $('.panel-slide .swiper-button-next').click();
                    } else if (e.key === 'ArrowLeft') {
                        $('.panel-slide .swiper-button-prev').click();
                    }
                }
            });

            // Touch/swipe support
            let startX = 0;
            let startY = 0;
            let isTouch = false;

            $container.on('touchstart mousedown', function(e) {
                isTouch = true;
                startX = e.type === 'touchstart' ? e.originalEvent.touches[0].clientX : e.clientX;
                startY = e.type === 'touchstart' ? e.originalEvent.touches[0].clientY : e.clientY;
            });

            $container.on('touchend mouseup', function(e) {
                if (!isTouch) return;

                let endX = e.type === 'touchend' ? e.originalEvent.changedTouches[0].clientX : e.clientX;
                let endY = e.type === 'touchend' ? e.originalEvent.changedTouches[0].clientY : e.clientY;

                let deltaX = endX - startX;
                let deltaY = endY - startY;

                if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                    if (deltaX > 0) {
                        $('.panel-slide .swiper-button-prev').click();
                    } else {
                        $('.panel-slide .swiper-button-next').click();
                    }
                }

                isTouch = false;
            });

            console.log('Manual slide system initialized.');
        }
    };



	$(document).ready(function(){
        HT.highlightTocOnScroll();
        HT.scrollHeading()
        HT.requestConsult()
        HT.scroll()
        HT.advise()
        HT.addVoucher()
		HT.removePagination()
		HT.wow()
		HT.category()
		HT.swiperBestSeller()
		HT.swiperAsideFeature()
		
		/* CORE JS */
		HT.manualSlide()
		HT.niceSelect()		
		HT.carousel()
		HT.select2()
		HT.loadDistribution()
		HT.wrapTable()
        HT.service()
        HT.skeleton()
        HT.customer()

        // $(window).on('load', function() {
        //     HT.swiper();
        // });
	});

})(jQuery);



addCommas = (nStr) => { 
    nStr = String(nStr);
    nStr = nStr.replace(/\./gi, "");
    let str ='';
    for (let i = nStr.length; i > 0; i -= 3){
        let a = ( (i-3) < 0 ) ? 0 : (i-3);
        str= nStr.slice(a,i) + '.' + str;
    }
    str= str.slice(0,str.length-1);
    return str;
}

document.addEventListener("DOMContentLoaded", function() {
    // Lựa chọn tất cả các ảnh cần lazy load
    const lazyImages = document.querySelectorAll('.lazy-image');
    
    // Tạo Intersection Observer
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            // Khi phần tử trở nên visible
            if (entry.isIntersecting) {
                const img = entry.target;
                // Lấy nguồn ảnh từ thuộc tính data-src
                const src = img.dataset.src;
                
                // Tạo ảnh mới và thiết lập trình xử lý sự kiện onload
                const newImg = new Image();
                newImg.onload = function() {
                    // Khi ảnh đã tải xong, gán src và thêm class loaded
                    img.src = src;
                    img.classList.add('loaded');
                    
                    // Ẩn skeleton loading
                    const parent = img.closest('.image');
                    if (parent) {
                        const skeleton = parent.querySelector('.skeleton-loading');
                        if (skeleton) {
                            skeleton.style.display = 'none';
                        }
                    }
                    
                    // Ngừng quan sát phần tử này
                    observer.unobserve(img);
                };
                
                // Bắt đầu tải ảnh
                newImg.src = src;
            }
        });
    }, {
        // Tùy chọn: thiết lập ngưỡng và root
        rootMargin: '0px 0px 50px 0px', // Tải trước ảnh khi chúng cách 50px từ viewport
        threshold: 0.1 // Kích hoạt khi ít nhất 10% của ảnh trở nên visible
    });
    
    // Quan sát mỗi ảnh
    lazyImages.forEach(img => {
        observer.observe(img);
    });
});