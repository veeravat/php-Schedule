$('#search').click(function() {
    var id = $('#stid').val();
    if (id.length < 1) {
        return false
    } else {
        $.ajax({
            type: 'get',
            url: "/find-" + id,
            data: {},
            dataType: 'json',
            success: function(response, status, xhr) {
                $('.Monday,.Tuesday,.Wednesday,.Thursday,.Friday,.Saturday')
                    .html('<div class="timeline morning">\</div>\
                            <div class="timeline afternoon"></div>\
                            <div class="timeline evening"></div>');
                if (!response.status) {
                    $('#Message').html('Can\'t find data');
                    $('#Message').fadeIn();
                    setTimeout(function() {
                        $('#Message').fadeOut();
                        setTimeout(function() {}, 500);
                    }, 1500);
                    return false
                }
                Object.keys(response).forEach(function(key) {
                    if (Object.keys(response[key]).length > 0) {
                        // console.log(key, response[key]);
                        newCard(response[key], key);
                    }
                });
                $('#Message').html('Schedule has been loaded');
                $('#Message').fadeIn();
                setTimeout(function() {
                    $('#Message').fadeOut();
                }, 1500);
            }
        });
    }
})

function newCard(data, field) {
    // $('.resultdata').append('<div class="card-deck row ">');
    Object.keys(data).forEach(function(key) {
        let time = data[key].time.split(".");
        if (time[0] == '08') {
            time = 'morning';
        } else if (time[0] == '12') {
            time = 'afternoon';
        } else {
            time = 'evening';
        }
        let card = '<div class="col-12">\
            <div style="display:none" class="card text-white text-center bg-' + field + ' sccard" id="' + field + time + data[key].code + '">\
                <div class="card-header">\
                    ' + data[key].code + '\
                </div>\
                <div class="card-body">\
                    <h6 class="card-title"> Sec ' + data[key].section + '</h6>\
                    <small class="card-text texttime">' + data[key].time + '\</small>\
                </div>\
            </div>\
        </div>';
        $('.' + field + ' .' + time).append(card);
        $('#' + field + time + data[key].code).fadeIn();
    });
    // $('.resultdata').append('</div>');
}
// $(window).resize(function() {
//     $('#Message').show();
//     $('#Message').html($(document).width());;
// });

$('#promise').click(function() {
    $.ajax({
        type: 'post',
        url: "/test",
        data: {},
        success: function(response, status, xhr) {
            console.log(response)
        }
    });
});