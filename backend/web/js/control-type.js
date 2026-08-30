//Revenue
function submitControlType() {

    var error = false;

    if($('#m_select2_control-types_validate :selected').text() == ""){
        $('#m_select2_control-types_validate').parent('div').addClass('has-error');
        $("#m_select2_control-types_validate").siblings(".help-block").text("«Փաստաթղթերի տեսակներ» -ը չի կարող դատարկ լինել:");
        $("#m_select2_control-types_validate").siblings(".help-block").show();
        error = true;
    }else{
        $('#m_select2_control-types_validate').parent('div').removeClass('has-error');
        $("#m_select2_control-types_validate").siblings(".help-block").hide();
        $("#m_select2_control-types_validate :selected").prop("readonly",true);

        var text = $('#m_select2_control-types_validate :selected').text();

        var source = text.split(' - ');

        var controlTypeCode =  source[0];
        var controlTypeName = source[1];
        var controlTypeNameID = $('#m_select2_control-types_validate').val();
    }


    if(!error){

        var count = $('.control_type-row').length;
        var id = count + 1;
        var newRow = "<tr class='control_type-row m-datatable__row m-datatable__row--even' data-count='"+id+"' >";
        newRow += "<td class='m-datatable__cell--center m-datatable__cell'>";
        newRow += "<span id='control_type-span-id-"+id+"' class='' style='width: 50px;'>"+id+"</span>";
        newRow += "</td>";

        newRow += "<td class='m-datatable__cell'>";
        newRow += "<span id='control_type-span-name-"+id+"' class='' style='width: 100px;'>"+controlTypeCode+"</span>";
        newRow += "</td>";

        newRow += "<td class='m-datatable__cell'>";
        newRow += "<span id='control_type-span-name-"+id+"' class='' style='width: 150px;'>"+controlTypeName+"</span>";
        newRow += "<input id='control_type-input-name-"+id+"' type='hidden' name='ControlTypeHasDocumentType[document_type_id][]' value='"+controlTypeNameID+"'>";
        newRow += "</td>";


        newRow += "<td class='m-datatable__cell'>";
        newRow += "<span  style='overflow: visible; width: 120px;'>  ";
        newRow += "<a onclick='removeMethod("+id+")' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-trash'></i></a>";
        newRow += "</span>";
        newRow += "</td>";


        $('.control_type-body').append(newRow);
        $('#control_type').val(id);


        $('#add-control_type').modal('toggle');

        $('#m_select2_control-types_validate').parent('div').removeClass('has-success');
        $("#m_select2_control-types_validate").select2('val', 'All');
        $('#m_select2_control-types_validate').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('.field-control_type .help-block').html('');

    }
}

function formatDocumentType (state) {
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
function createMethod(){
    $('#add-control_type').modal('toggle');

    if($("#m_select2_control-types_validate").val() != ''){

        $("#m_select2_control-types_validate").select2('val', 'All');
        $('.field-m_select2_control-types_validate').removeClass('has-error');
        $('.field-m_select2_control-types_validate label').css('color','black');
        $('.field-m_select2_control-types_validate .help-block').remove();

    }

    $("#m_select2_control-types_validate option").prop('disabled',false);
    $.each($('*[id^="control_type-input-name-"]'), function( index, value ) {

        $("#m_select2_control-types_validate option[value='"+$(value).val()+"']").prop('disabled',true);
    });
    var $el = $("#m_select2_control-types_validate"), // your input id for the HTML select input
        settings = $el.attr('data-krajee-select2');
    settings = window[settings];
    // reinitialize plugin
    $el.select2(settings);


    $('#m_select2_control-types_validate').select2({
        placeholder: "Ընտրեք ցանկից",
        templateResult: formatDocumentType,
    });
}
function removeMethod(id){
    if(confirm("Համոզված եք որ ցանկանում եք ջնջել?")){

        $("tr[data-count='"+id+"']").remove();
        var rowCount = $('.control_type-row').data('count');
        if(rowCount){
            $('#control_type').val(1);
        }else{
            $('#control_type').val('');
        }

    }
}

function showDocumentTypes(id){
    console.log(id);
    $.ajax({
        type: "POST",
        url: "/app/control-types/get-document-type",
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if ((typeof obj.error !== 'undefined')) {
                alert(obj.error);
            } else {
                var cont = "";
                $.each(obj, function(index , value ) {
                    cont += "<tr class='animal-row m-datatable__row m-datatable__row--even' data-count='"+index+"'>"+
                        "<td class='m-datatable__cell--center m-datatable__cell'>"+
                        "<span id='animal-span-id-<?= $i; ?>' class='' style='width: 30px;'>"+index+"</span>"+
                        "</td>"+
                        "<td class='m-datatable__cell'>"+
                        "<span class='' style='width: 190px;'>"+value.code+"</span>"+
                        "</td>"+
                        "<td class='m-datatable__cell'>"+
                        "<span style='width: 200px;'>"+value.name+"</span>"+
                        "</td>"+
                        "</tr>";
                });

                a = $(".m_datatable").mDatatable({})
                $('.popup-cont').html(cont);

            }
        },
        complete: function (xhr) {
            if (xhr.status != 200) {
                alert("Error");

            }
        }
    });
}