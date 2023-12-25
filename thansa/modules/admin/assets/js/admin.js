/**
 * Created by Tony on 6/22/2017.
 */
var admin = {
    VAR: {
        checkout: {
            'order_id': null,
            'index': 0,
        }
    },
    CHECKOUT: {
        loadAjaxTerm: function (url, term, language = '') {
            var res = {};
            is_ajax_loading = false;
            $.ajax({
                url: url,
                dataType: 'json',
                data: {
                    term: term,
                    language: language
                },
                async: false,
                beforeSend: function () {
                    $('#ajax-loading').fadeOut();
                    is_ajax_loading = true;
                },
                success: function (data) {
                    res = data;
                }
            });
            return res;
        },
        appendRow: function (item) {
            if (admin.CHECKOUT.checkExistRow(item.id)) {
                $('.row-pro-' + item.id).addClass('row-blink');
                return false;
            }
            admin.VAR.checkout.index = (admin.VAR.checkout.index == 0) ? parseInt($('#id-count-items').val()) + 1 : admin.VAR.checkout.index + 1;
            var s = '<tr id="row-item-0" class="row-pro-' + item.id + '" data-key="0">' +
                    '<td>' + admin.VAR.checkout.index + '</td>' +
                    '<td><img src="' + item.image + '" width="60" alt=""></td>' +
                    '<td>' + item.name +
                    '<input type="hidden" id="adminorderitem-product_name" name="AdminOrderItem[' + item.id + '][product_name]" value="' + item.name + '">' +
                    '</td>' +
                    '<td>' +
                    '<span id="adminorderitem-' + item.id + '-price_text" class="price_text"' +
                    'data-id="' + item.id + '" data-id-pro="' + item.id + '" >' + item.price + '</span >' +
                    '<input type="hidden" value="' + item.price + '" id="adminorderitem-' + item.id + '-price" name="AdminOrderItem[' + item.id + '][price]"' + '/> ' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" id="adminorderitem-' + item.id + '-percent_discount" class="percent_discount input-mask-percent" name="AdminOrderItem[' + item.id + '][percent_discount]" value="0"' +
                    ' data-id="1" data-id-pro="' + item.id + '" onblur="admin.CHECKOUT.calMoneyRow(this);" style="width:40px;" maxlength="5"/>' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" id="adminorderitem-' + item.id + '-qty" class="qty input-mask-int" name="AdminOrderItem[' + item.id + '][qty]" value="1"' +
                    ' data-id="1" data-id-pro="' + item.id + '" onblur="admin.CHECKOUT.calMoneyRow(this);" style="width:40px;" maxlength="4"/>' +
                    '</td>' +
                    '<td id="adminorderitem-' + item.id + '-total" class="row-money">' + item.price + '</td>' +
                    '<td style="text-align:center">' +
                    '<a href="javascript:admin.CHECKOUT.removeRow(0,' + item.id + ')" title="Xóa" aria-label="Xóa">' +
                    '<span class="glyphicon glyphicon-trash"></span>' +
                    '</a>' +
                    '</td>' +
                    '<input type="hidden" id="adminorderitem-id_product_typelink" value="' + item.id + '">' +
                    '<input type="hidden" id="adminorderitem-id_product" name="AdminOrderItem[' + item.id + '][id_product]" value="' + item.id_product + '">' +
                    '</tr>';
            $('.order_product_items table').append(s);
            admin.CHECKOUT.calMoney();
            if (admin.FUNC.is_exists($('#adminorderitem-' + item.id + 'delete'))) {
                $('#adminorderitem-' + item.id + 'delete').val(0);
            }
            $('.row-blink').removeClass('row-blink');
        },
        removeRow: function (id, pro_type_link_id) {
            if (id > 0) {
                var s = '<input type="hidden" id="adminorderitem-' + pro_type_link_id + 'delete" name="AdminOrderItem[' + pro_type_link_id + '][delete]" value="' + id + '">';
                $('.order_product_items table').append(s);
            }
            $('.row-pro-' + pro_type_link_id).remove();
            admin.CHECKOUT.calMoney();
        },
        checkExistRow: function (pro_type_link_id) {
            var res = false;
            $('.order_product_items table tr').each(function (index) {
                if ($(this).hasClass('row-pro-' + pro_type_link_id)) {
                    res = true;
                    return res;
                }
            });
            return res;
        },
        calMoneyRow: function (ele) {
            var totalRow, qty, price, percent, pro_type_link_id = 0;
            if ($(ele).attr('data-id-pro')) {
                pro_type_link_id = $(ele).attr('data-id-pro');
            }
            if (pro_type_link_id) {
                qty = parseInt($('#adminorderitem-' + pro_type_link_id + '-qty').val());
                price = parseInt($('#adminorderitem-' + pro_type_link_id + '-price_text').text());
                percent = parseFloat($('#adminorderitem-' + pro_type_link_id + '-percent_discount').val());
                if (isNaN(qty) || qty > 1000) {
                    qty = 1;
                    $('#adminorderitem-' + pro_type_link_id + '-qty').val(1);
                }
                if (percent > 100 || isNaN(percent)) {
                    percent = 0;
                    $('#adminorderitem-' + pro_type_link_id + '-percent_discount').val(percent);
                }
                totalRow = parseInt((price - price * percent / 100) * qty);
                $('#adminorderitem-' + pro_type_link_id + '-total').html(totalRow);
            }
            admin.CHECKOUT.calMoney();
        },
        calMoney: function () {
            var grandTotal, total_money, shiping_cost, total_paid, discount_money = 0, discount_accumulated_money = 0, discount_point_money = 0;
            grandTotal = 0;
            discount_money = isNaN(parseInt($('.discount-money').text())) ? 0 : parseInt($('.discount-money').text());
            discount_accumulated_money = isNaN(parseInt($('.accumulated-money').text())) ? 0 : parseInt($('.accumulated-money').text());
            discount_point_money = isNaN(parseInt($('.discount-point-money').text())) ? 0 : parseInt($('.discount-point-money').text());
            discount_pointsp_money = isNaN(parseInt($('.pointsp-money').text())) ? 0 : parseInt($('.pointsp-money').text());
            shiping_cost = parseInt($('#adminorder-shiping_cost').val());
            total_paid = parseInt($('#adminorder-total_paid').val());
            if (isNaN(shiping_cost)) {
                shiping_cost = 0;
                $('#adminorder-shiping_cost').val(0);
            }
            if (isNaN(total_paid)) {
                total_paid = 0;
                $('#adminorder-total_paid').val(0);
            }
            $('.order_product_items table tr .row-money').each(function (index) {
                grandTotal = grandTotal + parseInt($(this).text());
            });
            total_money = grandTotal + shiping_cost - discount_money - discount_accumulated_money - discount_point_money - discount_pointsp_money;
            $('.total-money-items').html(grandTotal);
            $('#adminorder-grand_total').val(grandTotal);
            $('.total-order').html(total_money);
            $('#adminorder-total_money').val(total_money);
            $('.remain-order').html(total_money - total_paid);
        },

    },
    FUNC: {
        strip_tags: function (input, allowed) {
            allowed = (((allowed || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
            var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi, commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
            return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
                return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : ''
            })
        },
        getUrlVars: function () {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
                vars[key] = value
            });
            return vars
        },
        getPath2Check: function (type) {
            return type ? document.referrer : document.URL
        },
        checker: function (url) {
            return admin.FUNC.getPath2Check().indexOf(url) != -1
        },
        join: function (b) {
            var c = [b];
            return function extend(a) {
                if (a != null && 'string' == typeof a) {
                    c.push(a);
                    return extend
                }
                return c.join('')
            }
        },
        is_exists: function (obj) {
            return (obj != null && obj != undefined && obj != "undefined")
        },
        is_email: function (str) {
            return (/^[a-z-_0-9\.]+@[a-z-_=>0-9\.]+\.[a-z]{2,3}$/i).test(str)
        },
        is_phone: function (num) {
            return (/^(01([0-9]{2})|09[0-9])(\d{7})$/i).test(num)
        },
    },
}
