<?php session_start(); 

    ?>

    <!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Kreiraj Bundle</title>
  <link rel="stylesheet" type="text/css" href="style/css.css">
</head>
<!--Treba napraviti kod za Log in sa sesijama-->
<body>
<div class="container">
  <?php 
  
  include "izgled/slika.php";
  include "Konekcija.php";

       if (isset($_GET['dodaj'])) {
        // Dodavanje bundle u korpu
        $PaketID = 0;
        $korisnikId = 0;
        $KorpaID = 0;
        $cena = 0;
        $kolicina = 1;
        $novaKol = 1;
        if (isset($_GET['PaketID'])) $PaketID = $_GET['PaketID'];
        if (isset($_SESSION['ID'])) $korisnikId = $_SESSION['ID'];
        if (isset($_SESSION['KorpaID'])) $KorpaID = $_SESSION['KorpaID'];
        if ($KorpaID == 0) {
          // Ako korisnik nema otvorenu porudžbinu, otvaramo je (kreiramo praznu korpu)
          $datum = date("Y-m-d");
          $vreme = date("h:i");
          $upit = "Insert into korpa (KorisnikID, Datum, Vreme, Brisano)  
          values ('".$korisnikId."','".$datum."','".$vreme."', 0);";
          $rez=$mysqli->query($upit);
          if ($rez) {
            $upit = "select * from korpa where KorisnikID=" . $korisnikId . " AND Brisano = 0;";
            $rez=$mysqli->query($upit);
            $red=$rez->fetch_assoc();
            if ($red) $KorpaID = $red['KorpaID']; else $KorpaID = 0;
            $_SESSION['KorpaID'] = $KorpaID;
          }
        }

      if ($KorpaID > 0) {
        $upit = "SELECT * FROM paketUsluga WHERE PaketID = ". $PaketID . ";";
        $rez=$mysqli->query($upit);
        $red=$rez->fetch_assoc();
        if ($red) {
          $cena = $red['Cena'] ;
        }
        $upit = "SELECT * FROM sastavkorpe WHERE KorpaID = ". $KorpaID . " AND PaketID = " . $PaketID;
        $rez=$mysqli->query($upit);
        $red=$rez->fetch_assoc();
        if ($red) {
          $novaKol = $kolicina + $red['Kolicina'];
          $StavkaKorpeID = $red['StavkaKorpeID'];
          $upit = "UPDATE sastavkorpe SET Kolicina =" . $novaKol . " WHERE StavkaKorpeID = " . $StavkaKorpeID;
        }
        else 
        {
          $upit = "Insert into sastavkorpe (KorpaID, SifraArtikala, PaketID, Kolicina, Cena) VALUES 
          (".$KorpaID. ", 0, ". $PaketID. ", " . $novaKol . ", " . $cena. ") ;";
        }
        $rez=$mysqli->query($upit);
        if ($rez) {
          if (isset($_SESSION['BrArt'])) $_SESSION['BrArt'] += 1; else $_SESSION['BrArt'] = 1;
          $_SESSION['Ispis'] =  '<div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Uspešno! </strong> Paket je dodat u korpu.
            </div>';
        }
        else {
          $_SESSION['Ispis'] =  '<div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Uspešno! </strong> Greška kod dodavanja paketa.
            </div>';
        }
      }        
    }


  include "izgled/nav.php";
 


 ?>
<!--Pocetak Forme -->

<div class="row mt-10">
    <div class="col-12">
      <br>
      <h2 class="boja">Bundle (Paketi)</h2>
      <hr>
    </div>
  </div>
  <div>
    <form method="POST" action="kreirajBundle.php">
      <div>
        <button type="submit" name="kreiraj" class="btn btn-outline-primary">Kreiraj novi Bundle</button>
      </div>
      &nbsp
      &nbsp

      <?php 


if(isset($_SESSION['Ispis']) && $_SESSION['Ispis'] != ""){
  echo $_SESSION['Ispis'];
  $_SESSION['Ispis'] = "";
}


      $upit = "select * from paketusluga";
      $rez = $mysqli->query($upit);

      if(!$rez)
            {
                print("Nema paketa trenutno u ponudi!");
                die($mysqli->error);
            }
                    $message="";
                    if ($rez->num_rows>0) 
                    {

                        $message .= "<h4 class='boja'>Prikaz paketa:</h4> <br>"
                        ."<table class='table table-dark table-striped'> 
                        <th>ID Paket</th>
                        <th>Naziv</th>
                        <th>Cena</th>
                        <th>Operacije</th>
                        <th>Kupovina</th>
                        </tr>";
                        while ($row=$rez->fetch_assoc()) 
                        {
                            $ID = $row['PaketID'];

                            $message .= "<tr>
                            <td>".$row['PaketID']."</td>
                            <td>".$row['Naziv']."</td>
                            <td>".$row['Cena']."</td>
                            <td>
                            <a class='btn btn-outline-warning' href='izmeniPodatkeBundle.php?PaketID=".$ID."'>Izmeni</a>
                            <a class='btn btn-outline-primary' href='detaljiBundle.php?PaketID=".$ID."'>Detalji</a>
                            <a class='btn btn-outline-danger' href='obrisiBundle.php?PaketID=".$ID."'>Obrisi</a>
                            <td><a class='btn btn-outline-success' href='dodajBundle.php?PaketID=".$ID."&dodaj=1'>U korpu</a></td>
                            </td>";
                        }
                        $message .= "</table><br>";
                        echo $message;
                    }
                    else
                    {
                        echo "Nema Paketa u ponudi trenutno!";
                    }
       ?>
    </form>
  </div>
<?php 

include "izgled/footer.php"; 



?>
</div>
<br>
<br>
<br>
<br>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>