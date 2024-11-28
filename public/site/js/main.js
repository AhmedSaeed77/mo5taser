


$(document).ready(function() {
  $('body').bind('cut copy', function(e) {
      e.preventDefault();
    });
});

$(window).load(function() {
    $('.loader').fadeOut(2000);
    $(".single_lesson_content:first-child").find('.arrow i').addClass('rotate')
});

new WOW().init();
wow = new WOW({
    boxClass: 'wow', // default
    animateClass: 'animated', // default
    offset: 0, // default
    mobile: true, // default
    live: true // default
})
wow.init();

// All Sliader
$(document).ready(function() {
    "use strict";

    // Home Slider
    $(".home-slider").owlCarousel({
        nav: false,
        loop: true,
        navText: ["<i class='la la-arrow-left'></i>", "<i class='la la-arrow-right'></i>"],
        dots: true,
        autoplay: 4000,
        items: 1,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        autoplayHoverPause: true,
        center: false,
        responsiveClass: true,
    });

    // Courses Slider
    $(".courses-slider").owlCarousel({
        nav: true,
        loop: false,
        navText: ["<i class='las la-angle-left'></i>", "<i class='las la-angle-right'></i>"],
        dots: false,
        autoplay: false,
        items: 1,
        autoplayHoverPause: true,
        center: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4
            }
        }
    });


    // Courses Slider
    $(".students_result").owlCarousel({
        nav: true,
        loop: false,
        navText: ["<i class='las la-angle-left'></i>", "<i class='las la-angle-right'></i>"],
        dots: false,
        autoplay: false,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1201: {
                items: 3
            }
        }
    });



    // News Slider
    $(".news-slider").owlCarousel({
        nav: true,
        loop: true,
        navText: ["<i class='las la-angle-left'></i>", "<i class='las la-angle-right'></i>"],
        dots: false,
        autoplay: 4000,
        items: 1,
        autoplayHoverPause: true,
        center: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4
            }
        }
    });

    // Say Slider
    $(".say-slider").owlCarousel({
        nav: false,
        loop: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        dots: true,
        dotsData: true,
        autoplay: 4000,
        items: 1,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        autoplayHoverPause: true,
        center: false,
        responsiveClass: true
    });

    // contest Slider
    $(".contest_div").owlCarousel({
        nav: false,
        loop: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        dots: true,
        autoplay: 4000,
        items: 1,
        autoplayHoverPause: true,
        center: false,
        responsiveClass: true
    });


    //Nav
    $(window).on("scroll", function() {
        if ($(window).scrollTop() > 50) {
            $(".sticky").addClass("active");
        } else {
            $(".sticky").removeClass("active");
        }
    });

    // Mobile Menu
    if ($('.mobile-menu').length) {

        $('.mobile-menu .menu-box');

        var mobileMenuContent = $('.main-header .nav-outer .main-menu').html();
        $('.mobile-menu .menu-box .menu-outer').append(mobileMenuContent);
        $('.sticky-header .main-menu').append(mobileMenuContent);

        //Menu Toggle Btn
        $('.mobile-nav-toggler').on('click', function() {
            $('body').addClass('mobile-menu-visible');
        });

        //Menu Toggle Btn
        $('.mobile-menu .menu-backdrop,.mobile-menu .close-btn').on('click', function() {
            $('body').removeClass('mobile-menu-visible');
        });

    }

    //Drop
    $('.mobile-menu li.menu-item-has-children').on('click', function(event) {
        $(this).siblings().removeClass('open');
        $(this).toggleClass('open');
    });

    $('.menu-nav .nav-inner ul li a').on('click', function(event) {
        $(this).parent().siblings().removeClass('active');
        $(this).parent().toggleClass('active');
    });


    // Select
    $('.nice-select').niceSelect();

    // Phone
    $(".phone").intlTelInput({
        preferredCountries: ["sa", "gb"],
        separateDialCode: true,
        hiddenInput: "full",
    });




    /*======================= show dropdown in navbar =====================*/
    $(".login_box .icon").on('click', function(e) {
        e.stopPropagation();
        $(this).next().toggleClass('open');
        $(this).parent().siblings().find('.dropdown_menu').removeClass('open');
        $('.minicartBox').removeClass('show')
    })

    $(".login_box .dropdown_menu").on('click', function(e) {
        e.stopPropagation();
    })

    $("body").on('click', function() {
        $(".login_box .dropdown_menu").removeClass('open')
    })

    /* =============================== Settings of content tabs =============================== */
    $('.mou_tab').on('click', function(e) {

        e.preventDefault();

        $(this).addClass('active').siblings().removeClass('active');

        var id = $(this).attr('data-content')

        $('.box_content[id="' + id + '"]').addClass('active').siblings().removeClass('active')

    })

    /* =============================== animation on hr =============================== */

    $(window).scroll(function() {

        'use strict';

        $('.heading_line').each(function() {

            if ($(window).scrollTop() >= $(this).offset().top - window.innerHeight) {

                $(this).find('hr').addClass('hr-width')

            }
        })


    });

    $('.heading_line').each(function() {

        if ($(window).scrollTop() >= $(this).offset().top - window.innerHeight) {

            $(this).find('hr').addClass('hr-width')

        }
    })


    /*======================= slide toggle =====================*/
    $('.single_course_page .course_block .head').on('click', function() {
        $(this).parent().find('.content').slideToggle();
        $(this).parent().siblings().find('.content').slideUp();
    })


    $(".single_exam_page .explain_btn").on('click', function() {
        $(this).parents(".ques_name_box").find(".ques_explain").slideToggle();
    })

    /* ===============================  venobox  =============================== */
    $('.venobox').venobox({
        bgcolor: '',
        overlayColor: 'rgba(6, 12, 34, 0.85)',
        closeBackground: '',
        closeColor: '#fff'
    });


    /* ===============================  control radio  =============================== */
    $('input:radio[name="type"]').change(function() {
        if (this.checked && this.value == 'student') {
            $('#firstContent').show()
            $('#secondContent').hide()
        } else if (this.checked && this.value == 'teacher') {
            $('#firstContent').hide()
            $('#secondContent').show()
        }
    });

    /* ===============================  control radio  =============================== */
    $('input:radio[name="educational_level"]').change(function() {
        if (this.checked && this.value == 'University stage') {
            $('#student_1').slideDown().siblings().slideUp();
        } else if (this.checked && this.value == 'High school') {
            $('#student_2').slideDown().siblings().slideUp();
        } else if (this.checked && this.value == 'Secondary school') {
            $('#student_3').slideDown().siblings().slideUp();
        } else if (this.checked && this.value == 'Primary school') {
            $('#student_4').slideDown().siblings().slideUp();
        } else if (this.checked && this.value == 'Kindergarten') {
            $('#student_5').slideDown().siblings().slideUp();
        }
    });


    /* =============================== edit personal information =============================== */
    $("#my_Information .input_box .icon").on('click', function() {
        $(this).parent().find('input').attr("readonly", false).attr("value", "").focus();
        $(this).parents('.section_content').find('.main-btn').removeAttr('disabled');
    })


    /* =============================== toggle lessons =============================== */
    $("#decisions_section .single_decision .head").on('click', function() {
        $(this).next().slideToggle();
        $(this).parent().siblings().find(".decision_content").slideUp();
        $(this).parent().siblings().find(".head i").addClass("la-plus");
        $(this).find("i").toggleClass("la-plus")
    })

    /* =============================== toggle lessons =============================== */
    $("#course_section .lessons_card .head").on('click', function() {
        $(this).next().slideToggle();
        $(this).parent().siblings().find(".lessons_content").slideUp();
        $(this).parent().siblings().find(".head .arrow i").removeClass("rotate");
        $(this).find(".arrow i").toggleClass("rotate")
    })


    /* =============================== toggle lessons =============================== */
    $("#exams_content .lessons_card .head").on('click', function() {
        $(this).next().slideToggle();
        $(this).parent().siblings().find(".lessons_content").slideUp();
        $(this).parent().siblings().find(".head .arrow i").removeClass("rotate");
        $(this).find(".arrow i").toggleClass("rotate")
    })


    $(".mobile_list .dropdown_item").on('click', function() {
        $(this).find(".dropdown_menu").slideToggle();
    })

    $(".second_nav .toggle_icon").on('click', function(e) {
        $(".mobile_list").toggleClass("open")
        e.stopPropagation();
    })
    $("body").on('click', function() {
        $(".mobile_list").removeClass("open")
    })

    $(".mobile_list").on('click', function(e) {
        e.stopPropagation();
    })


    $(".question_wrapper > .name_ques").on('click', function() {
        $(this).next().slideToggle();
        $(".result_box").show();
        
            // if ($(".question_wrapper .show_ans").hasClass('close')) {

            //     if(lang == 'ar')
            //     {
            //         $(".question_wrapper .show_ans").find('span').text("عرض أقل")
            //     }
            //     else
            //     {
            //         $(".question_wrapper .show_ans").find('span').text("show less")
            //     }
            //     $(".question_wrapper .show_ans").removeClass('close')
            // } else {
            //     if(lang == 'ar')
            //     {
            //         $(".question_wrapper .show_ans").find('span').text("عرض الاجابة")
            //     }
            //     else
            //     {
            //         $(".question_wrapper .show_ans").find('span').text("show answer")
            //     }

            //     $(".question_wrapper .show_ans").addClass('close')
            // }
    })

});

/*======================= copy =====================*/
const copyButton = document.querySelectorAll('#markiting_section .copy_btn');

copyButton.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        window.getSelection().selectAllChildren(btn.parentElement.previousElementSibling);
        document.execCommand("copy");
    })
})



/*======================= show video in course box =====================*/

// let playIcon = document.querySelectorAll(".cour-block .play_icon");
// let closeIcon = document.querySelectorAll(".cour-block .close_video");

// playIcon.forEach((icon) => {
//     icon.onclick = function() {
//         this.nextElementSibling.classList.add('play');
//         this.nextElementSibling.play();
//         this.nextElementSibling.nextElementSibling.classList.add('show');
//     }
// })

// closeIcon.forEach((icon) => {
//     icon.onclick = function() {
//         this.previousElementSibling.classList.remove('play');
//         this.previousElementSibling.pause();
//         this.classList.remove('show');
//     }
// })

$(function() {

    $('.vimeo').each(function() {

        //var iframe = document.querySelector('iframe');
        var iframe = this;
        var player = new Vimeo.Player(iframe);
        // player.setAutopause(true); // default
        player.ready().then(function() {
            console.log(player.element);
            var $player = $(player.element);
            var $container = $player.parent().parent().parent();
            $container.addClass("ready");
            $container.on("click", function() {
                player.play();
                $container.addClass("play");
            })

        })

    })
});


/* ===============================  search popup  =============================== */

let iconSearch = document.getElementById('icon_search');
let searchPopup = document.getElementById('search-popup');
let searchForm = document.querySelector('.aws-search-form');

if (searchPopup) {
    iconSearch.addEventListener('click', () => {
        searchPopup.classList.add('active')
    })

    searchPopup.addEventListener('click', () => {
        searchPopup.classList.remove('active')
    })

    searchForm.addEventListener('click', (e) => {
        e.stopPropagation();
    })
}




$(window).scroll(function() {
    if ($(this).scrollTop() > 400) {
        $('.fixed-box').addClass('stickey');
    } else {
        $('.fixed-box').removeClass('stickey');
    }
});

/* ===============================  minicart  =============================== */
$('.icon_cart').on('click', function() {
    $('.minicartBox').toggleClass('show')
    $('.login_box .dropdown_menu').removeClass('open')
})

$('.minicartBox h5 span , body').on('click', function() {
    $('.minicartBox').removeClass('show')
})

$('.minicart_wrapper').on('click', function(e) {
    e.stopPropagation();
})

$('.btn-drop').on('click', function(e) {
    $(".sub-drop").toggleClass("active");
})

/* ===============================  show password =============================== */
$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});


    function myFunction(x) {
        if (x.matches) {
             
                 $(".single_course_join_page #course_section .lessons_card .lessons_content .single_lesson").on('click', function() {
               
                    $('html, body').animate({
            
                        scrollTop: 120000
            
                    }, 1000);
    
                })
             
            
        } else {
            return false;
        }
    }
    var x = window.matchMedia("(max-width: 991px)")
    myFunction(x)
    x.addListener(myFunction)
    
    
    
    /*========================== settings of comments ===========================*/

$('.single-comment .replaies-btn').on('click', function() {
    $(this).toggleClass('active');
    $(this).parents('.single-comment').find('.replaies-comments').slideToggle();
})


/*========================== lazyload ===========================*/
$(function() {
    $(".lazyload").lazyload({
        effect: "fadeIn"
    });
});

document.addEventListener('contextmenu', event => event.preventDefault());

$(document).ready(function() {
    $('.radioshow').on('change', function() { 
        var val = $(this).attr('data-class'); 
        $('.allshow').hide('slow');
        $('.' + val).show('slow');        
    });
}); 

$('.onceClick').on('click', function() { 
    $('.onceClick').addClass('disblad');    
});


