/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here.
    // For complete reference see:
    // https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

    // The toolbar groups arrangement, optimized for two toolbar rows.
    config.toolbarGroups = [
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
        {name: 'links'},
        {name: 'insert'},
        {name: 'forms'},
        {name: 'tools'},
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'others'},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
        {name: 'styles'},
        {name: 'colors'},
        {name: 'about'}
    ];

    // Remove some buttons provided by the standard plugins, which are
    // not needed in the Standard(s) toolbar.
    config.removeButtons = 'Underline,Subscript,Superscript';

    // Set the most common block elements.
    config.format_tags = 'p;h1;h2;h3;pre;div;i;span';
    config.format_i = {name: 'I', element: 'i'};
    config.format_span = {name: 'Span', element: 'span'};
    config.allowedContent = true;

    // Simplify the dialog windows.
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.colorButton_enableMore = true;
    config.colorButton_enableAutomatic = true;
    config.extraPlugins = 'colorbutton,colordialog,bdsimage,youtube,justify,font,image2';
    config.colorButton_renderContentColors = false;

    config.filebrowserBrowseUrl = ckEditor_baseUrl + '/admin/image/browse';
    config.filebrowserUploadUrl = ckEditor_baseUrl + '/admin/image/upload';

    config.font_defaultLabel = 'Roboto';
    config.fontSize_defaultLabel = '14';

    var myFonts = ['Roboto'];
    //
    config.font_names = 'Arial;Georgia;Tahoma;Time New Roman;Verdana;serif;sans serif;monospace;cursive;fantasy';
    // //
    for (var i = 0; i < myFonts.length; i++) {
        config.font_names = config.font_names + ';' + myFonts[i];
        myFonts[i] = 'http://fonts.googleapis.com/css?family=' + myFonts[i].replace(' ', '+');
    }
};
