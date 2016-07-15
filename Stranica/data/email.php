<?php
$atch = false;
if(isset($_FILES["file"]))
	if($_FILES["file"]["size"] > 0 && $_FILES["file"]["size"] < 2000000 && $_FILES["file"]["error"] == 0)
		$atch = true;
if(!empty($_POST['chsendto']))
	$to = @$_POST['chsendto'];
else $to = "kraksorz@gmail.com"; 

$subject = htmlspecialchars($_POST['chname']); 
$random_hash = md5(date('r', time())); 
$eol = PHP_EOL;

if($atch)
$attachment = chunk_split(base64_encode(file_get_contents($_FILES["file"]["tmp_name"]))); 

$headers  = "From: ".htmlspecialchars($_POST['chemail']).$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$random_hash."\"";

$body = "--".$random_hash.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $_POST['chtext'].$eol;

if($atch){
$body .= "--".$random_hash.$eol;
$body .= "Content-Type: application/octet-stream; name=\"".basename($_FILES["file"]["name"])."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol;
}
$body .= "--".$random_hash."--";

$mail_sent = @mail( $to, $subject, $body , $headers ); 
if(empty($_POST['chsendto']))
	{echo $mail_sent ? header("Location: ../?kontakt&poslan=1") : header("Location: ../?kontakt&poslan=0");}
else echo $mail_sent ? "1" : "0";

?>