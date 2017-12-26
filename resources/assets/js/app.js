var Filter = (function() {
    var filters = {};

    return {
        sendData: function() {
            filters.keyword = $('#searchKeyword').val();

            $.ajax({
                type: 'post',
                url: '',
                data: filters,
                success: function(response) {
                    console.log(response);
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