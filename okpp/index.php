<?php

$kon_var =@explode("&",$_SERVER["QUERY_STRING"]);
 $vars = array();
 $test = explode("=",$kon_var[0]);
 if(isset( $test[1] )) {$vars[$test[0]] = $test[1]; $kontrola= "pocetna";}
 else {$kontrola = $test[0]; unset($kon_var[0]);}

 foreach($kon_var as $ii){
	$test = explode("=",$ii);
	$vars[$test[0]] = $test[1];
	}

session_start();
	
 $block = "Ovo otvara index.php!";
 $pages = "pages";
 $images = "images";
 $data = "data";
 $BAR_MAX = 20;
 
 include($data.'/qrcode/qrlib.php');
 include($data.'/barcode/src/BarcodeGenerator.php');
 include($data.'/barcode/src/BarcodeGeneratorPNG.php');
 
 
 $cin=0;
 $cout=0;
/* 
 $dbhost = "eu-cdbr-azure-north-e.cloudapp.net";
 $dbase = "project_iq_kviz";
 $db_testovi = $dbase.".testovi";
 $db_zadaci = $dbase.".zadaci";
 $db_data =  $dbase.".bgdata";
 $dbuser = "bb3e7efc984029";
 $dbpass = "a0f2f9c8";

 */
 $bar = "Ovo je barcode!";
 $QR = "Ovo je QRcode!";
 
 if(!isset($_POST["in_bar"]) || strlen($_POST["in_bar"]) < 1 )
	 $_POST["in_bar"] = "Barcode!";
 if(!isset($_POST["in_qr"]) || strlen($_POST["in_qr"]) < 1)
	 $_POST["in_qr"] = "QRcode!";
 
//echo $_POST["in_bar"]." ".$_POST["in_qr"];

if ($handle = opendir($images)) {
		while (false !== ($file = readdir($handle))) {
			if(!is_dir($file))
				unlink($images.'/'.$file);
		}
	}
closedir($handle);

	 $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
	 $filebar = $images.'/barcode'.date("dmyhis").'.png';
	 file_put_contents($filebar, $generatorPNG->getBarcode($_POST["in_bar"], $generatorPNG::TYPES['TYPE_CODE_128']/*$generatorPNG::TYPE_CODE_128*/));

	 $fileqr = $images.'/qrcode'.date("dmyhis").'.png';
	 QRcode::png($_POST["in_qr"], $fileqr, "H", 10, 2); 

 
 
 
 if(empty( $kontrola))  $kontrola = "pocetna";
 $loginz = false;
 $logerr = 0;

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stvaranje Bar i QR kodova</title>
<link rel="SHORTCUT ICON" href="<?php echo $data?>/favicon.ico">
<script type="text/jscript" src="data/jquery-1.7.2.min.js"></script>
<script type="text/jscript" src="data/javascript.js"></script>
<link href="data/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="popup">
</div>
<div align="center">
<table class="frame" style="padding-top: 2%; height: 98%; width: 70%">
<tr>
<td id="top" colspan="2" style="">
<?php
// Header

?>
<h1 id="naslov">Stvaranje Bar i QR kodova</h1>
</td>
</tr>
<tr >
<td id="body" style="">
<?php
// Body
@include $pages."/".$kontrola.".php";
?>
</td>
</tr>

</table>
</div>

</body>
</html>
