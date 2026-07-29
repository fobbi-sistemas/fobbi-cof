-- fobbi.vw_oportunidade_detalhes_completos source

CREATE OR REPLACE
ALGORITHM = UNDEFINED VIEW `vw_oportunidade_detalhes_completos` AS
SELECT
    `o`.`id` AS `id`,
    `o`.`idCnpj` AS `cnpj`,
    `o`.`razaoSocial` AS `razao_social`,
    `o`.`nomeFantasia` AS `nome_fantasia`,
    `co`.`nome` AS `indicacao`,
    CASE
        WHEN `o`.`data` >= '2025-06-01' THEN `osla`.`data`
        ELSE `o`.`data`
    END AS `data_cadastro`,
    (
    SELECT
        `oportunidade_status`.`nome`
    FROM
        `oportunidade_status`
    WHERE
        `oportunidade_status`.`id_oportunidade` = `o`.`id`
    ORDER BY
        `oportunidade_status`.`data` DESC
    LIMIT 1) AS `ultimo_status`,
    (
    SELECT
        `oportunidade_status`.`data`
    FROM
        `oportunidade_status`
    WHERE
        `oportunidade_status`.`id_oportunidade` = `o`.`id`
    ORDER BY
        `oportunidade_status`.`data` DESC
    LIMIT 1) AS `data_ultimo_status`,
    `o`.`valorUltimoPedido` AS `valor_ultimo_pedido`,
    `o`.`pedidoAcumulado` AS `valor_total_pedidos`,
    CASE
        WHEN `o`.`data` > '2025-06-01' THEN CAST(substring_index(`o`.`tempo_resposta`, ':', 1) AS signed) * 3600 + CAST(substring_index(substring_index(`o`.`tempo_resposta`, ':', 2), ':',-1) AS signed) * 60 + CAST(substring_index(`o`.`tempo_resposta`, ':',-1) AS signed)
        ELSE NULL
    END AS `tempo_resposta`
FROM
    (((`oportunidade` `o`
LEFT JOIN `oportunidade_status` `osla` ON
    (`o`.`id` = `osla`.`id_oportunidade` AND `osla`.`nome` = 'LEAD'))
LEFT JOIN `oportunidadeCampo` `oc` ON
    (`o`.`id` = `oc`.`idOportunidade`))
LEFT JOIN `campoOpcao` `co` ON
    (`oc`.`valor` = `co`.`id`));