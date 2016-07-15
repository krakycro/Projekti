<?php 
if(empty($block)) 
  header("Location: error.php");

$logerr = 0;
$buff = array();
   $query= "SELECT email FROM *PRIVATE*.korisnik WHERE *PRIVATE*.korisnik.nick = '".$_COOKIE['nick']."'";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    if (@mysql_num_rows($q)==0 && !$logerr)
      $logerr = "Prazan red!";
    else if(!$logerr)
      $redak = @mysql_fetch_array($q);
      else $loginz = false;
      
?>


<script language="JavaScript">
var t = 1;
$(document).ready(function(){
  <?php
  if(isset($_GET['poslan'])){
    if($_GET['poslan'] == 1) echo "alert('USPJEH: E-mail poslan!');\n";
    else echo "alert('GREŠKA: E-mail nije poslan!');\n";
  }
  ?>
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
  $(":text[name^='chemail']").blur(function(){
    var atpos= $(":text[name^='chemail']").val().indexOf("@");
    var dotpos= $(":text[name^='chemail']").val().lastIndexOf(".");
    if(atpos<1 || dotpos<atpos+2 || dotpos+2>=string[i].value.length) {
      $(":text[name^='chemail']").css("background-color","#FF5555");
      $("#popup").css("display","block");
      $("#popup").html("Nevalja, treba: naziv@ekstenzija.domena !");
      $("#popup").css("left",$(":text[name^='chemail']").offset().left+160);
      $("#popup").css("top",$(":text[name^='chemail']").offset().top);
      temp = "chemail";
      }
    });
  $(":text[name^='chemail']").focus(function(){
    if(temp == "chemail") $("#popup").hide(400);
    });
  });
function SubmitForm(forma,errtarget,errout){
  var string = document.forms[forma];
  var errtext = "";
  t = true;
  var i = "chname";
  if(string[i].value.length == 0 ){
    $(":text[name^='chname']").css("background-color","#FF5555");
    errtext += "<p><b>Naslov: </b> Nesmije biti prazno !</p><br>";
    t=false;
    }
  i = "chemail";
  var atpos=string[i].value.indexOf("@");
  var dotpos=string[i].value.lastIndexOf(".");
  if(atpos<1 || dotpos<atpos+2 || dotpos+2>=string[i].value.length) {
    $(":text[name^='chemail']").css("background-color","#FF5555");
    errtext += "<p><b>Pošiljatelj:</b> treba: naziv@ekstenzija.domena !</p><br>";
    t=false;
    }
  i = "chtext";
  if(string[i].value.length == 0 ){
    errtext += "<p><b>Predmet: </b> Nesmije biti prazno !</p><br>";
    t=false;
    }
  if($("#file").val().length > 0 ) {
    var s = $("#file").val().split(".");
    if(slikaSize > 2000000){
      t = false;
      errtext += "<p><b>Privitak:</b> <2MB !</p><br>";
      }
  }
  if(!t){
    $(errout).html("");
    $(errtarget).slideDown(400);
    $(errout).append(errtext);
    }
  return t;
  }
</script>
<style type="text/css">
#pold{
  display: block;
  margin: 15px 15px 15px 15px;
  padding: 5px 20px 5px 20px;
  background-color: #C0C0C0;
  color: #000040;
  border: 5;
  border-radius: 15px;
  box-shadow: 2px 2px 5px 1px #111111;
  width: 600px;
}
#polu{
  display: block;
  margin: 15px 15px 15px 15px;
  padding: 5px 20px 5px 20px;
  background-color: #3399FF;
  color: #000040;
  border: 5;
  border-radius: 15px;
  box-shadow: 2px 2px 5px 1px #111111;
  width: 600px;
}
#chform{
  margin: 15px 15px 15px 15px;
  text-align:left;
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
.insertz{
  display:none;
  position:absolute;
  width: 180px;
}
.naziv{
  display: inline-block;
  position:relative;
  margin: 0px;
  padding: 0px;
  float: right;
  top: -20px;
}
#polerr{
  display: none;
  margin: 15px 15px 15px 15px;
  padding: 5px 20px 5px 20px;
  background-color: #FF5050;
  border: 5;
  border-radius: 15px;
  box-shadow: 2px 2px 5px 1px #111111;
  color: #000040;
  width: 92%;
  float: left;
}
</style>
<div align="center" style="width: 100%;">
<div id="polu">
<h2>Kontaktirajte nas!</h2>
<h5>U slučaju nekog problema, primjedbe i ostalih pitanja pošaljite nam e-mail!</h5>
</div>
<div id="pold">
<form class="bodyform" id="chform" name="mailform" action="../data/email.php" onsubmit="return SubmitForm('mailform','#polerr','#errunos');" method="post" enctype="multipart/form-data">
<p style="margin:2;"><b>Naslov: </b><input type="text" name="chname" id="chname" ></p>
<p style="margin:2;"><b>Pošiljatelj: </b>
<div class="naziv" id="divemail">
<?php if($loginz) echo $redak['email']; else echo 'Anonymous';?>
<a class="uredi" href="#" onclick="return false;"><img class="cog" id="email" src="../slike/edit.png"></a>
<input type="text" name="chemail" class="insertz" id="chemail" value="<?php if(loginz) echo $redak['email'];?>">
</div>
<p style="margin:2;"><b>Predmet: </b></p><br><textarea name="chtext" id="chtext" ></textarea>
<p style="margin:2;"><b>Privitak: </b><input type="file" name="file" id="file" onchange="readURL(this);" ></p>
<div align="center" style="width:auto;"><hr style="width: 100%">
<input type="submit" name="submit" value="Pošalji"  style="margin:5px;" >
<input type="reset" name="reset" value="Reset"  style="margin:5px;">
</div>
</form>
</div>
</div>
<div id="polerr">
<h4>GREŠKA:</h4>
<hr style="width: 100%">
<div id="errunos"></div>
<hr style="width: 100%">
</div>

