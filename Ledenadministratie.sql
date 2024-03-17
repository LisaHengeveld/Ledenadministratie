-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 07 jun 2023 om 14:04
-- Serverversie: 8.0.31
-- PHP-versie: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `LOI_eindopdracht`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `boekjaar`
--

CREATE TABLE `boekjaar` (
  `id` int NOT NULL,
  `jaar` year NOT NULL,
  `basisbedrag` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `boekjaar`
--

INSERT INTO `boekjaar` (`id`, `jaar`, `basisbedrag`) VALUES
(2, '2023', 100.00),
(17, '2024', 150.00);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contributie`
--

CREATE TABLE `contributie` (
  `id` int NOT NULL,
  `leeftijd` int NOT NULL,
  `familielid` int NOT NULL,
  `bedrag` decimal(8,2) NOT NULL,
  `boekjaar` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `contributie`
--

INSERT INTO `contributie` (`id`, `leeftijd`, `familielid`, `bedrag`, `boekjaar`) VALUES
(100, 31, 28, 100.00, 2),
(101, 31, 28, 150.00, 17),
(102, 67, 29, 55.00, 2),
(103, 67, 29, 82.50, 17),
(115, 37, 34, 100.00, 2),
(116, 37, 34, 150.00, 17),
(129, 30, 39, 100.00, 2),
(130, 30, 39, 150.00, 17);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `familie`
--

CREATE TABLE `familie` (
  `id` int NOT NULL,
  `naam` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `adres` varchar(128) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `familie`
--

INSERT INTO `familie` (`id`, `naam`, `adres`) VALUES
(73, 'Hengeveld', 'Nieuwstadsweg 2, Elburg'),
(84, 'Bovée', 'Brabantlaan 1, Breda'),
(86, 'Fikse', 'Hellenbeekstraat 28, Elburg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `familielid`
--

CREATE TABLE `familielid` (
  `id` int NOT NULL,
  `naam` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `geboortedatum` date NOT NULL,
  `soort_lid` int DEFAULT NULL,
  `familie` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `familielid`
--

INSERT INTO `familielid` (`id`, `naam`, `geboortedatum`, `soort_lid`, `familie`) VALUES
(28, 'Lisa', '1992-01-29', 17, 73),
(29, 'Gerrie', '1955-07-16', 18, 73),
(34, 'Yvonne', '1985-09-02', 17, 73),
(39, 'Lianne', '1992-09-28', 17, 86);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int NOT NULL,
  `gebruikersnaam` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `wachtwoord` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `gebruikersnaam`, `wachtwoord`) VALUES
(1, 'secretaris', '$2y$10$UVRDBsOi3Tqf64PEC16g7uV1q6Y/.Ca0yHvoIEvJOOkfdtuOmtN4m'),
(2, 'penningmeester', '$2y$10$t5X71ZlqDUuinWgh2BYYzeH6gWab/s2NtoUzKlnwfpDj.WypUsM92');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `soort_lid`
--

CREATE TABLE `soort_lid` (
  `id` int NOT NULL,
  `omschrijving` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `korting` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `soort_lid`
--

INSERT INTO `soort_lid` (`id`, `omschrijving`, `korting`) VALUES
(14, 'Jeugd: Jonger dan 8 jaar', 0.50),
(15, 'Aspirant: Van 8 tot 12 jaar', 0.40),
(16, 'Junior: Van 13 tot 17 jaar', 0.25),
(17, 'Senior: Van 18 tot 50 jaar', 0.00),
(18, 'Oudere: Vanaf 51 jaar', 0.45);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `boekjaar`
--
ALTER TABLE `boekjaar`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `contributie`
--
ALTER TABLE `contributie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `familielid` (`familielid`),
  ADD KEY `boekjaar` (`boekjaar`);

--
-- Indexen voor tabel `familie`
--
ALTER TABLE `familie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `familielid`
--
ALTER TABLE `familielid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `familie_id` (`familie`),
  ADD KEY `soort_lid` (`soort_lid`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `soort_lid`
--
ALTER TABLE `soort_lid`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `boekjaar`
--
ALTER TABLE `boekjaar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT voor een tabel `contributie`
--
ALTER TABLE `contributie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT voor een tabel `familie`
--
ALTER TABLE `familie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT voor een tabel `familielid`
--
ALTER TABLE `familielid`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `soort_lid`
--
ALTER TABLE `soort_lid`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `contributie`
--
ALTER TABLE `contributie`
  ADD CONSTRAINT `contributie_ibfk_1` FOREIGN KEY (`familielid`) REFERENCES `familielid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contributie_ibfk_2` FOREIGN KEY (`boekjaar`) REFERENCES `boekjaar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `familielid`
--
ALTER TABLE `familielid`
  ADD CONSTRAINT `familielid_ibfk_1` FOREIGN KEY (`familie`) REFERENCES `familie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `familielid_ibfk_2` FOREIGN KEY (`soort_lid`) REFERENCES `soort_lid` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
