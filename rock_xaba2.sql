-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10-Ago-2022 às 00:10
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
-- Banco de dados: `rock_xaba2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `artista`
--

CREATE TABLE `artista` (
  `id_artista` int(11) NOT NULL,
  `nome_artista` varchar(100) DEFAULT NULL,
  `link_play` varchar(100) DEFAULT NULL,
  `dsc_artista` varchar(100) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `artista`
--

INSERT INTO `artista` (`id_artista`, `nome_artista`, `link_play`, `dsc_artista`, `FK_USUARIO_id_user`) VALUES
(0, 'Rex Orange County', 'https://open.spotify.com/embed/playlist/31rJ43fIpaSa3Kt9UrnERg?utm_source=generator', 'Alexander O\'Connor, mais conhecido por seu nome artístico Rex Orange County, é um cantor e composito', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `artista_genero`
--

CREATE TABLE `artista_genero` (
  `FK_GENERO_id_gen` int(11) DEFAULT NULL,
  `FK_ARTISTA_id_artista` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `artista_rede`
--

CREATE TABLE `artista_rede` (
  `FK_ARTISTA_id_artista` int(11) DEFAULT NULL,
  `FK_REDE_SOCIAL_id_rede_social` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao_casa`
--

CREATE TABLE `avaliacao_casa` (
  `qtd_estrelas` int(11) DEFAULT NULL,
  `date_aval` datetime DEFAULT NULL,
  `id_aval` int(11) NOT NULL,
  `FK_CASA_DE_SHOW_id_casa` int(11) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao_evento`
--

CREATE TABLE `avaliacao_evento` (
  `id_aval` int(11) NOT NULL,
  `qtd_estrelas` int(11) DEFAULT NULL,
  `date_aval` datetime DEFAULT NULL,
  `FK_EVENTO_id_evento` int(11) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `casa_de_show`
--

CREATE TABLE `casa_de_show` (
  `id_casa` int(11) NOT NULL,
  `nome_casa` varchar(100) DEFAULT NULL,
  `dsc_casa` varchar(100) DEFAULT NULL,
  `contato_casa` varchar(100) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `casa_rede`
--

CREATE TABLE `casa_rede` (
  `FK_CASA_DE_SHOW_id_casa` int(11) DEFAULT NULL,
  `FK_REDE_SOCIAL_id_rede_social` int(11) DEFAULT NULL
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
-- Estrutura da tabela `comentario_artista`
--

CREATE TABLE `comentario_artista` (
  `dsc_coment` varchar(100) DEFAULT NULL,
  `date_coment` datetime DEFAULT NULL,
  `id_coment` int(11) NOT NULL,
  `FK_ARTISTA_id_artista` int(11) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL,
  `FK_TIPO_COMENTARIO_id_tipo_coment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `comentario_artista`
--

INSERT INTO `comentario_artista` (`dsc_coment`, `date_coment`, `id_coment`, `FK_ARTISTA_id_artista`, `FK_USUARIO_id_user`, `FK_TIPO_COMENTARIO_id_tipo_coment`) VALUES
('oiiiiiii', '2022-08-09 16:45:19', 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario_casa`
--

CREATE TABLE `comentario_casa` (
  `id_coment` int(11) NOT NULL,
  `dsc_coment` varchar(100) DEFAULT NULL,
  `date_coment` datetime DEFAULT NULL,
  `FK_CASA_DE_SHOW_id_casa` int(11) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL,
  `FK_TIPO_COMENTARIO_id_tipo_coment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario_evento`
--

CREATE TABLE `comentario_evento` (
  `id_coment` int(11) NOT NULL,
  `dsc_coment` varchar(100) DEFAULT NULL,
  `date_coment` datetime DEFAULT NULL,
  `FK_EVENTO_id_evento` int(11) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL,
  `FK_TIPO_COMENTARIO_id_tipo_coment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coment_resposta_artista`
--

CREATE TABLE `coment_resposta_artista` (
  `FK_COMENTARIO_ARTISTA_id_coment` int(11) DEFAULT NULL,
  `FK_COMENTARIO_ARTISTA_id_coment_resposta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coment_resposta_casa`
--

CREATE TABLE `coment_resposta_casa` (
  `FK_COMENTARIO_CASA_id_coment` int(11) DEFAULT NULL,
  `FK_COMENTARIO_CASA_id_coment_resposta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coment_resposta_evento`
--

CREATE TABLE `coment_resposta_evento` (
  `FK_COMENTARIO_EVENTO_id_coment` int(11) DEFAULT NULL,
  `FK_COMENTARIO_EVENTO_id_coment_resposta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curtir_curtido`
--

CREATE TABLE `curtir_curtido` (
  `FK_USUARIO_id_user` int(11) DEFAULT NULL,
  `FK_ARTISTA_id_artista` int(11) DEFAULT NULL,
  `data_curtida` datetime DEFAULT NULL,
  `id_curtida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `dat_evento` datetime DEFAULT NULL,
  `dsc_evento` varchar(1000) DEFAULT NULL,
  `local_evento` varchar(100) DEFAULT NULL,
  `preco_evento` varchar(100) DEFAULT NULL,
  `dat_limite_ingresso` datetime DEFAULT NULL,
  `dat_inicio_ingresso` datetime DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL,
  `FK_CASA_DE_SHOW_id_casa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `foto_artista`
--

CREATE TABLE `foto_artista` (
  `id_photo` int(11) NOT NULL,
  `photo_artista` varchar(100) DEFAULT NULL,
  `FK_ARTISTA_id_artista` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `foto_artista`
--

INSERT INTO `foto_artista` (`id_photo`, `photo_artista`, `FK_ARTISTA_id_artista`) VALUES
(1, '9145636132030696282rex_orange.jpg', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `foto_casa_de_show`
--

CREATE TABLE `foto_casa_de_show` (
  `photo_casa_de_show` varchar(100) DEFAULT NULL,
  `id_photo` int(11) NOT NULL,
  `FK_CASA_DE_SHOW_id_casa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `foto_catalogo`
--

CREATE TABLE `foto_catalogo` (
  `id_photo` int(11) NOT NULL,
  `photo_catalogo` varchar(100) DEFAULT NULL,
  `FK_CATALOGO_id_catalog` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `foto_evento`
--

CREATE TABLE `foto_evento` (
  `id_photo` int(11) NOT NULL,
  `photo_evento` varchar(100) DEFAULT NULL,
  `FK_EVENTO_id_evento` int(11) DEFAULT NULL
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
-- Estrutura da tabela `rede_social`
--

CREATE TABLE `rede_social` (
  `id_rede_social` int(11) NOT NULL,
  `dsc_rede_social` varchar(100) DEFAULT NULL,
  `icon_rede_social` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `seguidores_seguindo`
--

CREATE TABLE `seguidores_seguindo` (
  `FK_ARTISTA_id_artista` int(11) DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL,
  `id_seg` int(11) NOT NULL,
  `data_seg` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sit_usuario`
--

CREATE TABLE `sit_usuario` (
  `id_sit` int(11) NOT NULL,
  `dsc_sit` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `sit_usuario`
--

INSERT INTO `sit_usuario` (`id_sit`, `dsc_sit`) VALUES
(1, 'Ativo'),
(2, 'Inativo'),
(3, 'Aguardando Confirmação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `suporte`
--

CREATE TABLE `suporte` (
  `id_msg` int(11) NOT NULL,
  `dsc_msg` varchar(100) DEFAULT NULL,
  `data_msg` datetime DEFAULT NULL,
  `FK_USUARIO_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `suporte`
--

INSERT INTO `suporte` (`id_msg`, `dsc_msg`, `data_msg`, `FK_USUARIO_id_user`) VALUES
(1, 'Sla oq', '0000-00-00 00:00:00', 0),
(2, 'Sla oq', '0000-00-00 00:00:00', 0),
(3, 'AAAAAAAAAAAAAAAAA', '0000-00-00 00:00:00', 0),
(4, 'aaaaaaaa', '0000-00-00 00:00:00', 0),
(5, 'aaaaaaa', '0000-00-00 00:00:00', 0),
(6, 'aaaaaaa', '0000-00-00 00:00:00', 0),
(7, 'aaaaaaaaaa', '2022-08-09 22:28:32', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_comentario`
--

CREATE TABLE `tipo_comentario` (
  `id_tipo_coment` int(11) NOT NULL,
  `dsc_tipo_coment` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `codigo` int(11) NOT NULL,
  `dsc_tipo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`codigo`, `dsc_tipo`) VALUES
(1, 'Comum'),
(2, 'Casa de Show'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_user` int(11) NOT NULL,
  `senha_user` varchar(100) DEFAULT NULL,
  `email_user` varchar(100) DEFAULT NULL,
  `nome_user` varchar(100) DEFAULT NULL,
  `chave_confirm` varchar(100) DEFAULT NULL,
  `chave_recupera_senha` varchar(100) DEFAULT NULL,
  `photo_user` varchar(100) DEFAULT NULL,
  `dsc_user` varchar(100) DEFAULT NULL,
  `FK_TIPO_USUARIO_codigo` int(11) DEFAULT NULL,
  `FK_SIT_USUARIO_id_sit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_user`, `senha_user`, `email_user`, `nome_user`, `chave_confirm`, `chave_recupera_senha`, `photo_user`, `dsc_user`, `FK_TIPO_USUARIO_codigo`, `FK_SIT_USUARIO_id_sit`) VALUES
(0, '$2y$10$VmEqHKzNcz7iKvfHAUl37uqgzTi0wM.cc7kh6BaW1G7JIpqYJjA2q', 'dudinha140405@gmail.com', 'duda14', NULL, NULL, '520355991Perry the Platypus_ Agent P.jpg', 'Meu nome é Duda', 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`id_artista`),
  ADD KEY `FK_ARTISTA_2` (`FK_USUARIO_id_user`);

--
-- Índices para tabela `artista_genero`
--
ALTER TABLE `artista_genero`
  ADD KEY `FK_ARTISTA_GENERO_1` (`FK_GENERO_id_gen`),
  ADD KEY `FK_ARTISTA_GENERO_2` (`FK_ARTISTA_id_artista`);

--
-- Índices para tabela `artista_rede`
--
ALTER TABLE `artista_rede`
  ADD KEY `FK_ARTISTA_REDE_1` (`FK_ARTISTA_id_artista`),
  ADD KEY `FK_ARTISTA_REDE_2` (`FK_REDE_SOCIAL_id_rede_social`);

--
-- Índices para tabela `avaliacao_casa`
--
ALTER TABLE `avaliacao_casa`
  ADD PRIMARY KEY (`id_aval`),
  ADD KEY `FK_AVALIACAO_CASA_2` (`FK_CASA_DE_SHOW_id_casa`),
  ADD KEY `FK_AVALIACAO_CASA_3` (`FK_USUARIO_id_user`);

--
-- Índices para tabela `avaliacao_evento`
--
ALTER TABLE `avaliacao_evento`
  ADD PRIMARY KEY (`id_aval`),
  ADD KEY `FK_AVALIACAO_EVENTO_2` (`FK_EVENTO_id_evento`),
  ADD KEY `FK_AVALIACAO_EVENTO_3` (`FK_USUARIO_id_user`);

--
-- Índices para tabela `casa_de_show`
--
ALTER TABLE `casa_de_show`
  ADD PRIMARY KEY (`id_casa`),
  ADD KEY `FK_CASA_DE_SHOW_2` (`FK_USUARIO_id_user`);

--
-- Índices para tabela `casa_rede`
--
ALTER TABLE `casa_rede`
  ADD KEY `FK_CASA_REDE_1` (`FK_CASA_DE_SHOW_id_casa`),
  ADD KEY `FK_CASA_REDE_2` (`FK_REDE_SOCIAL_id_rede_social`);

--
-- Índices para tabela `catalogo`
--
ALTER TABLE `catalogo`
  ADD PRIMARY KEY (`id_catalog`),
  ADD KEY `FK_CATALOGO_2` (`FK_ARTISTA_id_artista`);

--
-- Índices para tabela `comentario_artista`
--
ALTER TABLE `comentario_artista`
  ADD PRIMARY KEY (`id_coment`),
  ADD KEY `FK_COMENTARIO_ARTISTA_2` (`FK_ARTISTA_id_artista`),
  ADD KEY `FK_COMENTARIO_ARTISTA_3` (`FK_USUARIO_id_user`),
  ADD KEY `FK_COMENTARIO_ARTISTA_4` (`FK_TIPO_COMENTARIO_id_tipo_coment`);

--
-- Índices para tabela `comentario_casa`
--
ALTER TABLE `comentario_casa`
  ADD PRIMARY KEY (`id_coment`),
  ADD KEY `FK_COMENTARIO_CASA_2` (`FK_CASA_DE_SHOW_id_casa`),
  ADD KEY `FK_COMENTARIO_CASA_3` (`FK_USUARIO_id_user`),
  ADD KEY `FK_COMENTARIO_CASA_4` (`FK_TIPO_COMENTARIO_id_tipo_coment`);

--
-- Índices para tabela `comentario_evento`
--
ALTER TABLE `comentario_evento`
  ADD PRIMARY KEY (`id_coment`),
  ADD KEY `FK_COMENTARIO_EVENTO_2` (`FK_EVENTO_id_evento`),
  ADD KEY `FK_COMENTARIO_EVENTO_3` (`FK_USUARIO_id_user`),
  ADD KEY `FK_COMENTARIO_EVENTO_4` (`FK_TIPO_COMENTARIO_id_tipo_coment`);

--
-- Índices para tabela `coment_resposta_artista`
--
ALTER TABLE `coment_resposta_artista`
  ADD KEY `FK_COMENT_RESPOSTA_ARTISTA_1` (`FK_COMENTARIO_ARTISTA_id_coment`),
  ADD KEY `FK_COMENT_RESPOSTA_ARTISTA_2` (`FK_COMENTARIO_ARTISTA_id_coment_resposta`);

--
-- Índices para tabela `coment_resposta_casa`
--
ALTER TABLE `coment_resposta_casa`
  ADD KEY `FK_COMENT_RESPOSTA_CASA_1` (`FK_COMENTARIO_CASA_id_coment`),
  ADD KEY `FK_COMENT_RESPOSTA_CASA_2` (`FK_COMENTARIO_CASA_id_coment_resposta`);

--
-- Índices para tabela `coment_resposta_evento`
--
ALTER TABLE `coment_resposta_evento`
  ADD KEY `FK_COMENT_RESPOSTA_EVENTO_1` (`FK_COMENTARIO_EVENTO_id_coment`),
  ADD KEY `FK_COMENT_RESPOSTA_EVENTO_2` (`FK_COMENTARIO_EVENTO_id_coment_resposta`);

--
-- Índices para tabela `curtir_curtido`
--
ALTER TABLE `curtir_curtido`
  ADD PRIMARY KEY (`id_curtida`),
  ADD KEY `FK_CURTIR_CURTIDO_2` (`FK_USUARIO_id_user`),
  ADD KEY `FK_CURTIR_CURTIDO_3` (`FK_ARTISTA_id_artista`);

--
-- Índices para tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `FK_EVENTO_2` (`FK_USUARIO_id_user`),
  ADD KEY `FK_EVENTO_3` (`FK_CASA_DE_SHOW_id_casa`);

--
-- Índices para tabela `foto_artista`
--
ALTER TABLE `foto_artista`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `FK_FOTO_ARTISTA_2` (`FK_ARTISTA_id_artista`);

--
-- Índices para tabela `foto_casa_de_show`
--
ALTER TABLE `foto_casa_de_show`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `FK_FOTO_CASA_DE_SHOW_2` (`FK_CASA_DE_SHOW_id_casa`);

--
-- Índices para tabela `foto_catalogo`
--
ALTER TABLE `foto_catalogo`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `FK_FOTO_CATALOGO_2` (`FK_CATALOGO_id_catalog`);

--
-- Índices para tabela `foto_evento`
--
ALTER TABLE `foto_evento`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `FK_FOTO_EVENTO_2` (`FK_EVENTO_id_evento`);

--
-- Índices para tabela `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_gen`);

--
-- Índices para tabela `rede_social`
--
ALTER TABLE `rede_social`
  ADD PRIMARY KEY (`id_rede_social`);

--
-- Índices para tabela `seguidores_seguindo`
--
ALTER TABLE `seguidores_seguindo`
  ADD PRIMARY KEY (`id_seg`),
  ADD KEY `FK_SEGUIDORES_SEGUINDO_2` (`FK_ARTISTA_id_artista`),
  ADD KEY `FK_SEGUIDORES_SEGUINDO_3` (`FK_USUARIO_id_user`);

--
-- Índices para tabela `sit_usuario`
--
ALTER TABLE `sit_usuario`
  ADD PRIMARY KEY (`id_sit`);

--
-- Índices para tabela `suporte`
--
ALTER TABLE `suporte`
  ADD PRIMARY KEY (`id_msg`),
  ADD KEY `FK_SUPORTE_2` (`FK_USUARIO_id_user`);

--
-- Índices para tabela `tipo_comentario`
--
ALTER TABLE `tipo_comentario`
  ADD PRIMARY KEY (`id_tipo_coment`);

--
-- Índices para tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `FK_USUARIO_2` (`FK_TIPO_USUARIO_codigo`),
  ADD KEY `FK_USUARIO_3` (`FK_SIT_USUARIO_id_sit`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `foto_artista`
--
ALTER TABLE `foto_artista`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `suporte`
--
ALTER TABLE `suporte`
  MODIFY `id_msg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `artista`
--
ALTER TABLE `artista`
  ADD CONSTRAINT `FK_ARTISTA_2` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `artista_genero`
--
ALTER TABLE `artista_genero`
  ADD CONSTRAINT `FK_ARTISTA_GENERO_1` FOREIGN KEY (`FK_GENERO_id_gen`) REFERENCES `genero` (`id_gen`),
  ADD CONSTRAINT `FK_ARTISTA_GENERO_2` FOREIGN KEY (`FK_ARTISTA_id_artista`) REFERENCES `artista` (`id_artista`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `artista_rede`
--
ALTER TABLE `artista_rede`
  ADD CONSTRAINT `FK_ARTISTA_REDE_1` FOREIGN KEY (`FK_ARTISTA_id_artista`) REFERENCES `artista` (`id_artista`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_ARTISTA_REDE_2` FOREIGN KEY (`FK_REDE_SOCIAL_id_rede_social`) REFERENCES `rede_social` (`id_rede_social`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `avaliacao_casa`
--
ALTER TABLE `avaliacao_casa`
  ADD CONSTRAINT `FK_AVALIACAO_CASA_2` FOREIGN KEY (`FK_CASA_DE_SHOW_id_casa`) REFERENCES `casa_de_show` (`id_casa`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_AVALIACAO_CASA_3` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `avaliacao_evento`
--
ALTER TABLE `avaliacao_evento`
  ADD CONSTRAINT `FK_AVALIACAO_EVENTO_2` FOREIGN KEY (`FK_EVENTO_id_evento`) REFERENCES `evento` (`id_evento`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_AVALIACAO_EVENTO_3` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `casa_de_show`
--
ALTER TABLE `casa_de_show`
  ADD CONSTRAINT `FK_CASA_DE_SHOW_2` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`);

--
-- Limitadores para a tabela `casa_rede`
--
ALTER TABLE `casa_rede`
  ADD CONSTRAINT `FK_CASA_REDE_1` FOREIGN KEY (`FK_CASA_DE_SHOW_id_casa`) REFERENCES `casa_de_show` (`id_casa`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_CASA_REDE_2` FOREIGN KEY (`FK_REDE_SOCIAL_id_rede_social`) REFERENCES `rede_social` (`id_rede_social`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `catalogo`
--
ALTER TABLE `catalogo`
  ADD CONSTRAINT `FK_CATALOGO_2` FOREIGN KEY (`FK_ARTISTA_id_artista`) REFERENCES `artista` (`id_artista`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `comentario_artista`
--
ALTER TABLE `comentario_artista`
  ADD CONSTRAINT `FK_COMENTARIO_ARTISTA_2` FOREIGN KEY (`FK_ARTISTA_id_artista`) REFERENCES `artista` (`id_artista`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMENTARIO_ARTISTA_3` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMENTARIO_ARTISTA_4` FOREIGN KEY (`FK_TIPO_COMENTARIO_id_tipo_coment`) REFERENCES `tipo_comentario` (`id_tipo_coment`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `comentario_casa`
--
ALTER TABLE `comentario_casa`
  ADD CONSTRAINT `FK_COMENTARIO_CASA_2` FOREIGN KEY (`FK_CASA_DE_SHOW_id_casa`) REFERENCES `casa_de_show` (`id_casa`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMENTARIO_CASA_3` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMENTARIO_CASA_4` FOREIGN KEY (`FK_TIPO_COMENTARIO_id_tipo_coment`) REFERENCES `tipo_comentario` (`id_tipo_coment`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `comentario_evento`
--
ALTER TABLE `comentario_evento`
  ADD CONSTRAINT `FK_COMENTARIO_EVENTO_2` FOREIGN KEY (`FK_EVENTO_id_evento`) REFERENCES `evento` (`id_evento`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMENTARIO_EVENTO_3` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMENTARIO_EVENTO_4` FOREIGN KEY (`FK_TIPO_COMENTARIO_id_tipo_coment`) REFERENCES `tipo_comentario` (`id_tipo_coment`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `coment_resposta_artista`
--
ALTER TABLE `coment_resposta_artista`
  ADD CONSTRAINT `FK_COMENT_RESPOSTA_ARTISTA_1` FOREIGN KEY (`FK_COMENTARIO_ARTISTA_id_coment`) REFERENCES `comentario_artista` (`id_coment`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMENT_RESPOSTA_ARTISTA_2` FOREIGN KEY (`FK_COMENTARIO_ARTISTA_id_coment_resposta`) REFERENCES `comentario_artista` (`id_coment`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `coment_resposta_casa`
--
ALTER TABLE `coment_resposta_casa`
  ADD CONSTRAINT `FK_COMENT_RESPOSTA_CASA_1` FOREIGN KEY (`FK_COMENTARIO_CASA_id_coment`) REFERENCES `comentario_casa` (`id_coment`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMENT_RESPOSTA_CASA_2` FOREIGN KEY (`FK_COMENTARIO_CASA_id_coment_resposta`) REFERENCES `comentario_casa` (`id_coment`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `coment_resposta_evento`
--
ALTER TABLE `coment_resposta_evento`
  ADD CONSTRAINT `FK_COMENT_RESPOSTA_EVENTO_1` FOREIGN KEY (`FK_COMENTARIO_EVENTO_id_coment`) REFERENCES `comentario_evento` (`id_coment`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMENT_RESPOSTA_EVENTO_2` FOREIGN KEY (`FK_COMENTARIO_EVENTO_id_coment_resposta`) REFERENCES `comentario_evento` (`id_coment`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `curtir_curtido`
--
ALTER TABLE `curtir_curtido`
  ADD CONSTRAINT `FK_CURTIR_CURTIDO_2` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_CURTIR_CURTIDO_3` FOREIGN KEY (`FK_ARTISTA_id_artista`) REFERENCES `artista` (`id_artista`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `FK_EVENTO_2` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EVENTO_3` FOREIGN KEY (`FK_CASA_DE_SHOW_id_casa`) REFERENCES `casa_de_show` (`id_casa`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `foto_artista`
--
ALTER TABLE `foto_artista`
  ADD CONSTRAINT `FK_FOTO_ARTISTA_2` FOREIGN KEY (`FK_ARTISTA_id_artista`) REFERENCES `artista` (`id_artista`);

--
-- Limitadores para a tabela `foto_casa_de_show`
--
ALTER TABLE `foto_casa_de_show`
  ADD CONSTRAINT `FK_FOTO_CASA_DE_SHOW_2` FOREIGN KEY (`FK_CASA_DE_SHOW_id_casa`) REFERENCES `casa_de_show` (`id_casa`);

--
-- Limitadores para a tabela `foto_catalogo`
--
ALTER TABLE `foto_catalogo`
  ADD CONSTRAINT `FK_FOTO_CATALOGO_2` FOREIGN KEY (`FK_CATALOGO_id_catalog`) REFERENCES `catalogo` (`id_catalog`);

--
-- Limitadores para a tabela `foto_evento`
--
ALTER TABLE `foto_evento`
  ADD CONSTRAINT `FK_FOTO_EVENTO_2` FOREIGN KEY (`FK_EVENTO_id_evento`) REFERENCES `evento` (`id_evento`);

--
-- Limitadores para a tabela `seguidores_seguindo`
--
ALTER TABLE `seguidores_seguindo`
  ADD CONSTRAINT `FK_SEGUIDORES_SEGUINDO_2` FOREIGN KEY (`FK_ARTISTA_id_artista`) REFERENCES `artista` (`id_artista`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_SEGUIDORES_SEGUINDO_3` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `suporte`
--
ALTER TABLE `suporte`
  ADD CONSTRAINT `FK_SUPORTE_2` FOREIGN KEY (`FK_USUARIO_id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_USUARIO_2` FOREIGN KEY (`FK_TIPO_USUARIO_codigo`) REFERENCES `tipo_usuario` (`codigo`),
  ADD CONSTRAINT `FK_USUARIO_3` FOREIGN KEY (`FK_SIT_USUARIO_id_sit`) REFERENCES `sit_usuario` (`id_sit`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
