$(document).ready(function () {
    //owner
    $("#customer_name_span").remove()
    if ($("#deliverys-customer_name").val() == "") {
        $("#deliverys-customer_name").before("<br><span id='customer_name_span' class='not-marked'>Նշված չէ</span>");
    } else {
        $("#deliverys-customer_name").before("<br><span id='customer_name_span' class='not-marked'>" + $("#deliverys-customer_name").val() + "</span>");

        $("#deliverysearch").remove();
        $("#deliverys-customer_pass_id").after('<span id="deliveryClear" onclick=\'deliveryClear();\' class="input-group-addon pass-clrear"><i class="fa fa-eraser" aria-hidden="true"></i></span>');
    }

    $("#customer_address_span").remove()
    if ($("#deliverys-customer_address").val() == "") {
        $("#deliverys-customer_address").before("<br><span id='customer_address_span'class='not-marked'>Նշված չէ</span>");
    } else {
        $("#deliverys-customer_address").before("<br><span id='customer_address_span' class='not-marked'>" + $("#deliverys-customer_address").val() + "</span>");
    }

    $("#slaughteranimal-animal_id").on("change",function(){
        var id = $(this).val();
        if(id == null){
            id = $("#slaughteranimal-animal_id option:selected").val();
        }

        if((id != '')){
            $.ajax({
                type: "POST",
                url: "/app/delivery/check-balance",
                data: {id: id},
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if ((typeof obj.error !== 'undefined')) {
                        alert(obj.error);
                    } else {

                        $("#balance").html(obj);
                        $("#balance").show();
                    }
                },
                complete: function (xhr) {
                    if (xhr.status != 200) {
                        alert("Error");
                        $('.loader').hide();
                    }
                }
            });
        }

    });
});

function deliveryClear() {
    $("#deliverys-customer_pass_id").val("");

    $("#customer_name_span").html("Նշված չէ");
    $("#deliverys-customer_name").val("");

    $("#customer_address_span").html("Նշված չէ");
    $("#deliverys-customer_address").val("");
    $("#deliverys-company_type").val("");

    $("#deliverys-customer_city_town").val("");

    $("#deliveryClear").remove();
    $("#deliverys-customer_pass_id").after('<span id="deliverysearch" onclick=\'deliverySearch();\' class="input-group-addon pass-search"><i class="fa fa-search" aria-hidden="true"></i></span>');
    $("#deliverys-customer_pass_id").prop("readonly",false);
}

function deliverySearch() {
    var taxID = $("#deliverys-customer_pass_id").val();
    if (taxID == "") {
        $(".field-deliverys-customer_pass_id").addClass("has-error");
        $(".field-deliverys-customer_pass_id .help-block").html("«ՀՎՀՀ/Անձնագիր» չի կարող լինել դատարկ.");
    }  else {
        $(".field-deliverys-customer_pass_id").removeClass("has-error");
        $(".field-deliverys-customer_pass_id .help-block").html("");
        $('.loader').show();
        if ($(".customer_type_id").val() == 1) {
            $.ajax({
                type: "POST",
                url: "/app/slaughter/check-tax",
                data: {taxID: taxID},
                success: function (data) {
                    $('.loader').hide();
                    var obj = jQuery.parseJSON(data);
                    if ((typeof obj.error !== 'undefined')) {
                        alert(obj.error);
                    } else {
                        //name
                        var name_am = obj.result.company.name_am
                        $("#customer_name_span").html(name_am);
                        $("#deliverys-customer_name").val(name_am);
                        $('.field-deliverys-customer_name').removeClass("has-error");
                        $('.field-deliverys-customer_name .help-block').html("");
                        //address
                        var addr_descr = obj.result.company.address.addr_descr.toUpperCase();
                        $("#customer_address_span").html(addr_descr ? addr_descr : 'Նշված չէ')
                        $("#deliverys-customer_address").val(addr_descr ? addr_descr : 'Նշված չէ');
                        $("#deliverys-company_type").val(obj.result.company.company_type_id);
                        $('.field-deliverys-customer_address').removeClass("has-error");
                        $('.field-deliverys-customer_address .help-block').html("");
                        //town
                        var city_town = obj.result.company.address.city_town
                        $("#deliverys-customer_city_town").val(city_town);

                        $("#deliverysearch").remove();
                        $("#deliverys-customer_pass_id").after('<span id="deliveryClear" onclick=\'deliveryClear();\' class="input-group-addon pass-clrear"><i class="fa fa-eraser" aria-hidden="true"></i></span>');
                        $("#deliverys-customer_pass_id").prop("readonly",true);
                    }
                },
                complete: function (xhr) {
                    if (xhr.status != 200) {
                        alert("Error");
                        $('.loader').hide();
                    }
                }
            })
        } else {
            $.ajax({
                type: "POST",
                url: "/app/slaughter/check-passport",
                data: {passportID: taxID},
                success: function (data) {
                    $('.loader').hide();
                    var obj = jQuery.parseJSON(data);
                    if ((typeof obj.error !== 'undefined')) {
                        alert(obj.error);
                    } else {
                        //name
                        var name_am = obj.last_name +' '+obj.first_name;
                        $("#customer_name_span").html(name_am);
                        $("#deliverys-customer_name").val(name_am);
                        $('.field-deliverys-customer_name').removeClass("has-error");
                        $('.field-deliverys-customer_name .help-block').html("");
                        //address
                        var addr_descr = obj.passport_data.AVVRegistrationAddress.Region+", "+obj.passport_data.AVVRegistrationAddress.Community+", "+obj.passport_data.AVVRegistrationAddress.Street+" "+obj.passport_data.AVVRegistrationAddress.Building+obj.passport_data.AVVRegistrationAddress.BuildingType+" "+obj.passport_data.AVVRegistrationAddress.Apartment
                        $("#customer_address_span").html(addr_descr ? addr_descr : 'Նշված չէ')
                        $("#deliverys-customer_address").val(addr_descr ? addr_descr : 'Նշված չէ');
                        $('.field-deliverys-customer_address').removeClass("has-error");
                        $('.field-deliverys-customer_address .help-block').html("");
                        //town
                        var city_town = obj.passport_data.AVVRegistrationAddress.LocationCode;
                        $("#deliverys-customer_city_town").val(city_town);

                        $("#deliverysearch").remove();
                        $("#deliverys-customer_pass_id").after('<span id="deliveryClear" onclick=\'deliveryClear();\' class="input-group-addon pass-clrear"><i class="fa fa-eraser" aria-hidden="true"></i></span>');
                        $("#deliverys-customer_pass_id").prop("readonly",true);
                    }
                },
                complete: function (xhr) {
                    if (xhr.status != 200) {
                        alert("Error");
                        $('.loader').hide();
                    }
                }
            })
        }
    }
}

function submitDelivery(elm){
    var error = false;
    if($('#slaughteranimal-animal_id').val() == ""){
        $('#slaughteranimal-animal_id').parent('div').addClass('has-error');
        $("#slaughteranimal-animal_id").siblings(".help-block").text("Կենդանին չի կարող դատարկ լինել:");
        $("#slaughteranimal-animal_id").siblings(".help-block").show();
        error = true;
    }else{
        $('#slaughteranimal-animal_id').parent('div').removeClass('has-error');
        $("#slaughteranimal-animal_id").siblings(".help-block").hide();
        var animalName = $('#slaughteranimal-animal_id :selected').text();
        var animalId = $('#slaughteranimal-animal_id').val()
    }

    if(($('#slaughteranimal-weight').val() == "") || ($('#slaughteranimal-weight').val() == "0")){
        $('#slaughteranimal-weight').parent('div').addClass('has-error');
        $("#slaughteranimal-weight").next(".help-block").text("Քաշը չի կարող դատարկ լինել:");
        $("#slaughteranimal-weight").next(".help-block").show();
        error = true;
    }else if(($('#slaughteranimal-weight').val() != "" && !$.isNumeric($('#slaughteranimal-weight').val()))){
        $('#slaughteranimal-weight').parent('div').addClass('has-error');
        $("#slaughteranimal-weight").next(".help-block").text("Քաշը պետք է լինի ամբողջական:");
        $("#slaughteranimal-weight").next(".help-block").show();
        error = true;
    }else if((parseInt($('#slaughteranimal-weight').val()) > parseInt($('#balance').html()))){
        $('#slaughteranimal-weight').parent('div').addClass('has-error');
        $("#slaughteranimal-weight").next(".help-block").text("Քաշը չի կարող մեծ լինել:");
        $("#slaughteranimal-weight").next(".help-block").show();
        error = true;
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
            newRow += "<input id='animal-input-id-"+id+"' type='hidden' name='animal[id][]' value='"+id+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='animal-span-name-"+id+"' class='' style='width: 150px;'>"+animalName+"</span>";
            newRow += "<input id='animal-input-name-"+id+"' type='hidden' name='animal[animal_id][]' value='"+animalId+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='animal-span-weight-"+id+"' class='' style='width: 120px;'>"+weight+"</span>";
            newRow += "<input id='animal-input-weight-"+id+"' type='hidden' name='animal[weight][]' value='"+weight+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span  style='overflow: visible; width: 120px;'>  ";
            newRow += "<a onclick='editAnimalD("+id+")' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-edit'></i></a>";
            newRow += "<a onclick='removeAnimalD("+id+","+animalId+")' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-trash'></i></a>";
            newRow += "</span>";
            newRow += "</td>";


            $('.animal-body').append(newRow);
            $('#deliverys-animal').val(id);
        }else{
            var typeArray = type.split("-");
            var id = typeArray[1];
            console.log(id);
            console.log("text" + $('#slaughteranimal-animal_id :selected').text());
            console.log("id" + $('#slaughteranimal-animal_id').val());

            $("#animal-span-name-"+id).html($('.edit-name').html());
            $("#animal-input-name-"+id).val($('.edit-id').html());
            $("#animal-span-weight-"+id).html($('#slaughteranimal-weight').val());
            $("#animal-input-weight-"+id).val($('#slaughteranimal-weight').val());
        }


        $('#slaughteranimal-animal_id').val("");
        $('#slaughteranimal-weight').val("");

        $('#add-animal').modal('hide');
        $('.modal-backdrop').remove();

    }
}
function createAnimalD(){
    $('.edit-name').remove();
    $('#balance').hide();
    $('.field-slaughteranimal-quantity .select2').show();
    $("#slaughteranimal-animal_id option").prop('disabled',false);
    $.each($('*[id^="animal-input-name-"]'), function( index, value ) {
        console.log(value);
        $("#slaughteranimal-animal_id option[value='"+$(value).val()+"']").prop('disabled',true);
    });
    var $el = $("#slaughteranimal-animal_id"), // your input id for the HTML select input
        settings = $el.attr('data-krajee-select2');
    settings = window[settings];
    // reinitialize plugin
    $el.select2(settings);


    $('#add-animal').modal('toggle');
    $("#slaughteranimal-animal_id").val("").trigger('change').trigger('change');
    $("#slaughteranimal-weight").val("");
    $("#modal-type").val("add");
}

function editAnimalD(id){
    $('.edit-name').remove();
    $('.edit-id').remove();
    $('.field-slaughteranimal-quantity .select2').hide();
    $("#slaughteranimal-animal_id").after("<span class='edit-name'>"+$("#animal-span-name-"+id).text()+"</span> <span class='edit-id'>"+$("#animal-input-name-"+id).val()+"</span>");
    $("#slaughteranimal-animal_id").val($("#animal-input-name-"+id).val()).trigger('change');
    $("#slaughteranimal-weight").val($("#animal-input-weight-"+id).val());


    $("#modal-type").val("edit-"+id);
    $('#add-animal').modal('toggle');

}


function removeAnimalD(id, animalId){
    if(confirm("Համոզված եք որ ուզում եք ջնջել?")){
        $.ajax({
            type: "POST",
            url: "/app/delivery/remove-animal",
            data: {id: animalId},
            success: function (data) {
                $("tr[data-count='"+id+"']").remove();
                var rowCount = $('#deliverys-animal').val();
                if(rowCount == 1){
                    $('#deliverys-animal').val("");
                }else{
                    $('#deliverys-animal').val(rowCount - 1);
                }

            },
            complete: function (xhr) {
                if (xhr.status != 200) {
                    alert("Error");
                    $('.loader').hide();
                }
            }
        });
    }
}

function showDelivery(id){
    $.ajax({
        type: "POST",
        url: "/app/delivery/get-deliveries",
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
                        "<span  class='' style='width: 30px;'>"+index+"</span>"+
                        "</td>"+
                        "<td class='m-datatable__cell'>"+
                        "<span style='width: 150px;'>"+value.name+"</span>"+
                        "</td>"+
                        "<td class='m-datatable__cell'>"+
                        "<span  style='width: 150px;'>"+value.balance+"</span>"+
                        "</td>"+
                        "</tr>";
                });

                a = $(".m_datatable").mDatatable({});
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