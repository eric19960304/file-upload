<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="_GLayout.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title>Simple file server</title>
	<?php 
	include('_check.php');
	?>
</head>
<body>
	<font size="5">
	<H2 style="color:DarkCyan">Simple File server</H2>
	<div class="center">Upload files here, then everyone (or only admin) can see those files :)</div><br/>
	</font>
<?php 
	$files = array();
	$dir = opendir('./Files'); 
	while(false != ($file = readdir($dir))) {
		if( ($file != ".") and ($file != "..") 
		and ($file[strlen($file)-1] !='~') ) {
                	$files[] = $file; // put in array.
        }   
    }
    $menu = array();
    $dir = opendir('.'); 
	while(false != ($item = readdir($dir))) {
		if( ($item != ".") and ($item != "..") 
		and ($item[strlen($item)-1] !='~') and ($item[0] !='_') and ($item[0] !='.')
		and ($item != "index.html") and ($item != "Files") and ($item != "show.php")
		and ($item != "readme.txt") ) {
                	$menu[] = $item; // put in array.
        }   
    }
	echo "<font size=\"5\">";
	natsort($files); // sort
	natsort($menu); // sort
	echo "~~~~~Menu~~~~~<br/>";
	// print menu
	foreach($menu as $item) {
		echo("<a href='$item'>$item</a> <br/>");
	}
	
	echo "~~~~~~~~~~~~~~<br/>File(s) uploaded:<br/>";
	// print others
	foreach($files as $file) {
		$dir='./Files/' . $file;
		echo("<a href='$dir'>$file</a> <br/>");
	}
	echo "</font>";
	?>
	
</body>
</html>
