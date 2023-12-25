
jQuery(function ($) {
    $('.file-image').ace_file_input({
        no_file: 'No File ...',
        btn_choose: 'Choose',
        btn_change: 'Change',
        droppable: false,
        onchange: null,
        thumbnail: false, //| true | large
//        whitelist: 'gif|png|jpg|jpeg',
//        blacklist: 'exe|php',
        //onchange:''
        before_change: function (files, dropped) {
            var allowed_files = [];
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (typeof file === "string") {
                    //IE8 and browsers that don't support File Object
                    if (!(/\.(jpe?g|png|gif|bmp)$/i).test(file)) {
                        alert('File không hợp lệ!');
                        return false;
                    }

                } else {
                    var type = $.trim(file.type);
                    if ((type.length > 0 && !(/^image\/(jpe?g|png|gif|bmp)$/i).test(type))
                            || (type.length == 0 && !(/\.(jpe?g|png|gif|bmp)$/i).test(file.name))//for android's default browser which gives an empty string for file.type
                            ) {
                        alert('File không hợp lệ!');
                        continue;
                    }//not an image so don't keep this file
                }

                allowed_files.push(file);
            }
            if (allowed_files.length == 0)
                return false;
            return allowed_files;
        },
    });
    $('.file-pdf-doc').ace_file_input({
        no_file: 'No File ...',
        btn_choose: 'Choose',
        btn_change: 'Change',
        droppable: false,
        onchange: null,
        thumbnail: false, //| true | large
//        whitelist: 'gif|png|jpg|jpeg',
//        blacklist: 'exe|php',
        //onchange:''
        before_change: function (files, dropped) {
            var allowed_files = [];
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (typeof file === "string") {
                    //IE8 and browsers that don't support File Object
                    if (!(/\.(pdf|doc|docx)$/i).test(file)) {
                        alert('File không hợp lệ!');
                        return false;
                    }

                } else {
                    var type = $.trim(file.type);
                    if ((type.length > 0 && !(/^((application\/vnd.openxmlformats-officedocument.wordprocessingml.document)|(application\/msword)|(application\/pdf))$/i).test(type))
                            || (type.length == 0 && !(/\.(pdf|doc|docx)$/i).test(file.name))//for android's default browser which gives an empty string for file.type
                            )
                    {
                        alert('File không hợp lệ!');
                        continue; //not an image so don't keep this file
                    }
                }

                allowed_files.push(file);
            }
            if (allowed_files.length == 0)
                return false;
            return allowed_files;
        },
    });
//    $('.input-mask-sort').bind('keyup blur', function () {
//        var myValue = $(this).val();
//        $(this).val(myValue.replace(/[^0-9]/g, ''));
//    });

    $('.input-mask-sort').mask('000.000.000.000.000', {reverse: true});
    $('.input-mask-real').mask('RRRRRRRR', {reverse: true, translation: {'R': {pattern: /[0-9,]/}}});
    $('.input-mask-int').mask('000000000000', {reverse: true, });
//    $('.input-mask-sort').mask("#.##0,00", {reverse: true});

    $(".chosen-select").chosen();
    $('form#active-form').on('beforeSubmit', function (e) {
        getEditor();
    }).on('submit', function (e) {
//        e.preventDefault();
    });
    function getEditor() {
        $(".wysiwyg-editor").each(function () {
//            console.log($(this).attr('lang'));
            vlang = $(this).attr('lang');
            $(vlang).val($(this).html());
        });
    }
    function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
        } else {
            console.log("error uploading file", reason, detail);
        }
//        alert('File upload error ' + msg);
        alert('File không đúng định dạng.');
    }
    $('.wysiwyg-editor').ace_wysiwyg({
        toolbar:
                [
                    'font',
                    null,
                    'fontSize',
                    null,
                    {name: 'bold', className: 'btn-info'},
                    {name: 'italic', className: 'btn-info'},
                    {name: 'strikethrough', className: 'btn-info'},
                    {name: 'underline', className: 'btn-info'},
                    null,
                    {name: 'insertunorderedlist', className: 'btn-success'},
                    {name: 'insertorderedlist', className: 'btn-success'},
                    {name: 'outdent', className: 'btn-purple'},
                    {name: 'indent', className: 'btn-purple'},
                    null,
                    {name: 'justifyleft', className: 'btn-primary'},
                    {name: 'justifycenter', className: 'btn-primary'},
                    {name: 'justifyright', className: 'btn-primary'},
                    {name: 'justifyfull', className: 'btn-inverse'},
                    null,
                    {name: 'createLink', className: 'btn-pink'},
                    {name: 'unlink', className: 'btn-pink'},
                    null,
                    {name: 'insertImage', className: 'btn-success'},
                    null,
                    'foreColor',
                    null,
                    {name: 'undo', className: 'btn-grey'},
                    {name: 'redo', className: 'btn-grey'}
                ],
        'wysiwyg': {
            fileUploadError: showErrorAlert
        }
    }).prev().addClass('wysiwyg-style2');
    if (typeof jQuery.ui !== 'undefined' && /applewebkit/.test(navigator.userAgent.toLowerCase())) {

        var lastResizableImg = null;
        function destroyResizable() {
            if (lastResizableImg == null)
                return;
            lastResizableImg.resizable("destroy");
            lastResizableImg.removeData('resizable');
            lastResizableImg = null;
        }

        var enableImageResize = function () {
            $('.wysiwyg-editor')
                    .on('mousedown', function (e) {
                        var target = $(e.target);
                        if (e.target instanceof HTMLImageElement) {
                            if (!target.data('resizable')) {
                                target.resizable({
                                    aspectRatio: e.target.width / e.target.height,
                                });
                                target.data('resizable', true);
                                if (lastResizableImg != null) {//disable previous resizable image
                                    lastResizableImg.resizable("destroy");
                                    lastResizableImg.removeData('resizable');
                                }
                                lastResizableImg = target;
                            }
                        }
                    })
                    .on('click', function (e) {
                        if (lastResizableImg != null && !(e.target instanceof HTMLImageElement)) {
                            destroyResizable();
                        }
                    })
                    .on('keydown', function () {
                        destroyResizable();
                    });
        }
        enableImageResize();
    }

    $('textarea[class*=autosize]').autosize({append: "\n"});
    $('textarea.limited').inputlimiter({
        remText: '%n character%s remaining...',
        limitText: 'max allowed : %n.'
    });
    $('.file-images').ace_file_input({
        style: 'well',
        btn_choose: 'Drop image here or click to choose',
        btn_change: null,
        no_icon: 'icon-cloud-upload',
        droppable: true,
        thumbnail: 'small', //large | fit
        before_change: function (files, dropped) {
            var allowed_files = [];
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (typeof file === "string") {
                    //IE8 and browsers that don't support File Object
                    if (!(/\.(jpe?g|png|gif|bmp)$/i).test(file)) {
                        alert('File không hợp lệ!');
                        return false;
                    }
                } else {
                    var type = $.trim(file.type);
                    if ((type.length > 0 && !(/^image\/(jpe?g|png|gif|bmp)$/i).test(type))
                            || (type.length == 0 && !(/\.(jpe?g|png|gif|bmp)$/i).test(file.name))//for android's default browser which gives an empty string for file.type
                            )
                    {
                        alert('File không hợp lệ!');
                        continue; //not an image so don't keep this file
                    }
                }

                allowed_files.push(file);
            }
            if (allowed_files.length == 0)
                return false;
            return allowed_files;
        },
        preview_error: function (filename, error_code) {
        }

    }).on('change', function () {
    });


    $('.file-input').ace_file_input({
        style: 'well',
        btn_choose: 'Drop files here or click to choose',
        btn_change: null,
        no_icon: 'icon-cloud-upload',
        droppable: true,
        thumbnail: 'small', //large | fit
        before_change: function (files, dropped) {
            var allowed_files = [];
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (typeof file === "string") {
                    //IE8 and browsers that don't support File Object
                    if (!(/\.(jpe?g|png|gif|bmp|flv|mp4|ogg|webm|wmv|swf|pdf)$/i).test(file)) {
                        alert('File không hợp lệ!');
                        return false;
                    }
                } else {
                    var type = $.trim(file.type);
                    if ((type.length > 0 && !(/^(image\/(jpe?g|png|gif|bmp)|flv|mp4|ogg|webm|wmv|swf|(application\/pdf))$/i).test(type))
                            || (type.length == 0 && !(/\.(jpe?g|png|gif|bmp|flv|mp4|ogg|webm|wmv|swf|pdf)$/i).test(file.name))//for android's default browser which gives an empty string for file.type
                            )
                    {
                        alert('File không hợp lệ!');
                        continue; //not an image so don't keep this file
                    }
                }

                allowed_files.push(file);
            }
            if (allowed_files.length == 0)
                return false;
            return allowed_files;
        },
        preview_error: function (filename, error_code) {
            //name of the file that failed
            //error_code values
            //1 = 'FILE_LOAD_FAILED',
            //2 = 'IMAGE_LOAD_FAILED',
            //3 = 'THUMBNAIL_FAILED'
            //alert(error_code);
        }

    }).on('change', function () {
//console.log($(this).data('ace_input_files'));
//console.log($(this).data('ace_input_method'));
    });

    jQuery(function ($) {
        var colorbox_params = {
            reposition: true,
            scalePhotos: true,
            scrolling: false,
            previous: '<i class="icon-arrow-left"></i>',
            next: '<i class="icon-arrow-right"></i>',
            close: '&times;',
            current: '{current} of {total}',
            maxWidth: '100%',
            maxHeight: '100%',
            onOpen: function () {
                document.body.style.overflow = 'hidden';
            },
            onClosed: function () {
                document.body.style.overflow = 'auto';
            },
            onComplete: function () {
                $.colorbox.resize();
            }
        };

        $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
        $("#cboxLoadingGraphic").append("<i class='icon-spinner orange'></i>");//let's add a custom loading icon
    });

    $(".form-field-tags").each(function () {
        var tag_input = $(this);
        if (!(/msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())))
        {
            tag_input.tag(
                    {
                        placeholder: tag_input.attr('placeholder'),
                        maxlength: tag_input.attr('maxlength'),
                        class: tag_input.attr('tagClass'),
                        source: (tag_input.attr('data-source')) ? tag_input.attr('data-source').split(";") : '',
                        //enable typeahead by specifying the source array
                    }
            );
        } else {
            //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
            tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' + tag_input.val() + '</textarea>').remove();
        }
    });
    $('.timepicker').timepicker({
        minuteStep: 1,
        showSeconds: false,
        showMeridian: false
    }).next().on(ace.click_event, function () {
        $(this).prev().focus();
    });


});
$(document).ready(function () {
    var next_project = parseInt($("#count-project").val());
    $(".add-more-project").click(function (e) {
        e.preventDefault();
        var addtoName = "#label" + next_project;
        var addRemoveName = "#label" + (next_project);
        var addtoValue = "#value" + next_project;
        var addRemoveValue = "#value" + (next_project);
        var addtoStt = "#stt" + next_project;
        var addRemoveStt = "#stt" + (next_project);
        var addtoRemove = "#removeifo" + next_project;
        var addRemoveRemove = "#removeifo" + (next_project);
        next_project = parseInt(next_project) + 1;
        var newIn = '<input autocomplete="off" class="col-xs-4" id="label' + next_project + '" name="label[' + next_project + ']" type="text" maxlength="255" placeholder="Tiêu đề">';
        newIn += '<input autocomplete="off" class="col-xs-4" id="value' + next_project + '" name="value[' + next_project + ']" type="text" maxlength="1000" placeholder="Giá trị">';
        newIn += '<input autocomplete="off" class="col-xs-1 input-mask-int" id="stt' + next_project + '" name="stt[' + next_project + ']" type="text" maxlength="4" placeholder="Thứ tự">';
        newIn += '<input autocomplete="off" class="col-xs-1" id="removeifo' + next_project + '" name="removeifo[' + next_project + ']" type="hidden" value="0">';
        var newInput = $(newIn);
        var removeBtn = '<a lang="' + (parseInt(next_project) - 1) + '" id="remove' + (parseInt(next_project) - 1) + '" class="btn btn-danger remove-me remove-me-project" >-</a></div><div id="field" class="field-project-' + (parseInt(next_project) - 1) + '">';
        var removeButton = $(removeBtn);
        $(addtoName).after(newInput);
        $(addRemoveName).after(removeButton);
        $("#label" + next_project).attr('data-source', $(addtoName).attr('data-source'));
        $(addtoValue).after(newInput);
        $(addRemoveValue).after(removeButton);
        $("#value" + next_project).attr('data-source', $(addtoValue).attr('data-source'));
        $(addtoStt).after(newInput);
        $(addRemoveStt).after(removeButton);
        $("#stt" + next_project).attr('data-source', $(addtoStt).attr('data-source'));
        $(addtoRemove).after(newInput);
        $(addRemoveRemove).after(removeButton);
        $("#removeifo" + next_project).attr('data-source', $(addtoRemove).attr('data-source'));
        $("#count-project").val(next_project);
        $('.remove-me-project').click(function (e) {
            e.preventDefault();
            var fieldNum = $(this).attr('lang');
            var fieldIDName = "#label" + fieldNum;
            var fieldIDValue = "#value" + fieldNum;
            var fieldIDStt = "#stt" + fieldNum;
            var fieldIDRemove = "#removeifo" + fieldNum;
            var fieldDiv = ".field-project-" + fieldNum;
            $(this).remove();
            $(fieldIDName).remove();
            $(fieldIDValue).remove();
            $(fieldIDStt).remove();
            $(fieldIDRemove).remove();
            $(fieldDiv).remove();
        });
    });
    $('.remove-me-project').click(function (e) {
        e.preventDefault();
        var fieldNum = $(this).attr('lang');
        var fieldIDName = "#label" + fieldNum;
        var fieldIDValue = "#value" + fieldNum;
        var fieldIDStt = "#stt" + fieldNum;
        var fieldIDRemove = "#removeifo" + fieldNum;
        var fieldDiv = ".field-project-" + fieldNum;
        $(this).remove();
        $(fieldIDName).remove();
        $(fieldIDValue).remove();
        $(fieldIDStt).remove();
        $(fieldIDRemove).remove();
        $(fieldDiv).remove();
    });

   
});


function uploadImageEditor(fileInfo) {
    var matches_array = fileInfo.name.match(/\.(.+)$/);
    var ext = matches_array[matches_array.length - 1];
    switch (ext.toLowerCase()) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            var fileSize = fileInfo.size || fileInfo.fileSize;
            fileSize = parseInt(fileSize) / 1048576;
            if (fileSize > 5) {
                alert('File ảnh lớn hơn 5MB.');
                return '';
            }
            break;
        default:
            alert('File không đúng định dạng.');
            return '';
    }
    var dataUrl = '';
    var formData = new FormData();
    formData.append('file', fileInfo);
    jQuery.ajax({
        url: urlUploadImage,
        type: "POST",
        data: formData,
        dataType: "json",
        async: false,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data['action']) {
                dataUrl = data['url'];
            } else {
                dataUrl = '';
            }

        }

    });
    return dataUrl;
}

// Begin Chon vi tri tren ban do cho Du an
var map = null, marker;
$("#btn_select_map").on('click', function () {
    bootbox.dialog({
        message: "<span class='bigger-110'>Dùng chuột kéo, di chuyển điểm tới tọa độ cần chọn. Cuộn chuột để phóng to, thu nhỏ bản đồ</span><div id='map-canvas' style='height: 500px'></div>",
        className: 'large',
        buttons:
                {
                    "success":
                            {
                                "label": "<i class='icon-ok'></i> OK!",
                                "className": "btn-sm btn-success",
                                "callback": function () {
                                    var point = marker.getPosition();
                                    $('.eb_latV').val(point.lat().toFixed(5))
                                    $('.eb_lngV').val(point.lng().toFixed(5))
                                }
                            },
                    "danger":
                            {
                                "label": "Cancel!",
                                "className": "btn-sm btn-danger",
                                "callback": function () {

                                }
                            }
                }
    }).on('shown.bs.modal', function () {
        function initialize() {
            var lat = 21.03553, log = 105.85099;
            if ($('#lat_default').val()) {
                lat = $('#lat_default').val();
            }
            if ($('#lng_default').val()) {
                log = $('#lng_default').val();
            }
            var lagIn = $('.eb_latV').val();
            var logIn = $('.eb_lngV').val();
            if (lagIn != '') {
                lat = lagIn;
            }
            if (logIn != '') {
                log = logIn;
            }
            var mapOptions = {
                zoom: 15,
                center: new google.maps.LatLng(lat, log)
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),
                    mapOptions);



            var center = new google.maps.LatLng(lat, log);
            marker = new google.maps.Marker({position: center, draggable: true, map: map});
            map.panTo(center);
            google.maps.event.addListener(marker, "dragend", function () {
            });
        }
        initialize();
    });
});
// End Chon vi tri tren ban do cho Du an

$("document").ready(function () {
    $("input.date-range-picker").daterangepicker({
        format: "DD/MM/YYYY"
    }).prev().on(ace.click_event, function () {
        $(this).next().focus();
    });
    $(".date-range-picker").on("hidden", function (ev, picker) {
        $(".grid-view").yiiGridView("applyFilter");
    });
});

function split(val) {
    return val.split(/,\s*/);
}
function extractLast(term) {
    return split(term).pop();
}