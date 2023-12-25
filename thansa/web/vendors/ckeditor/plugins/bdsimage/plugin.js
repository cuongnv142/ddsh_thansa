/**
 * Copyright (c) 2014, CKSource - Frederico Knabben. All rights reserved.
 * Licensed under the terms of the MIT License (see LICENSE.md).
 *
 * Basic sample plugin inserting current date and time into the CKEditor editing area.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_intro
 */

// Register the plugin within the editor.
CKEDITOR.plugins.add( 'bdsimage', {

	// Register the icons. They must match command names.
	icons: 'bdsimage',

	// The plugin initialization logic goes inside this method.
	init: function( editor ) {

		// Define the editor command
		editor.addCommand( 'insertBdsimage', {

			// Define the function that will be fired when the command is executed.
			exec: function( editor ) {
				//var now = new Date();
				// Insert the timestamp into the document.
				//editor.insertHtml( 'The current date and time is: <em>' + now.toString() + '</em>' );
                window.open(editor.config.filebrowserBrowseUrl + '?is_quick=true&CKEditor=' + editor.name, "_blank", "width=800, height=700");
			}
		});

		// Create the toolbar button that executes the above command.
		editor.ui.addButton( 'Bdsimage', {
			label: 'Chọn ảnh chèn vào',
			command: 'insertBdsimage',
			toolbar: 'insert'
		});
	}
});
