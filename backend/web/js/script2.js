function createLabIndicator() {
    $(".lab_indicator_btn").attr("disabled", true);
    $.each($('*[id^="indicator-input-name-"]'), function( index, value ) {
        var id = $(this).data('id')
        $(".lab_indicator_id option[value='"+id+"']").prop('disabled',true);
    });


    $("#m_select2_2_validate").val("All");
    $('#m_select2_2_validate').select2({
        placeholder: "Ընտրեք ցանկից"
    });

    $("#m_select2_1_validate").val("");
    $('#m_select2_1_validate').select2({
        placeholder: "Ընտրեք ցանկից"
    });

}

$( ".lab_indicator_id" ).change(function() {
    var val = $(this).val();

    $.ajax({
        type: "POST",
        url:'/app/labs/ajax',
        data : {id:val},
        dataType: 'json',
        async:false,
        success: function(data){

            $('.lab_indicator_btn').removeAttr("disabled");
        }
    });
});

function editLabIndicator(id){

    $.ajax({
        type: "POST",
        url:'/app/labs/ajax2',
        data : {id:id},
        dataType: 'json',
        async:false,
        success: function(data){
            $('.indicator_id').val(data.indicator_id);
            $('.lab_indicator_id').val(data.id);
            $('#indicator_name').html(data.name);

            var arr = $.map(data.verification_method_id, function(el) { return el });

            $('select').select2().val(arr).trigger('change');
        }
    });
}

function menuOpen() {

    var width = $("#m_ver_menu").width();

    if (width == 250){
        $("#m_ver_menu").css("width", "70px");
    }else {
        $("#m_ver_menu").css("width", "250px");
    }
}

var pathname = window.location.pathname;

$( "#m_aside_left li" ).each(function( index ) {
    if(($( this ).children('a').attr('href')) == pathname){
        $( this ).addClass('m-menu__item--active');
        var parentTag = $( this ).parent().get( 0 );
        var parentTag2 = $( parentTag ).parent().get( 0 );
        var parentTag3 = $( parentTag2 ).parent().get( 0 );
         $( parentTag3 ).addClass('m-menu__item--active');
    }
});

$(function(){
    $('#testDiv').slimScroll({
        height: $( window ).height()-70
    });
    $('#testDiv').slimScroll({ scrollTo: $('#m_aside_left .m-menu__item--active').position().top+"px"});
});

$('#testDiv').animate({scrollTop: $('#m_aside_left .m-menu__item--active').position().top}, 0);

$(document).on("keypress",".select2-input",function(event){
    if (event.ctrlKey || event.metaKey) {
        var id =$(this).parents("div[class*='select2-container']").attr("id").replace("s2id_","");
        var element =$("#"+id);
        if (event.which == 97){
            var selected = [];
            element.find("option").each(function(i,e){
                selected[selected.length]=$(e).attr("value");
            });
            element.select2("val", selected);
        } else if (event.which == 100){
            element.select2("val", "");
        }
    }
});
