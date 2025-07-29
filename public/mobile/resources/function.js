(function($) {
    "use strict";
    var HT = {}; // Khai báo là 1 đối tượng
    var timer;
    var $carousel = $(".owl-slide");
    var _token = $('meta[name="csrf-token"]').attr('content');

    HT.swiperOption = (setting) => {
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
            let setting = JSON.parse($('.panel-slide').attr('data-setting'))
            let option = HT.swiperOption(setting)
            var swiper = new Swiper(".panel-slide .swiper-container", option);
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

    HT.category = () => {
		var swiper = new Swiper(".panel-category .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 15,
			slidesPerView: 1.5,
			breakpoints: {
				415: {
					slidesPerView: 2,
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

    HT.customer = () => {
		var swiper = new Swiper(".panel-customer .swiper-container", {
			loop: false,
			pagination: {
				el: '.swiper-pagination',
			},
			spaceBetween: 15,
			slidesPerView: 1.5,
			breakpoints: {
				415: {
					slidesPerView: 2,
				},
				500: {
				  slidesPerView: 2,
				},
				768: {
				  slidesPerView: 3,
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

    HT.service = () => {
		const swiper = new Swiper('.panel-service-1 .swiper-container', {
            // centeredSlides: true,
            loop: true,
            speed: 500,
            slidesPerView: 1,
            spaceBetween: 0,
            // autoplay: {
            //     delay: 3000,
            // },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                600: {
                    slidesPerView: 1,
                },
            },
        });
		
	}

    HT.video = () => {
		const swiper = new Swiper('.panel-video .swiper-container', {
            loop: true,
            speed: 500,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                300: {
                    slidesPerView: 1,
                },
                1280: {
					slidesPerView: 1,
				}
            },
        });
		
	}
  

    HT.advise = () => {
        $(document).on('click','#suggest button', function(e){
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
                        toastr.success(res.messages, 'Gửi yêu cầu thành công , chúng tôi sẽ sớm liên hệ vs bạn !')
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

    HT.product = () => {
		// const swiper = new Swiper('.panel-product .swiper-container', {
        //     centeredSlides: false,
        //     loop: false,
        //     autoplay:{
        //         delay: 3000
        //     },
        //     navigation: {
        //         nextEl: '.swiper-button-next',
        //         prevEl: '.swiper-button-prev',
        //     },
        //     breakpoints: {
        //         300: {
        //             slidesPerView: 1,
        //         },
        //         1280: {
		// 			slidesPerView: 1,
		// 		}
        //     },
        // });
		
	}

    HT.projectFeature = () => {
        const swiper = new Swiper('.project-featured.index .swiper-container', {
            centeredSlides: false,
            loop: false,
            autoplay:{
                delay: 3000
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                300: {
                    slidesPerView: 1,
                },
                1280: {
					slidesPerView: 1,
				}
            },
        });
    }


    HT.news = () => {
        const swiper = new Swiper('.panel-news.index .swiper-container', {
            centeredSlides: false,
            loop: false,
            autoplay:{
                delay: 3000
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                300: {
                    slidesPerView: 1,
                },
                1280: {
					slidesPerView: 1,
				}
            },
        });
    }

    HT.design = () => {
        const swiper = new Swiper('.panel-design .swiper-container', {
            centeredSlides: false,
            loop: false,
            autoplay:{
                delay: 3000
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                300: {
                    slidesPerView: 1,
                },
                1280: {
					slidesPerView: 1,
				}
            },
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
                        toastr.success(res.messages, 'Thông báo từ hệ thống !')
                        $('#advise input[name=phone]').val('')
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



    $(document).ready(function(){
        HT.scroll()
        HT.requestConsult()
        HT.design()
        HT.news()
        HT.projectFeature()
        HT.product()
        HT.advise()
        HT.video()
        HT.service()
        HT.category()
        HT.removePagination()
        HT.wow()
        
        /* CORE JS */
        HT.swiper()
        HT.niceSelect()		
        HT.carousel()
        HT.select2()
        HT.wrapTable()

        HT.customer()
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