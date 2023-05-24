// var token = require('../../../app/Http/Middleware/VerifyCsrfToken');
var xsrfToken = decodeURIComponent(readCookie('XSRF-TOKEN'));

$(document).ready(() => {
    $("input[type='radio'][name='field_id']").change(() => {
        $("#tanggal").prop('disabled', false);
        // $("#tanggal").change(() => {
            let selectedField = $("input[type='radio'][name='field_id']:checked").val();
            let selectedDate = $('#tanggal').val();
            // let csrfToken = $('meta[name="csrf-token"]').attr('content');
            alert(csrfToken);
            $.ajax({
                url: "/request",
                type: "POST",
                headers: {
                    'X-XSRF-TOKEN': xsrfToken
                },
                data: {
                    lapangan: selectedField,
                    tanggal: selectedDate
                },
                success: function(response) {
                    // console.log(response)
                    if (response.data) {
                        //tambahkan kelas disable pada input type checkbox
                        $('input[type="checkbox"]').each(function() {
                            let $element = $(this).val();
                            // console.log($element);
                            if ($.inArray($element, response.data) != -1) {
                                console.log('sama');
                                $(this).prop('disabled', false);
                            } else {
                                console.log('tidak');
                                $(this).prop('disabled', true);
                            }
                        });
                    } else {
                        console.log("data doesn't exists");
                    };
                },
                error: function(response) {
                    console.log(response);
                }
            });
        // })
    })
})