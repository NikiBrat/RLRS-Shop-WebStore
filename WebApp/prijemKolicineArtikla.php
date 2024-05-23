<?php

class ClassKolicina {

	public $SifraArtikla = 0;
	public $PaketID = 0;
	public $kolicina = 0;



	function pronadjiKolicinu() : int {
		$kolicina1 = 0;
		$korisnikId = $_SESSION['ID'];
		if (!isset($_SESSION['BrArt'])) $_SESSION['BrArt'] = 0;
		if (isset($_POST['kol']))
		{
			foreach ($_POST['kol'] as $key => $value) {
				$this->SifraArtikla = $key;
				$this->kolicina = $value;
				$kolicina1 = $value;
			}
		}
		return $kolicina1;
	}


	function memorisiNarucenArtikal() {
		$korisnikId = 0;
		require("Konekcija.php");
		if (isset($_POST['cmd']) && $_POST['cmd'] == 3 && isset($_SESSION['ID']) && $_SESSION['ID']>0) {
			$kolicina = $this->pronadjiKolicinu();
			$this->kolicina=$kolicina;
			//$PaketID = $_POST['PaketID'];
			if (isset($_SESSION['KorpaID'])) $KorpaID = $_SESSION['KorpaID']; else $KorpaID = 0;
			$datum = date("Y-m-d");
			$vreme = date("h:i");
			$novaKol=0;
			$_SESSION['BrArt'] += $kolicina;
			if ($KorpaID == 0) {
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

			if ($KorpaID > 0 && $this->kolicina > 0) {
				$upit = "SELECT * FROM artikli WHERE SifraArtikla = ". $this->SifraArtikla . ";";
				$rez=$mysqli->query($upit);
				$red=$rez->fetch_assoc();
				if ($red) {
					$cena = $red['Cena'] ;
					$stariLager = $red['Kolicina'] ;
				} 
				else {
					$cena = 0;
					$stariLager = 0;
				}

				$upit = "SELECT * FROM sastavkorpe WHERE KorpaID = ". $KorpaID . " AND SifraArtikala = " . $this->SifraArtikla;
				$rez=$mysqli->query($upit);
				$red=$rez->fetch_assoc();
				echo $upit . "<br>";
				if ($red) {
					$kol1 = 0;
					$kol2 = 0;
					$kol1 = (int)$this->kolicina;
					$kol2 = (int)$red['Kolicina'];
					$novaKol = $kol1 + $kol2;
					$StavkaKorpeID = $red['StavkaKorpeID'];
					echo "<br>".$this->kolicina ." ". $red['Kolicina']."<br>";
					$upit = "UPDATE sastavkorpe SET Kolicina =" . $novaKol . " WHERE StavkaKorpeID = " . $StavkaKorpeID;
				}
				else 
				{
					$upit = "Insert into sastavkorpe (KorpaID, SifraArtikala, PaketID, Kolicina, Cena) VALUES 
					(".$KorpaID. ", ".$this->SifraArtikla. ", ". $this->PaketID. ", " . $novaKol . ", " . $cena. ") ;";
					echo $upit . "<br>";
				}
				
				$rez=$mysqli->query($upit);
				if ($rez) {
					// Umanjenje stanja na lageru
					$kol1 = 0;
					$kol2 = 0;
					$kol1= (int)$stariLager;
					$kol2 = (int)$this->kolicina;
					$novaKol = $kol1 - $kol2;
					$upit = "UPDATE artikli SET kolicina = " . $novaKol . " WHERE SifraArtikla = " . $this->SifraArtikla .";" ;
					$rez=$mysqli->query($upit);

					$_SESSION['Ispis'] = 	'<div class="alert alert-success alert-dismissible" role="alert">
	  					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  					<strong>Uspešno! </strong> Artikal je dodat u korpu.
						</div>';
				}
				else {
					$_SESSION['Ispis'] = 	'<div class="alert alert-danger alert-dismissible" role="alert">
	  					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  					<strong>Uspešno! </strong> Greška kod dodavanja artikla.
						</div>';
				}
			}
		}
		 else {
		 	if ((isset($_POST['cmd']) && $_POST['cmd'] == 3) && (!isset($_SESSION['ID']) || $_SESSION['ID']<=0)) {
		 		$_SESSION['Ispis'] =  '<div class="alert alert-danger alert-dismissible" role="alert">
		  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  		<strong>Greška! </strong> Kupovina je omogućena samo registrovanim korisnicima 
				</div>';
		 	}
		 }
	}


			

	 

}

?>