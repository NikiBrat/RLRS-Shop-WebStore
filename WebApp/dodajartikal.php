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
  <title>Dodaj Artikal</title>
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
      <h2 class="boja">Dodaj Artikal</h2>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <form method="POST" action="dodajartikal.php">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Naziv artikla:</label>
      <input type="text" class="form-control" name="Naziv" id="inputEmail4" placeholder="Unesite naziv artikla:">
    </div>
  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Opis artikla:</label>
      <input type="text" class="form-control" name="Opis" id="inputEmail4" placeholder="Unesite kratak opis artikla:">
    </div>
  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Naziv igre:</label>
      <input type="text" class="form-control" name="Igre" id="inputEmail4" placeholder="Unesite naziv igre:">
    </div>
  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Unesite buducu cenu artikla:</label>
      <input type="number" class="form-control" name="Cena" id="inputEmail4" placeholder="Buducu cenu artikla:" value="0" min="0">
    </div>
  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Buduca cena sa predefinisanim popustom:</label>
      <input type="number" class="form-control" name="Popust" id="inputEmail4" placeholder="Unesite buducu cenu sa popustom:" 
      value="0" min="0">
    </div>
  </div>
  <div class="row">
   <div class="form-group col-md-6">
    <div class='custom-control custom-switch'>
      <input type='checkbox' class='custom-control-input' id='customSwitch1'>
      <label class='custom-control-label' for='customSwitch1'>Da li je artikal usluga:</label>
    </div>
    </div>
  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Kolicina koja ce biti na stanju:</label>
      <input type="number" class="form-control" name="kolicina" id="inputEmail4" value="0" min="0">
    </div>
  </div>
  <div>
      <button type="submit" class="btn btn-primary btn-sm" name="dugme">Posaljite</button>
  </div>
  &nbsp
</form>
    </div>
  </div>
<?php 

if (isset($_POST['dugme'])) 
{
  if (!empty($_POST['Naziv']) && !empty($_POST['Opis']) && !empty($_POST['Igre']) && $_POST['Cena']>0 && 
    $_POST['Popust']>0 && !isset($_POST['usluga']) &&  $_POST['kolicina']>0) 
  {
     $upit = "Insert into artikli (Naziv,Opis,Igra,Cena,CenaSaPopustom,Usluga,Kolicina) 
     values ('".$_POST['Naziv']."','".$_POST['Opis']."','".$_POST['Igre']."','".$_POST['Cena']."','".$_POST['Popust']."'
     ,'".$_POST['usluga']."','".$_POST['kolicina']."')";

      if (!$rez=$mysqli->query($upit)) 
          {
            die("Greska: ".$mysqli->error);
          }
          else
          {
             echo '<script type="text/javascript">alert("Uspesno ste se kreirali novi artikal!!");</script>';
          }
  }
  elseif (!empty($_POST['Naziv']) && !empty($_POST['Opis']) && !empty($_POST['Igre']) && $_POST['Cena']>0 && 
    $_POST['Popust']>0 && isset($_POST['usluga']) &&  $_POST['kolicina']>0) 
  {
    $upit = "Insert into artikli (Naziv,Opis,Igra,Cena,CenaSaPopustom,Usluga,Kolicina) 
     values ('".$_POST['Naziv']."','".$_POST['Opis']."','".$_POST['Igre']."','".$_POST['Cena']."','".$_POST['Popust']."'
     ,'".$_POST['usluga']."','".$_POST['kolicina']."')";

      if (!$rez=$mysqli->query($upit)) 
          {
            die("Greska: ".$mysqli->error);
          }
          else
          {
             echo '<script type="text/javascript">alert("Uspesno ste se kreirali novu uslugu!!");</script>';
          }
  }
  else
  {
     echo '<script type="text/javascript">alert("Morate uneti bitna polja kako bi ste napravili artikal!!");</script>';
  }
}

include "izgled/footer.php"; ?>
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
    $_SESSION['Ispis']='<script type="text/javascript">alert("Niste administrator sajta i ne mozete da kreirate artikle!!!");</script>';

    header("Location: index.php");
  }
}
else
{
  $_SESSION['Ispis']='<script type="text/javascript">alert("Morate se ulogovati kao administrator!!!");</script>';

    header("Location: index.php");
}

?>