$(document).ready(function () {
    //owner
    $("#owner_name_span").remove()
    if ($("#fo-cert_num").val() == "") {
        $("#fo-cert_num").before("<br><h5 id='owner_name_span' class='not-marked'>Նշված չէ</h5>");
    } else {
        $("#fo-cert_num").before("<br><h5 id='owner_name_span' class='not-marked'>" + $("#fo-cert_num").val() + "</h5>");
        $("#passsearch").remove();
        $("#fo-taxid").after('<span id="passclrear" onclick=\'passclrear();\' class="input-group-addon pass-clrear"><i class="fa fa-eraser" aria-hidden="true"></i></span>');
    }

    $("#owner_address_span").remove()
    if ($("#fo-cert_num").val() == "") {
        $("#slaughter-owner_address").before("<br><span id='owner_address_span'class='not-marked'>Նշված չէ</span>");
    } else {
        $("#slaughter-owner_address").before("<br><span id='owner_address_span' class='not-marked'>" + $("#fo-cert_num").val() + "</span>");
    }

    if ($("#hhvh").val() == "") {
        $("#hhvh").before("<br><h5 id='hhvh_span'class='not-marked'>Նշված չէ</h5>");
    } else {
        $("#hhvh").before("<br><h5 id='hhvh_span' class='not-marked'>" + $("#hhvh").val() + "</h5>");
    }



    //delivery
    $("#delivery_name_span").remove()
    if ($("#delivery_address_span").val() == "") {
        $("#delivery_address_span").before("<br><h5 id='delivery_name_span' class='not-marked'>Նշված չէ</h5>");
    } else {
        $("#delivery_address_span").before("<br><h5 id='delivery_name_span' class='not-marked'>" + $("#delivery_address_span").val() + "</h5>");
        $("#passsearchdelivery").remove();
        $("#slaughter-delivery_pass_id").after('<h5 id="passclreardelivery" onclick=\'passclrearDelivery();\' class="input-group-addon pass-clrear"><i class="fa fa-eraser" aria-hidden="true"></i></h5>');
    }

    $("#delivery_address_span").remove()
    if ($("#fo-registered").val() == "") {
        $("#fo-registered").before("<br><h5 id='delivery_address_span' class='not-marked'>Նշված չէ</h5>");
    } else {
        var registered = $("#fo-registered").val()
        var myarr = registered.split("-");
        var myvar = myarr[2] + "." + myarr[1]+"." + myarr[0];
        $("#fo-registered").before("<br><h5 id='delivery_address_span' class='not-marked'>" + myvar + "</h5>");
    }
});

//api search
function passclrear() {
    $("#fo-taxid").val("");

    $("#owner_name_span").html("Նշված չէ");
    $("#fo-cert_num").val("");

    $("#delivery_address_span").html("Նշված չէ");
    $("#fo-registered").val("");

    $("#fo-postcode").val("");
    $("#fo-company_type").val("");
    $("#fo-company_type_long").html("");
    $("#fo-city_town").val("");
    //company_name
    $("#fo-name4").val('');
    $("#fo-name5").val('');
    $("#fo-name6").val('');
    //address
    $("#fo-address4").val('');
    //director
    $("#fo-executive_first_name4").val('');
    $("#fo-executive_middle_name5").val('');
    $("#fo-executive_last_name6").val('');
    //fo-phone
    $("#fo-phone").val('');

    $(".fo-show").addClass('hide');

    $("#passclrear").remove();
    $("#fo-taxid").after('<span id="passsearch" onclick=\'passsearch();\' class="input-group-addon pass-search"><i class="fa fa-search" aria-hidden="true"></i></span>');
    $("#fo-taxid").prop("readonly",false);
}
function passsearch() {
    var taxID = $("#fo-taxid").val();
    if (taxID == "") {
        $(".field-fo-taxid").addClass("has-error");
        $(".field-fo-taxid .help-block").html("«ՀՎՀՀ» չի կարող լինել դատարկ.");
    }  else {
        $(".field-fo-taxid").removeClass("has-error");
        $(".field-fo-taxid .help-block").html("");
        $('.loader').show();

        $.ajax({
            type: "POST",
            url: "/app/fo/check-tax",
            data: {taxID: taxID},
            success: function (data) {
                var obj = jQuery.parseJSON(data);

                if (!obj.result){
                    alert(obj.error.message);
                }
                $('.loader').hide();
                if ((typeof obj.error !== 'undefined')) {
                    console.log(obj.error.message)
                    alert(obj.error.message);
                } else {
                    //name
                    var reg_num = obj.result.company.reg_num;


                    $("#owner_name_span").html(reg_num);
                    $("#fo-cert_num").val(reg_num);

                    $('.field-fo-registered').removeClass("has-error");
                    $('.field-fo-registered .help-block').html("");
                    //date
                    var registered = obj.result.company.registered;

                    var myarr = registered.split("-");

                    var myvar = myarr[2] + "." + myarr[1]+"." + myarr[0];

                    $("#delivery_address_span").html(myvar);
                    $("#fo-registered").val(registered);

                    //company_name
                    var company_name_am = obj.result.company.name_am;
                    var company_name_ru = obj.result.company.name_ru;
                    var company_name_en = obj.result.company.name_en;

                    $(".fo-name4").val(company_name_am);
                    $(".fo-name5").val(company_name_ru);
                    $(".fo-name6").val(company_name_en);
                    //address
                    var address = obj.result.company.address.addr_descr;
                    $(".fo-address4").val(address);

                    //director
                    var director_first_name = (obj.result.company.executive) ? (obj.result.company.executive.first_name) : (obj.result.company.sole_proprietor.first_name);
                    var director_middle_name = (obj.result.company.executive) ? obj.result.company.executive.middle_name : obj.result.company.sole_proprietor.middle_name;
                    var director_last_name = obj.result.company.executive ? obj.result.company.executive.last_name : obj.result.company.sole_proprietor.last_name;

                    $(".executive_first_name4").val(director_first_name);
                    $(".executive_middle_name4").val(director_middle_name);
                    $(".executive_last_name4").val(director_last_name);

                    //fo-phone
                    var phone = obj.result.company.executive ? obj.result.company.executive.address.phone : obj.result.company.sole_proprietor.address.phone;
                    $("#fo-phone").val(phone);

                    //etc

                    var postcode = obj.result.company.address.postcode;
                    var city_town = obj.result.company.address.city_town;
                    var company_type_id = obj.result.company.company_type_id;
                    var company_type_long = obj.result.company.company_type_long ? obj.result.company.company_type_long : 'Նշված չէ';

                    $("#fo-postcode").val(postcode);
                    $("#fo-city_town").val(city_town);
                    $("#fo-company_type").val(company_type_id);
                    $("#fo-company_type_long").html(company_type_long);

                    $("#passsearch").remove();
                    $("#fo-taxid").after('<span id="passclrear" onclick=\'passclrear();\' class="input-group-addon pass-clrear"><i class="fa fa-eraser" aria-hidden="true"></i></span>');
                    $("#fo-taxid").prop("readonly",true);

                    $(".fo-show").removeClass('hide');
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

//activity type validate

function foSubmit() {


    var error = false;

    $( ".activity-show" ).each(function( index ) {

        if($(this).find('.company_activity-fo').val() == ""){
            $(this).find('.company_activity-fo').parent('div').parent('div').addClass('has-error');
            $(this).find(".company_activity-fo").siblings(".help-block").text("«Կարգավիճակ» -ը չի կարող դատարկ լինել:");
            $(this).find(".company_activity-fo").siblings(".help-block").show();
            error = true
        }else{
            $(this).find('.company_activity-fo').parent('div').parent('div').removeClass('has-error');
            $(this).find(".company_activity-fo").siblings(".help-block").hide();
        }

        if($(this).find('.activity-date').val() == ""){
            $(this).find('.activity-date').parent('div').parent('div').addClass('has-error');
            $(this).find(".activity-date").parent('div').siblings(".help-block").text("«Ամսաթիվ» -ը չի կարող դատարկ լինել:");
            $(this).find(".activity-date").parent('div').siblings(".help-block").show();
            error = true
        }else{
            $(this).find('.date').parent('div').parent('div').removeClass('has-error');
            $(this).find('.date').parent('div').removeClass('has-error');
            $(this).find('.date').siblings(".help-block").hide();
        }
    });

    if(!error){
        $('#fo-submit').attr('type', 'submit');
    }

}
$('#fohasfoactivitytype-fo_activity_type_id input').click(function() {

    var ID = $(this).val();

    if ( $(this).is(':checked') ) {

        $('#fo-submit').attr('type', 'button');
        $('.block-'+ID).removeClass('hide');
        $('.block-'+ID).addClass('activity-show');

    }else {

        $('.block-'+ID).addClass('hide');
        $('.block-'+ID).removeClass('activity-show');

        $('.block-'+ID+' .company_activity-fo').val('');
        $('.block-'+ID+' .company_activity-fo').parent('div').removeClass('has-success');
        $('.block-'+ID+' .company_activity-fo').select2('val', 'All');
        $('.block-'+ID+' .company_activity-fo').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('.block-'+ID+' .krajee-datepicker').val('');
    }

});

$('#foobjecthasfoactivitytype-fo_activity_type_id input').click(function() {

    var ID = $(this).val();

    console.log(ID);

    if ( $(this).is(':checked') ) {

        $('#fo-submit').attr('type', 'button');
        $('.block-'+ID).removeClass('hide');
        $('.block-'+ID).addClass('activity-show');

    }else {

        $('.block-'+ID).addClass('hide');
        $('.block-'+ID).removeClass('activity-show');

        $('.block-'+ID+' .company_activity-fo').val('');
        $('.block-'+ID+' .company_activity-fo').parent('div').removeClass('has-success');
        $('.block-'+ID+' .company_activity-fo').select2('val', 'All');
        $('.block-'+ID+' .company_activity-fo').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('.block-'+ID+' .krajee-datepicker').val('');
    }

});

//Revenue
function submitRevenue() {
    var error = false;

    if($('#m_select2_ompany_revenue_validate :selected').text() == ""){
        $('#m_select2_ompany_revenue_validate').parent('div').addClass('has-error');
        $("#m_select2_ompany_revenue_validate").siblings(".help-block").text("«Շրջանառություն» -ը չի կարող դատարկ լինել:");
        $("#m_select2_ompany_revenue_validate").siblings(".help-block").show();
        error = true
    }else{
        $('#m_select2_ompany_revenue_validate').parent('div').removeClass('has-error');
        $("#m_select2_ompany_revenue_validate").siblings(".help-block").hide();
        $("#m_select2_ompany_revenue_validate :selected").prop("readonly",true);
        var cmpanyRevenueName = $('#m_select2_ompany_revenue_validate :selected').text();
        var cmpanyRevenueNameID = $('#m_select2_ompany_revenue_validate').val();
    }


    if($('#m_select2_year_validate :selected').text() == ""){
        $('#m_select2_year_validate').parent('div').addClass('has-error');
        $("#m_select2_year_validate").siblings(".help-block").text("«Տարի » -ն չի կարող դատարկ լինել:");
        $("#m_select2_year_validate").siblings(".help-block").show();
        error = true
    }else{
        $('#m_select2_year_validate').parent('div').removeClass('has-error');
        $("#m_select2_year_validate").siblings(".help-block").hide();
        $("#m_select2_year_validate :selected").prop("readonly",true);
        var cmpanyRevenueYear = $('#m_select2_year_validate :selected').text();
    }

    if(!error){
        var type = $("#modal-type").val();
        console.log(type);

        if(type == "add"){
            var count = $('.revenue-row').length;
            var id = count + 1;
            var newRow = "<tr class='revenue-row m-datatable__row m-datatable__row--even' data-count='"+id+"' >";
            newRow += "<td class='m-datatable__cell--center m-datatable__cell'>";
            newRow += "<span id='revenue-span-id-"+id+"' class='' style='width: 50px;'>"+id+"</span>";
            newRow += "<input id='revenue-input-id-"+id+"' type='hidden' name='FoHasRevenue[id][]' value='"+id+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='revenue-span-name-"+id+"' class='' style='width: 150px;'>"+cmpanyRevenueName+"</span>";
            newRow += "<input id='revenue-input-name-"+id+"' type='hidden' name='FoHasRevenue[company_revenue_id][]' value='"+cmpanyRevenueNameID+"'>";
            newRow += "</td>";


            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='revenue-span-year-"+id+"' class='' style='width: 120px;'>"+cmpanyRevenueYear+"</span>";
            newRow += "<input id='revenue-input-year-"+id+"' type='hidden' name='FoHasRevenue[company_revenue_year][]' value='"+cmpanyRevenueYear+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span  style='overflow: visible; width: 120px;'>  ";
            newRow += "<a onclick='editMethod("+id+")' data-toggle='modal' data-target='#m_typeahead_modal' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-edit'></i></a>";
            newRow += "<a onclick='removeMethod("+id+")' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-trash'></i></a>";
            newRow += "</span>";
            newRow += "</td>";


            $('.revenue-body').append(newRow);
            $('#revenue').val(id);
        }else{
            var typeArray = type.split("-");
            var id = typeArray[1];
            $("#revenue-span-name-"+id).html($('#m_select2_ompany_revenue_validate :selected').text());
            $("#revenue-input-name-"+id).val($('#m_select2_ompany_revenue_validate').val());

            var cmpanyRevenueYear = $('#m_select2_year_validate :selected').text();

            $("#revenue-span-year-"+id).html(cmpanyRevenueYear);
            $("#revenue-input-year-"+id).val(cmpanyRevenueYear);


        }

        $('#add-revenue').modal('toggle');

        $('#m_select2_ompany_revenue_validate').parent('div').removeClass('has-success');
        $("#m_select2_ompany_revenue_validate").select2('val', 'All');
        $('#m_select2_ompany_revenue_validate').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('#m_select2_year_validate').parent('div').removeClass('has-success');
        $("#m_select2_year_validate").select2('val', 'All');
        $('#m_select2_year_validate').select2({
            placeholder: "Ընտրեք ցանկից"
        });

    }
}

function editMethod(id) {

    $('#revenue-modal-title span').html('Խմբագրել շրջանառություն');

    $('#add-revenue').modal('toggle');

    var year = $("#revenue-input-year-" + id).val();
    var name =  $("#revenue-input-name-" + id).val();


    $('#m_select2_year_validate').select2("enable",false)


    $("#m_select2_ompany_revenue_validate").val(name).trigger('change');
    $("#m_select2_year_validate").val(year).trigger('change');
    $("#modal-type").val("edit-"+id);
}

function createMethod(){
    $('#revenue-modal-title span').html('Ավելացնել շրջանառություն');
    $('#add-revenue').modal('toggle');

    $('#m_select2_year_validate').select2();
    $('#m_select2_year_validate').prop('disabled', true);
    $('#m_select2_year_validate:first-of-type').prop('disabled', false);
    $('#m_select2_year_validate').on('select2:select', function(e) {
        $(this).nextAll('select').first().prop('disabled', false); // remove disabled prop from next select
    });


    $("#m_select2_year_validate option").prop('disabled',false);
    $.each($('*[id^="indicator-input-name-"]'), function( index, value ) {
        $("#m_select2_year_validate option[value='"+$(value).val()+"']").prop('disabled',true);
    });
    var $el = $("#m_select2_year_validate"), // your input id for the HTML select input
        settings = $el.attr('data-krajee-select2');
    settings = window[settings];
    // reinitialize plugin
    $el.select2(settings);

    $('#m_select2_year_validate').select2({
        placeholder: "Ընտրեք ցանկից"
    });

    $("#modal-type").val("add");
}

function removeMethod(id){
    if(confirm("Համոզված եք որ ցանկանում եք ջնջել?")){

        $("tr[data-count='"+id+"']").remove();
        var rowCount = $('#cutrhasindicator-indicator_id').val();
        if(rowCount == 1){
            $('#verification_method_id-indicator_id').val("");
        }else{
            $('#verification_method_id-indicator_id').val(rowCount - 1);
        }

    }
}

//production type
function createProductionType(type) {

    console.log(type);

    $('#modal-type-creat').val(type);
    $('#production-type-modal-title').html('Ավելացնել արտադրության տեսակ');



    $("#m_select2_production_type_validate option").prop('disabled',false);

    $.each($('.block-'+type+' *[id^="production_type-input-name-"'), function( index, value ) {
        $("#m_select2_production_type_validate option[value='"+$(value).val()+"']").prop('disabled',true);
    });
    var $el = $("#m_select2_production_type_validate"), // your input id for the HTML select input
        settings = $el.attr('data-krajee-select2');
    settings = window[settings];
    // reinitialize plugin
    $el.select2(settings);

    $('#m_select2_production_type_validate').select2({
        placeholder: "Ընտրեք ցանկից"
    });

    $('#add-production-type').modal('toggle');


}

function submitProductionType() {
    var error = false;

    if($('#m_select2_production_type_validate :selected').text() == ""){
        $('#m_select2_production_type_validate').parent('div').addClass('has-error');
        $("#m_select2_production_type_validate").siblings(".help-block").text("«Արտադրության տեսակ» -ը չի կարող դատարկ լինել:");
        $("#m_select2_production_type_validate").siblings(".help-block").show();
        error = true
    }else{
        $('#m_select2_production_type_validate').parent('div').removeClass('has-error');
        $("#m_select2_production_type_validate").siblings(".help-block").hide();
        $("#m_select2_production_type_validate :selected").prop("readonly",true);
        var ProductionTypeName = $('#m_select2_production_type_validate :selected').text();
        var ProductionTypeID = $('#m_select2_production_type_validate').val();
    }

    if($('#m_select2_production_type_status_validate :selected').text() == ""){
        $('#m_select2_production_type_status_validate').parent('div').addClass('has-error');
        $("#m_select2_production_type_status_validate").siblings(".help-block").text("«Կարգավիճակ» -ը չի կարող դատարկ լինել:");
        $("#m_select2_production_type_status_validate").siblings(".help-block").show();
        error = true
    }else{
        $('#m_select2_production_type_status_validate').parent('div').removeClass('has-error');
        $("#m_select2_production_type_status_validate").siblings(".help-block").hide();
        $("#m_select2_production_type_status_validate :selected").prop("readonly",true);
        var ProductionTypeStatusName = $('#m_select2_production_type_status_validate :selected').text();
        var ProductionTypeStatusID = $('#m_select2_production_type_status_validate').val();
    }


    if($('#date_production_type').val() == ""){
        $('#date_production_type').parent('div').parent('div').addClass('has-error');
        $("#date_production_type").parent('div').siblings(".help-block").text("«Ամսաթիվ» -ը չի կարող դատարկ լինել:");
        $("#date_production_type").parent('div').siblings(".help-block").show();
        error = true
    }else{
        $('#date_production_type').parent('div').parent('div').removeClass('has-error');
        $('#date_production_type').parent('div').removeClass('has-error');
        $('#date_production_type').siblings(".help-block").hide();
        var ProductionTypeStatusDateVal = $('#date_production_type').val();
    }

    if(!error){
        var type = $("#modal-type").val();
        var type_v = $('#modal-type-creat').val();

        if(type == "add"){
            var count = $('.production_type-row-'+type_v).length;
            var id = count + 1;
            var newRow = "<tr class='production_type-row-"+type_v+" m-datatable__row m-datatable__row--even' data-count='"+id+"' >";
            newRow += "<td class='m-datatable__cell--center m-datatable__cell'>";
            newRow += "<span id='production_type-span-id-"+id+"-"+type_v+"' class='' style='width: 50px;'>"+id+"</span>";
            newRow += "<input id='production_type-input-id-"+id+"-"+type_v+"' type='hidden' name='FoHasFoActivityTypeHasProductionType[id]["+type_v+"][]' value='p-"+id+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='production_type-span-name-"+id+"-"+type_v+"' class='' style='width: 170px;'>"+ProductionTypeName+"</span>";
            newRow += "<input id='production_type-input-name-"+id+"-"+type_v+"' type='hidden' name='FoHasFoActivityTypeHasProductionType[production_type_id]["+type_v+"][]' value='"+ProductionTypeID+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='production_type-span-status-"+id+"-"+type_v+"' class='' style='width: 120px;'>"+ProductionTypeStatusName+"</span>";
            newRow += "<input id='production_type-input-status-"+id+"-"+type_v+"' type='hidden' name='FoHasFoActivityTypeHasProductionTypeHasFoStatus[fo_status_id]["+type_v+"][]' value='"+ProductionTypeStatusID+"'>";
            newRow += "</td>";


            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='production_type-span-date-"+id+"-"+type_v+"' class='' style='width: 120px;'>"+ProductionTypeStatusDateVal+"</span>";
            newRow += "<input id='production_type-input-date-"+id+"-"+type_v+"' type='hidden' name='FoHasFoActivityTypeHasProductionTypeHasFoStatus[date]["+type_v+"][]' value='"+ProductionTypeStatusDateVal+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span  style='overflow: visible; width: 120px;'>  ";
            newRow += "<a onclick='editProductionType("+id+", "+type_v+")' data-toggle='modal' data-target='#m_typeahead_modal' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-lightbulb-o'></i></a>";
            newRow += "<a onclick='removeProductionType("+id+", "+type_v+")' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-trash'></i></a>";
            newRow += "</span>";
            newRow += "</td>";

            $('.production_type-body-'+type_v).append(newRow);

            $('#production_type').val(id);
        }else{
            var typeArray = type.split("-");
            var id = typeArray[1];


            $("#production_type-span-name-"+id+"-"+type_v).html($('#m_select2_production_type_validate :selected').text());
            $("#production_type-input-name-"+id+"-"+type_v).val($('#m_select2_production_type_validate').val());

            $("#production_type-span-status-"+id+"-"+type_v).html($('#m_select2_production_type_status_validate :selected').text());
            $("#production_type-input-status-"+id+"-"+type_v).val($('#m_select2_production_type_status_validate').val());

            $("#production_type-span-date-"+id+"-"+type_v).html($('#date_production_type').val());
            $("#production_type-input-date-"+id+"-"+type_v).val($('#date_production_type').val());

        }

        $('#m_select2_production_type_validate').parent('div').removeClass('has-success');
        $("#m_select2_production_type_validate").select2('val', 'All');
        $('#m_select2_production_type_validate').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('#m_select2_production_type_status_validate').parent('div').removeClass('has-success');
        $("#m_select2_production_type_status_validate").select2('val', 'All');
        $('#m_select2_production_type_status_validate').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('#date_production_type').val('');

        $('#add-production-type').modal('toggle');
    }
}

function editProductionType(id,type_v) {

    $('#production-type-modal-title').html('Խմբագրել արտադրության տեսակ');

    var name =  $("#production_type-input-name-" + id+"-"+type_v).val();
    var status =  $("#production_type-input-status-" + id+"-"+type_v).val();
    var date =  $("#production_type-input-date-" + id+"-"+type_v).val();

    $('#m_select2_production_type_validate').select2("enable",false);
    $("#m_select2_production_type_validate").val(name).trigger('change');
    $("#m_select2_production_type_status_validate").val(status).trigger('change');

    $("#date_production_type").val(date);
    $('#modal-type-creat').val(type_v);

    $("#modal-type").val("edit-"+id);
    $('#add-production-type').modal('toggle');
}

function removeProductionType(id,type_v) {
    if(confirm("Համոզված եք որ ցանկանում եք ջնջել?")){

        $("tr.production_type-row-"+type_v+"[data-count='"+id+"']").remove();
        var rowCount = $('#cutrhasindicator-indicator_id').val();
        if(rowCount == 1){
            $('#verification_method_id-indicator_id').val("");
        }else{
            $('#verification_method_id-indicator_id').val(rowCount - 1);
        }

    }
}

//food organizing type
function createFoodOrganizingType() {

    $('#food-organizing-type-modal-title').html('Ավելացնել հանրային սննդի կազմակերպման տեսակ');

    $('#m_select2_food_type_validate').select2();
    $('#m_select2_food_type_validate').prop('disabled', true);
    $('#m_select2_food_type_validate:first-of-type').prop('disabled', false);
    $('#m_select2_food_type_validate').on('select2:select', function(e) {
        $(this).nextAll('select').first().prop('disabled', false); // remove disabled prop from next select
    });



    $("#m_select2_food_type_validate option").prop('disabled',false);
    $.each($('*[id^="food_type-input-name-"]'), function( index, value ) {
        $("#m_select2_food_type_validate option[value='"+$(value).val()+"']").prop('disabled',true);
    });
    var $el = $("#m_select2_food_type_validate"), // your input id for the HTML select input
        settings = $el.attr('data-krajee-select2');
    settings = window[settings];
    // reinitialize plugin
    $el.select2(settings);


    $('#m_select2_food_type_validate').select2({
        placeholder: "Ընտրեք ցանկից"
    });

    $('#add-food-organizing-type').modal('toggle');

}

function submitFoodType() {
    var error = false;

    if($('#m_select2_food_type_validate :selected').text() == ""){
        $('#m_select2_food_type_validate').parent('div').addClass('has-error');
        $("#m_select2_food_type_validate").siblings(".help-block").text("«Հանրային սննդի կազմակերպման տեսակ » -ը չի կարող դատարկ լինել:");
        $("#m_select2_food_type_validate").siblings(".help-block").show();
        error = true
    }else{
        $('#m_select2_food_type_validate').parent('div').removeClass('has-error');
        $("#m_select2_food_type_validate").siblings(".help-block").hide();
        $("#m_select2_food_type_validate :selected").prop("readonly",true);
        var FoodTypeName = $('#m_select2_food_type_validate :selected').text();
        var FoodTypeID = $('#m_select2_food_type_validate').val();
    }

    if($('#m_select2_food_type_status_validate :selected').text() == ""){
        $('#m_select2_food_type_status_validate').parent('div').addClass('has-error');
        $("#m_select2_food_type_status_validate").siblings(".help-block").text("«Կարգավիճակ» -ը չի կարող դատարկ լինել:");
        $("#m_select2_food_type_status_validate").siblings(".help-block").show();
        error = true
    }else{
        $('#m_select2_food_type_status_validate').parent('div').removeClass('has-error');
        $("#m_select2_food_type_status_validate").siblings(".help-block").hide();
        $("#m_select2_food_type_status_validate :selected").prop("readonly",true);
        var FoodTypeStatusName = $('#m_select2_food_type_status_validate :selected').text();
        var FoodTypeStatusID = $('#m_select2_food_type_status_validate').val();
    }


    if($('#date_food_type').val() == ""){
        $('#date_food_type').parent('div').parent('div').addClass('has-error');
        $("#date_food_type").parent('div').siblings(".help-block").text("«Ամսաթիվ» -ը չի կարող դատարկ լինել:");
        $("#date_food_type").parent('div').siblings(".help-block").show();
        error = true
    }else{
        $('#date_food_type').parent('div').parent('div').removeClass('has-error');
        $('#date_food_type').parent('div').removeClass('has-error');
        $('#date_food_type').siblings(".help-block").hide();
        var FoodTypeStatusDateVal = $('#date_food_type').val();
    }


    if(!error){
        var type = $("#modal-type").val();

        if(type == "add"){
            var count = $('.food_type-row').length;
            var id = count + 1;
            var newRow = "<tr class='food_type-row  m-datatable__row m-datatable__row--even' data-count='"+id+"' >";
            newRow += "<td class='m-datatable__cell--center m-datatable__cell'>";
            newRow += "<span id='food_type-span-id-"+id+"' class='' style='width: 50px;'>"+id+"</span>";
            newRow += "<input id='food_type-input-id-"+id+"' type='hidden' name='FoHasFoActivityTypeHasFoodOrganizingType[id][]' value='f-"+id+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='food_type-span-name-"+id+"' class='' style='width: 170px;'>"+FoodTypeName+"</span>";
            newRow += "<input id='food_type-input-name-"+id+"' type='hidden' name='FoHasFoActivityTypeHasFoodOrganizingType[food_organizing_type_id][]' value='"+FoodTypeID+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='food_type-span-status-"+id+"' class='' style='width: 120px;'>"+FoodTypeStatusName+"</span>";
            newRow += "<input id='food_type-input-status-"+id+"' type='hidden' name='FoHasFoActivityTypeHasFoodOrganizingTypeHasFoStatus[fo_status_id][]' value='"+FoodTypeStatusID+"'>";
            newRow += "</td>";


            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='food_type-span-date-"+id+"' class='' style='width: 120px;'>"+FoodTypeStatusDateVal+"</span>";
            newRow += "<input id='food_type-input-date-"+id+"' type='hidden' name='FoHasFoActivityTypeHasFoodOrganizingTypeHasFoStatus[date][]' value='"+FoodTypeStatusDateVal+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span  style='overflow: visible; width: 120px;'>  ";
            newRow += "<a onclick='editFoodType("+id+")' data-toggle='modal' data-target='#m_typeahead_modal' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-lightbulb-o'></i></a>";
            newRow += "<a onclick='removeFoodType("+id+")' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-trash'></i></a>";
            newRow += "</span>";
            newRow += "</td>";


            $('.food-organizing-type-body').append(newRow);

            $('#food_type').val(id);
        }else{
            var typeArray = type.split("-");
            var id = typeArray[1];

            $("#food_type-span-name-"+id).html($('#m_select2_food_type_validate :selected').text());
            $("#food_type-input-name-"+id).val($('#m_select2_food_type_validate').val());

            $("#food_type-span-status-"+id).html($('#m_select2_food_type_status_validate :selected').text());
            $("#food_type-input-status-"+id).val($('#m_select2_food_type_status_validate').val());

            $("#food_type-span-date-"+id).html($('#date_food_type').val());
            $("#food_type-input-date-"+id).val($('#date_food_type').val());

        }

        $('#m_select2_food_type_validate').parent('div').removeClass('has-success');
        $("#m_select2_food_type_validate").select2('val', 'All');
        $('#m_select2_food_type_validate').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('#m_select2_food_type_status_validate').parent('div').removeClass('has-success');
        $("#m_select2_food_type_status_validate").select2('val', 'All');
        $('#m_select2_food_type_status_validate').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('#date_food_type').val('');

        $('#add-food-organizing-type').modal('toggle');
    }
}

function editFoodType(id) {

    $('#food-organizing-type-modal-title').html('Խմբագրել հանրային սննդի կազմակերպման տեսակ');

    var name =  $("#food_type-input-name-" + id).val();
    var status =  $("#food_type-input-status-" + id).val();
    var date =  $("#food_type-input-date-" + id).val();

    $('#m_select2_food_type_validate').select2("enable",false)
    $("#m_select2_food_type_validate").val(name).trigger('change');
    $("#m_select2_food_type_status_validate").val(status).trigger('change');

    console.log(date);

    $("#date_food_type").val(date);

    $("#modal-type").val("edit-"+id);
    $('#add-food-organizing-type').modal('toggle');
}

function removeFoodType(id) {
    if(confirm("Համոզված եք որ ցանկանում եք ջնջել?")){

        $("tr.food_type-row[data-count='"+id+"']").remove();
        var rowCount = $('#cutrhasindicator-indicator_id').val();
        if(rowCount == 1){
            $('#verification_method_id-indicator_id').val("");
        }else{
            $('#verification_method_id-indicator_id').val(rowCount - 1);
        }

    }
}

//realization type
function createRealizationType() {

    $('#realization-type-modal-title').html('Ավելացնել իրացման տեսակ');

    $('#m_select2_realization_type_validate').select2();
    $('#m_select2_realization_type_validate').prop('disabled', true);
    $('#m_select2_realization_type_validate:first-of-type').prop('disabled', false);
    $('#m_select2_realization_type_validate').on('select2:select', function(e) {
        $(this).nextAll('select').first().prop('disabled', false); // remove disabled prop from next select
    });


    $("#m_select2_realization_type_validate option").prop('disabled',false);
    $.each($('*[id^="realization_type-input-name-"]'), function( index, value ) {
        $("#m_select2_realization_type_validate option[value='"+$(value).val()+"']").prop('disabled',true);
    });
    var $el = $("#m_select2_realization_type_validate"), // your input id for the HTML select input
        settings = $el.attr('data-krajee-select2');
    settings = window[settings];
    // reinitialize plugin
    $el.select2(settings);

    $('#m_select2_realization_type_validate').select2({
        placeholder: "Ընտրեք ցանկից"
    });

    $('#add-realization-type').modal('toggle');

}

function submitRealizationType() {
    var error = false;

    if($('#m_select2_realization_type_validate :selected').text() == ""){
        $('#m_select2_realization_type_validate').parent('div').addClass('has-error');
        $("#m_select2_realization_type_validate").siblings(".help-block").text("«Հանրային սննդի կազմակերպման տեսակ » -ը չի կարող դատարկ լինել:");
        $("#m_select2_realization_type_validate").siblings(".help-block").show();
        error = true
    }else{
        $('#m_select2_realization_type_validate').parent('div').removeClass('has-error');
        $("#m_select2_realization_type_validate").siblings(".help-block").hide();
        $("#m_select2_realization_type_validate :selected").prop("readonly",true);
        var realizationTypeName = $('#m_select2_realization_type_validate :selected').text();
        var realizationTypeID = $('#m_select2_realization_type_validate').val();
    }

    if($('#m_select2_realization_type_status_validate :selected').text() == ""){
        $('#m_select2_realization_type_status_validate').parent('div').addClass('has-error');
        $("#m_select2_realization_type_status_validate").siblings(".help-block").text("«Կարգավիճակ» -ը չի կարող դատարկ լինել:");
        $("#m_select2_realization_type_status_validate").siblings(".help-block").show();
        error = true
    }else{
        $('#m_select2_realization_type_status_validate').parent('div').removeClass('has-error');
        $("#m_select2_realization_type_status_validate").siblings(".help-block").hide();
        $("#m_select2_realization_type_status_validate :selected").prop("readonly",true);
        var realizationTypeStatusName = $('#m_select2_realization_type_status_validate :selected').text();
        var realizationTypeStatusID = $('#m_select2_realization_type_status_validate').val();
    }


    if($('#date_realization_type').val() == ""){
        $('#date_realization_type').parent('div').parent('div').addClass('has-error');
        $("#date_realization_type").parent('div').siblings(".help-block").text("«Ամսաթիվ» -ը չի կարող դատարկ լինել:");
        $("#date_realization_type").parent('div').siblings(".help-block").show();
        error = true
    }else{
        $('#date_realization_type').parent('div').parent('div').removeClass('has-error');
        $('#date_realization_type').parent('div').removeClass('has-error');
        $('#date_realization_type').siblings(".help-block").hide();
        var realizationTypeStatusDateVal = $('#date_realization_type').val();
    }


    if(!error){
        var type = $("#modal-type").val();

        if(type == "add"){
            var count = $('.realization_type-row').length;
            var id = count + 1;
            var newRow = "<tr class='realization_type-row m-datatable__row m-datatable__row--even' data-count='"+id+"' >";
            newRow += "<td class='m-datatable__cell--center m-datatable__cell'>";
            newRow += "<span id='realization_type-span-id-"+id+"' class='' style='width: 50px;'>"+id+"</span>";
            newRow += "<input id='realization_type-input-id-"+id+"' type='hidden' name='FoHasFoActivityTypeHasRealizationType[id][]' value='r-"+id+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='realization_type-span-name-"+id+"' class='' style='width: 170px;'>"+realizationTypeName+"</span>";
            newRow += "<input id='realization_type-input-name-"+id+"' type='hidden' name='FoHasFoActivityTypeHasRealizationType[realization_type_id][]' value='"+realizationTypeID+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='realization_type-span-status-"+id+"' class='' style='width: 120px;'>"+realizationTypeStatusName+"</span>";
            newRow += "<input id='realization_type-input-status-"+id+"' type='hidden' name='FoHasFoActivityTypeHasRealizationTypeHasFoStatus[fo_status_id][]' value='"+realizationTypeStatusID+"'>";
            newRow += "</td>";


            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span id='realization_type-span-date-"+id+"' class='' style='width: 120px;'>"+realizationTypeStatusDateVal+"</span>";
            newRow += "<input id='realization_type-input-date-"+id+"' type='hidden' name='FoHasFoActivityTypeHasRealizationTypeHasFoStatus[date][]' value='"+realizationTypeStatusDateVal+"'>";
            newRow += "</td>";

            newRow += "<td class='m-datatable__cell'>";
            newRow += "<span  style='overflow: visible; width: 120px;'>  ";
            newRow += "<a onclick='editRealizationType("+id+")' data-toggle='modal' data-target='#m_typeahead_modal' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-lightbulb-o'></i></a>";
            newRow += "<a onclick='removeRealizationType("+id+")' class='m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' href='javascript:void(0)'><i class='la la-trash'></i></a>";
            newRow += "</span>";
            newRow += "</td>";


            $('.realization-type-body').append(newRow);

            $('#realization_type').val(id);
        }else{
            var typeArray = type.split("-");
            var id = typeArray[1];

            $("#realization_type-span-name-"+id).html($('#m_select2_realization_type_validate :selected').text());
            $("#realization_type-input-name-"+id).val($('#m_select2_realization_type_validate').val());

            $("#realization_type-span-status-"+id).html($('#m_select2_realization_type_status_validate :selected').text());
            $("#realization_type-input-status-"+id).val($('#m_select2_realization_type_status_validate').val());

            $("#realization_type-span-date-"+id).html($('#date_realization_type').val());
            $("#realization_type-input-date-"+id).val($('#date_realization_type').val());

        }

        $('#m_select2_realization_type_validate').parent('div').removeClass('has-success');
        $("#m_select2_realization_type_validate").select2('val', 'All');
        $('#m_select2_realization_type_validate').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('#m_select2_realization_type_status_validate').parent('div').removeClass('has-success');
        $("#m_select2_realization_type_status_validate").select2('val', 'All');
        $('#m_select2_realization_type_status_validate').select2({
            placeholder: "Ընտրեք ցանկից"
        });

        $('#date_realization_type').val('');

        $('#add-realization-type').modal('toggle');
    }
}

function editRealizationType(id) {

    $('#realization-type-modal-title').html('Խմբագրել իրացման տեսակ');

    var name =  $("#realization_type-input-name-" + id).val();
    var status =  $("#realization_type-input-status-" + id).val();
    var date =  $("#realization_type-input-date-" + id).val();

    $('#m_select2_realization_type_validate').select2("enable",false)
    $("#m_select2_realization_type_validate").val(name).trigger('change');
    $("#m_select2_realization_type_status_validate").val(status).trigger('change');

    console.log(date);

    $("#date_realization_type").val(date);

    $("#modal-type").val("edit-"+id);
    $('#add-realization-type').modal('toggle');
}

function removeRealizationType(id) {
    if(confirm("Համոզված եք որ ցանկանում եք ջնջել?")){

        $("tr.realization_type-row[data-count='"+id+"']").remove();
        var rowCount = $('#cutrhasindicator-indicator_id').val();
        if(rowCount == 1){
            $('#verification_method_id-indicator_id').val("");
        }else{
            $('#verification_method_id-indicator_id').val(rowCount - 1);
        }

    }
}

// edit status

function editStatus(id) {

    var name = $('.block-'+id+' .status-title').text();
    var status_id = $('.block-'+id+' #fohasfoactivitytypehasfostatus-fo_status_id-'+id).val();
    var data = $('.block-'+id+' #fohasfoactivitytypehasfostatus-date-'+id).val();


    $('#status-title').text(name);
    $("#m_select2_status_validate").val(status_id).trigger('change');
    $('#date_status_type').val(data);

    $('#modal-edit-activity-type-id').val(id)

    $('#edit-status').modal('toggle');

}

function submitEditStatus() {

    var statusID = $('#m_select2_status_validate').val();
    var dataVal = $('#date_status_type').val();
    var id = $('#modal-edit-activity-type-id').val();

    var statusName = $('#m_select2_status_validate :selected').text();

    console.log(statusName);

    $('.block-'+id+' #fohasfoactivitytypehasfostatus-fo_status_id-'+id).val(statusID);
    $('.block-'+id+' #fohasfoactivitytypehasfostatus-date-'+id).val(dataVal);
    $('.block-'+id+' #status-name-'+id).text(statusName);
    $('.block-'+id+' #status-data-'+id).text(dataVal);

    $('#edit-status').modal('toggle');
}

function showHistory(id) {

    var fo_id = $("#modal-edit-fo-id").val();
    $('.history_type-body tr').remove();
    $.ajax({
        type: "POST",
        url: "/app/fo/show-history",
        data: {id: id, fo_id: fo_id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);

            $.each(obj, function (index, value) {
                console.log(value);

                var newRow = "<tr class='realization_type-row m-datatable__row m-datatable__row--even'>";
                newRow += "<td class='m-datatable__cell--center m-datatable__cell'>";
                newRow += "<span class='' style='width: 50px;'>"+(index + 1)+"</span>";
                newRow += "</td>";

                newRow += "<td class='m-datatable__cell'>";
                newRow += "<span  class='' style='width: 120px;'>"+value.status+"</span>";
                newRow += "</td>";

                newRow += "<td class='m-datatable__cell'>";
                newRow += "<span id='realization_type-span-status-"+id+"' class='' style='width: 120px;'>"+value.date+"</span>";
                newRow += "</td>";

                $('.history_type-body').append(newRow);
            });
        },
        complete: function (xhr) {
            if (xhr.status != 200) {
                alert("Error");
            }
        }
    })


    $('#history-status').modal('toggle');

}

function showHistoryStatus(type, id) {

    var fo_id = $("#modal-edit-fo-id").val();

    $('.history_type-body tr').remove();
    $.ajax({
        type: "POST",
        url: "/app/fo/show-history-status",
        data: {id: id, type: type, fo_id: fo_id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);

            $.each(obj, function (index, value) {

                var newRow = "<tr class='m-datatable__row m-datatable__row--even'>";
                newRow += "<td class='m-datatable__cell--center m-datatable__cell'>";
                newRow += "<span class='' style='width: 50px;'>"+(index + 1)+"</span>";
                newRow += "</td>";

                newRow += "<td class='m-datatable__cell'>";
                newRow += "<span  class='' style='width: 120px;'>"+value.status+"</span>";
                newRow += "</td>";

                newRow += "<td class='m-datatable__cell'>";
                newRow += "<span id='realization_type-span-status-"+id+"' class='' style='width: 120px;'>"+value.date+"</span>";
                newRow += "</td>";

                $('.history_type-body').append(newRow);
            });
        },
        complete: function (xhr) {
            if (xhr.status != 200) {
                alert("Error");
            }
        }
    })


    $('#history-status').modal('toggle');

}