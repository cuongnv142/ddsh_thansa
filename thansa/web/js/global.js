if (!("ace" in window)) {
    window.ace = {}
}
jQuery(function () {
    window.ace.click_event = $.fn.tap ? "tap" : "click";
})
var csrfParam = $('#form-key-csrf-csdldongthucvat').attr('data-key-name');
var csrfToken = $('#form-key-csrf-csdldongthucvat').attr('data-key-value');
$.ajaxSetup({
    headers: {
        'X-CSRF-Token': csrfToken
    }
});
if (typeof csdldongthucvat === 'undefined') {
    var csdldongthucvat = {};
}

csdldongthucvat.media = {
    url: '/site/ajaxuploadmedia.html',
    init: function (url) {
        var self = this;
        if (url) {
            self.url = url;
        }
    },
    readImage: function () {

    },
    validateImage: function (file) {
        if (typeof file === "string") {
            //IE8 and browsers that don't support File Object
            if (!(/\.(jpe?g|png|gif|bmp)$/i).test(file)) {
                Swal.fire({
                    icon: 'error',
                    title: alert_thongbao,
                    text: 'File không hợp lệ!',
                });
                return false;
            }

        } else {
            var type = $.trim(file.type);
            if ((type.length > 0 && !(/^image\/(jpe?g|png|gif|bmp)$/i).test(type))
                    || (type.length == 0 && !(/\.(jpe?g|png|gif|bmp)$/i).test(file.name))//for android's default browser which gives an empty string for file.type
                    ) {
                Swal.fire({
                    icon: 'error',
                    title: alert_thongbao,
                    text: 'File không hợp lệ!',
                });
                return false;
            }
        }

        var fileSize = fileInfo.size || fileInfo.fileSize;
        fileSize = parseInt(fileSize) / 1048576;
        if (fileSize > 5) {
            Swal.fire({
                icon: 'error',
                title: alert_thongbao,
                text: 'File ảnh lớn hơn 5MB',
            });
            return false;
        }
        return true;
    },
    uploadImage: function (fileInfo) {
        var self = this;
        //validate image
        if (!self.validateImage(fileInfo)) {
            return false;
        }
        var formData = new FormData();
        formData.append('file', fileInfo);
        return new Promise(function (resolve, reject) {
            var ajaxUpload = $.ajax({
                url: self.url,
                type: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                async: false,
            });
            ajaxUpload.done(function (resp) {
                resolve(resp);
            }).fail(function (error) {
                reject(error);
            })
        });
    }
};
csdldongthucvat.customer = {
    uploadImage: function (url, fileInfo) {
        var formData = new FormData();
        formData.append('file', fileInfo);
        return new Promise(function (resolve, reject) {
            if (!csdldongthucvat.media.validateImage(fileInfo)) {
                resolve('File không hợp lệ!');
            } else {
                var ajaxUpload = $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    async: false,
                });
                ajaxUpload.done(function (resp) {
                    resolve(resp);
                }).fail(function (error) {
                    reject(error);
                })
            }
        });
    }
};

function dateInputMask(elm) {
    elm.addEventListener('keyup', function (e) {
        if (e.keyCode < 47 || e.keyCode > 57) {
            e.preventDefault();
        }
        var len = elm.value.length;
        // 30-12-2019
        if (len !== 1 || len !== 3) {
            if (e.keyCode == 47) {
                e.preventDefault();
            }
        }
        if (len === 2 && e.keyCode != 8) {
            elm.value += '-';
        }
        if (len === 5 && e.keyCode != 8) {
            elm.value += '-';
        }
    });
}

function isOnlyNumber(evt) {
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
    if (iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
        return false;

    return true;
}

function isNumber(evt) {
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
    if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
        return false;

    return true;
}

function validateImage(file) {
    var reval = true;
    if (typeof file === "string") {
        if (!(/\.(jpe?g|png|gif|bmp)$/i).test(file)) {
            reval = false;
        }
    } else {
        var type = $.trim(file.type);
        if ((type.length > 0 && !(/^image\/(jpe?g|png|gif|bmp)$/i).test(type))
                || (type.length == 0 && !(/\.(jpe?g|png|gif|bmp)$/i).test(file.name))
                ) {
            reval = false;
        }
        var fileSize = file.size || file.fileSize;
        fileSize = parseInt(fileSize) / 1048576;
        if (fileSize > 5) {
            reval = false;
        }
    }
    return reval;
}

function validateFilePdfDoc(file) {
    var reval = true;
    if (typeof file === "string") {
        if (!(/\.(pdf|doc|docx)$/i).test(file)) {
            reval = false;
        }
    } else {
        var type = $.trim(file.type);
        if ((type.length > 0 && !(/^((application\/vnd.openxmlformats-officedocument.wordprocessingml.document)|(application\/msword)|(application\/pdf))$/i).test(type))
                || (type.length == 0 && !(/\.(pdf|doc|docx)$/i).test(file.name))
                ) {
            reval = false;
        }
    }
    return reval;
}

function showLoading() {
    $("#bg_loading").fadeIn();
}

function hideLoading() {
    $('#bg_loading').fadeOut();
}

function validateEmail(email) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(email)) {
        return false;
    }
    return true;
}

function validatePhone(phone) {
    var filter = /^(01([0-9]{2})|09[0-9]|08[0-9]|03[0-9]|05[0-9]|07[0-9]|08[0-9])(\d{7})$/i;
    if (!filter.test(phone)) {
        return false;
    }
    return true;
}

function split(val) {
    return val.split(/,\s*/);
}

function extractLast(term) {
    return split(term).pop();
}

//Hàm so sánh date không quá ngày hiện tại
function compareDate(day, month, year) {
    var today = new Date();
    var strDate = (day.length < 2 ? "0" + day : "" + day) + "-" + (month.length < 2 ? "0" + month : "" + month) + "-" + year;
    var cvDate = year + "-" + (month.length < 2 ? "0" + month : "" + month) + "-" + (day.length < 2 ? "0" + day : "" + day);
    var dateCompare = new Date(cvDate);
    if (today >= dateCompare && isValidDate(strDate))
        return true;
    else
        return false;
}

function isValidDate(str) {
    var parts = str.split('-');
    if (parts.length < 3)
        return false;
    else {
        var day = parseInt(parts[0]);
        var month = parseInt(parts[1]);
        var year = parseInt(parts[2]);
        if (isNaN(day) || isNaN(month) || isNaN(year)) {
            return false;
        }
        if (day < 1 || year < 1900 || year > 3000)
            return false;
        if (month > 12 || month < 1)
            return false;
        if ((month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) && day > 31)
            return false;
        if ((month == 4 || month == 6 || month == 9 || month == 11) && day > 30)
            return false;
        if (month == 2) {
            if (((year % 4) == 0 && (year % 100) != 0) || ((year % 400) == 0 && (year % 100) == 0)) {
                if (day > 29)
                    return false;
            } else {
                if (day > 28)
                    return false;
            }
        }
        return true;
    }
}

function getAge(str) {
    var parts = str.split('-');
    var day = parseInt(parts[0]);
    var month = parseInt(parts[1]);
    var year = parseInt(parts[2]);
    var DOB = year + '-' + month + '-' + day;
    var today = new Date();
    var birthDate = new Date(DOB);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function reloadpage() {
    var url = location.href.split(/\?|#/)[0];
    location.href = url
    //                        window.location.reload();
}

function SetCookie(a, b, c) {
    Cookies.set(a, b, {
        expires: c,
        path: "/"
    })
}

function GetCookie(a) {
    return Cookies.get(a);
}

function ResetCookie(a) {
    Cookies.set(a, null, {path: "/"});
}

function change_language(lang, ele) {
    if (lang && ele) {
        SetCookie('language', lang, 365);
        url = $(ele).attr('data-url');
        if (url) {
            window.location.href = url;
        } else {
            window.location.href = url_home;
        }

    }
}

$("#feedback_email").on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        submit_emailletter();
    }
});

function submit_emailletter(ele) {
    var email = jQuery('#feedback_email').val();
    if (email == '') {
        $('#feedback_email').focus();
        Swal.fire({
            icon: 'error',
            title: alert_thongbao,
            text: 'Vui lòng nhập Email!',
        });
        return false;
    } else if (!validateEmail(email)) {
        $('#feedback_email').focus();
        Swal.fire({
            icon: 'error',
            title: alert_thongbao,
            text: 'Vui lòng nhập email hợp lệ!',
        });
        return false;
    }

    $(ele).attr('disabled', 'disabled');
    showLoading();
    var data = new FormData();
    var csrfParam = $('#form-key-csrf-csdldongthucvat').attr('data-key-name');
    var csrfToken = $('#form-key-csrf-csdldongthucvat').attr('data-key-value');
    data.append(csrfParam, csrfToken);
    data.append('email', email);
    jQuery.ajax({
        url: url_register_feedback,
        type: "POST",
        data: data,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (obj) {
            hideLoading();
            if (obj.err === 0) {
                $(ele).removeAttr('disabled');
                if (obj.status === 1) {
                    $('#feedback_email').val('');
                    Swal.fire({
                        icon: 'success',
                        title: alert_thongbao,
                        text: 'Bạn đã đăng ký nhận tin khuyến mại thành công!',
                    });
//                    setTimeout(function () {
//                        $(ele).removeAttr('disabled');
//                    }, 800);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: alert_thongbao,
                    text: (obj.msg) ? obj.msg : 'Có lỗi khi lưu dữ liệu!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });

            }
        }
    });
}




$(document).ready(function () {
    $('.pricerange_input').keyup(function (e)
    {
        if (/\D/g.test(this.value))
        {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }
    });
    $('.input-qty').keyup(function (e)
    {
        if (/\D/g.test(this.value))
        {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }
    });
    affixscrolltop();
});


function affixscrolltop() {
    jQuery('.back-top').click(function () {
        $("html, body").animate({scrollTop: 0}, "slow");
    });
    if ($(window).scrollTop() > 70) {
        $('.back-top').stop().show();
    } else {
        $('.back-top').stop().hide();
    }
    $(window).scroll(function () {
        if ($(this).scrollTop() > 70) {
            $('.back-top').stop().show();
        } else {
            $('.back-top').stop().hide();
        }
    });
}

function submit_frm_contact() {
    var fullname = jQuery('#fullname_contact').val();
    if (fullname == '') {
        $('#fullname_contact').focus();
        Swal.fire({
            icon: 'error',
            title: alert_thongbao,
            text: alert_name_null,
        });
        return false;
    }
    var email = jQuery('#email_contact').val();
    if (email == '') {
        $('#email_contact').focus();
        Swal.fire({
            icon: 'error',
            title: alert_thongbao,
            text: alert_email_null,
        });
        return false;
    } else if (!validateEmail(email)) {
        $('#email_contact').focus();
        Swal.fire({
            icon: 'error',
            title: alert_thongbao,
            text: alert_email_fail,
        });
        return false;
    }

    var phone = jQuery('#phone_contact').val();
    if (phone == '') {
        $('#phone_contact').focus();
        Swal.fire({
            icon: 'error',
            title: alert_thongbao,
            text: alert_phone_null,
        });
        return false;
    } else if (!validatePhone(phone)) {
        $('#phone_contact').focus();
        Swal.fire({
            icon: 'error',
            title: alert_thongbao,
            text: alert_phone_fail,
        });
        return false;
    }

    $(this).attr('disabled', 'disabled');
    var data = new FormData();
    var csrfParam = $('#form-key-csrf-csdldongthucvat').attr('data-key-name');
    var csrfToken = $('#form-key-csrf-csdldongthucvat').attr('data-key-value');
    data.append(csrfParam, csrfToken);
    data.append('fullname', fullname.trim());
    data.append('email', email.trim());
    data.append('phone', phone.trim());
    data.append('note', '');
    var url_register_subcriber = jQuery('#frm-contact').attr('action');
    jQuery.ajax({
        url: url_register_subcriber,
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (obj) {
            hideLoading();
            if (obj.err === 0) {
                Swal.fire({
                    icon: 'success',
                    title: alert_thongbao,
                    text: alert_send_contact_success,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: alert_thongbao,
                    text: (obj.msg) ? obj.msg : alert_email_err,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }
        }
    });
}

function redirectlink(link) {
    location.href = link;
}
function validate(evt) {
    var theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault)
            theEvent.preventDefault();
    }
}

function buildLink(str, val) {
    var url = location.href;
    var query = str;
    var value = val;
    var paramsUrl = $.parseParams(url.split('?')[1] || '');
    if (paramsUrl) {
        if (paramsUrl[query]) {
            delete paramsUrl[query];
            if (value && value != 0 && value != "") {
                paramsUrl[query] = value;
            }

        } else {
            if (value && value != 0 && value.length) {
                paramsUrl[query] = value;
            } else {
                delete paramsUrl[query];
            }
        }
        if (jQuery.param(paramsUrl)) {
            var url = url.split('?')[0] + '?' + jQuery.param(paramsUrl);
        } else {
            var url = url.split('?')[0];
        }
    }
    return url;
}
