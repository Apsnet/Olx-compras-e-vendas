-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 25/06/2018 às 09:57
-- Versão do servidor: 5.7.21-0ubuntu0.16.04.1
-- Versão do PHP: 7.0.30-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `classificados`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anuncios`
--

CREATE TABLE `anuncios` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `valor` float NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `anuncios`
--

INSERT INTO `anuncios` (`id`, `id_usuario`, `id_categoria`, `titulo`, `descricao`, `valor`, `estado`) VALUES
(1, 1, 1, 'Relogio top', ' aaa       ', 100, 1),
(3, 1, 4, 'Novo vectra editado ', ' Carros novo , muito bom   mesmo !!  ', 14000, 1),
(4, 1, 1, 'kIT HACKER INTERNET', ' Novo kit  ', 200, 2),
(5, 1, 2, 'Nova moda masculina', ' A melhor roupa do mercado   ', 200, 1),
(6, 1, 1, 'kIT HACKER INTERNET', 'wefdsfsdf', 200, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `anuncios_imagens`
--

CREATE TABLE `anuncios_imagens` (
  `id` int(11) NOT NULL,
  `id_anuncio` int(11) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `anuncios_imagens`
--

INSERT INTO `anuncios_imagens` (`id`, `id_anuncio`, `url`) VALUES
(50, 1, '30392984d617a1235fc2ec9ddd5fc6a8.png'),
(52, 1, '98c6f6a51f7c10004fdd7a9785c0e690.png'),
(53, 1, 'b87973e01c1bfb2f02a451608444b578.png'),
(55, 3, '2b66d3656692106fb476650319e2e54f.JPG'),
(56, 4, '16c9c9f3185ccb8639488219c1b4a607.png'),
(57, 5, 'e5f7b561525493dbed91b85a2a95f496.jpg'),
(58, 5, 'f99f46522ea6023ab45862ce89ced9a0.png'),
(59, 5, 'a505da50cac14e6c818a9b42802b9f01.png'),
(60, 5, '7296c0e6a1b2a4456899f6e6bc15b845.png'),
(61, 5, '79f4d72d48edea205ad65a8a90f2155a.png'),
(62, 1, 'f04de9eb097088804d6937ec92a59d3c.png'),
(63, 1, '22bad2322769af96157b9b698e1e5f4d.png'),
(64, 1, 'e37420b6b2e0dace4c4f0f08c91ec709.png'),
(65, 1, 'a909507cf361136831fbab52ed77faab.png'),
(66, 1, '3b1feea9e5f454576e380d017a69491a.png'),
(67, 1, '6706cfdaa3697e4f49db5f448cba3d8f.png'),
(68, 1, '2ac984e056c2099a23dad83326fceb3d.png'),
(69, 1, 'fbe22bbddec86751cdea23645e705f35.png'),
(70, 1, '492095bde76c97fc74179570a796dc9f.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Relógios'),
(2, 'Roupas'),
(3, 'Eletrônicos'),
(4, 'Carros');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `telefone`, `ip`) VALUES
(1, 'Ueslei Sales Vieira Magalhaes', 'wesleijt@hotmail.com', '120737c5839919496c3934336d7a23c5', '(73) 9884-3545', NULL);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `anuncios_imagens`
--
ALTER TABLE `anuncios_imagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `anuncios_imagens`
--
ALTER TABLE `anuncios_imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
