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
#polr{
  display: block;
  margin: 15px 15px 15px 15px;
  padding: 5px 20px 5px 20px;
  background-color: #C0C0C0;
  border: 5;
  border-radius: 15px;
  box-shadow: 2px 2px 5px 1px #111111;
  color: #000040;
  width: 42%;
  float: left;
}
#poll{
  display: block;
  margin: 15px 15px 15px 15px;
  padding: 5px 20px 5px 20px;
  background-color: #C0C0C0;
  border: 5;
  border-radius: 15px;
  box-shadow: 2px 2px 5px 1px #111111;
  color: #000040;
  width: 42%;
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
#cform{
  border: 2px groove #AAAFF4;
  border-radius: 4px;
  padding: 10px 20px;
  margin: 5px;
  width: 380px;
  background: #333333;
  color: #CC3300;
  text-align: center;
}
#cpcha{
  background-color: #666699;
  border-style: outset;
  border-width: medium;
  border-radius: 5px;
  width: 450px;
}
#updte{
  margin: 0 10px 0 10px;
  top: 0px;
}
</style>

<script language="JavaScript">
var t = false;
$(document).ready(function(){
  var t = new JsDatePick({
    useMode:2,
    isStripped:false,
    target:"godina",
    limitToToday:true,
    dateFormat:"%d.%m.%Y",
    selectedDate:{day:1,month:1,year:2000},
    cellColorScheme:"ocean_blue"
    });
  });
$(document).ready(function(){
  $(":text[name^='regnick']").blur(function(){
    if(isTaken('nicklist',":text[name^='regnick']")){
      $(":text[name^='regnick']").css("background-color","#FF5555");
      $("#popup").css("display","block");
      $("#popup").html("Zauzeto, promijenite nick.");
      $("#popup").css("left",$(":text[name^='regnick']").offset().left+160);
      $("#popup").css("top",$(":text[name^='regnick']").offset().top);
      temp = "regnick";
      }
    });
  $(":text[name^='regnick']").focus(function(){
    if(temp == "regnick") $("#popup").hide(400);
    });
  $(":password[name^='confirm']").blur(function(){
    if($(":password[name^='regpasswrd']").val().length>0 && $(":password[name^='regpasswrd']").val() != $(":password[name^='confirm']").val()){
      $(":password[name^='regpasswrd']").css("background-color","#FF5555");
      $(":password[name^='confirm']").css("background-color","#FF5555");
      $("#popup").css("display","block");
      $("#popup").html("Ne podudara se password!");
      $("#popup").css("left",$(":password[name^='confirm']").offset().left+160);
      $("#popup").css("top",$(":password[name^='confirm']").offset().top);
      temp = "confirm";
      }
    });
  $(":password[name^='confirm']").focus(function(){
    if(temp == "confirm")$("#popup").hide(400);
    });
  if(<?php if(isset($_COOKIE["accept"])) echo "true"; else echo "false";?>){
    $(":text[name^='recapcha']").css("background-color","#FF5555");
    $("#popup").css("display","block");
    $("#popup").html("Nije točan iznos !");
    $("#popup").css("left",$(":text[name^='recapcha']").offset().left+160);
    $("#popup").css("top",$(":text[name^='recapcha']").offset().top);
    temp = "recapcha";
    }  
  $(":text[name^='recapcha']").focus(function(){
    if(temp == "recapcha")$("#popup").hide(400);
    });
  
  });
  
function picswap(){
  if($("#file").val().length > 0 ) {
    var s = $("#file").val().split(".");
    $("#slika").val(s[s.length-1]);
    }
  else $("#slika").val("0");
  }

function SubmitForm(forma,errtarget,errout){
  var string = document.forms[forma];
  var errtext = "";
  var pswrd = string["regpasswrd"].value;
  var s = $("#idcapcha").val();
  t=true;
  var i = "regnick";
  if(isTaken('nicklist',":text[name^='regnick']")) {
    $(":text[name^='regnick']").css("background-color","#FF5555");
    errtext += "<p><b>Nick:</b> Naziv zauzet!</p><br>";
    t=false;
    }
  if(string[i].value.length > 30 || string[i].value.length < 4 || RegExp("[^a-z^A-Z^0-9/g]").test(string[i].value)) {
    $(":text[name^='regnick']").css("background-color","#FF5555");
    errtext += "<p><b>Nick:</b> 4-30 znakova: a-z, A-Z, 0-9 !</p><br>";
    t=false;
    }
  i = "regpasswrd";
  if(string[i].value.length > 16 || string[i].value.length < 4 || RegExp("[^a-z^A-Z^0-9/g]").test(string[i].value)) {
    $(":password[name^='regpasswrd']").css("background-color","#FF5555");
    errtext += "<p><b>Password:</b> 4-16 znakova: a-z, A-Z, 0-9 !</p><br>";
    t=false;
    }
  i = "confirm";
  if(string[i].value.length > 16 || string[i].value.length < 4 || RegExp("[^a-z^A-Z^0-9/g]").test(string[i].value)) {
    $(":password[name^='confirm']").css("background-color","#FF5555");
    errtext += "<p><b>Potvrdi Password:</b> 4-16 znakova: a-z, A-Z, 0-9 !</p><br>";
    t=false;
    }
  if(string[i].value != pswrd){
    $(":password[name^='confirm']").css("background-color","#FF5555");
    errtext += "<p><b>Nepududaranje passworda!</b></p><br>";
    t=false;
    }
  i = "email";
  var atpos=string[i].value.indexOf("@");
  var dotpos=string[i].value.lastIndexOf(".");
  if(atpos<1 || dotpos<atpos+2 || dotpos+2>=string[i].value.length) {
    $(":text[name^='email']").css("background-color","#FF5555");
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
  if($(":text[name^='recapcha']").val().length == 0 || data == "false"){
    $(":text[name^='recapcha']").css("background-color","#FF5555");
    errtext += "<p><b>Validacija:</b> iznos nije točan !</p><br>";
    t=false;
    }
  if(!t){
    $(errout).html("");
    $(errtarget).slideDown(400);
    $(errout).append(errtext);
    }
  return t;
  }
 function remakeC(){
  $.get("../data/updateC.php",function(data){$("#cform").html(data);});
  }
</script>
<form class="bodyform" id="regform" name="regbox" action="../data/SQL_in.php" onsubmit="return SubmitForm('regbox','#polerr','#errunos');"  enctype="multipart/form-data" method="post">
<div id="polu">
<p> 
<h1>Registracija</h1>
</p>
</div>
<div id="polr">
<p>
<h4>Bitno:</h4>
</p>
<hr>
<p><b>*Nick: </b></p>
<input id="nck" type="text" name="regnick" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
<p><b>*Password:</b></p>
<input type="password" name="regpasswrd" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
<p><b>*Potvrdi password:</b></p>
<input type="password" name="confirm" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
<p><b>*E-mail:</b></p>
<input type="text" name="email" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
<hr style="width: 100%">
<label>* Obavezno!</label>
</div>
<div id="poll">
<p>
<h4>Ostalo:</h4>
</p>
<hr>
<p><b>Ime: </b></p>
<input type="text" name="ime" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
<p><b>Prezime: </b></p>
<input type="text" name="prezime" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
<p><b>Godina rođenja: </b></p>
<input type="text" id="godina" name="godina" style="float:right; position:relative; margin: 0; left: 0px; top: -35px;" readonly>
<p><b>Adresa: </b></p>
<input type="text" name="adresa"style="float:right; position:relative; margin: 0; left: 0px; top: -35px;">
<hr style="width: 100%">
<label>:3</label>
</div>
<div id="pold">
<p>
<h4>Slika:</h4>
</p>
<hr>
<img class="profpic" id="tempslika" src="slike/profile/<?php echo $slika.".".$ext?>" style="float:right; margin: 0; left: 0px; top: -35px;">
<p><b>Datoteka: </b></p>
<p>(.jpg, .jpeg, .gif, .png, <2MB)</p>
<input type="hidden" id="slika" name="slika" value="0">
<input type="file" name="file" id="file" value="Biraj" accept="image/jpg,image/jpeg,image/gif,image/png" onchange="readURL(this,'#tempslika','slike/profile/User.jpg');picswap();" style="margin:5px;">
<br><br><br>
<hr>
</div>
<div id="polerr">
<h4>GREŠKA:</h4>
<hr style="width: 100%">
<div id="errunos"></div>
<hr style="width: 100%">
</div>
<div id="polu" align="center">
<p>Nakon ispravnog popunjavanja forme ostala je:</p>
<hr style="width: 100%">
<div id="cpcha">
<div class="capcha">
<p><label>Jednostavna spam zaštita:</label></p>
<p id="cform"><?php echo $cin;?></p>
<a href="" onclick="remakeC();return false" ><img id="updte" src="../slike/update.png"></a>
Rješenje bez decimala:<input type="text" id="idcapcha" name="recapcha">
</div>
</div>
<input type="submit" id="submit" name="submit" value="Registriraj"  style="margin:5px;" >
<input type="reset" name="reset" value="Reset" onclick="readURL(this,'#tempslika','slike/profile/User.jpg');" style="margin:5px;">
<hr style="width: 100%">
</div>
</form>

<?php
$logerr = 0;
$buff = array();
echo '<form name="nicklist">';
   $query= "SELECT nick FROM *PRIVATE*.korisnik WHERE 1";
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

