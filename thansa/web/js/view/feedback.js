function showFeedback() {
    $('#formTuVan').modal('show');
}

function hideFeedback() {
    $('#formTuVan').modal('hide');
}
function submit_feedback() {
    var feed_name = $.trim($('#feed_name').val());
    var feed_email = $.trim($('#feed_email').val());
    var feed_phone = $.trim($('#feed_phone').val());

    if (feed_name == '') {
        $('#feed_name').focus();
        Swal.fire({
            icon: 'error',
            title:alert_thongbao,
            text: alert_name_null,
        });
        return false;
    }
    if (feed_email == '') {
        $('#feed_email').focus();
        Swal.fire({
            icon: 'error',
            title:alert_thongbao,
            text: alert_email_null,
        });
        return false;
    }
    if (!validateEmail(feed_email)) {
        $('#feed_email').focus();
        Swal.fire({
            icon: 'error',
            title:alert_thongbao,
            text: alert_email_fail,
        });
        return false;
    }
    if (feed_phone == '') {
        $('#feed_phone').focus();
        Swal.fire({
            icon: 'error',
            title:alert_thongbao,
            text: alert_phone_null,
        });
        return false;
    }
    if (!validatePhone(feed_phone)) {
        $('#feed_phone').focus();
        Swal.fire({
            icon: 'error',
            title:alert_thongbao,
            text: alert_phone_fail,
        });
        return false;
    }
    var csrfParam = $('#form-key-csrf-csdldongthucvat').attr('data-key-name');
    var csrfToken = $('#form-key-csrf-csdldongthucvat').attr('data-key-value');
    var dataPost = {fullname: feed_name, email: feed_email, phone: feed_phone};
    dataPost[csrfParam] = csrfToken;
    showLoading();
    jQuery.ajax({
        url: url_savefeedback,
        type: "POST",
        data: dataPost,
        dataType: "json",
//         async: false,
        success: function (obj) {
            hideLoading();
            if (obj.err === 0) {
                Swal.fire({
                    icon: 'success',
                    title:alert_thongbao,
                    text: alert_send_contact_success,
                }).then((result) => {
                    if (result.isConfirmed) {
                        hideFeedback();
                        $('#feed_name').val('');
                        $('#feed_email').val('');
                        $('#feed_phone').val('');
//                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title:alert_thongbao,
                    text: alert_email_err,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }
        }
    });


}