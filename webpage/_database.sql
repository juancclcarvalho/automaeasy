-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 18-Jul-2018 às 00:43
-- Versão do servidor: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `automaeasy`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ambiente`
--

CREATE TABLE IF NOT EXISTS `ambiente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `endmacxbee` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Extraindo dados da tabela `ambiente`
--

INSERT INTO `ambiente` (`id`, `nome`, `endmacxbee`) VALUES
(21, 'Sala', '0013a200.414f36f9'),
(24, 'SuÃ­te 1', '456'),
(25, 'Quarto 1', ''),
(27, 'Cozinha', ''),
(29, 'Ambiente Teste', '123'),
(30, 'Sala de Visitas', '1234');

-- --------------------------------------------------------

--
-- Estrutura da tabela `controle`
--

CREATE TABLE IF NOT EXISTS `controle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(15) NOT NULL,
  `encode` int(11) DEFAULT NULL,
  `onoff` bigint(20) DEFAULT NULL,
  `modo` bigint(20) DEFAULT NULL,
  `mute` bigint(20) DEFAULT NULL,
  `num1` bigint(20) DEFAULT NULL,
  `num2` bigint(20) DEFAULT NULL,
  `num3` bigint(20) DEFAULT NULL,
  `num4` bigint(20) DEFAULT NULL,
  `num5` bigint(20) DEFAULT NULL,
  `num6` bigint(20) DEFAULT NULL,
  `num7` bigint(20) DEFAULT NULL,
  `num8` bigint(20) DEFAULT NULL,
  `num9` bigint(20) DEFAULT NULL,
  `num0` bigint(20) DEFAULT NULL,
  `enter` bigint(20) DEFAULT NULL,
  `voltempup` bigint(20) DEFAULT NULL,
  `voltempdw` bigint(20) DEFAULT NULL,
  `canalfanup` bigint(20) DEFAULT NULL,
  `canalfandw` bigint(20) DEFAULT NULL,
  `func1` bigint(20) DEFAULT NULL,
  `func2` bigint(20) DEFAULT NULL,
  `func3` bigint(20) DEFAULT NULL,
  `func4` bigint(20) DEFAULT NULL,
  `func5` bigint(20) DEFAULT NULL,
  `func6` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `controle`
--

INSERT INTO `controle` (`id`, `nome`, `encode`, `onoff`, `modo`, `mute`, `num1`, `num2`, `num3`, `num4`, `num5`, `num6`, `num7`, `num8`, `num9`, `num0`, `enter`, `voltempup`, `voltempdw`, `canalfanup`, `canalfandw`, `func1`, `func2`, `func3`, `func4`, `func5`, `func6`) VALUES
(1, 'Sony', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'A', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipamento`
--

CREATE TABLE IF NOT EXISTS `equipamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `porta` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `id_ambiente` int(11) NOT NULL,
  `id_controle` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `equipamento`
--

INSERT INTO `equipamento` (`id`, `nome`, `porta`, `status`, `id_ambiente`, `id_controle`) VALUES
(5, 'Lampada', 12, 1, 21, 0),
(8, 'Aquario', 14, 0, 21, 0),
(11, 'Teste', 15, 1, 21, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
