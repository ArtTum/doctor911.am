$(document).ready(function(){

    var win = $(window);
    var p = 1;
    win.scroll(function() {

        var maxPage = parseInt($('.page-count').data('max'));


        if (parseInt($(document).height() - win.height()) <= parseInt(win.scrollTop() + 200)) {


            $('#content').addClass('active');

            if ($("#content").hasClass('active')) {

                p++;
                console.log(maxPage);

                if (p <= maxPage) {

                    if(maxPage){
                        $('footer').addClass('hide');
                    }

                    $('#loading').show();

                    $.ajax({
                        url: window.location+'/'+p,
                        type: "GET",
                        async: false,
                        success: function(html) {
                            setTimeout(function(){
                                $("#content").append(html);
                                }, 500
                            );

                        }
                    });
                } else if(p <=  (parseInt($('.page-count').data('max')+1)) ){
                    $('#loading').hide();
                    $('footer').removeClass('hide');

                    console.log(p);
                    return false;
                }
            }
        }
    });

    $('.partner-slider').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: true,
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

    // Scroll Events
    $(window).scroll(function(){

        var wScroll = $(this).scrollTop();
        var width = $(this).width();

        if (width > 768 && wScroll > 80) {
            $('.navbar-inverse').addClass('navbar-fixed-top');
            $('.navbar-inverse').removeClass('navbar');
            $('.menu').addClass('hidden');
            $('.navbar-brand img').removeClass('hidden-lg hidden-md');
            $('.top-search').removeClass('hidden');
        }
        else {
            $('.navbar-inverse').removeClass('navbar-fixed-top');
            $('.navbar-inverse').addClass('navbar');
            $('.navbar-brand img').addClass('hidden-lg hidden-md');
            $('.menu').removeClass('hidden');
            $('.top-search').addClass('hidden');
        };

        //Scroll Effects
    });

    ///video
    // Gets the video src from the data-src on each button

    var $videoSrc;
    $('.video-btn').click(function() {
        $videoSrc = $(this).data( "src" );
    });

// when the modal is opened autoplay it
    $('#myModal').on('shown.bs.modal', function (e) {

// set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
        $("#video").attr('src',$videoSrc + "?rel=0&amp;showinfo=0&amp;modestbranding=1&amp;autoplay=1" );
    })


// stop playing the youtube video when I close the modal
    $('#myModal').on('hide.bs.modal', function (e) {
        // a poor man's stop video
        $("#video").attr('src','');


    })

    var timeOut;
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("myBtn").style.display = "block";

        } else {
            document.getElementById("myBtn").style.display = "none";

        }
    }


});
setInterval(function () {
    setTimeout(function(){
            $("#icon-video").css("opacity", "0.5");
            //alert("Hello");
        }, 500
    );
    setTimeout(function(){
            $("#icon-video").css("opacity", "1");
            //alert("Hello");
        }, 1000
    );
}, 2000);
setInterval(function () {
    setTimeout(function(){
            $("#myBtnPhone .b24-crm-button-icon").css("opacity", "0.5");
            //alert("Hello");
        }, 500
    );
    setTimeout(function(){
            $("#myBtnPhone .b24-crm-button-icon").css("opacity", "1");
            //alert("Hello");
        }, 1000
    );
}, 2000);

function registerDoctor(doctor) {
    $('#subscribe-doctor').val(doctor);
}

function registerHospital(hospital) {
    $('#subscribe-hospital').val(hospital);
}
document.querySelector('.custom-select-wrapper').addEventListener('click', function() {
    this.querySelector('.custom-select').classList.toggle('open');
});
window.addEventListener('click', function(e) {
    for (const select of document.querySelectorAll('.custom-select')) {
        if (!select.contains(e.target)) {
            select.classList.remove('open');
        }
    }
});

document.querySelector('.custom-select-wrapper1').addEventListener('click', function() {
    this.querySelector('.custom-select1').classList.toggle('open');
});
window.addEventListener('click', function(e) {
    for (const select of document.querySelectorAll('.custom-select1')) {
        if (!select.contains(e.target)) {
            select.classList.remove('open1');
        }
    }
});
