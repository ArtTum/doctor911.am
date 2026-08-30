/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var pathname = window.location.pathname;

$( "#m_aside_left li" ).each(function( index ) {
    if(($( this ).children('a').attr('href')) == pathname){
        $( this ).addClass('m-menu__item--active');
    }
});

$(function(){
    $('#testDiv').slimScroll({
        height: $( window ).height()-70,
    });
});
$('#express-price').change(function() {

    if($(this).is(":checked")) {
        $('.field-verificationtype-express_price').removeClass('hide')
    }else{
        $('.field-verificationtype-express_price').addClass('hide');
        $('.field-verificationtype-express_price input').val('');
    }

});
$('#uploads').on('click', function () {
    $('.fileinput-preview').click();
});

$('.fileinput .remove').on('click', function () {
    var id = parseInt($(this).data('id'));
    var url = '/products/image-remove';
    $(this).hide();
    if (id) {
        $.ajax({
            type: "POST",
            url: url,
            data: "id=" + id,
            dataType: 'json',
            async: false,
            success: function (data) {
                $(this).hide();
            }
        });
    }
});
/*upload image additem page*/
$('.fileinput').fileinput();
$('#icondemo').filestyle({
    iconName : 'la la-cloud-upload',
    buttonText : 'Ընտրեք Ֆայլը',
    buttonName : 'btn btn-metal'
});


$(document).ready(function() {

    function formatProductType (state) {
        if (!state.id) { return state.text; }
        var $state;
        if(state.id ){
            var source = state.text.split(' - ');
            var i = 0;
            var obj = source.reduce(function(o, val) {
                    i++;
                        if (i === 1){
                            o['code'] = val; return o;
                        }else {
                            o['name'] = val; return o;
                        }
                    }, {}
                );
            $state = $(
                '<span><span style="width: 20%;float: left;">'+obj.code+'</span>  <span style="width: 80%;display: inline-block">'+obj.name+'</span></span>'
            );
        }
        return $state;
    };
    $(".js-states-contact").select2({
        placeholder: "Ընտրեք ցանկից",
        templateResult: formatProductType
    });




});
function menuOpen() {

    var width = $("#m_ver_menu").width();

    if (width == 250){
        $("#m_ver_menu").css("width", "70px");
    }else {
        $("#m_ver_menu").css("width", "250px");
    }
}
