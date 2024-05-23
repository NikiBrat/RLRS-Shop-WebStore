<?php session_start(); 

  include "Konekcija.php";

if (isset($_SESSION['Ime'])) 
{
  if ($_SESSION['Admin']==True) 
  {

    if (isset($_GET['PaketID'])) 
    {
      $paket=$_GET['PaketID'];
    }

     $upit = "select * from paketusluga where PaketID=".$paket;

    if (!$rez=$mysqli->query($upit)) 
    {
      die("Greska: ".$mysqli->error);
    }

    $row=$rez->fetch_assoc();

    $naziv=$row['Naziv'];
    $cena=$row['Cena'];


    if(isset($_POST['dugme']))
    {
      $naziv=$_POST['NazivP'];
      $cena=$_POST['Cena'];

      $upit="Update paketusluga set Naziv='".$naziv."', Cena='".$cena."' where PaketID=".$paket;

      $rez = $mysqli->query($upit);

      if(!$rez)
      {
            $_SESSION['Ispis'] = "<script>alert('Bundle sa traženim ID-em ne postoji!')</script>";
        header("Location: dodajBundle.php");
      }
      else
      {
            $_SESSION['Ispis'] = "<script>alert('Uspešno ažuriranje Bundle-a!')</script>";
        header("Location: dodajBundle.php");
      } 
    }
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


 ?>
<!--Pocetak Forme -->

<div class="row mt-4">
    <div class="col-12">
      <h2>Izmeni podatke o Bundle-u</h2>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <form method="POST" action="#">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Unesite naziv paketa:</label>
      <input type="text" class="form-control" name="NazivP" id="inputEmail4" placeholder="Naziv paketa:" value="<?php echo $naziv ?>">
    </div>
  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Unesite cenu paketa:</label>
      <input type="text" class="form-control" name="Cena" id="inputEmail4" size="2" min="0" value="<?php echo $cena ?>">
    </div>
  </div>
  <div>
      <button type="submit" class="btn btn-primary btn-sm" name="dugme">Izmeni</button>
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
    $_SESSION['Ispis']='<script type="text/javascript">alert("Niste administrator sajta i ne mozete da menjate podatke o Bundle-u!!!");</script>';

    header("Location: dodajBundle.php");
  }
}
else
{
  $_SESSION['Ispis']='<script type="text/javascript">alert("Morate se ulogovati kao administrator!!!");</script>';

    header("Location: dodajBundle.php");
}

?>