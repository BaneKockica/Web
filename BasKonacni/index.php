<!DOCTYPE html>
<html lang="en">
<head>
  <title>BAS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="Bas.css">
 
</head>
<body>
  <div class="row">
    <nav class="navbar-top navbar navbar-inverse">
  	  <div class ="navbar-inner">
  		  <div class = "container metanav_container">
        <div class="col-md-6 bas">
  			  <img src="logo.jpg" width="72px" align="left">
          <div class="naslov">
          <p>BEOGRADSKA AUTOBUSKA STANICA</p>
          </div>
          </div>
          <div class="col-md-6 dog">
  		     <ul class="nav navbar-nav">
          </ul> 
          </div>
        </div>
      </div>	
    </nav>
  </div>
  <nav class="navbar  navbar-inverse meni" role="navigation">
    <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Početna</a></li>
          <li><a href="Onama.php">O nama</a></li>
          <li><a href="Bas.php">Bas</a></li> 
          <li><a href="Restoran.php">Restoran Golf</a></li>     
        </ul>
      
      </div>
    </div>
  </nav>
  <div class="container sadrzaj">
    <div class="row">
      <div class="col-md-4 levo">
        <div class="booking_mask">
            <div class="red text-center">
              <br><h1><strong>RED VOZNjE</strong></h1>
            </div>
            <div class="forma">
              <?php
              include "konekcija.php";
              ?>

              <form method="post" action="?akcija=unos">
                Mesto polaska:                
                <input type="text" name="mestoPolaska"><br><br>
                Destinacija:
                <input type="text" name="destinacija"><br><br>
                Datum polaska:
                <input type="date" name="datumPolaska"><br><br>
                  <input class="checkbox" type="checkbox" name="checkbox" id="chk" onclick="showHide()"/>
                  <label for="chk">Povratna karta</label>
                  <br><br>
                <label class="hidden">Datum povratka:</label>
                <input type="date" name="datumPovratka" id="datum" class="hidden"><br><br>
                <input type="submit" id="hide" class="btn btn-primary btn-block" name="unos" value="Pronađi"/>
              </form>
  
     
               



            </div>
        </div>     
        <div class="booking_mask1">
          <?php

              if (isset($_POST["unos"]))
              {
              //Prikupljanje podataka sa forme

                if (isset($_POST['checkbox'])) 
                {
                  if (isset($_POST['mestoPolaska'])&&isset($_POST['destinacija'])&&isset($_POST['datumPolaska'])&&isset($_POST['datumPovratka']))
                  {
                    $mestoPolaska = $_POST['mestoPolaska'];
                    $destinacija = $_POST['destinacija'];
                    $datumPolaska = $_POST['datumPolaska'];
                    $datumPovratka = $_POST['datumPovratka'];
                    $sql="SELECT PolazakIz, Destinacija, Datum, Vreme, CenaSaPopustom, Autobus, BrojSlobodnihMesta FROM relacija WHERE PolazakIz='$mestoPolaska' and Destinacija='$destinacija' and Datum='$datumPolaska'";
                    $sql1="SELECT PolazakIz, Destinacija, Datum, Vreme, CenaSaPopustom, Autobus, BrojSlobodnihMesta FROM relacija WHERE Destinacija='$mestoPolaska' and PolazakIz='$destinacija' and Datum='$datumPovratka'";
                    $upit = $db->query($sql);
                    $upit1 = $db->query($sql1);
                    $broj_redova = $upit->rowCount();
                    $broj_redova1 = $upit1->rowCount();
                      if ($broj_redova == 0 or $broj_redova1==0)
                      {
                        echo "<p>Nema podataka za dati kriterijum!</p>";
                      } 
                      else 
                      {
                        ?>
                        <h1>Prikaz</h1>
                        <hr/>
                        <table id="myTable">
                        <tr>
                        <td><b>Polazak iz</b></td>
                        <td><b>Destinacija</b></td>
                        <td><b>Datum polaska</b></td>
                        <td><b>Vreme polaska</b></td>
                        <td><b>Cena</b></td>
                        <td><b>Datum povratka</b></td>
                        <td><b>Vreme povratka</b></td>
                        </tr>
                        <?php
                        while ($red= $upit->fetch(PDO::FETCH_OBJ))
                        { 
                          if ($red->BrojSlobodnihMesta>0) 
                          {
                            if ($broj_redova1>1) {
                            ?>
                            <tr onclick="myFunction(this)">
                            <td><?php echo $red->PolazakIz; ?></td>
                            <td><?php echo $red->Destinacija; ?></td>
                            <td><?php echo $red->Datum; ?></td>
                            <td><?php echo $red->Vreme; ?></td>
                            <td><?php echo $red->CenaSaPopustom; ?></td>
                            <?php
                            while($red= $upit1->fetch(PDO::FETCH_OBJ))
                                {
                                  ?>
                                    <td><?php echo $red->Datum; ?></td>
                                    <td><?php echo $red->Vreme; ?></td>                       
                                  <?php
                                  break;
                                }
                                ?></tr><tr><?php
                                while ($red= $upit->fetch(PDO::FETCH_OBJ)) {
                                  ?>
                                  <td><?php echo $red->PolazakIz; ?></td>
                                  <td><?php echo $red->Destinacija; ?></td>
                                  <td><?php echo $red->Datum; ?></td>
                                  <td><?php echo $red->Vreme; ?></td>
                                  <td><?php echo $red->CenaSaPopustom; ?></td>
                                  <?php
                                while($red= $upit1->fetch(PDO::FETCH_OBJ))
                                  {
                                    ?>
                                      <td><?php echo $red->Datum; ?></td>
                                      <td><?php echo $red->Vreme; ?></td>                       
                                    <?php
                                    break;
                                  }
                                  break;
                                }
                                ?></tr><?php
                              }
                              else{

                                
                              }                            
                            break;                            
                            ?>

                            
                            <?php
                          }
                        }
                        ?>
                        </table>
                        <?php
                      }
                    $db = null;
                  }
                }
                else
                {
                  if (isset($_POST['mestoPolaska'])&&isset($_POST['destinacija'])&&isset($_POST['datumPolaska']))
                  {
                    $mestoPolaska = $_POST['mestoPolaska'];
                    $destinacija = $_POST['destinacija'];
                    $datumPolaska = $_POST['datumPolaska'];
                    $sql="SELECT PolazakIz, Destinacija, Datum, Vreme, Cena, Autobus, BrojSlobodnihMesta FROM relacija WHERE PolazakIz='$mestoPolaska' and Destinacija='$destinacija' and Datum='$datumPolaska'";
                    $upit = $db->query($sql);
                    $broj_redova = $upit->rowCount();
                      if ($broj_redova == 0)
                      {
                        echo "<p>Nema podataka za dati kriterijum!</p>";
                      } 
                      else 
                      {
                        ?>
                        <h1>Prikaz</h1>
                        <hr/>
                        <table id="myTable">
                        <tr>
                        <td><b>Polazak iz</b></td>
                        <td><b>Destinacija</b></td>
                        <td><b>Datum</b></td>
                        <td><b>Vreme</b></td>
                        <td><b>Cena</b></td>
                        </tr>
                        <?php
                        while ($red= $upit->fetch(PDO::FETCH_OBJ))
                        {
                          if ($red->BrojSlobodnihMesta>0) 
                          {
                               ?>
                          <tr class='clickable-row' data-href='url://link-for-first-row/'>
                          <td><?php echo $red->PolazakIz; ?></td>
                          <td><?php echo $red->Destinacija; ?></td>
                          <td><?php echo $red->Datum; ?></td>
                          <td><?php echo $red->Vreme; ?></td>
                          <td><?php echo $red->Cena; ?></td>
                          </tr>
                          <?php
                          }
                       
                        }
                        ?>
                        </table>
                        <?php
                      }
                    $db = null;
                  }

                }

              
              }
              ?>

              <!--Ovo sam pokusavao da izaberem red iz tabele i sacuvam ga kao rezervaciju i
               trebalo je da upadate-ujem u tabeli relacija brojSlobodnihMesta da smanjim za 1

                <form method="post" action="?akcija=unos2">
                Unesite redni broj iz tabele koji zelite da rezervisete!                
                <input type="text" name="id"><br><br>
                <input type="submit" class="btn btn-primary btn-block" name="rezervacija" value="Rezervisi" onclick="myFunction(id)"/>
              </form>
              <?php
                  if (isset($_POST["rezervacija"])){
                  //Prikupljanje podataka sa forme

                  if (isset($_POST['id'])){
                  $id = $_POST['id'];

                  //Operacije nad bazom
                  include "konekcija.php";
                  $sql="INSERT INTO relacija (PolazakIz, Destinacija, DatumPolaska) VALUES ()";
                  if ($db->exec($sql)){
                  echo "<p>rRezervacija je uspešno izvršena</p>";
                  } else {
                  echo "<p>Nastala je greška pri rezervaciji</p>";
                  }
                  } else {
                  //Ako POST parametri nisu prosleđeni
                  echo "Nisu uneli podatke!";
                  }
                  }
                  ?>
                  <script>
                  function myFunction() {
                      var x = document.getElementById("myTable").rows[id].cells.innerHTML;
                     
                  }
                  </script>
                  //-->



             
        </div>
        <div id="f1_container">
          <div id="f1_card" class="shadow">
            <div class="front face">
              <img src="pranje.jpg"/>
            </div>
            <div class="back face center">
              <p><STRONG>PRANJE I PARKIRANJE</STRONG></p>
              <p>Cene pranja.</p>
              <img src="pranje1.jpg">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8 desno">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <img src="bas1.jpg">
                <div class="el_slide_box text-center"<p><strong>NOVO!</strong> Prodaja polise putničkog zdravstvenog osiguranja za inostranstvo.</p>
                </div>
            </div>
            <div class="item">
              <img src="bas2.jpg">
                <div class="el_slide_box text-center"<p> Prodaja avio karata na šest mesečnih rata. </p>
                </div>
            </div>
            <div class="item">
              <img src="bas3.jpg">
                <div class="el_slide_box text-center"<p>Herceg Novi - FIRST MINUTE od 9€. </p>
                </div>
            </div>
          </div>
        </div>
          <div class="row">
            <div class="col-md-6 levo">
              <div class="booking_mask2">
                <h2>TURISTIČKI ARANŽMANI:</h2>
                <br>
                <ul> 
                  <li><a href="http://www.bas.rs/PDF2015/VrBanja%202015.pdf">Vrnjačka Banja</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/SokoBanja%202015.pdf">Sokobanja</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Prolom%20Banja%202015.pdf">Prolom Banja</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Lukovska%20Banja%202015.pdf">Lukovska Banja</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Vrdnik%20za%20penzionere%202015.pdf">Banja Vrdnik</a></li>
            		  <li><a href="http://www.bas.rs/PDF2015/Zlatibor%202015.PP.pdf">Zlatibor Čigota</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/NOVAKOV%20DVOR%202015.pdf">Zlatibor Novakov Dvor</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Tara%20%202015.pdf">Tara</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Hotel%20PEPA%202015.pdf">Divčibare</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Hotel%20JUNIOR%202015.pdf">Kopaonik</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Zlatibor%202015.program.pdf">Čigota 7 dana</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Banja%20Kanji%C5%BEa%202015.pdf">Kanjiža</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Banja%20Junakovic%202015.pdf">Apatin</a></li>
                  <li><a href="http://www.bas.rs/PDF2015/Niska%20Banja%202015.pdf">Niška Banja</a></li>
                  <li><a href="http://www.bas.rs/PDF2016/H.Novi-Hotel%20PLAZA%202016.pdf">Herceg Novi</a></li>                         
                  <li><a href="http://www.bas.rs/PDF2016/Canj-app%20LARA%202016.pdf">Čanj</a></li>                                    
                  <li><a href="http://www.bas.rs/PDF2016/Becici-Hotel%20ALET%202016.pdf">Bečići</a></li>                                   			
                  <li><a href="http://www.bas.rs/PDF2016/Dobre%20vode-app%20LARA-S%202016.pdf">Dobre vode</a></li>
                </ul><br>
              </div>
              <div id="f1_container">
                <div id="f1_card" class="shadow">
                  <div class="front face">
                    <img src="aranzman.jpg"/>
                  </div>
                  <div class="back face center">
                    <p><strong>TURISTICKI ARANZMANI</strong></p>
                    <p>Zlatibor Čigota 4000,00<br>
                      Zlatibor Novakov Dvor 5000,00<br>
                      Tara 3500,00<br>
                      Divčibare 3000,00<br>
                      Kopaonik 3500,00<br>
                      Čigota 7 dana 8000,00<br>
                      Kanjiža 4000,00<br>
                      Apatin 5000,00<br>
                      Niška Banja 4500,00<br>
                      Herceg Novi 5000,00<br>
                      Čanj 7000,00<br>
                      Bečići 8000,00<br>
                      Dobre vode 6500,00</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 Desno">
              <div id="sakri" class="booking_mask2">
                <div class="info">
                  <h2>INFO</h2>
                  <br>
                  <p><img src="parking.jpg">
                  <strong>KAKO DO NAS?</strong><br><br>
                  Autobuske linije: 46,51,78,83,91,92,<br>511,551,552,553,601,E1<br>
                  Tramvajske linije: 2,3,7,9,12,13<br>
                  Taxi stanica: 24h/7</p>
                  <br>
                  <p><img src="kafe.jpg">
                  <strong>PRE PUTA</strong><br><br>
                  Restorani, pekare, kiosci</p>
                  <br>
                </div>
              </div>
              <div id="f1_container">
                <div id="f1_card" class="shadow">
                  <div class="front face">
                    <img src="golf.jpg"/>
                  </div>
                  <div class="back face center">
                    <p><strong>RESTORAN GOLF - CENOVNIK</strong></p>
                    <p>Lignje na zaru 600,00 <br>
                      Pastrmka 1kg 1500,00<br>
                      Biftek na zaru 750,00<br>
                      Pilece belo punjeno 700,00<br>
                      Srpska salata 120,00 <br>
                      Sopska salata 150,00<br>
                      Zelena salata 100,00 <br>
                      Urnebes salata 120,00<br>
                      Pohovane palacinke 250,00<br>
                      Pohovani kackavalj 300,00</p>
                  </div>
                </div>
              </div>
            </div>
          </div>  	
      </div>      
    </div>       	
  </div>
      
      
      
  <footer class="footer">
    <div class="slikafuter">
      <img src="city.png">
    </div>
    <div class="row futer">
      <div class="col-md-4">
        <h3><strong>KONTAKT</strong></h3>
        <p>Železnička 4, 11000 Beograd, SRBIJA<br>
        Telefoni:
        Rezervacije 011/2636-299<br> 
        Centrala 011/6644-455<br>
        Knjigovodstvo 011/7621-463<br>
        Računovodstvo 011/7621-457<br><br><br>
        </p>
      </div>
      <div class="col-md-8">
        <div id="googleMap" style="height:200px;width:100%;"></div>
          <!-- Add Google Maps -->
         
          
      </div>
    </div>
  </footer>
</body>
<script type="text/javascript">
  function showHide(){

var checkbox=document.getElementById("chk");
var hiddeninputs = document.getElementsByClassName("hidden");

for (var i = 0; i != hiddeninputs.length; i++) {
    if (checkbox.checked) {
      hiddeninputs[i].style.display ="block";
    }
    else{
            hiddeninputs[i].style.display ="none";

    }
  }
}
</script>
        <script>
        $(document).ready(function(){
          $("#hide").click(function(){
            $("#myCarousel").hide();
          });

        });
        </script> 
        <script type="text/javascript">
    function myFunction(x) {
    alert("Row index is: " + x.rowIndex);
}
        </script>
 <script src="http://maps.googleapis.com/maps/api/js"></script>
          <script>
          var myCenter = new google.maps.LatLng(44.8092207, 20.455434,17);

          function initialize() {
          var mapProp = {
            center:myCenter,
            zoom:12,
            scrollwheel:false,
            draggable:false,
            mapTypeId:google.maps.MapTypeId.ROADMAP
          };

          var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

          var marker = new google.maps.Marker({
            position:myCenter,
          });

          marker.setMap(map);
          }

          google.maps.event.addDomListener(window, 'load', initialize);
          </script>
</html>