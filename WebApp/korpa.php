  <?php 
  session_start();
  include "Konekcija.php";
  ?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="style/css.css">
  <title>Pregled Korpe</title>

</head>
<body>
 <div class="container">
  <?php 

     include "izgled/slika.php";
     include "izgled/nav.php";
     ?>

  <div>
  <form method="POST" action="korpa.php">
    
<?php
 

 $ukupno =0;
 $korpa=0;
 if (isset($_POST['Kolicina'])) 
 {

  foreach ($_POST['Kolicina'] as $key => $value) 
  {
    $StavkaKorpeID=$key;
    $kol=$value;
  }

  if ($kol==0) 
  {
    $upit="Delete from sastavkorpe where StavkaKorpeID=".$StavkaKorpeID;

    $rez = $mysqli->query($upit);

    if(!$rez)
    {
      print('<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Obaveštenje</strong> Nemoguće je obrisati stavku u korpi, došlo je do greške!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
      die($mysqli->error);
    }
  }
  else
  {

    $upit="Update sastavkorpe set Kolicina='".$kol."' where StavkaKorpeID=".$StavkaKorpeID;

    $rez = $mysqli->query($upit);

    if(!$rez)
    {
       print('<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Obaveštenje</strong> Nemoguće je ažurirati količinu, došlo je do greške!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
      die($mysqli->error);
    }
  }
}
  if (isset($_SESSION['ID'])) 
  {

    $upit = "Select * from korpa k join sastavkorpe s on k.KorpaID=s.KorpaID 
    where k.KorisnikID=".$_SESSION['ID']." and k.Brisano=0"; 

    $rez=$mysqli->query($upit);

    $red=$rez->fetch_assoc();

    if ($red) 
    {
      $_SESSION['KorpaID'] = $red['KorpaID'];
    }

    $upit1 = "Select a.Naziv,s.KorpaID,s.StavkaKorpeID,s.SifraArtikala,s.Kolicina, a.Kolicina as kol, a.Cena from sastavkorpe s join artikli a on s.SifraArtikala=a.SifraArtikla where KorpaID=".$_SESSION['KorpaID'];

    $upit2 = "Select a.Naziv,s.KorpaID,s.StavkaKorpeID,s.Kolicina, a.Cena, a.PaketID from sastavkorpe s join paketusluga a on s.PaketID=a.PaketID where KorpaID=".$_SESSION['KorpaID'];

    $rez1 = $mysqli->query($upit1);
    $rez2 = $mysqli->query($upit2);

    if(!$rez1 && !$rez2)
    {
       print('<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Obaveštenje</strong> Korpa nije napravljena, došlo je do greške!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
      die($mysqli->error);
    }

    $message="<br>";

    if ($rez1->num_rows>0 || $rez2->num_rows>0) 
    {

      $message .= "<h4 class='boja'>Prikaz sastava korpe:</h4> <br>"
      ."<table class='table table-dark table-striped'>
      <th>Redni broj</th> 
      <th>Korpa ID</th>
      <th>Naziv</th>
      <th>Šifra Artikla</th>
      <th>Paket ID</th>
      <th>Količina</th>
      <th>Cena</th> 
      <th>Suma</th>
      <th>Memoriši</th> 
      </tr>";

      $brojac=0;
      $ukupno=0;
      $korpa=0;

      while ($row=$rez1->fetch_assoc()) 
      {

        $brojac++;
        $korpa=$row['KorpaID'];
        $ID = $row['StavkaKorpeID'];
        $kol = $row['Kolicina'];
        $maxKol = $row['kol'];
        $message .= "<tr>
        <form method='POST' action='korpa.php'>
        <td>".$brojac."</td>
        <td>".$row['KorpaID']."</td>
        <td>".$row['Naziv']."</td>
        <td>".$row['SifraArtikala']."</td>
        <td>-</td>
        <td><input type='number' name='Kolicina[".$row['StavkaKorpeID']."]' value='".$row['Kolicina']."' size='2' max='" . $maxKol ."'></td>
        <td>".$row['Cena']."</td>
        <td>".$row['Cena']*$row['Kolicina']."</td>
        <td><button class='btn btn-outline-primary' type='submit'>Zapamti</button></td>
        </form>
        </tr>";

      }



      while ($row=$rez2->fetch_assoc()) 
      {
        $brojac++;
        $korpa=$row['KorpaID'];
        $ID = $row['StavkaKorpeID'];
        $kol = $row['Kolicina'];
        $message .= "<tr>
        <form method='POST' action='korpa.php'>
        <td>".$brojac."</td>
        <td>".$row['KorpaID']."</td>
        <td>".$row['Naziv']."</td>
        <td>-</td>
        <td>".$row['PaketID']."</td>
        <td><input type='number' name='Kolicina[".$row['StavkaKorpeID']."]' value='".$row['Kolicina']."' size='2'></td>
        <td>".$row['Cena']."</td>
        <td>".$row['Cena']*$row['Kolicina']."</td>
        <td><button class='btn btn-outline-primary' type='submit'>Zapamti</button></td>
        </form>
        </tr>";

      }


      $message .= "</table><br>";
      if (isset($_POST['dugme'])) 
      {
        echo "";
      }
      else
      {
        echo $message;
      }
    }
    else
    {
      print('<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Obaveštenje</strong> Korpa je prazna!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
    }

    $upit="Select sum(Cena*Kolicina) as Suma, sum(Kolicina) as zbir from sastavkorpe where KorpaID=".$_SESSION['KorpaID'];

    $rez = $mysqli->query($upit);

    if(!$rez)
    {
      print('<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Obaveštenje</strong> Korpa nije napravljena, doslo je do greske!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
      die($mysqli->error);
    }

    $row=$rez->fetch_assoc();

    $ukupno=$row['Suma'];
    $brArt=$row['zbir'];

}
  
  

 if (isset($_POST['dugme'])) 
 {

      $upit="Update korpa set Brisano=1 where KorpaID=".$korpa;

      $rez = $mysqli->query($upit);

      if($rez)
      {
        echo '<script type="text/javascript">alert("Uspesno ste naručili vašu porudzbinu!!");</script>';
         header("Location: index.php");
      }
      else
      {
        print('<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Obaveštenje</strong> Došlo je do greške, neuspešno pokušaj naručivanja porudzbine!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        die($mysqli->error);
      }
 }

 

?>

<div>
  <label>Ukupna cena: <?php echo $ukupno; ?></label><br>
  <label>Broj porucenih artikala je: <?php echo $brArt; ?></label>
</div>
<div>
  <hr>
</div>
<div>
  <button type="submit" class='btn btn-outline-primary' name="dugme">Poruci</button>
</div>
 <br>
</form>
  </div>


<?php
  include "izgled/footer.php"; 
  ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
