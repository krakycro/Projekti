<?php 
if(empty($block))
	header("Location: ?error");

$_SESSION["backsite"] = "pocetna";

if( $logerr != 0) echo $logerr;	
?>
<script type="text/jscript">

</script>

<div class="pol1" align="center" style="text-align: center;">

	<div id="screen" align="center" style="text-align:center;">
	<img src="<?php echo $data."/loading.gif";?>" width="64" height="64" style="position:relative; top:33%"></img>
	</div>

	<div class="pol2" align="center" style="margin-left: 2%; position: absolute; width: 90%; height: 90%; top:5%;">
	<form class="bodyform" id="next" action="?pocetna" method="post">
		<table class="frame2" style="width:90%; text-align: center; align-items: baseline;">
		<tr>
			<td>
			<h3>Bar Kod</h3>
			</td>
			<td>
			<h3>QR Kod</h3>
			</td>
		</tr>
		<tr>
			<td>
			<h3>Tekst(max: <?php echo $BAR_MAX;?>): </h3>
				<input type="input" id="input1" name="in_bar" maxlength="<?php echo $BAR_MAX;?>" value="<?php echo $_POST["in_bar"];?>" style="position: relative; width: <?php echo $BAR_MAX*8;?>px;">
				<input type="submit" id="submit" name="submit" value="GO" onclick="$('#screen').css('visibility','visible');" style="position: relative; width: 40px;">
			</td>
			<td >
			<h3>Tekst: </h3>
				<input type="input" id="input2" name="in_qr" value="<?php echo $_POST["in_qr"];?>" style="position: relative;">
				<input type="submit" id="submit" name="submit" value="GO" onclick="$('#screen').css('visibility','visible');" style="position: relative; width: 40px;">
			</td>
		</tr>
		<tr>
			<td>
			<img class="input_pic" id="out_bar" width="auto" height="30" src="<?php echo $filebar; ?>" style="background-color: white; margin: 2%; margin-bottom: 0;">
			<h4 style="margin:0; padding : 0; letter-spacing: <?php echo $BAR_MAX/2;?>px;"><?php echo $_POST["in_bar"];?></h4>
			</td>
			<td >
			<img class="input_pic" id="out_qr" width="auto" height="128" src="<?php echo $fileqr; ?>" style="margin: 2%;">
			</td>
		</tr>
		</table>
	</form>
		
	</div>
	
</div>