<?php
$block = "Ovo otvara index.php!";
$kon_var =@explode("&",$_SERVER["QUERY_STRING"]);
$kontrola = $kon_var[0];
$cin=0;
$cout=0;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Završni rad</title>
<link rel="SHORTCUT ICON" href="../slike/favicon.ico">
<link href="css/style.css" rel="stylesheet" type="text/css">
<script type="text/jscript" src="data/jquery.js"></script>
<script type="text/jscript" src="data/jscript.js"></script>
</head>
<body>
<div id="xybox">
x:0, y:0
</div>
<div align="center">
	<table class="mtable">
	<tr>
		<td>
			<div id="head" align="center">
				<h1>Web Kalkulator</h1>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div id="body" align="center">
				<form id="mform" name="form" action="" onsubmit="calculate(0,'#input','#output'); return false; " method="post">
					<div id="inbox">
						<input type="text" id="input" name="input" autocomplete="off" autofocus>
						<a href="" onclick="calculate(0,'#input','#output'); return false; " id="clcbutton">=</a>
					</div>
				</form>
				<div align="center" class="helpdiv">
					<p>
						<a href="" onclick="return false;" id="helpbutton">Uputstva</a>
					</p>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div id="tail">
				<div id="helpbox" class="dropbox">
					Uputstva:<br>
					<div class="inbox">
						<h4>Kalkulator za rješavanje matematičkih problema i prikazivanje grafa.</h4>
						<p>
							<strong>Operacije:</strong>
						</p>
						<p>
							+, -, *, /, ^
						</p>
						<p>
							<strong>Funkcije:</strong>
						</p>
						<p>
							pow, root(√), log, sin, cos, tan, cot
						</p>
						<p>
							<strong>Konstante:</strong>
						</p>
						<p>
							e, pi(π), ¼, ½, ¾
						</p>
						<p>
							<strong>Oznaka za graf</strong>
						</p>
						<p>
							x
						</p>
						<p>
							<strong>Pravila:</strong>
						</p>
						<p>
							Funkcije:
							<ul>
								<li>funkcija(baza)</li>
								<li>(eksponenta)funkcija(baza)</li>
							</ul>
						</p>
						<p>
							<strong>Primjer:</strong>
						</p>
							<ul>
								<li>5+2.2(3e-15/√4)</li>
								<li>sin(x)/5pow6.6</li>
								<li>2log(10,pi)+pipowe</li>
							</ul>
						</div>
					</div>
					<p id="output">
					</p>
					<p id="info">
						Izradio: Filip Kraus,<br>
						 Elektrotehnički Fakultet Osijek<br>
					</p>
				</div>
			</td>
		</tr>
		</table>
	</div>
	</body>
	</html>