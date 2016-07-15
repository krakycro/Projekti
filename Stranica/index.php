<?php
 $slika = "User";
 $ext = "jpg";
 $block = "Ovo otvara index.php!";
 $kon_var =@explode("&",$_SERVER["QUERY_STRING"]);
 $vars = array();
 $test = explode("=",$kon_var[0]);
 if(isset( $test[1] )) {$vars[$test[0]] = $test[1]; $kontrola= "pocetna";}
 else {$kontrola = $test[0]; unset($kon_var[0]);}

 foreach($kon_var as $ii){
	$test = explode("=",$ii);
	$vars[$test[0]] = $test[1];
	}

 $cin=0;
 $cout=0;
 $admin_mail = "kraksorz@gmail.com";
 include "data/recapche.php";
 if(empty( $kontrola))  $kontrola = "pocetna";
 $loginz = false;
 $logerr = 0;
 $chatroom = 0;
 session_start();
 $_SESSION['amail'] = $admin_mail;
 if (isset($_COOKIE["nick"]) && isset($_COOKIE["passwrd"])){
   if($kontrola == "logout"){
   setcookie("nick", "", time()-900);
    setcookie("passwrd", "", time()-900);
   }
   else{
   if(!($con = @mysql_connect("fdb5.biz.ht","1354734_web","a13s57d246")))
      $logerr = "Neuspjelo spajanje na MySQL!";
    mysql_set_charset('utf8',$con);
  if(!@mysql_select_db("1354734_web") && !$logerr)
      $logerr = "Neuspjelo spajanje na bazu podataka!";
   $query= "SELECT * FROM 1354734_web.korisnik WHERE 1354734_web.korisnik.nick = '".$_COOKIE["nick"]."'";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    if (@mysql_num_rows($q)==0 && !$logerr)
      $logerr = "Nepostojeći korisnik!";
    else if(!$logerr){
      $redak = @mysql_fetch_array($q);
      if ($redak["passwrd"] == $_COOKIE["passwrd"]){
        if($redak["slika"] != "0") { $slika = @$_COOKIE["nick"]; $ext = $redak["slika"]; }
        setcookie("nick", $_COOKIE["nick"], time()+900,'/');
        setcookie("passwrd", $_COOKIE["passwrd"], time()+900,'/');
        $loginz = true;
        $query = "UPDATE 1354734_web.korisnik SET online = NOW() WHERE 1354734_web.korisnik.nick ='".$_COOKIE["nick"]."'";
        if (!@mysql_query($query))
            $logerr = "Neuspjelo slanje upita bazi!";
        }
    }
    }

 }
 else if($kontrola == "login"){
   $Tpasswrd = md5($_POST["passwrd"].$_POST["nick"]);
   if(!($con = @mysql_connect("fdb5.biz.ht","1354734_web","a13s57d246")))
      $logerr = "Neuspjelo spajanje na MySQL!"; 
    mysql_set_charset('utf8',$con);
  if(!@mysql_select_db("1354734_web") && !$logerr)
      $logerr = "Neuspjelo spajanje na bazu podataka!";
  $query= "SELECT * FROM 1354734_web.korisnik WHERE 1354734_web.korisnik.passwrd = '".$Tpasswrd."'";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    if (@mysql_num_rows($q)==0 && !$logerr)
      $logerr = "Nepostojeći korisnik!";
    else if(!$logerr){
        $redak = @mysql_fetch_array($q);
        setcookie("nick", $_POST["nick"], time()+900,'/');
      setcookie("passwrd", $Tpasswrd, time()+900,'/');
      if($redak["slika"] != "0") {$slika = $redak["nick"]; $ext = $redak["slika"]; }
      $loginz = true;
    $_SESSION[$_POST["nick"]] = $_POST["nick"];
  }
 }

if($logerr) echo '
<script type="text/jscript">
$(document).ready(function(){alert("'.$logerr.'");});
</script>
';
 
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stranica</title>
<link rel="SHORTCUT ICON" href="slike/favicon.ico">
<script type="text/jscript" src="data/jquery-1.7.2.min.js"></script>
<script type="text/jscript" src="data/javascript.js"></script>
<script type="text/jscript" src="data/jsDatePick.min.1.3.js"></script>
<script type="text/jscript" src="data/jsColor.js"></script>
<script type="text/jscript" src="data/lightbox.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/lightbox.css" rel="stylesheet" type="text/css">
<link href="css/menu.css" rel="stylesheet" type="text/css">
<link href="data/jsDatePick_ltr.min.css" media="all" rel="stylesheet" type="text/css">
</head>
<?php
?>
<body>
<div id="popup">
</div>
<div align="center">
<table class="frame" style="height: auto; width: 1100px">
<tr>
<td id="top" colspan="2" style="height: 215px">
<div>
<?php
?>
<a href="slike/profile/<?php echo $slika.".".$ext?>" rel="lightbox[user]" title="<?php echo $slika?>"><img class="profpic"  src="slike/profile/<?php echo $slika.".".$ext?>" ></a>
<div id="logz" style="position:absolute; top: 10px;">
<?php
if($loginz)
echo '
<script type="text/jscript">
$("#logz").css("padding","0 0 0 0px");
</script>
<p>Prijavljeni kao korisnik: <a href="?profil" id="areg">'.$redak["nick"].'</a> (<a href="?logout&bck='.($kontrola=="logout" ? $vars[bck]:($kontrola=="login" ? $vars[bck]:$kontrola)).'">Logout</a>)
';
else{
echo '
<p>Dobrodošli, sada ste gost: <a href="?register">registracija</a> ili prijava<br>
<form name="form1" method="post" action="?login&bck='.($kontrola=="logout" ? $vars[bck]:($kontrola=="login" ? $vars[bck]:$kontrola)).'" onsubmit="return LogIn(\'form1\')">
<input type="text" name="nick" size="16">
<input type="password" name="passwrd" size="16">
<input type="submit" name="submit" value="Potvrdi">
<p id="err"></p>
</form>
';
}
?>
</div>
</div>
<div class="h_menu">
<?php
$img = "slike/down.png";
$tr = false;
include ("data/menu.php");
?>

</div>
</td>
</tr>
<tr style="height: auto">
<td id="side" style="width: 150px">
<div class="v_menu" id="hover" style="position:absolute; top:0;">
<?php
$img = "slike/left.png";
$tr = true;
include ("data/menu.php");
?>
</div>
</td>
<td id="body">
<?php
if(/*!$loginz || */$kontrola=="login" || $kontrola=="logout"){
/*if($kontrola=="profil" ||  $kontrola=="register")  @include "page/register.php";
else*/ //@include "page/pocetna.php"; 
$kontrola=$vars[bck];
@include "page/".$vars[bck].".php";

}
else {if(!is_file("page/".$kontrola.".php")) @include "page/busy.php"; else @include "page/".$kontrola.".php";}
?>
</td>
</tr>
<tr id="bottom"style="height: 50px">
<td colspan="2" align="center">
<p style="margin: 0;">Web stranicu je izradilo: Filip Kraus, <a href="http://www.etfos.unios.hr">Elektrotehnički
fakultet, Osijek</a><br>Kolegij: <a href="http://moodle.etfos.hr/course/view.php?id=453">Multimedijska tehnika</a> 
</p>
<p style="margin: 0;">E-mail: fkraus@etfos.hr,<br>Sva prava priznata® 2016.</p>
</td>
</tr>
</table>
</div>

</body>
</html>


