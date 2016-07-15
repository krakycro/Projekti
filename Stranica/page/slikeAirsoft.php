<?php 
if(empty($block))
	header("Location: error.php");
?>
<link href="./data/js-image-slider.css" rel="stylesheet" type="text/css">
<script type="text/jscript" src="./data/js-image-slider.js"></script>
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
#slider{
	height:500px;
}
</style>

<script type="text/jscript" language="javascript">
$(document).ready(function(){

	});
</script>
<div id="polu">
<h2>Galerija Airsofta</h2>
</div>
<div id="pold">

<div id="sliderFrame">
<div id="slider">
        <a href="./slike/gallery/airsoft1.jpg" rel="lightbox[airsoft]" title="Airsoft 1"><img src="./slike/gallery/airsoft1.jpg" >
        <a href="./slike/gallery/airsoft2.gif" rel="lightbox[airsoft]" title="Airsoft 2"><img src="./slike/gallery/airsoft2.gif" >
        <a href="./slike/gallery/airsoft3.bmp" rel="lightbox[airsoft]" title="Airsoft 3"><img src="./slike/gallery/airsoft3.bmp" >
        <a href="./slike/gallery/airsoft4.tif" rel="lightbox[airsoft]" title="Airsoft 4"><img src="./slike/gallery/airsoft4.tif" >
</div>
</div>
</div>
