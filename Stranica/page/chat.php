<?php 
if(empty($block))
	header("Location: error.php");
?>

<style>
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
<div id="pol3">
<h2>Molimo registrijate se!</h2>
</div>
<?php if(!$loginz) die(); ?>

<script type="text/jscript">
$('.editable').each(function(){
    this.contentEditable = true;
});

function chatGet(IN){
		$.get("../data/chat_update.php",{input: "croom", chat: <?php echo "'".md5($chatroom)."'";?>},function(data){if(data != "NULL") $("#croom").html(data);if(IN)$("#croom").scrollTop($("#croom")[0].scrollHeight);});
		$.get("../data/chat_update.php",{input: "cnick", chat: <?php echo "'".md5($chatroom)."'";?>},function(data){if(data != "NULL") $("#cnick").html(data);if(IN)$("#croom").scrollTop($("#croom")[0].scrollHeight);});
		}
		
function chatSend(){
		if($("#chattype").val().length > 0){
		var IN = $("#chattype").val();
		var COL = $('#colc').val();
		var BG = $('#colbg').val();
		$.get("../data/chat_update.php",{input: "ctype", chat: <?php echo "'".md5($chatroom)."'";?>, block: IN, color: COL,bgcolor: BG});
		chatGet(true);
		}
		}


$(document).ready(function (){
	chatGet(true);
	setInterval(function(){
		chatGet(false);
		},500);
	$("#chattype").keyup(function(event) {
                if (event.keyCode==13) {
                    chatSend();
                    $('#chattype').val('');
                }
            });
	});
</script>

<style type="text/css">
.chatsplit{
	margin: 30px 0 0 0;
	padding: 0;
	display: block;
	top: -30px;
	color: #333399;
}
#chatform{
	margin:0;
}
.editable {
	resize: none;
    overflow: auto;
}
#chattable{
	border-radius: 10px;
	margin: 0 0 0 0;
	width: 100%;
}
#croom{
	border-color: #C0C0C0;
	border-radius: 10px;
	border-style: inset;
	background-color: #808080;
	position: relative;
	width: 680px;
	height: 250px;
	vertical-align: top;
	text-align: left;
	color: #990033;
}
#cnick{
	border-color: #C0C0C0;
	border-radius: 10px;
	color: #000066;
	border-style: inset;
	background-color: #808080;
	position: relative;
	width: 200px;
	height: 250px;
	vertical-align: top;
	text-align: left;
}
#chatin{
	border-color: #C0C0C0;
	border-radius: 10px;
	padding: 0 0 0 10px;
	border-style: inset;
	background-color: none;
	position: relative;
	max-height: 40px;
}
#chatroom{
	border-radius: 10px;
	background-color: #808080;
}
#chatnick{
	border-radius: 10px;
    background-color:#C0C0C0;
}
#chattype{
	background-color: #C0C0C0;
	color: #990033;
}

</style>
<form id="chatform" action="" onsubmit="chatSend();$('#chattype').val('');return false;">
<table id="chattable">
<tr>
	<td id="chatroom">
	<div class="editable" id="croom" readonly><?php echo $chatbox;?></div>
	</td>
	<td id="chatnick">
	<div class="editable" id="cnick" readonly><?php echo $chatname;?></div>
	</td>
</tr>
<tr>
	<td id="chatin" colspan="2">
	<input id="chattype" autocomplete="off" maxlength="254" name="chattype" style="width:665px">
	<input type="button" id="chatsubmit" name="chatsubmit" value="Pošalji" onclick="chatSend();$('#chattype').val('');" style="margin:5px 10px 0 30px; width:150px">
	<b>Boja teksta: <input id="colc" style="width:55px">
	Boja pozadine: <input id="colbg" style="width:55px" ></b>
	</td>
</tr>
</table>
<script type="text/javascript">
var Col = new jscolor.color(document.getElementById("colc"), {required:false})
Col.fromString('990033')
var Bgc = new jscolor.color(document.getElementById("colbg"), {required:false})
Bgc.fromString('#808080')
</script>
</form>