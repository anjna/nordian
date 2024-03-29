<?php
/** 
 * Uploader Plugin Config
 *
 * A config class that holds all the settings and default mimetypes.
 *
 * @author      Miles Johnson - http://milesj.me
 * @copyright   Copyright 2006-2011, Miles Johnson, Inc.
 * @license     http://opensource.org/licenses/mit-license.php - Licensed under The MIT License
 * @link        http://milesj.me/code/cakephp/uploader
 */

/**
 * Current version.
 */
$config['Uploader']['version'] = '2.8';

/**
 * The accepted file/mime types.
 */
$config['Uploader']['mimeTypes'] = array(
	'image' => array(
		'bmp'	=> 'image/bmp',
		'gif'	=> 'image/gif',
		'jpe'	=> 'image/jpeg',
		'jpg'	=> 'image/jpeg',
		'jpeg'	=> 'image/jpeg',
		'pjpeg'	=> 'image/pjpeg',
		'svg'	=> 'image/svg+xml',
		'svgz'	=> 'image/svg+xml',
		'tif'	=> 'image/tiff',
		'tiff'	=> 'image/tiff',
		'ico'	=> 'image/vnd.microsoft.icon',
		'png'	=> array('image/png', 'image/x-png'),
		'xpng'	=> 'image/x-png'
	),
	'text' => array(
		'txt' 	=> 'text/plain',
		'asc' 	=> 'text/plain',
		'css' 	=> 'text/css',
		'csv'	=> 'text/csv',
		'htm' 	=> 'text/html',
		'html' 	=> 'text/html',
		'stm' 	=> 'text/html',
		'rtf' 	=> 'text/rtf',
		'rtx' 	=> 'text/richtext',
		'sgm' 	=> 'text/sgml',
		'sgml' 	=> 'text/sgml',
		'tsv' 	=> 'text/tab-separated-values',
		'tpl' 	=> 'text/template',
		'xml' 	=> 'text/xml',
		'js'	=> 'text/javascript',
		'xhtml'	=> 'application/xhtml+xml',
		'xht'	=> 'application/xhtml+xml',
		'json'	=> 'application/json'
	),
	'archive' => array(
		'gz'	=> 'application/x-gzip',
		'gtar'	=> 'application/x-gtar',
		'z'		=> 'application/x-compress',
		'tgz'	=> 'application/x-compressed',
		'zip'	=> 'application/zip',
		'rar'	=> 'application/x-rar-compressed',
		'rev'	=> 'application/x-rar-compressed',
		'tar'	=> 'application/x-tar',
		'7z'	=> 'application/x-7z-compressed'
	),
	'audio' => array(
		'aif' 	=> 'audio/x-aiff',
		'aifc' 	=> 'audio/x-aiff',
		'aiff' 	=> 'audio/x-aiff',
		'au' 	=> 'audio/basic',
		'kar' 	=> 'audio/midi',
		'mid' 	=> 'audio/midi',
		'midi' 	=> 'audio/midi',
		'mp2' 	=> 'audio/mpeg',
		'mp3' 	=> 'audio/mpeg',
                '3gpp' 	=> 'audio/3gpp',
                '3ga' 	=> 'audio/3ga',
		'mpga' 	=> 'audio/mpeg',
		'ra' 	=> 'audio/x-realaudio',
		'ram' 	=> 'audio/x-pn-realaudio',
		'rm' 	=> 'audio/x-pn-realaudio',
		'rpm' 	=> 'audio/x-pn-realaudio-plugin',
		'snd' 	=> 'audio/basic',
		'tsi' 	=> 'audio/TSP-audio',
		'wav' 	=> 'audio/x-wav',
		'wma'	=> 'audio/x-ms-wma',
		'amr' => 'application/octet-stream'
	),
	'video' => array(
        'flv' 	=> array('video/flv', 'video/x-flv', 'flv-application/octet-stream', 'application/octet-stream'),
		//'flv' 	=> 'video/x-flv',
        //'flv' 	=> 'flv-application/octet-stream',
		'fli' 	=> 'video/x-fli',
		'avi' 	=> array('video/x-msvideo', 'video/avi'),
		'qt' 	=> 'video/quicktime',
		'mov' 	=> array('video/quicktime', 'video/x-quicktime', 'image/mov'),
		'movie' => 'video/x-sgi-movie',
		'mp2' 	=> 'video/mpeg',
		'mpa' 	=> 'video/mpeg',
		'mpv2' 	=> 'video/mpeg',
		'mpe' 	=> 'video/mpeg',
		'mpeg' 	=> 'video/mpeg',
		'mpg' 	=> 'video/mpeg',
		'mp4'	=> array('video/mp4', 'video/mpeg4'),
        'mp3' 	=> 'video/3gpp',
        '3gp' 	=> 'video/3gpp',
		'viv' 	=> 'video/vnd.vivo',
		'vivo' 	=> 'video/vnd.vivo',
		'wmv'	=> 'video/x-ms-wmv'
	),
	'application' => array(
		'js'	=> 'application/x-javascript',
		'xlc' 	=> 'application/vnd.ms-excel',
		'xll' 	=> 'application/vnd.ms-excel',
		'xlm' 	=> 'application/vnd.ms-excel',
		'xls' 	=> 'application/vnd.ms-excel',
		'xlw' 	=> 'application/vnd.ms-excel',
		'doc'	=> 'application/msword',
		'dot'	=> 'application/msword',
		'pdf' 	=> 'application/pdf',
		'psd' 	=> 'image/vnd.adobe.photoshop',
		'ai' 	=> 'application/postscript',
		'eps' 	=> 'application/postscript',
		'ps' 	=> 'application/postscript',
		'swf'	=> 'application/x-shockwave-flash'
	)
);
