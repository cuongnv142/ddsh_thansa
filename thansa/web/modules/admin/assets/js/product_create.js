

$("document").ready(function () {
    $(document).on('change', '.required_input', function (event) {
        event.preventDefault();
        $(this).removeClass("tooltip-error");
        $(this).next('.tooltip').remove();
    });
});


function setnametype(ele, type) {
    if (!ele || !type) {
        return false;
    }
    var name_type = $.trim($(ele).val());
    if (!name_type) {
        $('.name_type' + type).html('Tên');
        if (type == 1) {
            $('.name_image_type1').html('Nhóm phân loại 1');
        }
        return false;
    }
    $('.name_type' + type).html(name_type);
    if (type == 1) {
        $('.name_image_type1').html(name_type);
    }
}
function setnametypesub(ele, type) {
    if (!ele || !type) {
        return false;
    }
    var name_type_sub = $.trim($(ele).val());
    var id = $(ele).data('id');
    if (!id) {
        return false;
    }
    if (!name_type_sub) {
        $('.name_type' + type + '_sub' + id).html('Loại');
        if (type == 1) {
            $('.name_typeimage1_sub' + id).html('Phân loại hàng');
        }
        return false;
    }
    $('.name_type' + type + '_sub' + id).html(name_type_sub);
    if (type == 1) {
        $('.name_typeimage1_sub' + id).html(name_type_sub);
    }
}
function delete_boxtype2(ele, id) {
    if (!ele || !id) {
        return false;
    }
    var count = $('#boxs_type2').find('.text-row').length;
    if (count == 1) {
        $(ele).parent('.options-remove-btn').addClass('hidden');
        return false;
    }
    $(ele).parents('.text-row').remove();
    var count = $('#boxs_type2').find('.text-row').length;
    if (count == 1) {
        $('#boxs_type2').find('.options-remove-btn').addClass('hidden');
    }
    var html_b = '<i class="vars-icon icon-plus-sign bigger-125"></i> Đã thêm (' + count + '/20)';
    $('.btn-addtype2').removeClass('hidden').html(html_b);
    $('.b_listtype2_' + id).remove();
}

function add_boxtype2(ele) {
    if (!ele) {
        return false;
    }
    var count = $('#boxs_type2').find('.text-row').length;
    if (count >= 20) {
        return false;
    }
    count_type2++;
    var html = '<div class="grid text-row" >' +
            '<div class="edit-text">' +
            '<input type="text" name="product_type_two_sub[' + count_type2 + ']" placeholder="Nhập phân loại, ví dụ: S, M, v.v" maxlength="20" data-id="' + count_type2 + '"  onkeyup="setnametypesub(this,2)" class="form-control required_input" />' +
            '<span class="options-remove-btn">' +
            '<i class="vars-icon icon-trash" onclick="delete_boxtype2(this,' + count_type2 + ')"></i>' +
            '</span>' +
            '</div>' +
            '</div>';
    $('#boxs_type2').append(html);
    $('#boxs_type2').find('.options-remove-btn').removeClass('hidden');
    var count = $('#boxs_type2').find('.text-row').length;
    if (count == 1) {
        $('#boxs_type2').find('.options-remove-btn').addClass('hidden');
    } else if (count >= 20) {
        $(ele).addClass('hidden');
    }
    var html_b = '<i class="vars-icon icon-plus-sign bigger-125"></i> Đã thêm (' + count + '/20)';
    $(ele).html(html_b);
    addboxlisttype();

}

function delete_boxtype1(ele, id) {
    if (!ele || !id) {
        return false;
    }
    var count = $('#boxs_type1').find('.text-row').length;
    if (count == 1) {
        $(ele).parent('.options-remove-btn').addClass('hidden');
        return false;
    }
    $(ele).parents('.text-row').remove();
    var count = $('#boxs_type1').find('.text-row').length;
    if (count == 1) {
        $('#boxs_type1').find('.options-remove-btn').addClass('hidden');
    }
    var html_b = '<i class="vars-icon icon-plus-sign bigger-125"></i> Đã thêm (' + count + '/20)';
    $('.btn-addtype1').removeClass('hidden').html(html_b);
    $('.b_listtype1_' + id).remove();
    $('.b_imagetype1_' + id).remove();
}

function add_boxtype1(ele) {
    if (!ele) {
        return false;
    }
    var count = $('#boxs_type1').find('.text-row').length;
    if (count >= 20) {
        return false;
    }
    count_type1++;
    var html = '<div class="grid text-row" >' +
            '<div class="edit-text">' +
            '<input type="text" name="product_type_one_sub[' + count_type1 + ']" placeholder="Nhập phân loại hàng, ví dụ: Trắng, Đỏ v.v" maxlength="20" data-id="' + count_type1 + '" onkeyup="setnametypesub(this,1)" class="form-control required_input" />' +
            '<span class="options-remove-btn">' +
            '<i class="vars-icon icon-trash" onclick="delete_boxtype1(this,' + count_type1 + ')"></i>' +
            '</span>' +
            '</div>' +
            '</div>';
    $('#boxs_type1').append(html);
    $('#boxs_type1').find('.options-remove-btn').removeClass('hidden');
    var count = $('#boxs_type1').find('.text-row').length;
    if (count == 1) {
        $('#boxs_type1').find('.options-remove-btn').addClass('hidden');
    } else if (count >= 20) {
        $(ele).addClass('hidden');
    }

    var html_b = '<i class="vars-icon icon-plus-sign bigger-125"></i> Đã thêm (' + count + '/20)';
    $(ele).html(html_b);
    addboxlisttype();
    addboxlistimagetype();
}
function hide_grouptype1() {
    $('.box_price_root').removeClass('hidden');
    $('#adminproduct-price').val('');
    $('.box_price_type').addClass('hidden').html('');
    $('#box_image_type').addClass('hidden');
    $('.name_image_type1').html('');
    $('.box_image_type_content').html('');
}

function hide_grouptype2() {
    $('#group_add_type2').removeClass('hidden');
    $('#group_type2').addClass('hidden').html('');
    $('#list_head_type').find('.name_type2').remove();
    addboxlisttype();
}
function show_grouptype() {
    var group_type2_html = $('#group_type2_html').html();
    $('#group_add_type2').addClass('hidden');
    $('#group_type2').removeClass('hidden').html(group_type2_html);
    add_boxtype2($('.btn-addtype2'));
    $('#list_head_type').find('.name_type1').after('<div class="table-cell table-header name_type2">Tên</div>');
    addboxlisttype();

}

function addboxlisttype() {
    var html = '';
    if ($('.name_type2').length) {
        html = addlisttype_two();

    } else {
        html = addlisttype_one();
    }
    if (html) {
        html = '<div>' + html + '</div>';
    }
    $('#list_content_type').html(html);
    $('.input-mask-sort').mask('000.000.000.000.000', {reverse: true});
}
function addlisttype_two() {
    var html = '';
    $("#boxs_type1 .form-control").each(function () {
        var value = $(this).val();
        var id = $(this).data('id');
        html += '<div  class="table-cell-wrapper b_listtype1_' + id + '">' +
                '<div  class="table-cell first-variation name_type1_sub' + id + '">' + (value ? value : 'Loại') + '</div> ' +
                '<div  class="" style="flex: 4 1 0%;">';

        $("#boxs_type2 .form-control").each(function () {
            var value2 = $(this).val();
            var id2 = $(this).data('id');
            var price = '';
            var quantity = '';
            var sku = '';
            if ($('#product_type_price_' + id + '_' + id2).length) {
                price = $('#product_type_price_' + id + '_' + id2).val();
            }
            if ($('#product_type_quantity_' + id + '_' + id2).length) {
                quantity = $('#product_type_quantity_' + id + '_' + id2).val();
            }
            if ($('#product_type_sku_' + id + '_' + id2).length) {
                sku = $('#product_type_sku_' + id + '_' + id2).val();
            }
            html += '<div  class="flex data-group b_listtype2_' + id2 + '">' +
                    '<div  class="table-cell  name_type2_sub' + id2 + '">' + (value2 ? value2 : 'Loại') + '</div> ' +
                    '<div class="table-cell"><input type="text" value="' + price + '" id="product_type_price_' + id + '_' + id2 + '" name="product_type_price[' + id + '][' + id2 + ']" placeholder="Nhập vào"  class="form-control required_input input-mask-sort"></div>' +
                    '<div class="table-cell"><input type="text" value="' + quantity + '" id="product_type_quantity_' + id + '_' + id2 + '" name="product_type_quantity[' + id + '][' + id2 + ']" placeholder="Nhập vào"  class="form-control input-mask-sort"></div>' +
                    '<div class="table-cell"><input type="text" value="' + sku + '" id="product_type_sku_' + id + '_' + id2 + '" name="product_type_sku[' + id + '][' + id2 + ']" placeholder="Nhập vào"  class="form-control"></div>' +
                    '</div>  ';
        });
        html += '</div>' +
                '</div>';
    });
    return  html
}


function addlisttype_one() {
    var html = '';
    $("#boxs_type1 .form-control").each(function () {
        var value = $(this).val();
        var id = $(this).data('id');
        var price = '';
        var quantity = '';
        var sku = '';
        if ($('#product_type_price_' + id + '_0').length) {
            price = $('#product_type_price_' + id + '_0').val();
        }
        if ($('#product_type_quantity_' + id + '_0').length) {
            quantity = $('#product_type_quantity_' + id + '_0').val();
        }
        if ($('#product_type_sku_' + id + '_0').length) {
            sku = $('#product_type_sku_' + id + '_0').val();
        }
        html += '<div class="flex data-group b_listtype1_' + id + '">' +
                '<div class="table-cell name_type1_sub' + id + '">' + (value ? value : 'Loại') + '</div> ' +
                '<div class="table-cell"><input type="text" value="' + price + '" id="product_type_price_' + id + '_0" name="product_type_price[' + id + '][0]" placeholder="Nhập vào"  class="form-control required_input input-mask-sort"></div>' +
                '<div class="table-cell"><input type="text" value="' + quantity + '" id="product_type_quantity_' + id + '_0" name="product_type_quantity[' + id + '][0]" placeholder="Nhập vào"  class="form-control input-mask-sort"></div>' +
                '<div class="table-cell"><input type="text" value="' + sku + '" id="product_type_sku_' + id + '_0" name="product_type_sku[' + id + '][0]" placeholder="Nhập vào"  class="form-control"></div>' +
                '</div>';
    });
    return  html
}
function addboxlistimagetype() {
    var html = '';
    $("#boxs_type1 .form-control").each(function () {
        var value = $(this).val();
        var id = $(this).data('id');
        html += '<div class="control-image b_imagetype1_' + id + '">' +
                '<div class="editable-input editable-image">' +
                '<div class="ace-file-input ace-file-multiple" style="width: 150px;">' +
                '<input type="file" class="input_file" name="file_image_type_' + id + '" accept="image/*" id="file_image_type_' + id + '" onchange="readURL(this)"/>' +
                '<label class="file-label" data-title="Change Image" for="file_image_type_' + id + '">' +
                '<span class="file-name" data-title="No File ..."><i class="icon-picture"></i></span>' +
                '</label>' +
                '<a class="remove" onclick="remove_image(this)"><i class="icon-remove"></i></a><input type="checkbox" class="ace chk_deleteimage" name="is_deleteimagetype' + id + '">' +
                '</div>' +
                '</div>' +
                '<div class="editable-buttons align-center name_typeimage1_sub' + id + '">' + (value ? value : 'Phân loại hàng') + '</div>' +
                '</div>';
    });
    $('.box_image_type_content').html(html);
}

function show_pricetype() {
    var box_price_type_html = $('#box_price_type_html').html();
    $('.box_price_root').addClass('hidden');
    $('.box_price_type').removeClass('hidden').html(box_price_type_html);
    add_boxtype1($('.btn-addtype1'));
    addboxlisttype();

    $('#box_image_type').removeClass('hidden');
    $('.name_image_type1').html('Nhóm phân loại 1');
    addboxlistimagetype();

}

function choose_cat(ele, level) {
    if (!ele || !level) {
        return false;
    }
    var id = $(ele).data('id');
    if (!id) {
        return false;
    }
    $('#adminproduct-product_cat_id').val('');
    load_attrcat(0);
    switch (parseInt(level)) {
        case 1:
            $('#category_text1').html($(ele).find('.text-overflow').html());
            $('#category_text2').html('');
            $('#category_text3').html('');
            $('#categorys_item_1 .category-item').removeClass('selected');
            $('#categorys_item_2').html('');
            $('#categorys_item_3').html('');
            $(ele).addClass('selected');
            $('#adminproduct-root_product_cat_id').val(id);
            if (!list_cat[id].length) {
                $('#adminproduct-product_cat_id').val(id);
                load_attrcat(id);
            }
            var html = '';
            for (var i in list_cat[id]) {
                html += '<li onclick="choose_cat(this, 2)" class="category-item" data-id="' + list_cat[id][i].id + '">';
                html += '<p class="text-overflow">' + list_cat[id][i].name + '</p>';
                if (list_cat[list_cat[id][i].id].length) {
                    html += '<i class="icon-next vars-icon icon-angle-right"></i>';
                }
                html += '</li>';
            }
            jQuery('#categorys_item_2').html(html);
            break;
        case 2:
            if (!$('#category_text2').html()) {
                $('#category_text1').append('<span class="mt">&gt;</span>');
            }
            $('#category_text2').html($(ele).find('.text-overflow').html());
            $('#category_text3').html('');
            $('#categorys_item_2 .category-item').removeClass('selected');
            $('#categorys_item_3').html('');
            $(ele).addClass('selected');
            if (!list_cat[id].length) {
                $('#adminproduct-product_cat_id').val(id);
                load_attrcat(id);
            }
            var html = '';
            for (var i in list_cat[id]) {
                html += '<li onclick="choose_cat(this, 3)" class="category-item" data-id="' + list_cat[id][i].id + '">';
                html += '<p class="text-overflow">' + list_cat[id][i].name + '</p>';
                if (list_cat[list_cat[id][i].id]) {
                    html += '<i class="icon-next vars-icon icon-angle-right"></i>';
                }
                html += '</li>';
            }
            jQuery('#categorys_item_3').html(html);
            break;
        case 3:
            if (!$('#category_text3').html()) {
                $('#category_text2').append('<span class="mt">&gt;</span>');
            }
            $('#category_text3').html($(ele).find('.text-overflow').html());
            $('#categorys_item_3 .category-item').removeClass('selected');
            $(ele).addClass('selected');
            $('#adminproduct-product_cat_id').val(id);
            load_attrcat(id);
            break;
    }
}

function readURL(input) {
    if (input.files && validateImage(input.files[0]) !== false) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var html = '<img class="middle" src="' + e.target.result + '">';
            $(input).next('.file-label').addClass('hide-placeholder selected').find('.file-name').addClass('large').html(html);
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        alert('Định dạng file không hợp lệ (chỉ hỗ trợ jpeg,png,jpg, dung lượng 5MB).');
    }
}

function remove_image(ele) {
    if (!ele) {
        return false;
    }
    var html = '<i class="icon-picture"></i>';
    $(ele).prev('.file-label').removeClass('hide-placeholder selected').find('.file-name').removeClass('large').html(html);
    $(ele).prev('.file-label').prev('.input_file').val('');
    $(ele).next('.chk_deleteimage').prop("checked", true);
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

function a() {

}