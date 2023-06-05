CREATE TABLE usuarioApi (
	id INTEGER NOT NULL AUTO_INCREMENT,
	nome CHARACTER VARYING(255),
	senha CHARACTER varying(255),
  	PRIMARY KEY (`id`)
);

ALTER TABLE formulario ADD COLUMN processadoDadosCnpj BOOLEAN DEFAULT FALSE;

UPDATE formulario processadoDadosCnpj = true;
UPDATE formulario SET pessoaResponsavel = nome WHERE nome <> '';