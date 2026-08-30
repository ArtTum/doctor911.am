//Animal
function submitAnimal(elm){

    var error = false;

    if(($('#slaughteranimal-quantity').val() == "")){
        $('#slaughteranimal-quantity').parent('div').addClass('has-error');
        $("#slaughteranimal-quantity").next(".help-block").text("Քանակը չի կարող դատարկ լինել:");
        $("#slaughteranimal-quantity").next(".help-block").show();
        error = true
    }else if(($('#slaughteranimal-quantity').val() != "" && !$.isNumeric($('#slaughteranimal-quantity').val()))){
        $('#slaughteranimal-quantity').parent('div').addClass('has-error');
        $("#slaughteranimal-quantity").next(".help-block").text("Quantity must be an integer.");
        $("#slaughteranimal-quantity").next(".help-block").show();
        error = true
    }else{
        $('#slaughteranimal-quantity').parent('div').removeClass('has-error');
        var quantity = $('#slaughteranimal-quantity').val();
        $("#slaughteranimal-quantity").next(".help-block").hide();
    }

    if(($('#slaughteranimal-weight').val() == "")){
        $('#slaughteranimal-weight').parent('div').addClass('has-error');
        $("#slaughteranimal-weight").next(".help-block").text("ct չի կարող դատարկ լինել:");
        $("#slaughteranimal-weight").next(".help-block").show();
        error = true
    }else{
        $('#slaughteranimal-weight').parent('div').removeClass('has-error');
        var weight = $('#slaughteranimal-weight').val();
        $("#slaughteranimal-weight").next(".help-block").hide();
    }

    if(!error){
        var type = $("#modal-type").val();

        if(type == "add"){
            var count = $('.animal-row').length;
            var id = count + 1;
            var newRow = "<tr class='animal-row m-datatable__row m-datatable__row--even' data-count='"+id+"' >";
            newRow += "<td class='m-datatable__cell--center m-datatable__cell'>";
            newRow += "<span id='animal-span-id-"+id+"' class='' style='width: 50px;'>"+id+"</span>";
            newRow += "<input id='animal-input-id-"+id+"' type='hidden' name='Diamond[id][]' value='"+id+"'>";
            newRow += "</td>";



            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='animal-span-quantity-"+id+"' class='' style='width: 120px;'>"+quantity+"</span>";
            newRow += "<input id='animal-input-quantity-"+id+"' type='hidden' name='Diamond[count][]' value='"+quantity+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='animal-span-weight-"+id+"' class='' style='width: 120px;'>"+weight+"</span>";
            newRow += "<input id='animal-input-weight-"+id+"' type='hidden' name='Diamond[param][]' value='"+weight+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span  style='overflow: visible; width: 150px;'>  ";
            newRow += "<a onclick='editAnimal("+id+")' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-edit'></i></a>";
            newRow += "<a onclick='removeAnimal("+id+")' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-trash'></i></a>";
            newRow += "</span>";
            newRow += "</td>";


            $('.animal-body').append(newRow);
            $('#slaughter-animal').val(id);
        }else{
            var typeArray = type.split("-");
            var id = typeArray[1];
            $("#animal-span-name-"+id).html($('#slaughteranimal-animal_id :selected').text());
            $("#animal-input-name-"+id).val($('#slaughteranimal-animal_id').val());
            $("#animal-span-quantity-"+id).html($('#slaughteranimal-quantity').val());
            $("#animal-input-quantity-"+id).val($('#slaughteranimal-quantity').val());
            $("#animal-span-weight-"+id).html($('#slaughteranimal-weight').val());
            $("#animal-input-weight-"+id).val($('#slaughteranimal-weight').val());
        }


        $('#slaughteranimal-animal_id').val("");
        $('#slaughteranimal-weight').val("");
        $('#slaughteranimal-quantity').val("");

        $('#add-animal').modal('hide');
        $('.modal-backdrop').remove();

    }
}
function createAnimal(){

    var $el = $("#slaughteranimal-animal_id"), // your input id for the HTML select input
        settings = $el.attr('data-krajee-select2');
    settings = window[settings];
    // reinitialize plugin
    $el.select2(settings);

    $("#slaughteranimal-animal_id").siblings(".help-block").text("");
    $("#slaughteranimal-quantity").next(".help-block").text("");
    $("#slaughteranimal-weight").next(".help-block").text("");



    $('#add-animal').modal('toggle');
    $("#slaughteranimal-animal_id").val("").trigger('change').trigger('change');
    $("#slaughteranimal-quantity").val("");
    $("#slaughteranimal-weight").val("");
    $("#modal-type").val("add");
}
function editAnimal(id){

    $("#slaughteranimal-quantity").val($("#animal-input-quantity-"+id).val());
    $("#slaughteranimal-weight").val($("#animal-input-weight-"+id).val());
    $("#modal-type").val("edit-"+id);
    $('#add-animal').modal('toggle');
}
function removeAnimal(id){
    if(confirm("Համոզված եք որ ուզում եք ջնջել?")){
        $("tr[data-count='"+id+"']").remove();
        var rowCount = $('#slaughter-animal').val();
        if(rowCount == 1){
            $('#slaughter-animal').val("");
        }else{
            $('#slaughter-animal').val(rowCount - 1);
        }

    }

}