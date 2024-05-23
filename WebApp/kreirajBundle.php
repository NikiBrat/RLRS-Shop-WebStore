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
  <title>Kreiraj Bundle</title>
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
      <h2 class="boja">Kreiraj Bundle</h2>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <form method="POST" action="kreirajBundle.php">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Unesite naziv paketa:</label>
      <input type="text" class="form-control" name="NazivP" id="inputEmail4" placeholder="Naziv paketa:">
    </div>
  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Unesite cenu paketa:</label>
      <input type="number" class="form-control" name="Cena" id="inputEmail4" size="2" min="0" value="0">
    </div>
  </div>
  <div>
      <button type="submit" class="btn btn-primary btn-sm" name="dugme">Kreiraj Paket</button>
  </div>
  &nbsp
</form>
    </div>
  </div>
<?php 

if (isset($_POST['dugme'])) 
{
  if (!empty($_POST['NazivP']) && ($_POST['Cena'])>0) 
  {
     $upit = "Insert into paketusluga (Naziv,Cena) 
     values ('".$_POST['NazivP']."','".$_POST['Cena']."')";

      if (!$rez=$mysqli->query($upit)) 
          {
            die("Greska: ".$mysqli->error);
          }
          else
          {
             echo '<script type="text/javascript">alert("Uspesno ste se kreirali novi Bundle!!");</script>';
          }
  }
  else
  {
     echo '<script type="text/javascript">alert("Morate uneti bitna polja kako bi ste napravili Bundle!!");</script>';
  }
}

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
    $_SESSION['Ispis']='<script type="text/javascript">alert("Niste administrator sajta i ne mozete da kreirate Bundle!!!");</script>';

    header("Location: index.php");
  }
}
else
{
  $_SESSION['Ispis']='<script type="text/javascript">alert("Morate se ulogovati kao administrator!!!");</script>';

    header("Location: index.php");
}

?>