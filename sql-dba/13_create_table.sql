-- CREATE TABLE
CREATE TABLE oportunidade_status (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	id_oportunidade INTEGER,
    nome CHARACTER VARYING(500),
	data datetime
);

ALTER TABLE oportunidade_status
	ADD FOREIGN KEY(id_oportunidade) REFERENCES oportunidade(id);

-- ALTER COLUNS
UPDATE oportunidade SET status = statusFacilCatalogos;
ALTER TABLE oportunidade DROP COLUMN statusFacilCatalogos;
UPDATE oportunidade SET status = 'LEAD' WHERE status = 'NAO_ENCONTRADO';
UPDATE oportunidade SET status = 'LEAD' WHERE status = 'CONSULTANDO';
UPDATE oportunidade SET status = 'LEAD' WHERE status = 'PENDENTE';

-- INSERT
INSERT INTO oportunidade_status (id_oportunidade, nome, data)
SELECT
    o.id,              
    o.status,        
    NULL
FROM
    oportunidade AS o;

ALTER TABLE oportunidade DROP COLUMN status;

-- UPDATE LEAD
UPDATE oportunidade_status os
INNER JOIN oportunidade o ON os.id_oportunidade = o.id
SET os.data = o.data
WHERE os.nome = 'LEAD';