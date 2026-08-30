function showProductTypeStatus(CompanyID,ProductTypeID){
    console.log(CompanyID,ProductTypeID);
    $.ajax({
        type: "POST",
        url: "/app/companies/get-product-status",
        data: {CompanyID: CompanyID, ProductTypeID: ProductTypeID},
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
                                "<span class='' style='width: 170px;'>"+value.status+"</span>"+
                            "</td>"+
                            "<td class='m-datatable__cell'>"+
                                "<span  class='' style='width: 100px;'>"+value.date+"</span>"+
                            "</td>"+
                            "<td class='m-datatable__cell'>"+
                                "<span  class='' style='width: 135px;'>"+value.list+"</span>"+
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
    })
}