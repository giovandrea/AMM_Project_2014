-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Ago 24, 2014 alle 15:28
-- Versione del server: 5.5.35-0ubuntu0.13.10.2
-- Versione PHP: 5.5.3-1ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amm14_atzeniAndrea`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `acquisti`
--

CREATE TABLE IF NOT EXISTS `acquisti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcd` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `costo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cd_fk` (`idcd`),
  KEY `cliente_fk` (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `amministratori`
--

CREATE TABLE IF NOT EXISTS `amministratori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `numerotel` varchar(128) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  `numero_civico` int(128) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `amministratori`
--

INSERT INTO `amministratori` (`id`, `nome`, `cognome`, `email`, `numerotel`, `via`, `numero_civico`, `citta`, `username`, `password`) VALUES
(1, 'Andrea', 'Atzeni', 'utentefasullo@email.it', '070/123456', 'Via Boh', 1, 'Roma', 'andrea', 'andrea'),
(2, 'Davide', 'Spano', 'utentenonesistente@email.it', '070/999999', 'Via dei Sogni', 75, 'Milano', 'davide', 'davide');

-- --------------------------------------------------------

--
-- Struttura della tabella `artisti`
--

CREATE TABLE IF NOT EXISTS `artisti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomeartista` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dump dei dati per la tabella `artisti`
--

INSERT INTO `artisti` (`id`, `nomeartista`) VALUES
(1, 'Avantasia'),
(2, 'Edguy'),
(3, 'Shaaman'),
(4, 'Elvenking'),
(5, 'Genius'),
(6, 'Grand Magus');

-- --------------------------------------------------------

--
-- Struttura della tabella `caratterizzazioni`
--

CREATE TABLE IF NOT EXISTS `caratterizzazioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idartista` int(11) DEFAULT NULL,
  `titolo` varchar(60) DEFAULT NULL,
  `prezzo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `artisti_fk` (`idartista`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dump dei dati per la tabella `caratterizzazioni`
--

INSERT INTO `caratterizzazioni` (`id`, `idartista`, `titolo`, `prezzo`) VALUES
(1, 1, 'The Scarecrow', 18),
(2, 6, 'Triumph and Power', 17),
(3, 4, 'The Pagan Manifesto', 19),
(4, 2, 'Space Police - Defenders Of The Crown', 22),
(5, 3, 'Ritual', 19),
(6, 5, 'Rock Opera: Episode II - In Search Of The Little Prince', 22);

-- --------------------------------------------------------

--
-- Struttura della tabella `cd`
--

CREATE TABLE IF NOT EXISTS `cds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcaratterizzazione` int(11) DEFAULT NULL,
  `anno` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `caratterizzazione_fk` (`idcaratterizzazione`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dump dei dati per la tabella `cd`
--

INSERT INTO `cd` (`id`, `idcaratterizzazione`, `anno`) VALUES
(1, 2, 2014),
(2, 1, 2014),
(3, 4, 2014),
(4, 5, 2014),
(5, 6, 2014),
(6, 3, 2014);

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

CREATE TABLE IF NOT EXISTS `clienti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `numerotel` varchar(128) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  `numero_civico` int(128) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`id`, `nome`, `cognome`, `email`, `numerotel`, `via`, `numero_civico`, `citta`, `username`, `password`) VALUES
(1, 'Tobias', 'Sammet', 'utenteimmaginario@email.it', '0781/122121', 'Via Roux', 48, 'Carbonia', 'tobias', 'tobias'),
(2, 'Thomàs', 'Diaz', 'utentespagnolo@email.es', '00349312345566', 'Via Spagnola', 66, 'Siviglia', 'thomas', 'thomas');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `acquisti`
--
ALTER TABLE `acquisti`
  ADD CONSTRAINT `cd_fk` FOREIGN KEY (`idcd`) REFERENCES `cd` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cliente_fk` FOREIGN KEY (`idcliente`) REFERENCES `clienti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `caratterizzazioni`
--
ALTER TABLE `caratterizzazioni`
  ADD CONSTRAINT `artisti_fk` FOREIGN KEY (`idartista`) REFERENCES `artisti` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `cd`
--
ALTER TABLE `cd`
  ADD CONSTRAINT `caratterizzazione_fk` FOREIGN KEY (`idcaratterizzazione`) REFERENCES `caratterizzazioni` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
