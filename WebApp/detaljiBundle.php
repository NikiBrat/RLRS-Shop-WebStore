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
      <h2 class="boja">Detalji Bundle-a</h2>
      <hr>
    </div>
  </div>
  <div>
    <div>
      <form method="POST" action="detaljiBundle.php">

      &nbsp
      <div>
        <a href="izmeniBundle.php" class="btn btn-primary btn-sm" name="dugme">Izmeni Paket</a>
      </div>  

      &nbsp
      &nbsp

      <?php 


      $paket="";
      $sifra="";

      if (isset($_GET['PaketID'])) 
      {

// ---------------------------------------------------------------------------------------
                    // Kod za ispis paketa podataka o paketu 


        $paket=$_GET['PaketID'];
        $_SESSION['PaketID']=$paket;
      
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

                        $message .= "<h4 class='boja'>Prikaz paketa:</h4> <br>"
                        ."<table class='table table-dark table-striped'> 
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
                        print('<div class="alert alert-primary alert-dismissible fade show" role="alert">
                      <strong>Obaveštenje</strong> Nema Paketa u ponudi trenutno!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                      </div>');
                    }


// ---------------------------------------------------------------------------------------
                    // Kod za ispis artikala koji ce nalaze u paketu

                      $upit="Select * from artikli a join sastavpaketa s 
                      on a.SifraArtikla=s.SifraArtikla where PaketID='".$paket."'";

                      $rez = $mysqli->query($upit);

              if(!$rez)
                {
                    print('<div class="alert alert-primary alert-dismissible fade show" role="alert">
                      <strong>Obaveštenje</strong> Nema artikala trenutno na stanju!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                      </div>');
                    die($mysqli->error);
                }     

                $message="";
                    if ($rez->num_rows>0) 
                    {

                        $message .= "<h4 class='boja'>Prikaz artikala koji su u paketu:</h4> <br>"
                        ."<table class='table table-dark table-striped'> 
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
                            <td><div class='custom-control custom-switch'>
                            <input type='checkbox' ".$usluga." class='custom-control-input' disabled id='customSwitch1'>
                            <label class='custom-control-label' for='customSwitch1'>Toggle this switch element</label>
                            </div></td>
                            <td>".$row['Kolicina']."</td>
                            </tr>";
                        }
                        $message .= "</table><br>";
                        echo $message;
                    }
                    else
                    {
                      echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                      <strong>Obaveštenje</strong> Nema artikala koji pripadaju ovom paketu!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                      </div>';

                    }

            }
       ?>

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