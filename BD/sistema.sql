-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 27-Dez-2019 às 18:48
-- Versão do servidor: 5.7.24
-- versão do PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `insert_Customers`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `insert_Customers` (`_name` VARCHAR(200), `_cpf` VARCHAR(14), `_dispatcher` VARCHAR(20), `_rg` VARCHAR(20), `_birthday` DATE, `_obs` LONGTEXT) RETURNS INT(11) NO SQL
BEGIN  
SET SQL_MODE = '';

INSERT INTO customers(name, cpf, dispatcher, rg, birthday, status, obs) VALUES (_name, _cpf, _dispatcher, _rg, _birthday, 'ACTIVE', _obs);
return LAST_INSERT_ID();
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `adresses`
--

DROP TABLE IF EXISTS `adresses`;
CREATE TABLE IF NOT EXISTS `adresses` (
  `idAddress` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCustomer` int(11) NOT NULL,
  `type` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `street` longtext COLLATE latin1_general_ci NOT NULL,
  `district` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `number` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `complement` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `city` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `state` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `zipCode` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `dtUpdate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `dtCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAddress`),
  KEY `fk_aderess_customer` (`idCustomer`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `adresses`
--

INSERT INTO `adresses` (`idAddress`, `idCustomer`, `type`, `street`, `district`, `number`, `complement`, `city`, `state`, `zipCode`, `dtUpdate`, `dtCreate`) VALUES
(25, 27, 'COMERCIAL', 'visconde de ouro preto', 'Caiçara', '454', '323', 'Belo Horizonte', 'MG', '43.435-34', NULL, '2019-12-27 12:55:37'),
(26, 28, 'COMERCIAL', 'Carlos Pereira', 'Savassi', '3445', '201', 'Belo Horizonte', 'MG', '39.440-050', NULL, '2019-12-27 14:02:06'),
(30, 33, 'COMERCIAL', 'rua h', 'Jardim Brasil', '345', '489', 'Belo Horizonte', 'MG', '31.528-668', NULL, '2019-12-27 18:42:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `idContact` int(11) NOT NULL AUTO_INCREMENT,
  `idCustomer` int(11) NOT NULL,
  `type` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `number` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `dtUpdate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `dtCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idContact`),
  KEY `fk_contact_customer` (`idCustomer`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `contacts`
--

INSERT INTO `contacts` (`idContact`, `idCustomer`, `type`, `number`, `email`, `dtUpdate`, `dtCreate`) VALUES
(53, 27, 'COMERCIAL', '(38) 9916-83297', 'lucasteixeira@hotmail.com', NULL, '2019-12-27 12:55:37'),
(54, 27, 'RESIDENCIAL', '(76) 9938-4885', 'lucas@teste.com', NULL, '2019-12-27 12:55:37'),
(55, 28, 'COMERCIAL', '(38) 4343-4857', 'osana@hotmail.com', NULL, '2019-12-27 14:02:06'),
(59, 33, 'COMERCIAL', '(38) 9916-7499', 'joao@teste.com', NULL, '2019-12-27 18:42:28'),
(60, 33, 'RESIDENCIAL', '(31) 8588-5949', 'joao@casa.com', NULL, '2019-12-27 18:42:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `idCustomer` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `nickname` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `genre` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `user` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `cpf` varchar(14) COLLATE latin1_general_ci NOT NULL,
  `dispatcher` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `rg` varchar(14) COLLATE latin1_general_ci NOT NULL,
  `birthday` date NOT NULL,
  `image` longtext COLLATE latin1_general_ci NOT NULL,
  `status` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `obs` longtext COLLATE latin1_general_ci,
  `dtUpdate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `dtCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idCustomer`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `customers`
--

INSERT INTO `customers` (`idCustomer`, `name`, `nickname`, `genre`, `user`, `password`, `cpf`, `dispatcher`, `rg`, `birthday`, `image`, `status`, `obs`, `dtUpdate`, `dtCreate`) VALUES
(26, 'lucas', '', '', '', '', '', '', '', '2000-01-01', '2019-12-27-10-53-285e05fec859f5e.png', 'ACTIVE', '', '2019-12-27 12:53:28', '2019-12-27 12:53:27'),
(27, 'Lucas Teixeira Moura Soares', 'Lucas', 'm', 'lucasteixeira', '123456', '116.923.656-14', 'MG', '74.775.543', '1997-09-04', '2019-12-27-10-55-375e05ff498127a.png', 'ACTIVE', '', '2019-12-27 18:37:12', '2019-12-27 12:55:37'),
(28, 'Osana Silva Primo', 'Osana Silva', '', 'osana', '123456', '458.727.523-44', 'SSP', 'MG', '1872-02-04', '2019-12-27-12-02-065e060edece4d6.png', 'ACTIVE', '', '2019-12-27 18:04:58', '2019-12-27 14:02:06'),
(31, 'dfgdf', '', '', '', '', '345.345.454-54', '5dd', '3453', '2049-01-03', '', 'ACTIVE', '34534', NULL, '2019-12-27 18:36:25'),
(33, 'João da Silva Pereira', '', '', '', '', '647.758.869-69', 'SSP', '65784893', '1985-02-15', '2019-12-27-16-42-285e06509482d4e.jpeg', 'ACTIVE', 'teste', '2019-12-27 18:42:28', '2019-12-27 18:42:28');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `adresses`
--
ALTER TABLE `adresses`
  ADD CONSTRAINT `fk_aderess_customer` FOREIGN KEY (`idCustomer`) REFERENCES `customers` (`idCustomer`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_contact_customer` FOREIGN KEY (`idCustomer`) REFERENCES `customers` (`idCustomer`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
