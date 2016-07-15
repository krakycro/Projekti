<?php 
if(empty($block))
	header("Location: error.php");
?>

<style type="text/css">
#po1{
	margin: 15px 15px 15px 15px;
	padding: 5px 20px 5px 25px;
	background-color: #C0C0C0;
	border: 5;
	border-radius: 15px;
	box-shadow: 2px 2px 5px 1px #111111;
	color: #000040;
	width: 92%;
	float: left;
}
#pol2{
	margin: 15px 15px 15px 15px;
	padding: 5px 20px 5px 25px;
	background-color: #3399FF;
	border: 5;
	border-radius: 15px;
	box-shadow: 2px 2px 5px 1px #111111;
	color: #000040;
	width: auto;
	float: left;
}
#pol3{
	display: block;
	margin: 15px 15px 15px 15px;
	padding: 5px 20px 5px 25px;
	background-color: #FF5050;
	border: 5;
	border-radius: 15px;
	box-shadow: 2px 2px 5px 1px #111111;
	color: #000040;
	width: 92%;
	float: left;
}

</style>
<script type="text/jscript">
$(document).ready(function(){
if(<?php if($loginz) echo "true"; else echo "false";?>){
	$("#pol3").css("display","none");
	}
});
</script>
<div id="po1">
<div id="pol2">
<h4>Slike admina:</h4>
<a href="slike/Kraky.jpg" rel="lightbox[pocetna]" title="Filip Kraus"><img class="profpic"  src="slike/Kraky.jpg" ></a>

</div>

<h1>Ovo je početna stranica!</h1>
<p><b>Ova stranica je dizajnirana u sklopu projekta za predmet Multimediska tehnika.
80% stranice je ručno izrađeno radi razvijanja vlstitih ideja i sposobnosti.
</b></p>
<p><a href="http://projectmultimedija.biz.ht/diplomski/">Ovdje</a> možete pronaći moj Diplomski rad.</p>
<p><a href="http://projectmultimedija.biz.ht/vizualizacija/">Ovdje</a> možete pronaći projekt Sunčevog sustava za kolegij Vizualizacija.</p>
<h4><b>Ovu web-stranucu je izradilo: </b>Filip Kraus</h4>
<h5><b>Fakultet:</b> Eletrkotehnički fakultet, Osijek</h5>
<h5><b>Godina:</b> 1. godina diplomskog studija</h5>
<h5><b>Smjer:</b> Programsko inženjerstvo</h5>
</div>
