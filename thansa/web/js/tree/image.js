$('#jstree').jstree({
    'core' : {
        'check_callback' : true,
        'data' : {
            'url' : function (node) {
              return node.id === '#' ? uFetchRoot : uFetchChildren;
            },
            'data' : function (node) {
              return { 'id' : node.id };
            }
        }
    },
    'state' : { 'key' : keySateJsTree },
    
    'contextmenu': {         
        'items': function($node) {
            var tree = $('#jstree').jstree(true);
            return {
                'Rename': {
                    'separator_before': false,
                    'separator_after': false,
                    'label': 'Đổi tên',
                    'action': function (obj) {
                        if ($node.id == 'h0') return;
                        tree.edit($node);
                    }
                },                         
                'Remove': {
                    'separator_before': false,
                    'separator_after': false,
                    'label': 'Xóa',
                    'action': function (obj) { 
                        //console.log($node);
                        //console.log(obj);
                        if ($node.id == 'h0') return;
                        var sure = confirm("Bạn có chắc là muốn xóa?");
                        if (sure) {
                            hp_delete_node($node, obj);
                        }
                    }
                }
            };
        }
    },
    
    'plugins' : [ 'state', 'contextmenu' ]
});

$('#jstree').on('rename_node.jstree', function (e, data) {
   //alert('Từ ' + data.old + ' sang ' + data.text + ' cho id ' + data.node.id);
   // $('#jstree').jstree(true).set_text(data.node, 'He he');
   var dataPost = {'id': data.node.id, 'name_new': data.text};
   jQuery.ajax({
        url: uRenameDir,
        type: "POST",
        data: dataPost,
        dataType: "json",
        success: function (obj) {
            if (obj.err === 0) {
                // Cap nhat thanh cong
            } else {
                if (obj.err == 1) {
                    alert('Tên thư mục không được để trống');
                } else if (obj.err == 2) {
                    alert('Tên thư mục không được quá dài');
                } else if (obj.err == 3) {
                    alert('Tên thư mục chỉ được có các ký tự a-z A-Z 0-9 CÁCH và _ -');
                } else {
                    alert('Có lỗi xảy ra khi đổi tên thư mục');
                }
                $('#jstree').jstree(true).set_text(data.node, data.old);
            }
        },
        error: function() {
            $('#jstree').jstree(true).set_text(data.node, data.old);
        }
    });
});

$('#jstree').on('changed.jstree', function (e, data) {
    var jA = $('#fake-url');
    //jA.attr('href', jA.attr('href').replace('ID_DIR', data.selected.replace('h','')));
    //jA.trigger('click');
    var urlLoad = jA.attr('href').replace('ID_DIR', new String(data.selected).replace('h',''));
    //alert(urlLoad);
    $.pjax.reload({'push': true, 'replace': false, container:'#image_result',async:false,url:urlLoad});
});

function hp_delete_node($node, obj) {
    var dataPost = {'id': $node.id};
   jQuery.ajax({
        url: uRemoveDir,
        type: "POST",
        data: dataPost,
        dataType: "json",
        success: function (obj) {
            if (obj.err === 0) {
                // Xoa thanh cong
                $('#jstree').jstree(true).delete_node($node);
            } else {
                if (obj.err == 1) {
                    alert('Thư mục có thư mục con nên không thể xóa');
                } else if (obj.err == 2) {
                    alert('Thư mục có ảnh nên không thể xóa');
                } else {
                    alert('Có lỗi xảy ra khi xóa thư mục');
                }
            }
        },
        error: function() {
            
        }
    });
}