-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Maio-2023 às 21:11
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `eventify2`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `modificar_evento` (IN `nom` VARCHAR(255), IN `fot` VARCHAR(1000), IN `lk` TEXT, IN `data_eve` DATE, IN `descri` VARCHAR(255), IN `categ` INT(11), IN `estab` INT(11), IN `cida` INT(11), IN `id_ev` INT(11), IN `id_img` INT(11), IN `id_usu` INT(11))   begin
UPDATE evento
set nome_evento= nom, link = lk, data_evento = data_eve,descricao_evento = descri, id_categoria = categ,id_estabelecimento = estab, id_cidade_evento = cida, id_usuario_resp = id_usu
where id = id_ev;
update imagens_evento
set img = fot, img_principal = 1
where id = id_img;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `modificar_usuario` (IN `n` VARCHAR(255), IN `s` VARCHAR(255), IN `em` VARCHAR(255), IN `id_niv` INT(11), IN `id_u` INT(11), IN `descri` VARCHAR(400), IN `foto_perfil` VARCHAR(400))   BEGIN
UPDATE usuarios SET nome = n, senha = s, id_nivel = id_niv, descricao = descri, foto = foto_perfil WHERE ID = id_u;
UPDATE emails_tabela SET email = em WHERE id_usuario = id_u;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_estabelecimento` (IN `id_cate` INT(11), IN `id_usu` INT(11), IN `id_cid` INT(11), IN `nom` VARCHAR(255), IN `emai` VARCHAR(255), IN `foto` VARCHAR(255))   BEGIN
DECLARE id INT;
insert into estabelecimento(id_catego_estab,id_usuario,id_cidade,nome,email,img)
VALUES (id_cate, id_usu,id_cid,nom,emai,foto);
set id = LAST_INSERT_ID();


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_evento` (IN `nom` VARCHAR(255), IN `lin` VARCHAR(255), IN `dat` DATE, IN `descr` VARCHAR(255), IN `id_cat` INT(11), IN `id_est` INT(11), IN `id_cid` INT(11), IN `img` VARCHAR(255), IN `id_usu_resp` INT(11))   begin
DECLARE uid INT;
insert into evento(nome_evento,link,data_evento,descricao_evento,id_categoria,id_estabelecimento,id_cidade_evento,id_usuario_resp) VALUES(nom,lin,dat,descr,id_cat,id_est,id_cid,id_usu_resp);


SET uid = LAST_INSERT_ID();

insert into imagens_evento(id_evento, img_principal, img) 
Values (uid, 1, img);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_usuario` (IN `n` VARCHAR(255), IN `s` VARCHAR(255), IN `Id_niv` INT(11), IN `em` VARCHAR(255), IN `descri` VARCHAR(400), IN `foto_perfil` VARCHAR(255))   begin
DECLARE id_usu INT;

INSERT INTO usuarios
  (nome, senha, id_nivel, descricao, foto)
VALUES
  (n, s, Id_niv ,descri, foto_perfil);
  SET id_usu = LAST_INSERT_ID();
INSERT INTO emails_tabela
	(email,primario,id_usuario)
VALUES
   (em,1,id_usu);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliação`
--

CREATE TABLE `avaliação` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `id_estabelecimento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE `cidade` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails_tabela`
--

CREATE TABLE `emails_tabela` (
  `id_email` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `primario` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estabelecimento`
--

CREATE TABLE `estabelecimento` (
  `id` int(11) NOT NULL,
  `id_catego_estab` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cidade` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estabelec_categoria`
--

CREATE TABLE `estabelec_categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `nome_evento` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `data_evento` date NOT NULL,
  `descricao_evento` varchar(255) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_estabelecimento` int(11) NOT NULL,
  `id_cidade_evento` int(11) NOT NULL,
  `id_usuario_resp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento_categoria`
--

CREATE TABLE `evento_categoria` (
  `ID` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens_evento`
--

CREATE TABLE `imagens_evento` (
  `id` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `img_principal` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_usuario`
--

CREATE TABLE `nivel_usuario` (
  `ID` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `nivel_usuario`
--

INSERT INTO `nivel_usuario` (`ID`, `nome`) VALUES
(1, 'Admin'),
(2, 'Padrão');

-- --------------------------------------------------------

--
-- Estrutura da tabela `redes_sociais`
--

CREATE TABLE `redes_sociais` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relacao_usuario`
--

CREATE TABLE `relacao_usuario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relação_estabelecimento`
--

CREATE TABLE `relação_estabelecimento` (
  `id` int(11) NOT NULL,
  `id_estabelecimento` int(11) NOT NULL,
  `id_rede` int(11) NOT NULL,
  `link_rede` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `foto` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `usuarios_login`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `usuarios_login` (
`email` varchar(255)
,`senha` varchar(255)
,`ID` int(11)
,`nome` varchar(255)
,`descricao` varchar(500)
,`foto` varchar(300)
,`id_nivel` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `view_estabelecimento`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `view_estabelecimento` (
`id` int(11)
,`nome` varchar(255)
,`nome_usuario` varchar(255)
,`id_usuario` int(11)
,`cidade` varchar(255)
,`categoria` varchar(255)
,`email` varchar(255)
,`img` varchar(255)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `view_eventos`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `view_eventos` (
`id` int(11)
,`Nome` varchar(255)
,`link` text
,`data_evento` date
,`descricao_evento` varchar(255)
,`Categoria` varchar(255)
,`Estabelecimento_Resp` varchar(255)
,`id_estab` int(11)
,`id_usu_resp` int(11)
,`Cidade` varchar(255)
,`Imagem` text
,`id_img` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `view_redes_sociais`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `view_redes_sociais` (
`id` int(11)
,`link_rede` varchar(255)
,`estabelecimento` varchar(255)
,`id_estab` int(11)
,`rede_social` varchar(255)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `view_tags`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `view_tags` (
`id` int(11)
,`id_usuario` int(11)
,`nome` varchar(255)
,`id_tag` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura para vista `usuarios_login`
--
DROP TABLE IF EXISTS `usuarios_login`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usuarios_login`  AS SELECT `emails_tabela`.`email` AS `email`, `usuarios`.`senha` AS `senha`, `usuarios`.`ID` AS `ID`, `usuarios`.`nome` AS `nome`, `usuarios`.`descricao` AS `descricao`, `usuarios`.`foto` AS `foto`, `usuarios`.`id_nivel` AS `id_nivel` FROM (`emails_tabela` join `usuarios` on(`emails_tabela`.`id_usuario` = `usuarios`.`ID`)) WHERE `emails_tabela`.`primario` = 11  ;

-- --------------------------------------------------------

--
-- Estrutura para vista `view_estabelecimento`
--
DROP TABLE IF EXISTS `view_estabelecimento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_estabelecimento`  AS SELECT `estabelecimento`.`id` AS `id`, `estabelecimento`.`nome` AS `nome`, `usuarios`.`nome` AS `nome_usuario`, `usuarios`.`ID` AS `id_usuario`, `cidade`.`nome` AS `cidade`, `estabelec_categoria`.`nome` AS `categoria`, `estabelecimento`.`email` AS `email`, `estabelecimento`.`img` AS `img` FROM (((`estabelecimento` join `usuarios` on(`estabelecimento`.`id_usuario` = `usuarios`.`ID`)) join `cidade` on(`estabelecimento`.`id_cidade` = `cidade`.`id`)) join `estabelec_categoria` on(`estabelecimento`.`id_catego_estab` = `estabelec_categoria`.`id`))  ;

-- --------------------------------------------------------

--
-- Estrutura para vista `view_eventos`
--
DROP TABLE IF EXISTS `view_eventos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_eventos`  AS SELECT `evento`.`id` AS `id`, `evento`.`nome_evento` AS `Nome`, `evento`.`link` AS `link`, `evento`.`data_evento` AS `data_evento`, `evento`.`descricao_evento` AS `descricao_evento`, `evento_categoria`.`nome` AS `Categoria`, `estabelecimento`.`nome` AS `Estabelecimento_Resp`, `estabelecimento`.`id` AS `id_estab`, `usuarios`.`ID` AS `id_usu_resp`, `cidade`.`nome` AS `Cidade`, (select `imagens_evento`.`img` from `imagens_evento` where `imagens_evento`.`id_evento` = `evento`.`id` and `imagens_evento`.`img_principal` = 1) AS `Imagem`, (select `imagens_evento`.`id` from `imagens_evento` where `imagens_evento`.`id_evento` = `evento`.`id` and `imagens_evento`.`img_principal` = 1) AS `id_img` FROM ((((`evento` join `estabelecimento` on(`evento`.`id_estabelecimento` = `estabelecimento`.`id`)) join `cidade` on(`evento`.`id_cidade_evento` = `cidade`.`id`)) join `evento_categoria` on(`evento`.`id_categoria` = `evento_categoria`.`ID`)) join `usuarios` on(`evento`.`id_usuario_resp` = `usuarios`.`ID`))  ;

-- --------------------------------------------------------

--
-- Estrutura para vista `view_redes_sociais`
--
DROP TABLE IF EXISTS `view_redes_sociais`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_redes_sociais`  AS SELECT `relação_estabelecimento`.`id` AS `id`, `relação_estabelecimento`.`link_rede` AS `link_rede`, `estabelecimento`.`nome` AS `estabelecimento`, `estabelecimento`.`id` AS `id_estab`, `redes_sociais`.`nome` AS `rede_social` FROM ((`relação_estabelecimento` join `estabelecimento` on(`relação_estabelecimento`.`id_estabelecimento` = `estabelecimento`.`id`)) join `redes_sociais` on(`relação_estabelecimento`.`id_rede` = `redes_sociais`.`id`))  ;

-- --------------------------------------------------------

--
-- Estrutura para vista `view_tags`
--
DROP TABLE IF EXISTS `view_tags`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_tags`  AS SELECT `relacao_usuario`.`id` AS `id`, `relacao_usuario`.`id_usuario` AS `id_usuario`, `tags`.`nome` AS `nome`, `relacao_usuario`.`id_tag` AS `id_tag` FROM (`relacao_usuario` join `tags` on(`relacao_usuario`.`id_tag` = `tags`.`id`))  ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliação`
--
ALTER TABLE `avaliação`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estabelecimento` (`id_estabelecimento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `cidade`
--
ALTER TABLE `cidade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `emails_tabela`
--
ALTER TABLE `emails_tabela`
  ADD PRIMARY KEY (`id_email`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `estabelecimento`
--
ALTER TABLE `estabelecimento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_catego_estab` (`id_catego_estab`),
  ADD KEY `id_cidade` (`id_cidade`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `estabelec_categoria`
--
ALTER TABLE `estabelec_categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_estabelecimento` (`id_estabelecimento`),
  ADD KEY `id_cidade_evento` (`id_cidade_evento`),
  ADD KEY `id_usuario_resp` (`id_usuario_resp`);

--
-- Índices para tabela `evento_categoria`
--
ALTER TABLE `evento_categoria`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `imagens_evento`
--
ALTER TABLE `imagens_evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Índices para tabela `nivel_usuario`
--
ALTER TABLE `nivel_usuario`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `redes_sociais`
--
ALTER TABLE `redes_sociais`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `relacao_usuario`
--
ALTER TABLE `relacao_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_tag` (`id_tag`);

--
-- Índices para tabela `relação_estabelecimento`
--
ALTER TABLE `relação_estabelecimento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estabelecimento` (`id_estabelecimento`),
  ADD KEY `id_rede` (`id_rede`);

--
-- Índices para tabela `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliação`
--
ALTER TABLE `avaliação`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cidade`
--
ALTER TABLE `cidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `emails_tabela`
--
ALTER TABLE `emails_tabela`
  MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estabelecimento`
--
ALTER TABLE `estabelecimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estabelec_categoria`
--
ALTER TABLE `estabelec_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `evento_categoria`
--
ALTER TABLE `evento_categoria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `imagens_evento`
--
ALTER TABLE `imagens_evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nivel_usuario`
--
ALTER TABLE `nivel_usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `redes_sociais`
--
ALTER TABLE `redes_sociais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `relacao_usuario`
--
ALTER TABLE `relacao_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `relação_estabelecimento`
--
ALTER TABLE `relação_estabelecimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliação`
--
ALTER TABLE `avaliação`
  ADD CONSTRAINT `avaliação_ibfk_1` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimento` (`id`),
  ADD CONSTRAINT `avaliação_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`ID`);

--
-- Limitadores para a tabela `emails_tabela`
--
ALTER TABLE `emails_tabela`
  ADD CONSTRAINT `emails_tabela_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `estabelecimento`
--
ALTER TABLE `estabelecimento`
  ADD CONSTRAINT `estabelecimento_ibfk_1` FOREIGN KEY (`id_catego_estab`) REFERENCES `estabelec_categoria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estabelecimento_ibfk_2` FOREIGN KEY (`id_cidade`) REFERENCES `cidade` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estabelecimento_ibfk_4` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `evento_categoria` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimento` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evento_ibfk_3` FOREIGN KEY (`id_cidade_evento`) REFERENCES `cidade` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evento_ibfk_4` FOREIGN KEY (`id_usuario_resp`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `imagens_evento`
--
ALTER TABLE `imagens_evento`
  ADD CONSTRAINT `imagens_evento_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `relacao_usuario`
--
ALTER TABLE `relacao_usuario`
  ADD CONSTRAINT `relacao_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `relacao_usuario_ibfk_2` FOREIGN KEY (`id_tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `relação_estabelecimento`
--
ALTER TABLE `relação_estabelecimento`
  ADD CONSTRAINT `relação_estabelecimento_ibfk_1` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimento` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `relação_estabelecimento_ibfk_2` FOREIGN KEY (`id_rede`) REFERENCES `redes_sociais` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `nivel_usuario` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
