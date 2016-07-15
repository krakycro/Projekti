<?php
$uperr = false;
$data = "../slike/";

$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 2000000)
&& in_array($extension, $allowedExts)){
  if ($_FILES["file"]["error"] > 0){
    $uperr = "Return Code: ".$_FILES["file"]["error"]."<br>";
  }
  else{
  	$data = $data.basename($_FILES['file']['name']);
  	echo $data;
    if (file_exists( $data )){
      $uperr = $_FILES["file"]["name"]." already exists. ";
    }
    else{
      move_uploaded_file($_FILES["file"]["tmp_name"], $data);
      $uperr = "Spremljeno u: ".$data;
      }
  }
}


?>