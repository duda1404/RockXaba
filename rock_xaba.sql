-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Ago-2022 às 14:53
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rock_xaba`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `artista`
--

CREATE TABLE `artista` (
  `id_artista` int(11) NOT NULL,
  `nome_artista` varchar(100) DEFAULT NULL,
  `link_play` varchar(100) DEFAULT NULL,
  `views_artista` varchar(100) DEFAULT NULL,
  `dsc_artista` varchar(300) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL,
  `photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `artista`
--

INSERT INTO `artista` (`id_artista`, `nome_artista`, `link_play`, `views_artista`, `dsc_artista`, `FK_USUARIO_id_user`, `photo`) VALUES
(20, 'Rex Orange County', 'https://open.spotify.com/embed/playlist/31rJ43fIpaSa3Kt9UrnERg?utm_source=generator', NULL, 'Alexander O\'Connor, mais conhecido por seu nome artístico Rex Orange County, é um cantor e compositor britânico, nasceu e cresceu na vila de Grayshott perto de Haslemere, Surrey', NULL, '2030696282rex_orange.jpg'),
(21, 'Red Hot Chili Peppers', 'https://open.spotify.com/embed/artist/0L8ExT028jH3ddEcZwqJJ5?utm_source=generator', NULL, 'Red Hot Chili Peppers é uma banda de rock dos Estados Unidos formada em Los Angeles, Califórnia, em 13 de fevereiro de 1983, considerada uma das maiores bandas de todos os tempos. O estilo musical do grupo consiste principalmente no funk rock, bem como elementos de outros gêneros, tais como punk, ro', NULL, '1586860358redd.jpg'),
(23, 'Linkin Park', 'https://open.spotify.com/artist/6XyY86QOPPrYVGvF9ch6wz', NULL, 'Linkin Park é uma banda de rock dos Estados Unidos formada em Agoura Hills, Califórnia. A formação atual da banda inclui o vocalista e multi-instrumentista Mike Shinoda, o guitarrista Brad Delson, o baixista Dave Farrell, o DJ Joe Hahn e o baterista Rob Bourdon, todos membros fundadores.', NULL, '103189114linkin.jpg'),
(24, 'Muse', 'https://open.spotify.com/artist/12Chz98pHFMPJEknJQMWvI', NULL, 'Muse é uma banda britânica de rock de Teignmouth, Devon, formada em 1994. Seus membros são: Matthew Bellamy, Christopher Wolstenholme e Dominic Howard. O estilo de Muse é um misto de vários gêneros musicais, incluindo rock alternativo, música clássica e eletrônica', NULL, '1482863895muse.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `id_aval` int(11) NOT NULL,
  `qtd_estrelas` int(11) DEFAULT NULL,
  `date_aval` date DEFAULT NULL,
  `FK_EVENTO_id_evento` int(11) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `catalogo`
--

CREATE TABLE `catalogo` (
  `id_catalog` int(11) NOT NULL,
  `link_catalog` varchar(100) DEFAULT NULL,
  `FK_ARTISTA_id_artista` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario`
--

CREATE TABLE `comentario` (
  `id_coment` int(11) NOT NULL,
  `dsc_coment` varchar(100) DEFAULT NULL,
  `date_coment` datetime DEFAULT NULL,
  `FK_EVENTO_id_evento` int(11) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `comentario`
--

INSERT INTO `comentario` (`id_coment`, `dsc_coment`, `date_coment`, `FK_EVENTO_id_evento`, `FK_USUARIO_id_user`) VALUES
(132, 'comentario teste', '2022-08-06 11:51:43', NULL, 39),
(133, 'lalala', '2022-08-06 12:01:18', NULL, 39),
(134, 'lalal', '2022-08-06 12:11:09', NULL, 40),
(135, 'u', '2022-08-06 14:47:45', NULL, 40);

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `dat_evento` date DEFAULT NULL,
  `dsc_evento` varchar(1000) DEFAULT NULL,
  `local_evento` varchar(100) DEFAULT NULL,
  `preco_evento` varchar(100) DEFAULT NULL,
  `dat_limite_ingresso` date DEFAULT NULL,
  `dat_inicio_ingresso` date DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `genero`
--

CREATE TABLE `genero` (
  `dsc_genero` varchar(100) DEFAULT NULL,
  `id_gen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sit_usuarios`
--

CREATE TABLE `sit_usuarios` (
  `id_sit` int(11) NOT NULL,
  `dsc_sit` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `sit_usuarios`
--

INSERT INTO `sit_usuarios` (`id_sit`, `dsc_sit`) VALUES
(1, 'Ativo'),
(2, 'Inativo'),
(3, 'Aguardando Confirmação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `suporte`
--

CREATE TABLE `suporte` (
  `id_msg` int(11) NOT NULL,
  `dsc_msg` varchar(420) NOT NULL,
  `msg_user_id` int(220) NOT NULL,
  `msg_user_email` varchar(220) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `suporte`
--

INSERT INTO `suporte` (`id_msg`, `dsc_msg`, `msg_user_id`, `msg_user_email`) VALUES
(1, 'E aí, Duda? Beleza? Testando email e Banco de Dados aqui!', 17, 'dudinha140405@gmail.com'),
(2, 'E aí, Duda? Beleza? Testando email e Banco de Dados aqui!', 17, 'dudinha140405@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `dsc_tipo` varchar(100) DEFAULT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_user` int(11) NOT NULL,
  `senha_user` varchar(100) DEFAULT NULL,
  `email_user` varchar(100) DEFAULT NULL,
  `nome_user` varchar(100) DEFAULT NULL,
  `FK_TIPO_USUARIO_codigo` int(11) DEFAULT NULL,
  `chave` varchar(220) NOT NULL,
  `sit_user_id` int(11) NOT NULL DEFAULT 3,
  `chave_recupera_senha` varchar(220) NOT NULL,
  `dsc_user` varchar(200) NOT NULL,
  `photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_user`, `senha_user`, `email_user`, `nome_user`, `FK_TIPO_USUARIO_codigo`, `chave`, `sit_user_id`, `chave_recupera_senha`, `dsc_user`, `photo`) VALUES
(24, '$2y$10$wYPQJUsYuMFyDH5eXc6P6uEcXx43CpIqrLoqAdwtNHw3H7ebarZmS', 'dudinha140405@gmail.com', 'duda14', NULL, '', 1, '', '', ''),
(25, '$2y$10$RY6xcvqEkjbmtospMgFah.EV7pWRSIlw.PiQXtOMgN1eVUVO0brE6', 'rockxaba@gmail.com', 'rockXabinha', NULL, '', 1, '', '', ''),
(27, NULL, NULL, NULL, NULL, '', 3, '$2y$10$RgZsE21Rew4Ja/YRHBJryu7n0lqHLikZaTYlOehzHfD1WLzblHalW', '', ''),
(28, NULL, NULL, NULL, NULL, '', 3, '$2y$10$Gl.gbMfkTSwEhYlGdsAi5ufO.r6.vPV4xpUH84DZ/CRYeJZoTHJAG', '', ''),
(29, NULL, NULL, NULL, NULL, '', 3, '$2y$10$YZPHfV9.weNDBIaatUdufe8L7xVOQf0JXzLXor73f7Y.i3gMiJtZ.', '', ''),
(30, NULL, NULL, NULL, NULL, '', 3, '$2y$10$M3klQVFQJCdLS9O5M8lYtOMz7HaOutd6SoE57w/MJfQIvV9ly4lH.', '', ''),
(39, '$2y$10$PF/idan8DGeJIRHfiMO7suLJpyPd5t5rR.x91pDEvXC0hn4qRGbJG', 'gileard96@gmail.com', 'gileardy', NULL, '', 1, '', 'descricao', '2089225430Capturar.PNG'),
(40, '$2y$10$pgkTG1iH8Hr2j3.70b9CbufvMYP/91AmsqxiFYkWyDFoqnwbSjJXa', 'sgilerad@gmail.com', 'sgil', NULL, '', 1, '', '', '95307237013.PNG');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`id_artista`);

--
-- Índices para tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`id_aval`);

--
-- Índices para tabela `catalogo`
--
ALTER TABLE `catalogo`
  ADD PRIMARY KEY (`id_catalog`);

--
-- Índices para tabela `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id_coment`);

--
-- Índices para tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`);

--
-- Índices para tabela `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_gen`);

--
-- Índices para tabela `sit_usuarios`
--
ALTER TABLE `sit_usuarios`
  ADD PRIMARY KEY (`id_sit`);

--
-- Índices para tabela `suporte`
--
ALTER TABLE `suporte`
  ADD PRIMARY KEY (`id_msg`);

--
-- Índices para tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `artista`
--
ALTER TABLE `artista`
  MODIFY `id_artista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `id_aval` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `catalogo`
--
ALTER TABLE `catalogo`
  MODIFY `id_catalog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id_coment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `genero`
--
ALTER TABLE `genero`
  MODIFY `id_gen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sit_usuarios`
--
ALTER TABLE `sit_usuarios`
  MODIFY `id_sit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `suporte`
--
ALTER TABLE `suporte`
  MODIFY `id_msg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
