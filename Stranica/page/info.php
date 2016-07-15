<?php 
if(empty($block))
	header("Location: error.php");
?>
<style type="text/css">
#polu{
	display: block;
	margin: 15px 15px 15px 15px;
	padding: 5px 20px 5px 20px;
	background-color: #3399FF;
	border: 5;
	border-radius: 15px;
	box-shadow: 2px 2px 5px 1px #111111;
	color: #000040;
	width: 92%;
	float: left;
}

#pold{
	display: block;
	margin: 15px 15px 15px 15px;
	padding: 5px 20px 5px 20px;
	background-color: #C0C0C0;
	border: 5;
	border-radius: 15px;
	box-shadow: 2px 2px 5px 1px #111111;
	color: #000040;
	width: 92%;
	float: left;
}
</style>

<script type="text/jscript" language="javascript">
$(document).ready(function(){

	});
</script>
<div id="polu">
<h2>Info</h2>
</div>
<div id="pold">
<p><b>Ova stranica je dizajnirana u sklopu projekta za predmet Multimediska tehnika. Bogata je multimediskim, dizajnerskim i programerskim sadržajima.
Prikazuje mogučnosti interakcije Fakulteta i njegovih studenata, no ovo je još alpha projekt i nije upotpunosti iskorišten njen potencijal!
</b></p>
<hr style="width:100%">
<h4>Stranica</h4>
<p>
Stranica sadrži jquery, jsData, jsImage i lightbox besplatne implementacije koda za animacije i prikaz. Sve ostalo je ručno programirano preko PHP, i SQL koda.
CSS se uređivao koristeći Microsoft Expresion Web 4 (zbog lakšeg stiliziranja u CSSu).
</p>
<p>
Na stranici je provedeno oko 30-ak sati rada i prikazan je primjer inerakcije servera sa bazom podataka i korisnicima.
Radi zaštite registracije, izrađen je algoritam za zakompliciravanje broja radi validacije osobe i zaštite od spama.
</p>
<hr style="width:100%">
<h4>Životopisi</h4>
<p><a href="?infoKraky">Ovdje</a> možete pronaći informacije o Filip Krausu.</p>
<hr style="width:100%">
<h4>Galerija</h4>
<p><a href="?slike">Ovdje</a> će te vidjeti galeriju fakulteta i prirode.</p>
</div>
