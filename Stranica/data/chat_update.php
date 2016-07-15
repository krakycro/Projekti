<?php
$logerr = 0;
$q= 0;
$buffer = "";
$pastdate = date("0000-00-00");
function login($base,$name,$pass,$table,$query){
  global $logerr, $q;
  if(!($con = @mysql_connect($base,$name,$pass)))
      $logerr = "Neuspjelo spajanje na MySQL!";
    mysql_set_charset('utf8',$con);
  if(!@mysql_select_db($table) && !$logerr)
      $logerr = "Neuspjelo spajanje na bazu podataka!";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    if (@mysql_num_rows($q)==0 && !$logerr)
      $logerr = "Nepostojeći korisnik!";
}
if(!isset($_COOKIE["nick"]) || !isset($_COOKIE["passwrd"])) die();
if($_REQUEST['input'] == "croom"){
  $query = "SELECT DATE_FORMAT( datum,  '%d.%m.%Y' ) AS  'datumi', DATE_FORMAT( datum,  '%H:%i' ) AS  'time', nick, chatting, tekst, color, bgcolor FROM 1354734_web.chat,1354734_web.korisnik WHERE 1354734_web.chat.user = 1354734_web.korisnik.ID AND 1354734_web.chat.chatting = '".$_REQUEST['chat']."' ORDER BY datum,time ASC";
  login("fdb5.biz.ht","1354734_web","a13s57d246","1354734_web",$query);
  $query = "UPDATE 1354734_web.korisnik SET online = NOW() WHERE 1354734_web.korisnik.nick ='".$_COOKIE["nick"]."'";
    if (!@mysql_query($query))
        $logerr = "Neuspjelo slanje upita bazi!";
  if(!$logerr){
    while($redak = @mysql_fetch_array($q)){
    $newdate = explode(".",$redak["datumi"]);
    $exp_date = $newdate[2]."-".$newdate[1]."-".$newdate[0];
    if($pastdate < strtotime($exp_date)){ 
      $buffer = $buffer."<p class='chatsplit'><b>".$redak["datumi"]."</b></p><hr>";  
      $pastdate = strtotime($exp_date);
      }
    $buffer = $buffer."<font style='color:black;'>".$redak["time"]."</font> <font style='color:#".$redak["color"].";background-color:#".$redak["bgcolor"]."'><b>".$redak["nick"]."</b>: ".$redak["tekst"]."</font><br>";
    }
    echo $buffer;
  } else return "NULL";
}
else if($_REQUEST['input'] == "cnick"){
  $query = "SELECT nick FROM 1354734_web.korisnik WHERE DATE_ADD(1354734_web.korisnik.online,INTERVAL 2 DAY_SECOND) > NOW() ORDER BY nick ASC";
  login("fdb5.biz.ht","1354734_web","a13s57d246","1354734_web",$query);
  if(!$logerr){
    $buffer = $buffer."<b>";
    while($redak = @mysql_fetch_array($q)){
    $buffer = $buffer.$redak["nick"]."<br>";
    }
    $buffer = $buffer."</b>";
    echo $buffer;
  } else return "NULL";

}
else if($_REQUEST['input'] == "ctype"){
  $query = "SELECT ID FROM 1354734_web.korisnik WHERE 1354734_web.korisnik.nick = '".$_COOKIE["nick"]."'";
  login("fdb5.biz.ht","1354734_web","a13s57d246","1354734_web",$query);
  if(!$logerr){
    $redak = @mysql_fetch_array($q);
    $query = "INSERT INTO 1354734_web.chat VALUES(NOW(),'".$redak['ID']."','".$_REQUEST['chat']."','".$_REQUEST['block']."','".$_REQUEST['color']."','".$_REQUEST['bgcolor']."')";
    if (!($q=@mysql_query($query)) && !$logerr)
          $logerr = "Neuspjelo slanje upita bazi!";
  } else return "NULL";

}
else echo "NULL";
?>