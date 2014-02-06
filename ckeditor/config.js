/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'ru';
	// config.uiColor = '#AADC6E';
	config.removePlugins = 'forms,iframe,pagebreak,flash,smiley,preview,showblocks,language';
	config.removeButtons = 'Save,NewPage,Print,Templates';
	config.filebrowserUploadUrl = '/pages/ckeupload.php';
};
