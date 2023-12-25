
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
    var next_ree = parseInt($("#count-ree").val());
    $(".add-more-ree").click(function (e) {
        e.preventDefault();
        var addtoName = "#branch_name" + next_ree;
        var addRemoveName = "#branch_name" + (next_ree);
        var addtoAddress = "#branch_address" + next_ree;
        var addRemoveAddress = "#branch_address" + (next_ree);
        var addtoPhone = "#branch_phone" + next_ree;
        var addRemovePhone = "#branch_phone" + (next_ree);
        var addtoFax = "#branch_fax" + next_ree;
        var addRemoveFax = "#branch_fax" + (next_ree);
        next_ree = parseInt(next_ree) + 1;
        var newIn = '<input autocomplete="off" class="col-xs-2" id="branch_name' + next_ree + '" name="branch_name[' + next_ree + ']" type="text" maxlength="255" placeholder="Trụ sở">';
        newIn += '<input autocomplete="off" class="col-xs-4" id="branch_address' + next_ree + '" name="branch_address[' + next_ree + ']" type="text" maxlength="255" placeholder="Địa chỉ">';
        newIn += '<input autocomplete="off" class="col-xs-2" id="branch_phone' + next_ree + '" name="branch_phone[' + next_ree + ']" type="text" maxlength="255" placeholder="Điện thoại">';
        newIn += '<input autocomplete="off" class="col-xs-2" id="branch_fax' + next_ree + '" name="branch_fax[' + next_ree + ']" type="text" maxlength="255" placeholder="Fax">';
        var newInput = $(newIn);
        var removeBtn = '<button lang="' + (parseInt(next_ree) - 1) + '" id="remove' + (parseInt(next_ree) - 1) + '" class="btn btn-danger remove-me remove-me-ree" >-</button></div><div id="field" class="field-ree-' + (parseInt(next_ree) - 1) + '">';
        var removeButton = $(removeBtn);
        $(addtoName).after(newInput);
        $(addRemoveName).after(removeButton);
        $("#branch_name" + next_ree).attr('data-source', $(addtoName).attr('data-source'));
        $(addtoAddress).after(newInput);
        $(addRemoveAddress).after(removeButton);
        $("#branch_address" + next_ree).attr('data-source', $(addtoAddress).attr('data-source'));
        $(addtoPhone).after(newInput);
        $(addRemovePhone).after(removeButton);
        $("#branch_phone" + next_ree).attr('data-source', $(addtoPhone).attr('data-source'));
        $(addtoFax).after(newInput);
        $(addRemoveFax).after(removeButton);
        $("#branch_fax" + next_ree).attr('data-source', $(addtoFax).attr('data-source'));
        $("#count-ree").val(next_ree);

        $('.remove-me-ree').click(function (e) {
            e.preventDefault();
//            var fieldNum = this.id.charAt(parseInt(this.id.length) - 1);
            var fieldNum = $(this).attr('lang');
            var fieldIDName = "#branch_name" + fieldNum;
            var fieldIDAddress = "#branch_address" + fieldNum;
            var fieldIDPhone = "#branch_phone" + fieldNum;
            var fieldIDFax = "#branch_fax" + fieldNum;
            var fieldDiv = ".field-ree-" + fieldNum;
            $(this).remove();
            $(fieldIDName).remove();
            $(fieldIDAddress).remove();
            $(fieldIDPhone).remove();
            $(fieldIDFax).remove();
            $(fieldDiv).remove();
        });
    });

    var next_apartment = parseInt($("#count-apartment").val());
    $(".add-more-apartment").click(function (e) {
        e.preventDefault();
        var addtoName = "#label" + next_apartment;
        var addRemoveName = "#label" + (next_apartment);
        var addtoValue = "#value" + next_apartment;
        var addRemoveValue = "#value" + (next_apartment);
        next_apartment = parseInt(next_apartment) + 1;
        var newIn = '<input autocomplete="off" class="col-xs-4" id="label' + next_apartment + '" name="label[' + next_apartment + ']" type="text" maxlength="255" placeholder="Tiêu đề">';
        newIn += '<input autocomplete="off" class="col-xs-4" id="value' + next_apartment + '" name="value[' + next_apartment + ']" type="text" maxlength="255" placeholder="Giá trị">';
        var newInput = $(newIn);
        var removeBtn = '<button lang="' + (parseInt(next_apartment) - 1) + '" id="remove' + (parseInt(next_apartment) - 1) + '" class="btn btn-danger remove-me remove-me-apartment" >-</button></div><div id="field" class="field-apartment-' + (parseInt(next_apartment) - 1) + '">';
        var removeButton = $(removeBtn);
        $(addtoName).after(newInput);
        $(addRemoveName).after(removeButton);
        $("#label" + next_apartment).attr('data-source', $(addtoName).attr('data-source'));
        $(addtoValue).after(newInput);
        $(addRemoveValue).after(removeButton);
        $("#value" + next_apartment).attr('data-source', $(addtoValue).attr('data-source'));
        $("#count-apartment").val(next_apartment);
        $('.remove-me-apartment').click(function (e) {
            e.preventDefault();
//            var fieldNum = this.id.charAt(parseInt(this.id.length) - 1);
            var fieldNum = $(this).attr('lang');
            var fieldIDName = "#label" + fieldNum;
            var fieldIDValue = "#value" + fieldNum;
            var fieldDiv = ".field-apartment-" + fieldNum;
            $(this).remove();
            $(fieldIDName).remove();
            $(fieldIDValue).remove();
            $(fieldDiv).remove();
        });
    });
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
        var removeBtn = '<button lang="' + (parseInt(next_project) - 1) + '" id="remove' + (parseInt(next_project) - 1) + '" class="btn btn-danger remove-me remove-me-project" >-</button></div><div id="field" class="field-project-' + (parseInt(next_project) - 1) + '">';
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
        message: "<span class='bigger-110'>Dùng chuột kéo, di chuyển điểm tới tọa độ cần chọn. Cuộn chuột để phóng to, thu nhỏ bản đồ</span><div id='map-canvas' style='height: 300px'></div>",
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
            var mapOptions = {
                zoom: 12,
                center: new google.maps.LatLng(-34.397, 150.644)
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),
                    mapOptions);

            var lat = 21.03553, log = 105.85099;
            var lagIn = $('.eb_latV').val();
            var logIn = $('.eb_lngV').val();
            if (lagIn != '') {
                lat = lagIn;
            }
            if (logIn != '') {
                log = logIn;
            }
            var center = new google.maps.LatLng(lat, log);
            marker = new google.maps.Marker({position: center, draggable: true, map: map});
            map.panTo(center);
            google.maps.event.addListener(marker, "dragend", function () {
                /*
                 var point = marker.getPosition();
                 $('#adminproject-eb_latv').val(point.lat().toFixed(5))
                 $('#adminproject-eb_lngv').val(point.lng().toFixed(5))
                 */
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
    if ($('.ckeditor_tiny').length) {
        CKEDITOR.replace('ckeditor_tiny', {
            // Define the toolbar groups as it is a more accessible solution.
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles", 'cleanup']
                },
//                {
//                    "name": "links",
//                    "groups": ["links"]
//                },
//                {
//                    "name": "paragraph",
//                    "groups": ["list", "blocks"]
//                },
//                {
//                    "name": "document",
//                    "groups": ["mode"]
//                },
//                {
//                    "name": "insert",
//                    "groups": ["insert"]
//                },
//                {
//                    "name": "styles",
//                    "groups": ["styles"]
//                },
//                {
//                    "name": "about",
//                    "groups": ["about"]
//                }
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Subscript,Superscript,Anchor,Styles,Specialchar'
        });
    }
});
$(document).ready(function () {
    var next_attribute = parseInt($("#count-attribute").val());
    $(".add-more-attribute").click(function (e) {
        e.preventDefault();
        var addtoName = "#label" + next_attribute;
        var addRemoveName = "#label" + (next_attribute);
        var addtoValue = "#value" + next_attribute;
        var addRemoveValue = "#value" + (next_attribute);
        next_attribute = parseInt(next_attribute) + 1;
        var countSortOrder = next_attribute * 2;
        var newIn = '<input autocomplete="off" class="col-xs-5" id="label' + next_attribute + '" name="label[' + next_attribute + ']" type="text" maxlength="255" placeholder="Tiêu đề">';
        newIn += '<input autocomplete="off" class="col-xs-2 input-mask-int" id="value' + next_attribute + '" value="' + countSortOrder + '" name="value[' + next_attribute + ']" type="text" maxlength="4" placeholder="Thứ tự">';
        var newInput = $(newIn);
        var removeBtn = '<button lang="' + (parseInt(next_attribute) - 1) + '" id="remove' + (parseInt(next_attribute) - 1) + '" class="btn btn-danger remove-me remove-me-attribute" >-</button></div><div id="field" class="field-attribute-' + (parseInt(next_attribute) - 1) + '">';
        var removeButton = $(removeBtn);
        $(addtoName).after(newInput);
        $(addRemoveName).after(removeButton);
        $("#label" + next_attribute).attr('data-source', $(addtoName).attr('data-source'));
        $(addtoValue).after(newInput);
        $(addRemoveValue).after(removeButton);
        $("#value" + next_attribute).attr('data-source', $(addtoValue).attr('data-source'));

        $("#count-attribute").val(next_attribute);
    });
    $("#fields").on("click", ".remove-me-attribute", function (e) {
        e.preventDefault();
        var fieldNum = $(this).attr('lang');
        var fieldIDName = "#label" + fieldNum;
        var fieldIDValue = "#value" + fieldNum;
        var fieldDiv = ".field-attribute-" + fieldNum;
        $(fieldIDName).remove();
        $(fieldIDValue).remove();
        $(fieldDiv).remove();
        $(this).hide();
    });
});

function safetitle(obj, id) {
    var title, slug;

    //Lấy text từ thẻ input title
    title = $(obj).val();

    //Đổi chữ hoa thành chữ thường
    slug = title.toLowerCase();

    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    //In slug ra textbox có id “slug”
    $('#' + id).val(slug);
}