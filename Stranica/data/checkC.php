<?php
if(isset($_REQUEST['checkC'])){
if(md5($_REQUEST['checkC']) == $_COOKIE['cpcha1'] || md5($_REQUEST['checkC']) == $_COOKIE['cpcha2']) 
			echo "true";
		else echo "false";
		}
else echo "false";
?>