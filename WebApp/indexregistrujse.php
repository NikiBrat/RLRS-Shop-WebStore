<?php session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Registracija</title>
  <link rel="stylesheet" type="text/css" href="style/css.css">
</head>>
<body>
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
      <h2 class="boja">Registruj se</h2>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <form method="Post" action="indexregistrujse.php">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Vas Email</label>
      <input type="email" class="form-control" id="inputEmail4" name="Email" placeholder="Unesite vaš E-mail:">
    </div>
  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Vasa Šifra</label>
      <input type="password" class="form-control" id="inputEmail4" name="Pass" placeholder="Unesite vašu šifru:">
    </div>
  </div>
  <div>
      <button type="submit" class="btn btn-primary btn-sm" name="dugme">Posaljite</button>
  </div>
  <?php 

  if (isset($_POST['dugme'])) 
  {
    if (!empty($_POST['Email']) && !empty($_POST['Pass'])) 
    {
      $upit = "Insert into korisnici (Ime,Sifra) values ('".$_POST['Email']."','".$_POST['Pass']."')";

      if (!$rez=$mysqli->query($upit)) 
          {
            die("Greska: ".$mysqli->error);
          }
          else
          {
            echo "Uspesno ste se napravili nalog u nasoj Web prodavnici!";
          }
    }
  }

   ?>
  &nbsp
</form>
    </div>
  </div>
<?php include "izgled/footer.php" ?>
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