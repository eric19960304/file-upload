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
	<style>
		table {
			border-collapse: collapse;
		}

		th{
			font-size: 22px;
		}

		th, td, tr {
			text-align: center;
			padding: 8px;
		}

		tr:nth-child(even){background-color: #f2f2f2}
	</style>
</head>
<body>
	<font size="5">
	<?php 
	
	include('_pw.php'); // *****include password file
	
	echo "<H2 class=\"attention\">Change file permission<br/>(for admin only)</H2>";

	if(!empty($_POST['chmodItem']) and isset($_POST['password']) ){
		if($_POST['password']==$passwd){
			$mode="0";
			$userMode=0;
			$otherMode=0;
			if(isset($_POST['ur'])){
				$userMode+=4;
			}
			if(isset($_POST['uw'])){
				$userMode+=2;
			}
			if(isset($_POST['ux'])){
				$userMode+=1;
			}
			if(isset($_POST['ar'])){
				$otherMode+=4;
			}
			if(isset($_POST['aw'])){
				$otherMode+=2;
			}
			if(isset($_POST['ax'])){
				$otherMode+=1;
			}
			$mode=$mode . "$userMode" . "$userMode" . "$otherMode";
			foreach($_POST['chmodItem'] as $target_file){
				if(chmod('./Files/' . $target_file, intval("0".$mode, 8))){
					echo "<div class=\"error\">".$target_file." permission change succeeded.</div><br/>";
				}else{
					echo "<div class=\"error\">".$target_file." permission change failed!</div><br/>";
				}
			}
		}else{
			
			if($_POST['password']!=$passwd)
				echo "<div class=\"error\">Incorrect password!</div><br/>";
		}
	}

	$files = array();
	$dir = opendir('./Files'); // open the cwd..also do an err check.
	$str = '~';
	while(false != ($file = readdir($dir))) {
		if(($file != ".") and ($file != "..") 
		and ($file[strlen($file)-1] !='~') ) {
                	$files[] = $file; // put in array.
                }   
            }

	natsort($files); // sort.
	echo "<form action=\"\" method=\"POST\">";
	// print others
	echo "Files:<br/>";
	foreach($files as $file) {
		echo("<input name=\"chmodItem[]\" value=\"".$file."\" type=\"checkbox\"> ".$file."<br/>");
	}
	echo "<p>Enter admin password: <input type=\"password\" name=\"password\"/></p>";
	?>
	Select the permission:
	<table>
		<col width="140">
		<col width="140">
		<col width="140">
		<col width="140">
		<tr>
		<th>User</th>
		<th>Readable</th>
		<th>Writable</th>
		<th>Executable</th>
	  </tr>
	  <tr>
	  	<td>anyone</td>
		<td><input name="ur" type="checkbox" /></td>
		<td><input name="uw" type="checkbox" /></td>
		<td><input name="ux" type="checkbox" /></td>
	  </tr>
	  <tr>
		<td>admin</td>
		<td><input name="ar" type="checkbox" /></td>
		<td><input name="aw" type="checkbox" /></td>
		<td><input name="ax" type="checkbox" /></td>
	  </tr>
	</table>
	<input type="submit"/>
	</form>
	<br/><a href="show.php">Click here back to show.php</a>
	</font>
</body>
</html>
