<?php session_start(); 
require_once("Konekcija.php");
include ("prijemKolicineArtikla.php");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Web Prodavnica</title>
	<link rel="stylesheet" type="text/css" href="style/css.css">
</head>
<body>
<div class="container">
	<?php

  include "izgled/slika.php";

  $kl = new ClassKolicina();
  if (isset($_POST['cmd']) && $_POST['cmd'] == 3 && isset($_SESSION['ID']) && $_SESSION['ID']>0) {
  	$brart = $kl->pronadjiKolicinu();
  	$kl->memorisiNarucenArtikal();
  	echo "Kolicina ".$brart;
  }

  include "izgled/nav.php";
  


  $prikaz="Sve igre";
  $ispis = "Odaberi";

  if (isset($_POST['odaberi'])) 
  {
  	
  	$ispis=$_POST['odaberi'];

  	if ($ispis=="Odaberi") 
  	{
  	 		$prikaz='Sve igre';
  	}
 		 else
  	{
  			$prikaz=$ispis;
  	}
  }

  ?>
  <br>
  <form method="POST" action="indexartikal.php">
	<div>
		<label>Izaberite igru po kojoj zelite da prikazete artikle:</label>
		<select name="odaberi" class="btn btn-secondary dropdown-toggle">
			<option value="Odaberi" <?php if ($ispis == 'Odaberi') echo "selected" ?> >Sve igre</option>
			<option value="Rocket League" <?php if ($ispis == 'Rocket League') echo "selected" ?> >Rocket League</option>
			<option value="Valorant" <?php if ($ispis == 'Valorant') echo "selected" ?> >Valorant</option>
			<option value="League of Legends" <?php if ($ispis == 'League of Legends') echo "selected" ?> >League of Legends</option>
			<option value="Fortnite" <?php if ($ispis == 'Fortnite') echo "selected" ?> >Fortnite</option>
			<option value="Usluga" <?php if ($ispis == 'Usluga') echo "selected" ?> >Usluge</option>
		</select>
		<button type="submit" name="izaberi" class="btn btn-outline-light">Izaberi</button>
		&nbsp

<br><br>
<?php
   if (isset($_SESSION['Ispis'])) 
  {
    echo $_SESSION['Ispis'];
    $_SESSION['Ispis']="";
  }

?>


	</div>
</form>
  <?php

	$igra="";
	$naziv="";
	$opis="";
	$cena="";
	$Kolicina="";

  			
if (true)
//if (isset($_POST['izaberi'])) 
{
	$upit = "Select * From artikli";
	if (isset($_POST['odaberi'])) 
	{
		$odaberi=$_POST['odaberi'];
			if ($odaberi=='Odaberi') $upit = "Select * From artikli";
		else
			$upit = "Select * From artikli where Igra='".$odaberi."'";
	}
	$rez = $mysqli->query($upit);

		if(!$rez)
		{
			print("Nema artikala trenutno na stanju!");
			die($mysqli->error);
		}
			$brojac=0;
			$dugmeIzmeni = "";
			$dugmeBrisi = "";
			$nazivIgre = "";

			while ($row=$rez->fetch_assoc()) 
			{
			if (isset($_SESSION['Admin']) && $_SESSION['Admin']) {
				$dugmeIzmeni = '<a class="btn btn-outline-warning" href = "izmeniartikal.php?SifraArtikla=' . $row['SifraArtikla'] . '&cmd=1">Izmeni </a> &nbsp; ';
				$dugmeBrisi = '<a class="btn btn-outline-danger" href = "obrisiArtikal.php?SifraArtikla=' . $row['SifraArtikla'] . '&cmd=2"> Briši</a> &nbsp;';
			}
			$brojac++;
			$ispis1 = '<div class = "row1">
				<div>
				<a href = "#">
				<img src = "';
			$ispis2 = ' 
				" class="img-thumbnail" width="350px" height="350px">
				</a>
				<form method="post" action="indexartikal.php">
				<div class="ispis">
				<label name="naziv" id="naziv">'.$row['Naziv'].'</label> - 
				<label name="naziv" id="naziv">'.$row['Opis'].'</label><br>
				<label name="ispis" id="ispis">Cena: '.$row['Cena'].'</label><br>
				<label name="naziv" id="naziv">Kolicina: '.$row['Kolicina'].'</label><br>
				<input type="number" name="kol[' . $row['SifraArtikla'] . ']" value="0" size="1" min="0" max="' . $row['Kolicina'] . '">
				<br> <br>'
				. $dugmeIzmeni
				. $dugmeBrisi .
				' <button type="submit" class="btn btn-outline-success" name="art[' . $row['SifraArtikla'] . ']" >Dodaj u korpu</button>
				<input type="hidden" value="3" name="cmd">
				</form>
				</div>
				</div>
				</div>';
					switch ($row['Igra']) 
					{
						case 'Rocket League':
							echo $ispis1 . 'Slike/Credits.png' . $ispis2;
						break;

						case 'Valorant':
							echo $ispis1 . 'Slike/Valorant_Poeni.png' . $ispis2;
						break;

						case 'League of Legends':
							echo $ispis1 . 'Slike/LOL_Poeni.png' . $ispis2;
						break;

						case 'Fortnite':
							echo $ispis1 . 'Slike/Fortnite_V-Bucks.png' . $ispis2;
						break;

						case 'Usluga':
							echo $ispis1 . 'Slike/Buying.png' . $ispis2;
						break;

						default:
							echo $ispis1 . 'Slike/RLRS_SHOP.png' . $ispis2;
						break;
				}
				
			}
			if ($brojac==0) 
				{
					echo "Nema nijedan artikal u ponudi za ovaj filter!";
				}
}

include "izgled/footer.php" ;

if(isset($_SESSION['Ispis']) && $_SESSION['Ispis'] != ""){
  echo $_SESSION['Ispis'];
  $_SESSION['Ispis'] = "";
}


?>
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
