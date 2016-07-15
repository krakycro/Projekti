<?php
if($_COOKIE['cpcha1'] == md5($_POST['recapcha']) || $_COOKIE['cpcha2'] == md5($_POST['recapcha'])){

$logerr = 0;
$uperr = false;
$data = "../slike/profile/";
if($_POST['slika'] != "0"){
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
    $data = $data.basename($_POST["regnick"].".".$extension);
    if (file_exists( $data )){
      $uperr = $_FILES["file"]["name"]." already exists. ";
    }
    else{
      move_uploaded_file($_FILES["file"]["tmp_name"], $data);
      $uperr = "Spremljeno u: ".$data;
      }
  }
}
}
if(!($con = @mysql_connect("*PRIVATE*","*PRIVATE*","*PRIVATE*")))
      $logerr = "Neuspjelo spajanje na MySQL!";
    mysql_set_charset('utf8',$con);
  if(!@mysql_select_db("*PRIVATE*") && !$logerr)
      $logerr = "Neuspjelo spajanje na bazu podataka!";
    $Tpasswrd = md5(htmlspecialchars($_POST["regpasswrd"]).htmlspecialchars($_POST["regnick"]));
    $godinaz = htmlspecialchars($_POST['godina']);
    if(empty($godinaz)) $godinaz = "";
    else { $pic = explode(".", $godinaz); $godinaz = $pic[2]."-".$pic[1]."-".$pic[0];}
    $query = "'".htmlspecialchars($_POST['regnick'])."','".htmlspecialchars($_POST['email'])."','".$Tpasswrd."',0,'".htmlspecialchars($_POST['ime']);
    $query = $query."','".htmlspecialchars($_POST['prezime'])."','".htmlspecialchars($_POST['slika'])."','".$godinaz."','".htmlspecialchars($_POST['adresa'])."'";
   $query = "INSERT INTO *PRIVATE*.korisnik VALUES('',".$query.",'')";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    else{
    setcookie("nick", htmlspecialchars($_POST["regnick"]), time()+900,'/');
    setcookie("passwrd", $Tpasswrd, time()+900,'/');
    }
    //echo "1";
    header('Location: ../');
}
else {  //echo "0";
      header('Location: ../?register#cpcha');
      setcookie("accept", "false", time()+30,'/');
}
?>