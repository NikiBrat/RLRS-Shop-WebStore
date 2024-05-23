<?php session_start(); 

include "Konekcija.php";

$naziv="";
$opis="";
$igra="";
$cena="";
$cenapop="";
$usluga="";
$kolicina="";
$artikal="";

if (isset($_SESSION['Ime'])) 
{
  if ($_SESSION['Admin']) 
  {
    if (isset($_GET['SifraArtikla'])) 
    {
      $artikal=$_GET['SifraArtikla'];
    }

    $upit = "select * from artikli where SifraArtikla=".$artikal;


    if (!$rez=$mysqli->query($upit)) 
    {
      die("Greska: ".$mysqli->error);
    }

    $row=$rez->fetch_assoc();

    $naziv=$row['Naziv'];
    $opis=$row['Opis'];
    $igra=$row['Igra'];
    $cena=$row['Cena'];
    $cenapop=$row['CenaSaPopustom'];
    $usluga=$row['Usluga'];
    $kolicina=$row['Kolicina'];

    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <title>Obrisi Artikal</title>
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
            <h2>Obrisi Artikal</h2>
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <form method="POST" action="#">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Naziv artikla:</label>
                  <input type="text" class="form-control" name="Naziv" id="inputEmail4" placeholder="Unesite naziv artikla:" disabled 
                  value="<?php echo $naziv ?>">
                </div>
              </div>
              <div class="row">
               <div class="form-group col-md-6">
                <label for="inputEmail4">Opis artikla:</label>
                <input type="text" class="form-control" name="Opis" id="inputEmail4" placeholder="Unesite kratak opis artikla:" disabled 
                value="<?php echo $opis ?>">
              </div>
            </div>
            <div class="row">
             <div class="form-group col-md-6">
              <label for="inputEmail4">Naziv igre:</label>
              <input type="text" class="form-control" name="Igre" id="inputEmail4" placeholder="Unesite naziv igre:" disabled 
              value="<?php echo $igra ?>">
            </div>
          </div>
          <div class="row">
           <div class="form-group col-md-6">
            <label for="inputEmail4">Unesite buducu cenu artikla:</label>
            <input type="text" class="form-control" name="Cena" id="inputEmail4" placeholder="Buducu cenu artikla:" disabled
            value="<?php echo $cena ?>">
          </div>
        </div>
        <div class="row">
         <div class="form-group col-md-6">
          <label for="inputEmail4">Buduca cena sa predefinisanim popustom:</label>
          <input type="text" class="form-control" name="Popust" id="inputEmail4" placeholder="Unesite buducu cenu sa popustom:" 
          disabled value="<?php echo $cenapop ?>">
        </div>
      </div>
      <div class="row">
       <div class="form-group col-md-6">
        <label for="inputEmail4">Da li je artikal usluga:</label>
        <input type="checkbox" class="form-control" name="usluga" id="inputEmail4" disabled <?php $x=($usluga) ? "checked" : ""; echo $x; ?>>
      </div>
    </div>
    <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Kolicina koja ce biti na stanju:</label>
      <input type="number" class="form-control" name="kolicina" id="inputEmail4" disabled value="<?php echo $kolicina ?>">
    </div>
  </div>
  <div>
    <button type="submit" class="btn btn-primary btn-sm" name="dugme" onclick="Obrisi()">Obrisi</button>
  </div>


  <script type="text/javascript">

    function Obrisi(){
      var c = confirm('Da li ste sigurni da želite da obrišete artikal?');
      if(c == false){
        event.preventDefault();
      }
    }
  </script>

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