<form method="POST" action="#">

<?php 

include "Konekcija.php";


if (isset($_GET['StavkaKorpeID']) && isset($_POST['kolicina'])) 
  {
    $kol=$_POST['kolicina'];

    echo $kol;

    $upit="Update sastavkorpe set Kolicina='".$kol."' where StavkaKorpeID=".$_GET['StavkaKorpeID'];

    $rez = $mysqli->query($upit);

    if(!$rez)
    {
      print("Ne moguce je ažurirati količinu, došlo je do greške!");
      die($mysqli->error);
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

  $upit = "Select a.Naziv,s.KorpaID,s.StavkaKorpeID,s.SifraArtikala,s.PaketID,s.Kolicina,a.Cena from sastavkorpe s join artikli a on s.SifraArtikala=a.SifraArtikla where KorpaID=".$_SESSION['KorpaID'];

  $rez = $mysqli->query($upit);

  if(!$rez)
  {
    print("Korpa nije napravljena, doslo je do greske!");
    die($mysqli->error);
  }


  $message="<br>";

  if ($rez->num_rows>0) 
  {

    $message .= "<h4>Prikaz sastava korpe:</h4> <br>"
    ."<table class='table table-dark table-striped' border='1px'>
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

    while ($row=$rez->fetch_assoc()) 
    {

      $brojac++;

      $ID = $row['StavkaKorpeID'];

      $kol = $row['Kolicina'];

      $message .= "<tr>
      <td>".$brojac."</td>
      <td>".$row['KorpaID']."</td>
      <td>".$row['Naziv']."</td>
      <td>".$row['SifraArtikala']."</td>
      <td>".$row['PaketID']."</td>
      <td><input type='number' name='kolicina' value='".$row['Kolicina']."' size='2'></td>
      <td>".$row['Cena']."</td>
      <td>".$row['Cena']*$row['Kolicina']."</td>
      <td><a name='zapamti' href='korpa.php?StavkaKorpeID=".$row['StavkaKorpeID']."'>Zapamti</a></td>
      </tr>";

    }
    $message .= "</table><br>";
    echo $message;

  }
  else
  {
    echo "Nema Korpe! Dogodila se greška!";
  }

  $upit="Select sum(Cena*Kolicina) as Suma from sastavkorpe where KorpaID=".$_SESSION['KorpaID'];

  $rez = $mysqli->query($upit);

  if(!$rez)
  {
    print("Korpa nije napravljena, doslo je do greske!");
    die($mysqli->error);
  }

  $row=$rez->fetch_assoc();

  $ukupno=$row['Suma'];
}

?>
<div class="container">
  <label>Ukupna cena: <?php echo $ukupno; ?></label>
  <br>
  <hr>
  <br>
  <button type="submit" name="dugme">Poruci</button>
  <br>
  <br>
</div>
</form>