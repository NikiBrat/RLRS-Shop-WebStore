<?php session_start(); 

if (isset($_SESSION['Ime'])) 
{
  if ($_SESSION['Admin']==True) 
  {
    ?>

    <!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Izmeni Bundle</title>
  <link rel="stylesheet" type="text/css" href="style/css.css">
</head>
<!--Treba napraviti kod za Log in sa sesijama-->
<body>
<div class="container">
  <?php 
  
  include "izgled/slika.php";

  include "izgled/nav.php";

  include "Konekcija.php";
 ?>
<!--Pocetak Forme -->

<div class="row mt-4">
    <div class="col-12">
      <h2>Detalji Bundle-a</h2>
      <hr>
    </div>
  </div>
  <div class="row">
    <div>
      <form method="POST" action="ubaciUBundle.php">

      <?php 


      $paket="";
      $sifra="";

      if (isset($_GET['PaketID'])) 
      {


// ---------------------------------------------------------------------------------------
                    // Kod za ispis paketa podataka o paketu 


        $paket=$_GET['PaketID'];
      
        $upit = "Select * from paketusluga where PaketID=".$paket;

        $rez = $mysqli->query($upit);

      if(!$rez)
            {
                print("Nema paketa trenutno u ponudi!");
                die($mysqli->error);
            }
                    $message="";
                    if ($rez->num_rows>0) 
                    {

                        $message .= "<h4>Prikaz paketa:</h4> <br>"
                        ."<table class='table table-dark table-striped' border='1px'> 
                        <th>ID Paket</th>
                        <th>Naziv</th>
                        <th>Cena</th>
                        </tr>";
                        while ($row=$rez->fetch_assoc()) 
                        {
                            $ID = $row['PaketID'];

                            $message .= "<tr>
                            <td>".$row['PaketID']."</td>
                            <td>".$row['Naziv']."</td>
                            <td>".$row['Cena']."</td></tr>";
                        }
                        $message .= "</table><br>";
                        echo $message;
                    }
                    else
                    {
                        echo "Nema Paketa u ponudi trenutno!";
                    }
}

// ---------------------------------------------------------------------------------------
                    // Kod za ispis artikala koji ce se upisati u trenutnom paketu

                    if (isset($_POST['dodaj'])) 
                    {

                      if (isset($_GET['SifraArtikla'])) 
                      {

                        $sifra=$_GET['SifraArtikla'];

                        $upit = "Insert into sastavpaketa (PaketID,SifraArtikla,Kolicina) values
                        ('".$paket."','".$sifra."','1')";

                        $rez = $mysqli->query($upit);

                        if(!$rez)
                        {
                          print("Nema artikala trenutno na stanju!");
                          die($mysqli->error);
                        }

                      }
                    }

                      $upit="Select * from artikli a join sastavpaketa s 
                      on a.SifraArtikla=s.SifraArtikla where PaketID='".$paket."'";

                      $rez = $mysqli->query($upit);

              if(!$rez)
                {
                    print("Nema artikala trenutno na stanju!");
                    die($mysqli->error);
                }     

                $message="";
                    if ($rez->num_rows>0) 
                    {

                        $message .= "<h4>Prikaz artikala koji su u paketu:</h4> <br>"
                        ."<table class='table table-dark table-striped' border='1px'> 
                        <th>Sifra Artikla</th>
                        <th>Naziv</th>
                        <th>Opis</th>
                        <th>Igra</th>
                        <th>Cena</th>
                        <th>Cena Sa Popustom</th>
                        <th>Usluga</th>
                        <th>Kolicina</th>
                        </tr>";

                        $usluga="";
                        while ($row=$rez->fetch_assoc()) 
                        {

                          if ($row['Usluga']) 
                          {
                            $usluga='checked';
                          }

                            $ID = $row['SastavID'];

                            $message .= "<tr>
                            <td>".$row['SifraArtikla']."</td>
                            <td>".$row['Naziv']."</td>
                            <td>".$row['Opis']."</td>
                            <td>".$row['Igra']."</td>
                            <td>".$row['Cena']."</td>
                            <td>".$row['CenaSaPopustom']."</td>
                            <td><input type='checkbox' ".$usluga.">Usluga</input></td>
                            <td>".$row['Kolicina']."</td>
                            <td><a name='izbaci' href='ubaciUBundle.php?SastavID=".$ID."'>Izbaci</a></td>
                            </tr>";
                        }
                        $message .= "</table><br>";
                        echo $message;
                    }
                    else
                    {
                        echo "Nema artikala koji pripadaju ovom paketu!";
                    }
                  
// ---------------------------------------------------------------------------------------
                    // Kod za ispis artikala koji nisu ni u jednom paketu 

                    if (isset($_POST['izbaci'])) 
                    {
                      if (isset($_GET['SastavID'])) 
                      {

                        $upit = "delete * from sastavpaketa where SastavID=".$_GET['SastavID'];

                        $rez = $mysqli->query($upit);

                        if(!$rez)
                        {
                          print("Nema artikala trenutno na stanju!");
                          die($mysqli->error);
                        }
                      }                          
                    }

              $upit = "select * from artikli where SifraArtikla not in 
              (select SifraArtikla from sastavpaketa where PaketID='".$paket."')";

              $rez = $mysqli->query($upit);

              if(!$rez)
                {
                    print("Nema artikala trenutno na stanju!");
                    die($mysqli->error);
                }     

                $message="";
                    if ($rez->num_rows>0) 
                    {

                        $message .= "<h4>Prikaz artikala koji nisu u ovom paketu:</h4> <br>"
                        ."<table class='table table-dark table-striped' border='1px'> 
                        <th>Sifra Artikla</th>
                        <th>Naziv</th>
                        <th>Opis</th>
                        <th>Igra</th>
                        <th>Cena</th>
                        <th>Cena Sa Popustom</th>
                        <th>Usluga</th>
                        <th>Kolicina</th>
                        </tr>";

                        $usluga="";
                        while ($row=$rez->fetch_assoc()) 
                        {

                          if ($row['Usluga']) 
                          {
                            $usluga='checked';
                          }

                            $ID = $row['SifraArtikla'];

                            $message .= "<tr>
                            <td>".$row['SifraArtikla']."</td>
                            <td>".$row['Naziv']."</td>
                            <td>".$row['Opis']."</td>
                            <td>".$row['Igra']."</td>
                            <td>".$row['Cena']."</td>
                            <td>".$row['CenaSaPopustom']."</td>
                            <td><input type='checkbox' ".$usluga.">Usluga</input></td>
                            <td>".$row['Kolicina']."</td>
                            <td><a name='dodaj' href='ubaciUBundle.php?SifraArtikla=".$ID."'>Dodaj</a></td>
                            </tr>";
                        }
                        $message .= "</table><br>";
                        echo $message;
                    }
                    else
                    {
                        echo "Nema artikala,dogodila se neka greska!";
                    }
      
       ?>
  <div>
      <button type="submit" class="btn btn-primary btn-sm" name="dugme">Memorisi izmene</button>
  </div>
  &nbsp
</form>
    </div>
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

    <?php 
  }
  else
  {
    $_SESSION['Ispis']='<script type="text/javascript">alert("Niste administrator sajta i nemate prava pristupa na ovoj strani!!!");</script>';

    header("Location: index.php");
  }
}
else
{
  $_SESSION['Ispis']='<script type="text/javascript">alert("Morate se ulogovati kao administrator!!!");</script>';

    header("Location: index.php");
}

?>