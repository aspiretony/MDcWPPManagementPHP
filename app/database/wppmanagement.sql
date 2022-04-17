-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Abr-2022 às 05:30
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `wppmanagement`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `mdc_dispositivos`
--

CREATE TABLE `mdc_dispositivos` (
  `nome` varchar(50) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `token` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `system_user_id` int(11) DEFAULT NULL,
  `statusatual` tinyint(1) NOT NULL,
  `servidores_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servidores`
--

CREATE TABLE `servidores` (
  `ipoudominio` varchar(255) NOT NULL,
  `porta` int(15) DEFAULT NULL,
  `chavesecreta` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `id` int(11) NOT NULL,
  `interno` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `servidores`
--

INSERT INTO `servidores` (`ipoudominio`, `porta`, `chavesecreta`, `descricao`, `id`, `interno`) VALUES
('127.0.0.1', 21465, 'THISISMYSECURETOKEN', 'Servidor Primário dentro da Pasta NodeSERVER', 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `mdc_dispositivos`
--
ALTER TABLE `mdc_dispositivos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`),
  ADD KEY `servidores_id` (`servidores_id`);

--
-- Índices para tabela `servidores`
--
ALTER TABLE `servidores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `mdc_dispositivos`
--
ALTER TABLE `mdc_dispositivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servidores`
--
ALTER TABLE `servidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `mdc_dispositivos`
--
ALTER TABLE `mdc_dispositivos`
  ADD CONSTRAINT `mdc_dispositivos_ibfk_1` FOREIGN KEY (`servidores_id`) REFERENCES `mdc_dispositivos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
