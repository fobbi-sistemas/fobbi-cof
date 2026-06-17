CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(2) DEFAULT NULL,
  `nome` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT IGNORE INTO `estado` (`id`, `sigla`, `nome`) VALUES
(1,'AC','Acre'),
(2,'AL','Alagoas'),
(3,'AP','Amapá'),
(4,'AM','Amazonas'),
(5,'BA','Bahia'),
(6,'CE','Ceará'),
(7,'DF','Distrito Federal'),
(8,'ES','Espírito Santo'),
(9,'GO','Goiás'),
(10,'MA','Maranhão'),
(11,'MT','Mato Grosso'),
(12,'MS','Mato Grosso do Sul'),
(13,'MG','Minas Gerais'),
(14,'PA','Pará'),
(15,'PB','Paraíba'),
(16,'PR','Paraná'),
(17,'PE','Pernambuco'),
(18,'PI','Piauí'),
(19,'RJ','Rio de Janeiro'),
(20,'RN','Rio Grande do Norte'),
(21,'RS','Rio Grande do Sul'),
(22,'RO','Rondônia'),
(23,'RR','Roraima'),
(24,'SC','Santa Catarina'),
(25,'SP','São Paulo'),
(26,'SE','Sergipe'),
(27,'TO','Tocantins');

CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idEstado` int(11) DEFAULT NULL,
  `nome` varchar(500) DEFAULT NULL,
  `nomeCartaoCnpj` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idEstado` (`idEstado`),
  CONSTRAINT `cidade_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`id`)
);

CREATE TABLE IF NOT EXISTS `mc2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ativo` tinyint(1) DEFAULT 1,
  `data` datetime DEFAULT current_timestamp(),
  `nomeFantasia` varchar(255) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `nomeResponsavel` varchar(255) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `perfil` varchar(50) DEFAULT NULL,
  `mc1` tinyint(1) DEFAULT 0,
  `mc2` tinyint(1) DEFAULT 0,
  `mc3` tinyint(1) DEFAULT 0,
  `mc4` tinyint(1) DEFAULT 0,
  `mc5` tinyint(1) DEFAULT 0,
  `mc6` tinyint(1) DEFAULT 0,
  `logo` varchar(500) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  `idCidade` int(11) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idEstado` (`idEstado`),
  KEY `idCidade` (`idCidade`),
  CONSTRAINT `mc2_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`id`),
  CONSTRAINT `mc2_ibfk_2` FOREIGN KEY (`idCidade`) REFERENCES `cidade` (`id`)
);