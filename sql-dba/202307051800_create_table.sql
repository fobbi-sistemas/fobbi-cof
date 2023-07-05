-- CREATE TABLE CAMPO
CREATE TABLE campo (
	id INTEGER NOT NULL AUTO_INCREMENT,
	ativo BOOLEAN DEFAULT TRUE,
	nome CHARACTER VARYING(255) NOT NULL,
	tipo CHARACTER varying(255) NOT NULL,
  	PRIMARY KEY (`id`)
);

-- CREATE TABLE CAMPOOPCAO
CREATE TABLE campoOpcao (
	id INTEGER NOT NULL AUTO_INCREMENT,
	idCampo INTEGER NOT NULL,
	ativo BOOLEAN DEFAULT TRUE,
	ordem INTEGER,
	nome CHARACTER VARYING(255) NOT NULL,
  	PRIMARY KEY (`id`)
);

ALTER TABLE campoOpcao
	ADD FOREIGN KEY(idCampo) REFERENCES campo(id);

-- CREATE TABLE FORMULARIO
CREATE TABLE formulario (
	id INTEGER NOT NULL AUTO_INCREMENT,
	nome CHARACTER VARYING(255) NOT NULL,
	link CHARACTER VARYING(255) NOT NULL,
  	PRIMARY KEY (`id`)
);

CREATE TABLE formularioCampo (
	id INTEGER NOT NULL AUTO_INCREMENT,
	idFormulario INTEGER NOT NULL,
	idCampo INTEGER NOT NULL,
  	PRIMARY KEY (`id`)
);

ALTER TABLE formularioCampo
	ADD FOREIGN KEY(idFormulario) REFERENCES formulario(id);

ALTER TABLE formularioCampo
	ADD FOREIGN KEY(idCampo) REFERENCES campo(id);

INSERT INTO formulario VALUES (DEFAULT, 'Indicar', 'www.fobbi.com.br/indicacao');
INSERT INTO formulario VALUES (DEFAULT, 'Solicitar', 'www.fobbi.com.br/indicacao');
INSERT INTO formulario VALUES (DEFAULT, 'Cotação', 'www.fobbi.com.br/distribuidor-material-construcao-cotacao');

INSERT INTO formularioCampo VALUES (DEFAULT, 1, 1);
INSERT INTO formularioCampo VALUES (DEFAULT, 2, 1);

-- CAMPO OPORTUNIDADECAMPO
CREATE TABLE oportunidadeCampo (
	id INTEGER NOT NULL AUTO_INCREMENT,
	idOportunidade INTEGER NOT NULL,
	idCampo INTEGER NOT NULL,
	valor CHARACTER VARYING(255) NOT NULL,
  	PRIMARY KEY (`id`)
);

ALTER TABLE oportunidadeCampo
	ADD FOREIGN KEY(idOportunidade) REFERENCES oportunidade(id);

ALTER TABLE oportunidadeCampo
	ADD FOREIGN KEY(idCampo) REFERENCES campo(id);