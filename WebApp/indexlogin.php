<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>LogIn</title>
  <link rel="stylesheet" type="text/css" href="style/css.css">
</head>
<body>
<div class="container">
  <?php 
  
  include "izgled/slika.php";
  include "izgled/nav.php";
  include "Konekcija.php";

  if (isset($_POST['dugme'])) 
  {
    if (isset($_POST['Email']) && isset($_POST['Pass'])) 
    {

      $upit = "Select * FROM korisnici where Ime='".$_POST['Email']."' and Sifra='".$_POST['Pass']."'";

      $rez=$mysqli->query($upit);

      $red=$rez->fetch_assoc();

      if (!$red) 
      {
        echo "Pogresan Email ili Sifra!!";
      }
      else
      {
        $_SESSION['KorpaID'] = 0;
        $_SESSION['Ime']=$red['Ime'];
        $_SESSION['Admin']=$red['Uloga'];
        $_SESSION['ID']=$red['KorisnikID'];
        $_SESSION['Ispis']='<script type="text/javascript">alert("Uspesno ste se ulogovali!!");</script>';
        $upit = "select * from korpa where KorisnikID=".$_SESSION['ID']." and Brisano=0";
        $rez=$mysqli->query($upit);
        $red=$rez->fetch_assoc();
        if ($red) 
        {
          $_SESSION['KorpaID'] = $red['KorpaID']; 
          echo "korpa je: ".$_SESSION['KorpaID']."<br>";
        }
        $upit="select sum(Kolicina) as A from sastavkorpe where KorpaID=".$_SESSION['KorpaID'];
        $rez=$mysqli->query($upit);
        $red=$rez->fetch_assoc();
        if ($red) 
        {
          $_SESSION['BrArt'] = $red['A'];
        }
        header("Location: index.php");
      }
    }
  }

 ?>
<!--Pocetak Forme -->

<div class="row mt-4">
    <div class="col-12">
      <h2 class="boja">Log In</h2>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <form method="POST" action="indexlogin.php">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Vaš Email</label>
      <input type="email" class="form-control" name="Email" id="inputEmail4" placeholder="Unesite vaš E-mail:">
    </div>
  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Vaša Šifra</label>
      <input type="password" class="form-control" name="Pass" id="inputEmail4" placeholder="Unesite vašu šifru:">
    </div>
  </div>
  <div class="rememberme-container">
          <input type="checkbox" name="rememberme" id="rememberme"/>
          <label for="rememberme" class="rememberme"><span>Zapamti me</span></label>
          &nbsp
          <!-- <a class="forgot-password" href="#">Forgot Password?</a> -->
        </div>
  <div>
      <button type="submit" class="btn btn-primary btn-sm" name="dugme">Posaljite</button>
  </div>
  &nbsp
</form>
    </div>
  </div>
<?php include "izgled/footer.php"; ?>
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