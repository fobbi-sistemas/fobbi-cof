<?php
namespace Src\Repository;

use PDO;
use Exception;
use Src\Exception\MyException;
use Src\Model\Card;
use Src\Exception\DefaultException;

class CardRepository extends GenericRepository
{

    public function findAll($filter, $page)
    {
        try {
            $limit = 25;
            $limitStart = ($page - 1) * $limit;

            $sql = "SELECT * FROM card WHERE ativo IS TRUE";
            $sql .= " ORDER BY nome DESC";

            if (! empty($page)) {
                $sql .= " LIMIT :limitStart , :limit";
            }

            $cst = $this->con->conectar()->prepare($sql);

            if (! empty($page)) {
                $cst->bindValue(":limit", $limit, PDO::PARAM_INT);
                $cst->bindValue(":limitStart", $limitStart, PDO::PARAM_INT);
            }

            $cst->execute();
            $result = array();

            foreach ($cst->fetchAll(PDO::FETCH_ASSOC) as $obj) {
                $entity = new Card();
                $entity->setId($obj['id']);
                $entity->setNome($obj['nome']);
                $entity->setSegmento($obj['segmento']);
                $entity->setAtivo($obj['ativo']);
                $result[] = $entity;
            }
            return $result;
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM card WHERE id = :id;");
            $cst->bindParam(":id", $id);
            $cst->execute();
            $obj = $cst->fetch(PDO::FETCH_ASSOC);

            $entity = new Card();
            $entity->setId($obj['id']);
            $entity->setNome($obj['nome']);
            $entity->setSegmento($obj['segmento']);
            $entity->setLink($obj['link']);
            $entity->setImagem("../../../../files/blog/" . $obj['imagem']);
            $entity->setAtivo($obj['ativo']);
            return $entity;
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    // METODOS DE CRUD
    public function save(Card $entity, $file)
    {
        if (empty($entity->getId())) {
            $this->insert($entity);
        } else {
            $this->update($entity);
        }
        $this->uploadFile($entity->getId(), $file);
        return $entity;
    }

    private function insert(Card $entity)
    {
        try {
            $sql = "INSERT INTO card (nome, segmento, link, ativo) VALUES (:nome, :segmento, :link, TRUE)";

            $conexao = $this->con->conectar();
            $cst = $conexao->prepare($sql);
            $cst->bindValue(":nome", $entity->getNome(), PDO::PARAM_STR);
            $cst->bindValue(":segmento", $entity->getSegmento(), PDO::PARAM_STR);
            $cst->bindValue(":link", $entity->getLink(), PDO::PARAM_STR);
            $cst->execute();
            $entity->setId($conexao->lastInsertId());
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    private function update(Card $entity)
    {
        try {
            $sql = "UPDATE card SET nome = :nome, segmento = :segmento, link = :link, ativo = :ativo WHERE id = :id;";

            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindValue(":id", $entity->getId(), PDO::PARAM_INT);
            $cst->bindValue(":nome", $entity->getNome(), PDO::PARAM_STR);
            $cst->bindValue(":segmento", $entity->getSegmento(), PDO::PARAM_STR);
            $cst->bindValue(":link", $entity->getLink(), PDO::PARAM_STR);
            $cst->bindValue(":ativo", $entity->getAtivo(), PDO::PARAM_BOOL);
            $cst->execute();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    private function uploadFile($id, $file)
    {
        if (! empty($file['imagem']['tmp_name'])) {
            
            if ($file['imagem']['size'] > 370000) {
                throw new DefaultException("Oops, para um melhor desempenho o arquivo deve ter menos de 360 kilobytes.");
            }
            
            $this->removeFile($id);
            $this->uploadNewFile($id, $file);
        }
    }
    
    private function removeFile($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT imagem FROM card WHERE id = :id");
            $cst->bindParam(":id", $id, PDO::PARAM_INT);
            $cst->execute();
            $arquivo = $cst->fetch();
            
            if (! empty($arquivo['imagem']) && file_exists("../../../../files/blog/" . $arquivo['imagem'])) {
                unlink("../../../../files/blog/" . $arquivo['imagem']);
            }
            
            $cst = $this->con->conectar()->prepare("UPDATE card SET imagem = NULL WHERE id = :id");
            $cst->bindParam(":id", $id, PDO::PARAM_INT);
            $cst->execute();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    private function uploadNewFile($id, $file)
    {
        try {
            $fileTemp = $file['imagem']['tmp_name'];
            $diretorio = "../../../../files/blog/";
            $nameFileTemp = $file['imagem']['name'];
            $nomeArquivo = uniqid() . date('YmdHis') . "-1" . strrchr($nameFileTemp, '.');
            
            // MOVE ARQUIVO DO INPUT FILE PARA O NOVO DIRETORIO CRIADO
            move_uploaded_file($fileTemp, $diretorio . $nomeArquivo);
            chmod($diretorio . $nomeArquivo, 0755);
            
            $conexao = $this->con->conectar();
            $cst = $conexao->prepare("UPDATE card SET imagem = :imagem WHERE id = :id;");
            $cst->bindParam(":id", $id);
            $cst->bindParam(":imagem", $nomeArquivo);
            $cst->execute();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
}

?>