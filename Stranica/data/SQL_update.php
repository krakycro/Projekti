<?php
$logerr = 0;
$uperr = false;
$data = "../slike/profile/";
$extension = $_POST["oldslika"];
$slkz = $_POST['inslika'];
if($_POST['inslika'] != "0"){
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
    $olddata = $data.basename($_POST["oldnick"].".".$_POST["oldslika"]);
    $data = $data.basename($_POST["innick"].".".$extension);
    if (file_exists( $data )){
      $uperr = $_FILES["file"]["name"]." already exists. ";
      unlink($data);
    }
    else{
    if($_POST['oldnick'] != $_POST['innick'] || ($_POST["oldslika"] != $extension && file_exists( $olddata )))
    unlink($olddata);
      move_uploaded_file($_FILES["file"]["tmp_name"], $data);
      $uperr = "Spremljeno u: ".$data;
     }
  }
}

}
else {
  $slkz = $_POST['oldslika'];
  if($_POST['oldnick'] != $_POST['innick']){
    rename($data.$_POST["oldnick"].".".$_POST["oldslika"],$data.$_POST["innick"].".".$extension);
    $uperr = "Promjenjeno u: ".$data.$_POST["innick"].".".$extension;
    }

}

if(!($con = @mysql_connect("*PRIVATE*","*PRIVATE*","*PRIVATE*")))
      $logerr = "Neuspjelo spajanje na MySQL!";
    mysql_set_charset('utf8',$con);
  if(!@mysql_select_db("*PRIVATE*") && !$logerr)
      $logerr = "Neuspjelo spajanje na bazu podataka!";
    if(strlen($_POST["inpasswrd"]) >= 4)
       $Tpasswrd = "', passwrd = '".md5(htmlspecialchars($_POST["inpasswrd"]).htmlspecialchars($_POST["innick"]))."'";
    else if(strlen($_POST["inpasswrd"]) < 4 && $_POST['oldnick'] == $_POST['innick'])
       $Tpasswrd = "'";
    else if(strlen($_POST["oldpasswrd"]) >= 4 && $_POST['oldnick'] != $_POST['innick']) 
      $Tpasswrd = "', passwrd = '".md5(htmlspecialchars($_POST["oldpasswrd"]).htmlspecialchars($_POST["innick"]))."'";
    else $logerr = "nevalja password!";
    if(!$logerr){
    $godinaz = htmlspecialchars($_POST['ingodina']);
    $pic = explode(".", $godinaz);
    $godinaz = $pic[2]."-".$pic[1]."-".$pic[0];
    $query = "nick = '".htmlspecialchars($_POST['innick'])."', email = '".htmlspecialchars($_POST['inemail']).$Tpasswrd.", ime = '".htmlspecialchars($_POST['inime']);
    $query = $query.basename("', prezime = '".htmlspecialchars($_POST['inprezime'])."', slika = '".$slkz."', godina = '".$godinaz."', adresa = '".htmlspecialchars($_POST['inadresa'])."'");
   $query = "UPDATE *PRIVATE*.korisnik SET ".$query." WHERE *PRIVATE*.korisnik.nick = '".htmlspecialchars($_POST['oldnick'])."'";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    else{
      $query = "SELECT passwrd FROM *PRIVATE*.korisnik WHERE *PRIVATE*.korisnik.nick = '".htmlspecialchars($_POST['innick'])."'";
      if (!($q=@mysql_query($query)) && !$logerr)
          $logerr = "Neuspjelo slanje upita bazi!";
        if (@mysql_num_rows($q)==0 && !$logerr)
      $logerr = "Nepostojeći korisnik!";
        else{
        $redak = mysql_fetch_array($q);
      setcookie("nick", htmlspecialchars($_POST["innick"]), time()+900,'/');
      setcookie("passwrd", $redak["passwrd"], time()+900,'/');
      }
    }
    }
    header('Location: ../?profil');
?>