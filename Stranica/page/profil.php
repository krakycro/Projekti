<?php 
if(empty($block)) 
  header("Location: error.php");
?>

<style type="text/css">
.insertz{
  display:none;
  position:absolute;
}
.insertpop{
  border: 2px solid #3E0066;
  border-radius: 5px;
  box-shadow: 2px 2px 5px 1px #111111;
  display: none;
  position: absolute;
  background-color: #99CCFF;
  width: 300px;
  padding: 5px;
  z-index:80;
}

#polu{
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
.block{
  margin: 10px;
  padding: 20px 120px 20px 20px;
  width: 160px
}
.naziv{
  display: block;
  position:relative;
  margin: 0px;
  padding: 0px;
  float:right;
  top: -35px;  left: 120px;
}
#pold{
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

<?php
$logerr = 0;
$buff = array();
   $query= "SELECT * FROM 1354734_web.korisnik WHERE 1354734_web.korisnik.nick = '".$_COOKIE['nick']."'";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    if (@mysql_num_rows($q)==0 && !$logerr)
      $logerr = "Prazan red!";
    else if(!$logerr)
      $redak = @mysql_fetch_array($q);
?>

<script language="JavaScript" src="data/hash.js"></script>

<script language="JavaScript">
$(document).ready(function(){
  $(".cog").mousedown(function(){
    if($(this).attr("src") == "../slike/edit.png" || $(this).attr("src") == "../slike/edit_u.png"){
      $(this).attr("src","../slike/edit_d.png");
      var tem = "#in"+$(this).attr("id");
      $(tem).css("display","block");
      if(tem == "#inpoppasswrd") {
        $(tem).css("right",$(this).position().left-60);
        }
      else $(tem).css("left",$(this).position().left-160);
      if(tem == "#ingodina") {
        $(tem).css("top",$(this).position().top-30);
        }
      else $(tem).css("top",$(this).position().top-10);
      }
    else {
      var spl = $("#div"+$(this).attr("id")).text().split("\n");
      var tem = "#in"+$(this).attr("id");
      if(spl[1] != $(tem).val() && tem != "#inpoppasswrd") $(this).attr("src","../slike/edit_u.png");
      else {
        if(($("#inpasswrd").val().length >0 || $("#confirm").val().length >0 || $("#oldpasswrd").val().length > 0) && tem == "#inpoppasswrd"){
        $(this).attr("src","../slike/edit_u.png");
        }
        else $(this).attr("src","../slike/edit.png");
        }
      $(tem).css("display","none");
      }
    });
  var t = new JsDatePick({
    useMode:2,
    isStripped:false,
    target:"ingodina",
    limitToToday:true,
    dateFormat:"%d.%m.%Y",
    selectedDate:{day:1,month:1,year:2000},
    cellColorScheme:"ocean_blue"
    });
  $(":text[name^='innick']").blur(function(){
    if( $(":text[name^='innick']").val() != "<?php echo $_COOKIE['nick'];?>" && (isTaken('nicklist',":text[name^='innick']"))){
      $(":text[name^='innick']").css("background-color","#FF5555");
      $("#popup").css("display","block");
      $("#popup").html("Zauzeto, promijenite nick.");
      $("#popup").css("left",$("#nick").offset().left+15);
      $("#popup").css("top",$("#nick").offset().top-10);
      temp = "innick";
      }
    });
  $(":text[name^='innick']").focus(function(){
    if(temp == "innick") $("#popup").hide(400);
    });
  $(":password[name^='confirm']").blur(function(){
    if($(":password[name^='inpasswrd']").val().length>0 && $(":password[name^='inpasswrd']").val() != $(":password[name^='confirm']").val()){
      $(":password[name^='inpasswrd']").css("background-color","#FF5555");
      $(":password[name^='confirm']").css("background-color","#FF5555");
      $("#popup").css("display","block");
      $("#popup").html("Ne podudara se password!");
      $("#popup").css("left",$("#poppasswrd").offset().left+15);
      $("#popup").css("top",$("#poppasswrd").offset().top-10);
      temp = "confirm";
      }
    });
  $(":password[name^='confirm']").focus(function(){
    if(temp == "confirm") $("#popup").hide(400);
    });
  });
  
function picswap(){
  if($("#file").val().length > 0 ) {
    var s = $("#file").val().split(".");
    $("#inslika").val(s[s.length-1]);
    }
  else $("#inslika").val("<?php echo $redak['slika'];?>");
  reload();
  }

function SubmitForm(forma,errtarget,errout){
  var string = document.forms[forma];
  var errtext = "";
  var pswrd = string["inpasswrd"].value;
  var hashp = hex_md5($("#oldpasswrd").val()+"<?php echo $_COOKIE['nick'];?>");
  var t = true;
  var i = "innick";
  if( $(":text[name^='innick']").val() != "<?php echo $_COOKIE['nick'];?>" && (isTaken('nicklist',":text[name^='innick']"))) {
    $(":text[name^='innick']").css("background-color","#FF5555");
    errtext += "<p><b>Nick:</b> Naziv zauzet!</p><br>";
    t=false;
    }
  if(string["oldpasswrd"].value.length < 4 && $(":text[name^='innick']").val() != "<?php echo $_COOKIE['nick'];?>"){
      $(":password[name^='oldpasswrd']").css("background-color","#FF5555");
      errtext += "<p><b>Nick: Mora se unjeti i stari/novi password !</b></p><br>";
      t=false;
      }
  if(string[i].value.length > 30 || string[i].value.length < 4 || RegExp("[^a-z^A-Z^0-9/g]").test(string[i].value)) {
    $(":text[name^='innick']").css("background-color","#FF5555");
    errtext += "<p><b>Nick:</b> 4-30 znakova: a-z, A-Z, 0-9 !</p><br>";
    t=false;
    }
  i = "oldpasswrd";
  if(string[i].value.length > 0 && (hashp != "<?php echo $_COOKIE['passwrd'];?>" || string[i].value.length > 16 || string[i].value.length < 4 || RegExp("[^a-z^A-Z^0-9/g]").test(string[i].value))){
    $(":password[name^='oldpasswrd']").css("background-color","#FF5555");
    errtext += "<p><b>Krivi stari password !</b></p><br>";
    t=false;
    }
  i = "inpasswrd";
  if(string[i].value.length > 0 && (string[i].value.length > 16 || string[i].value.length < 4 || RegExp("[^a-z^A-Z^0-9/g]").test(string[i].value))) {
    $(":password[name^='inpasswrd']").css("background-color","#FF5555");
    errtext += "<p><b>Novi Password:</b> 4-16 znakova: a-z, A-Z, 0-9 !</p><br>";
    t=false;
    }
  i = "confirm";
  if(string[i].value.length > 0 && (string[i].value.length > 16 || string[i].value.length < 4 || RegExp("[^a-z^A-Z^0-9/g]").test(string[i].value))) {
    $(":password[name^='confirm']").css("background-color","#FF5555");
    errtext += "<p><b>Potvrdi Password:</b> 4-16 znakova: a-z, A-Z, 0-9 !</p><br>";
    t=false;
    }
  if(string[i].value != pswrd){
    $(":password[name^='confirm']").css("background-color","#FF5555");
    errtext += "<p><b>Nepududaranje passworda!</b></p><br>";
    t=false;
    }
  i = "inemail";
  var atpos=string[i].value.indexOf("@");
  var dotpos=string[i].value.lastIndexOf(".");
  if(atpos<1 || dotpos<atpos+2 || dotpos+2>= string[i].value.length) {
    $(":text[name^='inemail']").css("background-color","#FF5555");
    errtext += "<p><b>E-mail:</b> treba: naziv@ekstenzija.domena !</p><br>";
    t=false;
    }
  if($("#file").val().length > 0 ) {
    var s = $("#file").val().split(".");
    if(!RegExp("(jpg|jpeg|gif|png)").test(s[s.length-1]) || slikaSize > 2000000){
      t = false;
      errtext += "<p><b>Slika:</b> samo: .jpg, .jpeg, .gif, .png, <2MB !</p><br>";
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
<form class="bodyform" name="regbox" action="../data/SQL_update.php" onsubmit="return SubmitForm('regbox','#polerr','#errunos')" enctype="multipart/form-data" method="post">
<div id="polu">
<p>
<h3>Korisnik <?php echo $_COOKIE['nick'] ?> :</h3>
</p>
<hr style="width: 100%">
<div style="display:block;float:left">
<img class="profpic" id="tempslika" src="slike/profile/<?php echo $slika.".".$ext?>" style="">
</div>
<div class="block" style="display:block;float:left">
<p><b>Nick: </b></p>
<div class="naziv" id="divnick">
<?php echo $_COOKIE['nick']?>
<a class="uredi" href="#" onclick="return false;"><img class="cog" id="nick" src="../slike/edit.png"></a>
<input type="text" name="innick" class="insertz" id="innick" value="<?php echo $_COOKIE['nick'];?>">
<input type="hidden" name="oldnick" value="<?php echo $_COOKIE['nick'];?>">
<input type="hidden" name="oldslika" value="<?php echo $redak['slika'];?>">
</div>
<p><b>E-mail: </b></p>
<div class="naziv" id="divemail">
<?php echo $redak['email'];?>
<a class="uredi" href="#" onclick="return false;"><img  class="cog" id="email" src="../slike/edit.png"></a>
<input type="text" name="inemail" class="insertz" id="inemail" value="<?php echo $redak['email'];?>">
</div>
<p><b>Password: </b></p>
<div class="naziv">
**********
<a class="uredi" href="#" onclick="return false;"><img  class="cog" id="poppasswrd" src="../slike/edit.png"></a>
<div class="insertpop" id="inpoppasswrd" >
<p><b>Stari password: </b></p>
<input type="password" name="oldpasswrd" id="oldpasswrd" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
<p><b>Novi password: </b></p>
<input type="password" name="inpasswrd" id="inpasswrd" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
<p><b>Potvrdi password: </b></p>
<input type="password" name="confirm" id="confirm" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
</div>
</div>
</div>
<div style="display:block;float:left; margin:20px 5px 20px 15px;">
<hr style="width: 0px; height: 200px">
</div>
<div class="block" style="display:block;float:left">
<p><b>Ime: </b></p>
<div class="naziv" id="divime">
<?php echo $redak['ime'];?>
<a class="uredi" href="#" onclick="return false;"><img  class="cog" id="ime" src="../slike/edit.png"></a>
<input type="text" name="inime" class="insertz" id="inime" value="<?php echo $redak['ime'];?>">
</div>
<p><b>Prezime: </b></p>
<div class="naziv" id="divprezime">
<?php echo $redak['prezime'];?>
<a class="uredi" href="#" onclick="return false;"><img  class="cog" id="prezime" src="../slike/edit.png"></a>
<input type="text" name="inprezime" class="insertz" id="inprezime" value="<?php echo $redak['prezime'];?>">
</div>
<p><b>Datum rođenja: </b></p>
<div class="naziv" id="divgodina">
<?php $pic = explode("-",$redak['godina']); echo $pic[2].".".$pic[1].".".$pic[0];?>
<a class="uredi" href="#" onclick="return false;"><img  class="cog" id="godina" src="../slike/edit.png"></a>
<input type="text" name="ingodina" class="insertz" id="ingodina" value="<?php echo $pic[2].".".$pic[1].".".$pic[0];?>">
</div>
<p><b>Adresa: </b></p>
<div class="naziv" id="divadresa">
<?php echo $redak['adresa'];?>
<a class="uredi" href="#" onclick="return false;"><img  class="cog" id="adresa" src="../slike/edit.png"></a>
<input type="text" name="inadresa" class="insertz" id="inadresa" value="<?php echo $redak['adresa'];?>">
</div>
</div>

<div style="display:block;float:left; position:absolute; top:280px;">
<input type="hidden" id="inslika" name="inslika" value="0">
<input type="file" name="file" id="file" value="Biraj" accept="image/jpg,image/jpeg,image/gif,image/png" onchange="readURL(this,'#tempslika','slike/profile/<?php echo $slika.".".$ext?>');picswap();" style="margin:5px;">
</div>
<div style="display:block; position:absolute; top:320px;">
<hr style="width: 840px">
</div>

</div>
<div id="polerr">
<h4>GREŠKA:</h4>
<hr style="width: 100%">
<div id="errunos"></div>
<hr style="width: 100%">
</div>
<div id="pold" align="center">
<p>Nakon ispravnog popunjavanja forme izaberite:</p>
<hr style="width: 100%">
<input type="submit" name="submit" value="Promijeni"  style="margin:5px;">
<input type="reset" name="reset" value="Reset" onclick="readURL(this,'#tempslika','slike/profile/<?php echo $slika.".".$ext?>');" style="margin:5px;">
<hr style="width: 100%">
</div>
</form>

<?php
      
echo '<form name="nicklist">';
   $query= "SELECT nick FROM 1354734_web.korisnik WHERE 1";
    if (!($q=@mysql_query($query)) && !$logerr)
        $logerr = "Neuspjelo slanje upita bazi!";
    if (@mysql_num_rows($q)==0 && !$logerr)
      $logerr = "Prazan red!";
    else if(!$logerr){
      while(($redak = @mysql_fetch_array($q) )){
        echo '<input type="hidden" name="'.$redak["nick"].'">';
        }
      }
echo '</form>';

?>

