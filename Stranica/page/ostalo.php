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
<h2>Ostalo</h2>
</div>
<div id="pold">
<p>
Dalje u primjeru postoji prikaz funkcionalnog live chata sa registriranim korisnicima, te prikaz svih korisnika sa mogučnosti kontakta preko e-maila.
Prikaz interakivne komunikacije sa bazom podataka sa i bez refresha, te online radio, koji se može otvoriti u zasebnom prozoru i slušati dok se koristi chat ili čita o našim hobijima:
</p>
<ul>
<li><a href="?slike">Slike</a></li>
<li><a href="?audioPlay">Online Radio Player</a></li>
<li><a href="?chat">Chat</a></li>
<li><a href="?korisnici">Korisnici</a></li>
</ul>
<p>
Može se primjetiti da je stranica zabranjena gostima, te da je obavezna registracija, i u daljnjim opcijama može se kontaktirati admina, ili promjeniti informacije o korisniku, te slika.
</p>

</div>
