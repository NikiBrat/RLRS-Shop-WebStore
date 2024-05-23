<?php 

session_start();

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

include "izgled/nav.php";

    ?>

<!--Pocetak Forme -->

<!--Treba podesiti css kod za text i srediti vizuelno malo stranicu-->

<div class="row mt-4">
    <div class="col-12">
      <h2 class="boja">Kratak opis projekta</h2>
      <hr>
    </div>
  </div>
  <form class="form-inline my-2 my-lg-0 mr-auto" method="POST" action="#">
  <div class="boja">
      <p>Potrebno je projektovati i implementirati aplikaciju za <strong>"Podršku specijalizovane prodavnice koja prodaje digitalne proizvode"</strong> poput dodataka za igrice, kodova za postizanje raznih benefita u igrama i slično. Aplikacija treba da ima mogućnost unosa nove ponude, povezivanje više predmeta prodaje u jedan paket, kao i evidentiranje prodaje. <strong>Kupac</strong> nema mogućnost dodavanja niti izmena artikala već može samo da vidi šta je sve u ponudi i da poruci artikale iz ponude. Pošto neki artikli imaju ograničenu količinu a neki ne, kod onih sa ograničenim brojem prilikom prodaje potrebno je umanjiti brojno stanje. Unos novih artikala i izmenu postojećih može da vrši samo administrator.
        Biće razmotrena ponašanja sistema kada je logovan jedan <strong>administrator</strong> a zatim jedan <strong>kupac</strong>.</p>   
  </div>
</form>
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