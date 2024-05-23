  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php">RLRS Web Prodavnica</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ">
      <li class="nav-item active">
        <a class="nav-link" href="onama.php">O nama <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown nav-item active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Izaberite</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="indexartikal.php">Artikli</a>
          <a class="dropdown-item" href="dodajBundle.php">Paketi</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="Onama.php">Kratak opis Projekta</a>
          <?php 
          $brArt=0;
          $_SESSION['ID']=0;
            include "Konekcija.php";
          if (isset($_SESSION['Ime'])) 
          {
            if (isset($_SESSION['BrArt'])) 
            {
              $brArt=$_SESSION['BrArt'];
            }
                if ($_SESSION['Admin']) 
                {

                  ?>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="dodajartikal.php">Kreiraj Artikal</a>
                  <a class="dropdown-item" href="kreirajBundle.php">Kreiraj Paket</a>
                  <?php

                }
          }

        $upit = "select * from korpa where KorisnikID=".$_SESSION['ID']." and Brisano=0";
        $rez=$mysqli->query($upit);
        $red=$rez->fetch_assoc();

        if ($red) 
        {
          $_SESSION['KorpaID'] = $red['KorpaID'];
        }

        $upit="select sum(Kolicina) as kolic from sastavkorpe where KorpaID=".$_SESSION['KorpaID'];
        $rez=$mysqli->query($upit);
        $red=$rez->fetch_assoc();


        if ($red) 
        {
          $_SESSION['BrArt'] = $red['kolic'];
          $brArt = $red['kolic'];
        }

           ?>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0 mr-auto">
    </form>

    <a href="korpa.php"> <img src="Slike/korpa.png" width="40"></a><span class="badge"><?php echo $brArt ?></span>  &nbsp; &nbsp; &nbsp; 

    <?php 

    if (!isset($_SESSION['Ime']) ) 
    {
       $ispis = '<a class="nav-link" href="indexregistrujse.php">Registruj se</a>';
       $ispis2 = '<a class="nav-link" href="indexlogin.php">Log in</a>';
    }
    else
    {
      $ispis = '<span class="nav-link">Korisnik: '.$_SESSION['Ime']. '</span>';
      $ispis2 = '<a class="nav-link" href="indexlogout.php">Log out</a>';
    }

     ?>
     <ul class="navbar-nav ">
      <li class="nav-item active">
      <?php echo $ispis; ?>
    </li>
      <li class="nav-item active">
      <?php echo $ispis2; ?>
    </li>
</ul>
  </div>
</nav>

