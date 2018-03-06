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
	<?php 
	include('_pw.php');  // include password file
	echo "<H2 class=\"attention\">Delete file (for admin only)</H2>";

	if(!empty($_POST['deleteItem']) and isset($_POST["password"]) ){
		if($_POST["password"]==$passwd){
			foreach($_POST['deleteItem'] as $del_file){
				if(unlink('./Files/' . $del_file)){
					echo "<div class=\"error\">" . $del_file . " delete Success.</div><br/>";
				}else{
					echo "<div class=\"error\">" . $del_file . " delete Failure!</div><br/>";
				}
			}
		}else{
			echo "<div class=\"error\">Incorrect password!</div><br/>";
		}
	}

	$files = array();
	$dir = opendir('./Files'); // open the cwd..also do an err check.
	$str = '~';
	while(false != ($file = readdir($dir))) {
		if(($file != ".") and ($file != "..") 
		and ($file[strlen($file)-1] !='~')  ) {
                	$files[] = $file; // put in array.
                }   
            }

	natsort($files); // sort.
	echo "<form action=\"\" method=\"POST\">";
	// print others
	echo "<p>Enter admin password: <input type=\"password\" name=\"password\"/></p>";
	foreach($files as $file) {
		echo("<input name=\"deleteItem[]\" value=\"".$file."\" type=\"checkbox\"> ".$file."<br/>");
	}
	echo "<br/><input type=\"submit\"/>";
	echo "</form>";
	?>
	<br/><a href="show.php">Click here back to show.php</a>
	</font>
</body>
</html>
