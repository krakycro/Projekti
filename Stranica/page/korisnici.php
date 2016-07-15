<?php

if(empty($block)) 
  header("Location: error.php");
  
$query= "SELECT * FROM *PRIVATE*.korisnik WHERE *PRIVATE*.korisnik.nick ='".$_COOKIE['nick']."'";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    if (@mysql_num_rows($q)==0 && !$logerr)
      $logerr = "Prazan red!";
    else if(!$logerr) $redak = @mysql_fetch_array($q);
    else $loginz = false;
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

<script type="text/jscript" language="javascript">
var tmail = 0;
$(document).ready(function(){
  $("#chback").mousedown(function(){
    $("#divmail").fadeOut(400);
    $(":text[name^='chname']").val("");
    $("#chtext").val("");
    });
  $("#chsubmit").mousedown(function(){
    var data = new FormData($('input[name^="file"]'));
    var fileInputName = $('input[name^="file"]').attr('name');     
    jQuery.each($('input[name^="file"]')[0].files, function(i, file) {
        data.append(fileInputName, file);
      });
      var params = $("#chform").serializeArray();
      $.each(params, function (i, val) {
          data.append(val.name, val.value);
        });
      $.ajax({
          type: "POST",
          data: data,
          url: "../data/email.php",
          cache: false,
          contentType: false,
          processData: false,
          success: function(data){
          if(data == "1") alert('USPJEH: E-mail poslan!');
          else alert('GREŠKA: E-mail nije poslan!');
          $("#divmail").fadeOut(400);
          }
      });
    });
  $(".mail").mousedown(function(){
    $("#divmail").fadeIn(400);
    $("#divmail").css({"left":$(this).position().left-300,"top":$(this).position().top-250});
    $("#chto").html("<b>Šalji: </b>"+$(this).attr("name"));
    $("#chsendto").val($(this).attr("name"));
    });
  $(".cog").mousedown(function(){
    var tem = "#ch"+$(this).attr("id");
    if($(this).attr("src") == "../slike/edit.png" || $(this).attr("src") == "../slike/edit_u.png"){
      $(this).attr("src","../slike/edit_d.png");
      $(tem).css("display","block");
      $(tem).css("left",$(this).position().left-185);
      $(tem).css("top",$(this).position().top-10);
      }
    else {
      var spl = $("#div"+$(this).attr("id")).text().split("\n");
      if(spl[1] != $(tem).val()) $(this).attr("src","../slike/edit_u.png");
      else $(this).attr("src","../slike/edit.png");
      $(tem).css("display","none");
      }
    });

  });
function SubmitForm(forma){
  var string = document.forms[forma];
  var errtext = "";
  t = true;
  var i = "chname";
  if(string[i].value.length == 0 ){
    $(":text[name^='chname']").css("background-color","#FF5555");
    t=false;
    }
  i = "chemail";
  var atpos=string[i].value.indexOf("@");
  var dotpos=string[i].value.lastIndexOf(".");
  if(atpos<1 || dotpos<atpos+2 || dotpos+2>=string[i].value.length) {
    $(":text[name^='chemail']").css("background-color","#FF5555");
    t=false;
    }
  i = "chtext";
  if(string[i].value.length == 0 ){
    t=false;
    }
  if($("#file").val().length > 0 ) {
    var s = $("#file").val().split(".");
    if(slikaSize > 2000000){
      t = false;
      }
  }
  return t;
  }

</script>
<style type="text/css">
.insertz{
  display:none;
  position:absolute;
  width: 180px;
}

.insertpop{
  border: 2px solid #3E0066;
  border-radius: 5px;
  box-shadow: 2px 2px 5px 1px #111111;
  display: none;
  position: absolute;
  background-color: #99CCFF;
  width: 600px;
  padding: 5px 10px 5px 15px;
  z-index: 260;
  color: #3E0066;
}

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
.polb{
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
#chtext{
  height: 200px;
  max-height: 200px;
  width: 570px;
  resize: none;
  overflow: auto;
  position:relative;
  top:-15px;
}
#chname{
  width: 505px;
}
.naziv{
  display: inline-block;
  position:relative;
  margin: 0px 20px 0 0;
  padding: 0px;
  float: right;
  top: -20px;
}

</style>
<div class="insertpop" id="divmail">
<form class="bodyform" id="chform" name="mailform" onsubmit="SubmitForm('mailform'); return false;" method="post" enctype="multipart/form-data">
<p name="chto" id="chto" style="margin:2;"></p>
<p style="margin:2;"><b>Naslov: </b><input type="text" name="chname" id="chname" ></p>
<p style="margin:2;"><b>Pošiljatelj: </b>
<div class="naziv" id="divemail">
<?php echo $redak['email']?>
<a class="uredi" href="#" onclick="return false;"><img class="cog" id="email" src="../slike/edit.png"></a>
<input type="text" name="chemail" class="insertz" id="chemail" value="<?php echo $redak['email'];?>">
</div>
<p style="margin:2;"><b>Predmet: </b></p><br><textarea name="chtext" id="chtext" ></textarea>
<p style="margin:2;"><b>Privitak: </b><input type="file" name="file" id="file" onchange="readURL(this);" ></p>
<div align="center" style="width:auto;"><hr style="width: 100%">
<input type="submit" name="submit" id="chsubmit" value="Pošalji"  style="margin:5px;" >
<input type="reset" name="reset" id="chback" value="Makni"  style="margin:5px;">
<input type="hidden" name="chsendto" id="chsendto" value="">
</div>
</form>
</div>


<div id="polu">
<h2>Lista korisnika</h2>
</div>
<?php
  $query= "SELECT * FROM *PRIVATE*.korisnik WHERE 1";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    if (@mysql_num_rows($q)==0 && !$logerr)
      $logerr = "Prazan red!";
    else if(!$logerr){
      while(($redak = @mysql_fetch_array($q) )) if($_COOKIE['nick'] != $redak['nick']){
        $pic = explode("-",$redak['godina']);
           echo '
        <div class="polb">
        <div style="display:block;float:left">';
        echo $redak['slika'] != "0" ? '<a href="slike/profile/'.$redak['nick'].'.'.$redak['slika'].'" rel="lightbox[korisnik]" title="'.$redak

['nick'].'"><img class="profpic" id="tempslika" src="slike/profile/'.$redak['nick'].'.'.$redak['slika'].'" style=""></a>' :
                      '<a href="slike/profile/User.jpg" rel="lightbox[korisnik]" title="'.$redak

['nick'].'"><img class="profpic" id="tempslika" src="slike/profile/User.jpg" style=""></a>';
      echo '
      </div>
      <div>
      <h3>'.$redak['nick'].'</h3>
      <p><b>Naziv:</b> '.$redak['ime'].' '.$redak['prezime'].'</p>
      <p><b>Email:</b> '.$redak['email'].' <a class="uredi" href="#" onclick="return false;"><img class="mail" name="'.$redak['email'].'" id="nick" src="../slike/mail.png"></a></p>
      <p><b>Godina rođenja:</b> '.$pic[2].'.'.$pic[1].'.'.$pic[0].'</p>
      </div>
        </div>
        ';
        }
      }

?>