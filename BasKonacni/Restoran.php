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
 <style>
.desno{
  height: 1000px !important;
}
.booking_mask2{
  
  height: 880px !important;
}
 </style>
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

             
        </div>
       
      </div>
      <div class="col-md-8 desno">
        <div class="booking_mask2">
            <div class="booking_mask_header">
                 <h2>RESTORAN GOLF</h2>
                      <p>U Košutnjaku, najlepšem delu Beograda, okružen šumom i tišinom, na svega 10 kilometara od centra grada, nalazi se restoran Golf. 
                      <br>Izgrađen je 1936. godine. Zbog izuzetne i autentične arhitektonske vrednosti, objekat je stavljen pod zaštitu države. Koncepcijski i stilski počiva na principima tradicionalnog izraza.
              
              <br><br>Danas, restoran Golf pripada samom vrhu beogradskog ugostiteljstva. Enterijer restorana odiše toplinom i prisnošću, a s proleća, najlepša ugostiteljska bašta u Beogradu, savršeno poprima boje i miris Košutnjaka. <br>Večernje sate ispunjavaju prijatni muzički tonovi i rado slušani starogradski melos. Restoran nudi raznovrsne specijalitete po povoljnim cenama i vrhunsku uslugu.

              <br><br><strong>Klimatizovana sala od 250 mesta je prilagođena za organizaciju svadbi, ispraćaja, maturskih večeri, rođendana, poslovnih ručkova, umetničkih okupljanja i drugih skupova.

             <br><br>U periodu od prvog maja do kraja septembra radi bašta kapaciteta 250 mesta.</strong>

            <br><br>Radno vreme restorana je od 9h do 24h sa mogućnošću produženja.
             
             <br><br>Restoran poseduje veliki sopstveni parking.
             
             <br><br>Telefon restorana Golf: 011/ 3540-263  355-43-48</p></div></div>
             
             




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