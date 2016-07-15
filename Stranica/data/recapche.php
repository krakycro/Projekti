<?php
$cin = mt_rand(0,100)*pow(-1,mt_rand(1,3));
//$cin /= pow(10,mt_rand(0,3));
$cout = $cin;
$count = mt_rand(2,3);

function complex2($x,$inst){
	$temp = $x;
	$sum = "";
	$temp = mt_rand(1,100)*pow(-1,mt_rand(1,3));
	if($temp < 0) $sum = " ( - ".abs($temp)." ) ".$sum;
	else $sum = complex1($temp,$inst-1,$inst,true)." ".$sum;
	switch(mt_rand(0,1)){
		case 0: { $sum = " * ".$sum; $temp = $x / $temp;}break;
		case 1: { $sum = " / ".$sum; $temp = $temp * $x;}break;
		}
	$x = $temp;
	if($temp < 0) $sum = " ( - ".abs($temp)." ) ".$sum;
	else $sum = complex1($temp,$inst-1,$inst,true)." ".$sum;
	return $sum;  
	}


function complex1($x,$inst,$inst2,$tr){
	$temp = $x;
	if($x<0) $sum = " - ".abs($x);
	else $sum = $x;
	$divide = mt_rand($inst/2,$inst);
	if($divide != 0) $sum = "";
	if($tr && ($divide != 0 || $x < 0)) $sum = $sum." ) ";  
	for($i=0 ; $i < $divide ; $i++){
		$temp = mt_rand(1,100)*pow(-1,mt_rand(1,3));
		if($temp < 0 && $temp <= $x) $sum = " ) ".$sum;
		if($temp < 0) $sum = abs($temp)." ".$sum;
		else {if(mt_rand(0,5)>4) $sum = complex1($temp,$inst-1,$inst2,true)." ".$sum;
			else $sum = complex2($temp,$inst2)." ".$sum;}
		if($temp < 0 && $temp <= $x) $sum = " ( - ".$sum;
		if($temp <= $x) $sum = " + ".$sum;
		else $sum = " - ".$sum;
		if($temp <= $x || $temp < 0) $temp = $x - $temp;
		else $temp = $x + $temp;
		$x = $temp;
		if($i == $divide-1) {
			if($temp < 0) $sum = " - ".abs($temp)." ".$sum;
			else {if(mt_rand(0,5)<5) $sum = complex1($temp,$inst-1,$inst2,true)." ".$sum;
			else $sum = complex2($temp,$inst2)." ".$sum;}
			}
		}
	if($tr && ($divide != 0 || $x < 0)) $sum = " ( ".$sum;
	return $sum;  
	}

$cin = complex1($cin,2,2,false)." = ";
$cin = explode(".",$cin);
$cin = implode(",",$cin);
$cin = explode(" ",$cin);
$cin = implode("",$cin);
//$min1 = localtime(time()+30);
@setcookie("cpcha1", md5($cout), time()+900,'/');
$cout--;
@setcookie("cpcha2", md5($cout), time()+900,'/');
?>