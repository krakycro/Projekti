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
<h2>Omiljeni hobi</h2>
</div>
<div id="pold">
<p>Nasuprod raznih zanimanja mogu se izdvojiti par njih koji su mu prilično prirasli k srcu. To su Aikido, Airsoft. Pobliže o njima možete vidjeti, klikom na doljne linkove:</p>
<ul>
<li><a href="?hobiKraky">Filip Kraus</a></li>
</ul>
<hr style="width:100%">
</div>
