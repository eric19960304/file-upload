	

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
   <p class="center">You can upload file here, however, there are some restriction.<br/>
   1. only the following file extensions are allowed:<br>
   "jpeg","jpg","png","txt","py","c","cpp","java",<br/>
   "doc","docx","rar","zip","tar","pdf","".<br/>
   2. The max file size for each file is 10 MB.<br/>
   3. File name cannot start from '~' character.
   </p>
   
	<?php
    include('_pw.php');
	if(isset($_FILES['image']) and $_FILES['image']['name']!=''){
	   $errors= array();

	   if($_POST["filename"]=='')
	   	$file_name = $_FILES['image']['name'];
	   else
		$file_name = basename($_POST["filename"]);

	   $file_size =$_FILES['image']['size'];
	   $file_tmp =$_FILES['image']['tmp_name'];
	   $file_type=$_FILES['image']['type'];
	   $file_ext=strtolower(end(explode('.',$file_name)));
	   $file_dir='./Files/';
	   
	   $expensions= array("jpeg","jpg","png","txt","java","c","cpp","py","doc","docx","rar","zip","tar","pdf");

       if($_POST['password']!=$passwd){
            $errors[]="Incorrect password!";
       }

	   if(count(explode('.',$file_name))>1 and in_array($file_ext,$expensions) === false){
	      $errors[]="Extension not allowed";
	   }
	   
	   if($file_size > 10485760){
	      $errors[]='File size must not be larger tran 10 MB';
	   }

	   if($file_name[0] == '~'){
	      $errors[]='File name cannot start from \'~\'';
	   }
	   
	   if(empty($errors)==true and move_uploaded_file($file_tmp,$file_dir.$file_name) ){
	      
	      echo "<div class=\"error\">Success! ".$file_name." has been uploaded.</div>";
	      if($_POST["permission"]=="public")
		 chmod($file_dir.$file_name, 0644);
	      else
	       chmod($file_dir.$file_name, 0600);
	 }else{
	  echo "<p class=\"error\">Error message(s):<br/>";
	  foreach($errors as $thisError)
	   echo($thisError."<br/>");
	echo "</p>";
	}
	}
	?>

   <form action="" method="POST" enctype="multipart/form-data">

      <p><input type="file" name="image" /></p>

      <p>Filename:<input type="text" name="filename"> </input> (including extension)</p>
      <p>Password:<input type="password" name="password"> </input></p>
      <p>
      <input type="radio" name="permission" value="public" checked> public permission<br/>
      <input type="radio" name="permission" value="private"> private permission
      </p>

      <input type="submit"/>
   </form>
   <br/><a href="show.php">Click here back to show.php</a>
   </font>
</body>
</html>
