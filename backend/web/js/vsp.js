$(document).ready(function () {
    //owner
    // $("#customer_name_span").remove()
    // if ($("#vehiclesanitarypassport-car_model_name").val() == "") {
    //     $("#vehiclesanitarypassport-car_model_name").before("<br><h5 id='customer_name_span' class='not-marked'>Նշված չէ</h5>");
    // } else {
    //     $("#vehiclesanitarypassport-car_model_name").before("<br><h5 id='customer_name_span' class='not-marked'>" + $("#vehiclesanitarypassport-car_model_name").val() + "</h5>");
    //
    //     $("#vsp-search").remove();
    //     $("#vehiclesanitarypassport-car_number").after('<span id="vspClear" onclick=\'vspClear();\' class="input-group-addon pass-clrear"><i class="fa fa-eraser" aria-hidden="true"></i></span>');
    // }
    //
    // $("#customer_address_span").remove()
    // if ($("#vehiclesanitarypassport-car_cert_num").val() == "") {
    //     $("#vehiclesanitarypassport-car_cert_num").before("<br><h5 id='customer_address_span'class='not-marked'>Նշված չէ</h5>");
    // } else {
    //     $("#vehiclesanitarypassport-car_cert_num").before("<br><h5 id='customer_address_span' class='not-marked'>" + $("#vehiclesanitarypassport-car_cert_num").val() + "</h5>");
    // }

});

function vspClear() {
    $("#vehiclesanitarypassport-car_number").val("");

    $("#customer_name_span").html("Նշված չէ");
    $("#vehiclesanitarypassport-car_model_name").val("");

    $("#customer_address_span").html("Նշված չէ");
    $("#vehiclesanitarypassport-car_cert_num").val("");

    $("#vsps-customer_city_town").val("");

    $("#vspClear").remove();
    $("#vehiclesanitarypassport-car_number").after('<span id="vsp-search" onclick=\'vspSearch();\' class="input-group-addon pass-search"><i class="fa fa-search" aria-hidden="true"></i></span>');
    $("#vehiclesanitarypassport-car_number").prop("readonly",false);
}

function vspSearch() {
    var taxID = $("#vehiclesanitarypassport-car_number").val();
    if (taxID == "") {
        $(".field-vehiclesanitarypassport-car_number").addClass("has-error");
        $(".field-vehiclesanitarypassport-car_number .help-block").html("«Պետ Համարանիշ» չի կարող լինել դատարկ.");
    }  else {
        $(".field-vehiclesanitarypassport-car_number").removeClass("has-error");
        $(".field-vehiclesanitarypassport-car_number .help-block").html("");
        $('.loader').show();
        $.ajax({
            type: "POST",
            url: "/app/vsp/check-tax",
            data: {taxID: taxID},
            success: function (data) {
                $('.loader').hide();
                var obj = jQuery.parseJSON(data);
                console.log(obj);
                if ((typeof obj.error !== 'undefined')) {
                    alert(obj.error);
                } else {
                    //name
                    var model_name = obj.result[0].model_name +' '+ obj.result[0].model
                    $("#customer_name_span").html(model_name);
                    $("#vehiclesanitarypassport-car_model_name").val(model_name);
                    $('.field-vehiclesanitarypassport-car_model_name').removeClass("has-error");
                    $('.field-vehiclesanitarypassport-car_model_name .help-block').html("");
                    //car_cert_num
                    var cert_num = obj.result[0].cert_num;
                    $("#customer_address_span").html(cert_num)
                    $("#vehiclesanitarypassport-car_cert_num").val(cert_num);
                    $('.field-vehiclesanitarypassport-car_cert_num').removeClass("has-error");
                    $('.field-vehiclesanitarypassport-car_cert_num .help-block').html("");

                    $("#vsp-search").remove();
                    $("#vehiclesanitarypassport-car_number").after('<span id="vspClear" onclick=\'vspClear();\' class="input-group-addon pass-clrear"><i class="fa fa-eraser" aria-hidden="true"></i></span>');
                    $("#vehiclesanitarypassport-car_number").prop("readonly",true);
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

function showFiles(id){

    $.ajax({
        type: "POST",
        url: "/app/vsp/get-files",
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if ((typeof obj.error !== 'undefined')) {
                alert(obj.error);
            } else {
                var cont = "";
                $.each(obj, function(index , value ) {
                    cont += "<tr class='animal-row m-datatable__row m-datatable__row--even' data-count='"+index+"'>"+
                        "<td class='m-datatable__cell'>"+
                        "<span id='animal-span-id-<?= $i; ?>' class='' style='width: 300px;'>"+index+"</span>"+
                        "</td>"+
                        "<td class='m-datatable__cell'>"+
                        "<span style='width: 300px'><a target='_blank' href='"+value.path+"'>"+value.name+"</a></span>"+
                        "</td>"+
                        "</tr>";
                });

                a = $(".m_datatable").mDatatable({})
                $('.popu    nt').html(cont);

            }
        },
        complete: function (xhr) {
            if (xhr.status != 200) {
                alert("Error");

            }
        }
    });
}
function removeVspFile(id){

    $('#remove-'+id ).remove();

    $.ajax({
        type: "POST",
        url:'/app/vsp/file-delete',
        data : {id:id},
        dataType: 'json',
        async:false,
        success: function(data){

        }
    });

}