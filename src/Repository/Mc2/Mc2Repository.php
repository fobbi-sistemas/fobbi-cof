<?php

namespace Src\Repository\Mc2;

use Src\Repository\GenericRepository;
use Src\Exception\MyException;
use Exception;
use PDO;

class Mc2Repository extends GenericRepository
{
    public function findAll($filter, $page)
    {
        try {
            $limit      = 25;
            $limitStart = ($page - 1) * $limit;

            $sql = "SELECT m.*, e.sigla AS uf, c.nome AS nomeCidade
                    FROM mc2 m
                    LEFT JOIN estado e  ON m.idEstado = e.id
                    LEFT JOIN cidade c  ON m.idCidade = c.id
                    WHERE 1=1";

            if (!empty($filter['dataCadastroInicial'])) {
                $sql .= " AND DATE(m.data) >= :dataCadastroInicial";
            }
            if (!empty($filter['dataCadastroFinal'])) {
                $sql .= " AND DATE(m.data) <= :dataCadastroFinal";
            }
            if (!empty($filter['perfil'])) {
                $sql .= " AND m.perfil = :perfil";
            }
            if (isset($filter['ativo']) && $filter['ativo'] !== '') {
                $sql .= " AND m.ativo = :ativo";
            }

            $sql .= " ORDER BY m.data DESC";

            if (!empty($page)) {
                $sql .= " LIMIT :limitStart, :limit";
            }

            $cst = $this->con->conectar()->prepare($sql);

            if (!empty($filter['dataCadastroInicial'])) {
                $cst->bindValue(":dataCadastroInicial", $filter['dataCadastroInicial']);
            }
            if (!empty($filter['dataCadastroFinal'])) {
                $cst->bindValue(":dataCadastroFinal", $filter['dataCadastroFinal']);
            }
            if (!empty($filter['perfil'])) {
                $cst->bindValue(":perfil", $filter['perfil']);
            }
            if (isset($filter['ativo']) && $filter['ativo'] !== '') {
                $cst->bindValue(":ativo", (int)$filter['ativo'], PDO::PARAM_INT);
            }

            if (!empty($page)) {
                $cst->bindValue(":limit", $limit, PDO::PARAM_INT);
                $cst->bindValue(":limitStart", $limitStart, PDO::PARAM_INT);
            }

            $cst->execute();
            return $cst->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            $sql = "SELECT m.*, e.sigla AS uf, e.nome AS nomeEstado, c.nome AS nomeCidade
                    FROM mc2 m
                    LEFT JOIN estado e ON m.idEstado = e.id
                    LEFT JOIN cidade c ON m.idCidade = c.id
                    WHERE m.id = :id";
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $id, PDO::PARAM_INT);
            $cst->execute();
            return $cst->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    public function save($id, $dados)
    {
        try {
            $ativo       = isset($dados['ativo']) ? 1 : 0;
            $observacao  = trim($dados['observacao'] ?? '');

            $sql = "UPDATE mc2 SET ativo = :ativo, observacao = :observacao WHERE id = :id";
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id",         $id,         PDO::PARAM_INT);
            $cst->bindParam(":ativo",      $ativo,      PDO::PARAM_INT);
            $cst->bindParam(":observacao", $observacao);
            $cst->execute();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
}
