-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2022 at 09:28 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digitalnaprodavnica`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikli`
--

CREATE TABLE `artikli` (
  `SifraArtikla` int(11) NOT NULL,
  `Naziv` varchar(50) NOT NULL,
  `Opis` varchar(50) DEFAULT NULL,
  `Igra` varchar(20) NOT NULL,
  `Cena` double NOT NULL,
  `CenaSaPopustom` double DEFAULT NULL,
  `Usluga` bit(1) NOT NULL,
  `Kolicina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artikli`
--

INSERT INTO `artikli` (`SifraArtikla`, `Naziv`, `Opis`, `Igra`, `Cena`, `CenaSaPopustom`, `Usluga`, `Kolicina`) VALUES
(6, 'Valorant Poeni - 500', 'Valorant valuta', 'Valorant', 600, 600, b'0', 37),
(7, 'Valorant Poeni - 1000', 'Valorant valuta', 'Valorant', 950, 900, b'0', 27),
(8, 'Valorant Poeni - 2000', 'Valorant valuta', 'Valorant', 1600, 1400, b'0', 16),
(9, 'League of Legends - 310', 'Lol Riot points - valuta', 'League of Legends', 350, 350, b'0', 97),
(10, 'League of Legends - 640', 'Lol Riot points - valuta', 'League of Legends', 750, 700, b'0', 45),
(11, 'Fortnite V-Bucks - 500', 'V-Bucks valuta za Fortnite', 'Fortnite', 600, 600, b'0', 60),
(12, 'Fortnite V-Bucks - 1000', 'V-Bucks valuta za Fortnite', 'Fortnite', 1200, 1100, b'0', 37),
(14, 'Otkljucavanje Trading sistema ', 'Usluga za Rocket League igru', 'Usluga', 850, 850, b'1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `KorisnikID` int(11) NOT NULL,
  `Ime` varchar(50) NOT NULL,
  `Sifra` varchar(50) NOT NULL,
  `Uloga` bit(1) NOT NULL DEFAULT b'0',
  `Kontakt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`KorisnikID`, `Ime`, `Sifra`, `Uloga`, `Kontakt`) VALUES
(1, 'nikolic@live.com', '123', b'1', ''),
(2, 'radnik@live.com', '123', b'0', ''),
(3, 'andrej@gmail.com', '123', b'0', '');

-- --------------------------------------------------------

--
-- Table structure for table `korpa`
--

CREATE TABLE `korpa` (
  `KorpaID` int(11) NOT NULL,
  `KorisnikID` int(11) NOT NULL,
  `Datum` date NOT NULL,
  `Vreme` time(6) NOT NULL,
  `Brisano` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korpa`
--

INSERT INTO `korpa` (`KorpaID`, `KorisnikID`, `Datum`, `Vreme`, `Brisano`) VALUES
(1, 2, '2022-02-24', '19:47:16.000000', b'0'),
(2, 1, '2022-02-24', '10:29:00.000000', b'1'),
(3, 1, '2022-02-25', '03:41:00.000000', b'1'),
(4, 0, '2022-02-25', '07:14:00.000000', b'0'),
(5, 0, '2022-02-25', '07:15:00.000000', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `paketusluga`
--

CREATE TABLE `paketusluga` (
  `PaketID` int(11) NOT NULL,
  `Cena` double NOT NULL,
  `Naziv` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paketusluga`
--

INSERT INTO `paketusluga` (`PaketID`, `Cena`, `Naziv`) VALUES
(2, 2000, 'Fast and Furious 2'),
(3, 5000, 'Valorant Bundle'),
(4, 1000, 'Lol Poeni');

-- --------------------------------------------------------

--
-- Table structure for table `sastavkorpe`
--

CREATE TABLE `sastavkorpe` (
  `KorpaID` int(11) NOT NULL,
  `StavkaKorpeID` int(11) NOT NULL,
  `SifraArtikala` int(11) DEFAULT NULL,
  `PaketID` int(11) DEFAULT NULL,
  `Kolicina` int(11) NOT NULL,
  `Cena` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sastavkorpe`
--

INSERT INTO `sastavkorpe` (`KorpaID`, `StavkaKorpeID`, `SifraArtikala`, `PaketID`, `Kolicina`, `Cena`) VALUES
(1, 1, 6, NULL, 3, 600),
(1, 2, NULL, 2, 1, 2000),
(2, 3, 6, 0, 6, 600),
(2, 5, 6, 0, 1, 600),
(2, 8, 6, 0, 2, 600),
(3, 12, 6, 0, 0, 600),
(3, 13, 10, 0, 0, 750),
(4, 21, 6, 0, 0, 600),
(4, 22, 7, 0, 0, 950),
(4, 23, 9, 0, 0, 350),
(4, 24, 10, 0, 0, 750);

-- --------------------------------------------------------

--
-- Table structure for table `sastavpaketa`
--

CREATE TABLE `sastavpaketa` (
  `SastavID` int(11) NOT NULL,
  `PaketID` int(11) NOT NULL,
  `SifraArtikla` int(11) NOT NULL,
  `Kolicina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sastavpaketa`
--

INSERT INTO `sastavpaketa` (`SastavID`, `PaketID`, `SifraArtikla`, `Kolicina`) VALUES
(11, 3, 10, 1),
(12, 3, 14, 1),
(16, 2, 8, 1),
(17, 2, 8, 1),
(20, 4, 6, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikli`
--
ALTER TABLE `artikli`
  ADD PRIMARY KEY (`SifraArtikla`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`KorisnikID`);

--
-- Indexes for table `korpa`
--
ALTER TABLE `korpa`
  ADD PRIMARY KEY (`KorpaID`);

--
-- Indexes for table `paketusluga`
--
ALTER TABLE `paketusluga`
  ADD PRIMARY KEY (`PaketID`);

--
-- Indexes for table `sastavkorpe`
--
ALTER TABLE `sastavkorpe`
  ADD PRIMARY KEY (`StavkaKorpeID`);

--
-- Indexes for table `sastavpaketa`
--
ALTER TABLE `sastavpaketa`
  ADD PRIMARY KEY (`SastavID`,`PaketID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikli`
--
ALTER TABLE `artikli`
  MODIFY `SifraArtikla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `KorisnikID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `korpa`
--
ALTER TABLE `korpa`
  MODIFY `KorpaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paketusluga`
--
ALTER TABLE `paketusluga`
  MODIFY `PaketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sastavkorpe`
--
ALTER TABLE `sastavkorpe`
  MODIFY `StavkaKorpeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sastavpaketa`
--
ALTER TABLE `sastavpaketa`
  MODIFY `SastavID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
