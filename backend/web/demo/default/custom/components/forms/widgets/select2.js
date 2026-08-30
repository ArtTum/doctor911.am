var Select2 = function () {
    var e = function () {

        $("#m_select2_1, #m_select2_1_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_2, #m_select2_2_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_3, #m_select2_3_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_year, #m_select2_year_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_activity1, #m_select2_activity1_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_ompany_revenue, #m_select2_ompany_revenue_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_production_type, #m_select2_production_type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_production_type_status, #m_select2_production_type_status_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_food_type_status, #m_select2_food_type_status_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_realization1_type_status, #m_select2_realization1_type_status_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_food_type, #m_select2_food_type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_realization1_type, #m_select2_realization1_type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_realization_type, #m_select2_realization_type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_realization_type_status, #m_select2_realization_type_status_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_transport_company, #m_select2_transport_company_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_control-types, #m_select2_control-types_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_city, #m_select2_city_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_state, #m_select2_state_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_region, #m_select2_region_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_export, #m_select2_export_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_status_export, #m_select2_status_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_1type, #m_select2_1type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_2type, #m_select2_2type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_3type, #m_select2_3type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_4type, #m_select2_4type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_5type, #m_select2_5type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_6type, #m_select2_6type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_7type, #m_select2_7type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_8type, #m_select2_8type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_9type, #m_select2_9type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_10type, #m_select2_10type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_11type, #m_select2_11type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_12type, #m_select2_12type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_13type, #m_select2_13type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_14type, #m_select2_14type_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_14status, #m_select2_14status_validate").select2({placeholder: "Ընտրեք ցանկից"}),
        $("#m_select2_4").select2({ placeholder: "Ընտրեք ցանկից", allowClear: !0});

        var e = [{id: 0, text: "Enhancement"}, {id: 1, text: "Bug"}, {id: 2, text: "Duplicate"}, {
            id: 3,
            text: "Invalid"
        }, {id: 4, text: "Wontfix"}];
        $("#m_select2_5").select2({
            placeholder: "Select a value",
            data: e
        }), $("#m_select2_6").select2({
            placeholder: "Search for git repositories",
            allowClear: !0,
            ajax: {
                url: "https://api.github.com/search/repositories", dataType: "json", delay: 250, data: function (e) {
                    return {q: e.term, page: e.page}
                }, processResults: function (e, t) {
                    return t.page = t.page || 1, {results: e.items, pagination: {more: 30 * t.page < e.total_count}}
                }, cache: !0
            },
            escapeMarkup: function (e) {
                return e
            },
            minimumInputLength: 1,
            templateResult: function (e) {
                if (e.loading) return e.text;
                var t = "<div class='select2-result-repository clearfix'><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.full_name + "</div>";
                return e.description && (t += "<div class='select2-result-repository__description'>" + e.description + "</div>"), t += "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + e.forks_count + " Forks</div><div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + e.stargazers_count + " Stars</div><div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + e.watchers_count + " Watchers</div></div></div></div>"
            },
            templateSelection: function (e) {
                return e.full_name || e.text
            }
        }), $("#m_select2_12_1, #m_select2_12_2, #m_select2_12_3, #m_select2_12_4").select2({placeholder: "Ընտրեք ցանկից"}), $("#m_select2_7").select2({placeholder: "Ընտրեք ցանկից"}), $("#m_select2_8").select2({placeholder: "Ընտրեք ցանկից"}), $("#m_select2_9").select2({
            placeholder: "Ընտրեք ցանկից",
            maximumSelectionLength: 2
        }), $("#m_select2_10").select2({
            placeholder: "Ընտրեք ցանկից",
            minimumResultsForSearch: 1 / 0
        }), $("#m_select42_10").select2({
            placeholder: "Ընտրեք ցանկից",
            minimumResultsForSearch: 1 / 0
        }), $("#m_select2_11").select2({placeholder: "Add a tag", tags: !0})
    }, t = function () {
        $("#m_select2_modal").on("shown.bs.modal", function () {
            $("#m_select2_1_modal").select2({placeholder: "Ընտրեք ցանկից"}), $("#m_select2_2_modal").select2({placeholder: "Ընտրեք ցանկից"}), $("#m_select2_3_modal").select2({placeholder: "Ընտրեք ցանկից"}), $("#m_select2_4_modal").select2({
                placeholder: "Ընտրեք ցանկից",
                allowClear: !0
            })
        })
    };
    return {
        init: function () {
            e(), t()
        }
    }
}();
jQuery(document).ready(function () {
    Select2.init()
});