<?php
	$filename = './Files';
	if (!file_exists($filename)) {
		mkdir("./Files", 0777);
		chmod("./Files", 0777);
	}
?>
