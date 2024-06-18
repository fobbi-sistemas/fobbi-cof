DELETE FROM campoOpcao WHERE idCampo = 2;
DELETE FROM campo WHERE id = 2;

ALTER TABLE oportunidade ADD COLUMN valorUltimoPedido decimal(16,2);
ALTER TABLE oportunidade ADD COLUMN dataUltimoPedido datetime;
ALTER TABLE oportunidade ADD COLUMN lojaUltimoPedido varchar(255);

ALTER TABLE oportunidade ADD COLUMN marca varchar(255);