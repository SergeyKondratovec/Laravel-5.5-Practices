var Filter = (function() {
    var filters = {};

    return {
        sendData: function(page) {
            filters.keyword = $('#searchKeyword').val();
            filters._token = $('meta[name="csrf-token"]').attr('content');

            var fn = $('input[name="functionalName"]:checked');

            delete filters.functionalName;
            if (fn.length) {
                filters.functionalName = [];
            }
            $.each(fn, function() {
                filters.functionalName.push($(this).val());
            });

            /*if (filters.functionalName) {
                filters.functionalName = filters.functionalName.join(',');
            }*/

            var attr = $('#attributes:checked');
            delete filters.attribute;
            if (attr.length) {
                filters.attribute = [];
            }

            $.each(attr, function() {
                filters.attribute.push({
                    'attrId': $(this).data('attrId'),
                    'id': $(this).val(),
                });
            });

            delete filters.page;
            if (typeof page != 'undefined') {
                filters.page = page;
            }

            $.ajax({
                type: 'post',
                url: '/search',
                data: filters,
                success: function(response) {
                    $('#records').html(response.resultHtml);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    console.log(textStatus);
                    console.log(errorThrown);
                },
            });

            $.ajax({
                type: 'post',
                url: '/search/filter',
                data: filters,
                success: function(response) {
                    $('#facets').html(response.facetsHtml);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    console.log(textStatus);
                    console.log(errorThrown);
                },
            });
        },
    };
}());