<ul>
<li class="row"><a href="?pocetna">POČETNA</a></li>
<li class="row"><a href="?info">INFO <img src="<?php echo $img;?>"></a>
  <ul>
  <li class="row1"><a href="?infoKraky">Filip Kraus</a></li>
  </ul>
</li>
<li class="row"><a href="?hobi">O MENI<img src="<?php echo $img;?>"></a>
  <ul>
  <li class="row1"><a href="?hobiKraky">OMILJEN HOBI<img style="" src="slike/left_w.png"></a>
    <ul>
    <li class="row2"><a href="?airsoft">Airsoft</a></li>
    <li class="row2"><a href="?aikido">Aikido</a></li>
    </ul>
  </li>
  <li class="row1"><a>PROJEKTI<img style="" src="slike/left_w.png"></a>
    <ul>
    <li class="row2"><a href="http://projectmultimedija.biz.ht/diplomski/">Diplomski rad</a></li>
    <li class="row2"><a href="http://projectmultimedija.biz.ht/vizualizacija/">Sunčev sustav</a></li>
    </ul>
  </li>
  </ul>
</li>
<li class="row"><a href="?ostalo">OSTALO <img style="" src="<?php echo $img;?>"></a>
  <ul>
  <li class="row1"><a href="?slike">SLIKE<img style="" src="slike/left_w.png"></a>
    <ul>
    <li class="row2"><a href="?slikeAirsoft">Airsoft</a></li>
    <li class="row2"><a href="?slikeAikido">Aikido</a></li>
    </ul>
  </li>
  <li class="row1"><a href="?audioPlay">RADIO PLAYER</a></li>
  <li class="row1"><a href="?chat">CHAT</a></li>
  <li class="row1"><a href="?korisnici">KORISNICI</a></li>
  </ul>
</li>
<li class="row"><a href="?kontakt">KONTAKT</a></li>
<?php
if($loginz)
        echo '<li class="row"><a href="?profil">PROFIL</a></li>';
else
        echo '<li class="row"><a href="?register">PRIJAVA</a></li>';
if($tr)
echo '<li id="gback"><a href="#">^GORE^</a></li>';
?>
</ul>