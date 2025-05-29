<?php
namespace Src\Repository\LandingPage\Oportunidade;

use PDO;
use DateTime;
use Exception;
use Src\Repository\GenericRepository;
use Src\Exception\MyException;

class OportunidadeRepository extends GenericRepository
{

    public function findAll($filter, $page)
    {
        try {
            $limit = 25;
            $limitStart = ($page - 1) * $limit;
            
            $sql = "SELECT o.*, osl.data AS dataLead, osla.data AS dataAtendimento,";
            $sql .= " (SELECT nome FROM oportunidade_status WHERE id_oportunidade = o.id ORDER BY data DESC, id DESC LIMIT 1) AS status";
            $sql .= " FROM oportunidade o";
            $sql .= " LEFT JOIN oportunidade_status osl ON o.id = osl.id_oportunidade AND osl.nome = 'LEAD'";
            $sql .= " LEFT JOIN oportunidade_status osla ON o.id = osla.id_oportunidade AND osla.nome = 'ATENDIMENTO'";
            $sql .= " WHERE ativo IS TRUE";
            
            if (! empty($filter['dataCadastroInicial'])) {
                $sql .= " AND data >= :dataCadastroInicial";
            }
            
            if (! empty($filter['dataCadastroFinal'])) {
                $sql .= " AND data <= :dataCadastroFinal";
            }

            if (! empty($filter['status'])) {
                $sql .= " AND (SELECT os.nome FROM oportunidade_status os WHERE os.id_oportunidade = o.id ORDER BY os.data DESC LIMIT 1) = :status";
            }
            
            if (! empty($filter['origem']) && $filter['origem'] == "NAO_DEFINIDO") {
                $sql .= " AND (origem IS NULL OR origem = '')";
            } elseif (! empty($filter['origem'])) {
                $sql .= " AND origem = :origem";
            }
            
            $sql .= " ORDER BY data DESC";
            
            if (! empty($page)) {
                $sql .= " LIMIT :limitStart , :limit";
            }
            
            $cst = $this->con->conectar()->prepare($sql);
            
            if (! empty($filter['dataCadastroInicial'])) {
                $cst->bindValue(":dataCadastroInicial", $filter['dataCadastroInicial'] . " 00:00:00", PDO::PARAM_STR);
            }
            
            if (! empty($filter['dataCadastroFinal'])) {
                $cst->bindValue(":dataCadastroFinal", $filter['dataCadastroFinal'] . " 23:59:59", PDO::PARAM_STR);
            }
            
            if (! empty($filter['status']) && $filter['status'] != "CONSULTANDO") {
                $cst->bindValue(":status", $filter['status'], PDO::PARAM_STR);
            }
            
            if (! empty($filter['origem']) && $filter['origem'] != "NAO_DEFINIDO") {
                $cst->bindValue(":origem", $filter['origem'], PDO::PARAM_STR);
            }
            
            if (! empty($page)) {
                $cst->bindValue(":limit", $limit, PDO::PARAM_INT);
                $cst->bindValue(":limitStart", $limitStart, PDO::PARAM_INT);
            }
            
            $cst->execute();
            $result = $cst->fetchAll(PDO::FETCH_ASSOC);
            
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['atendimento'] = null;
                
                if (!empty($result[$i]['dataAtendimento'])) {
                    $dataLead = new DateTime($result[$i]['dataLead']);
                    $dataAtendimento = new DateTime($result[$i]['dataAtendimento']);
                    
                    $intervalo = $dataLead->diff($dataAtendimento);
                    $diferencaTotalSegundos = $intervalo->days * 86400 + // Dias convertidos para segundos (24 * 60 * 60)
                    $intervalo->h * 3600 +    // Horas convertidas para segundos (60 * 60)
                    $intervalo->i * 60 +      // Minutos convertidos para segundos
                    $intervalo->s;            // Segundos
                    
                    // Agora, converta o total de segundos para o formato desejado
                    $horas = floor($diferencaTotalSegundos / 3600);
                    $minutos = floor(($diferencaTotalSegundos % 3600) / 60);
                    $segundos = $diferencaTotalSegundos % 60;
                    
                    // Formata para 00h:00m:00s
                    $result[$i]['atendimento'] = sprintf('%02dh:%02dm:%02ds', $horas, $minutos, $segundos);
                }
            }
            return $result;
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM oportunidade WHERE id = :id;");
            $cst->bindParam(":id", $id);
            $cst->execute();
            $result = $cst->fetch();
            $result['status'] = $this->findByStatus($result['id']);
            return $result;
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function findByStatus($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM oportunidade_status WHERE id_oportunidade = :id ORDER BY data ASC;");
            $cst->bindParam(":id", $id);
            $cst->execute();
            return $cst->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function validarHistoricoAtendimento($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM oportunidade_status WHERE id_oportunidade = :id AND nome = 'ATENDIMENTO';");
            $cst->bindParam(":id", $id);
            $cst->execute();
            $result = $cst->fetch(PDO::FETCH_ASSOC);
            $valid = isset($result['nome']) ? true : false;
            
            if (! $valid) {
                $this->insertStatusAtendimento($id);
            }
            
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    // METODOS DE CRUD
    public function save($id, $dados)
    {
        try {
            $sql = "UPDATE oportunidade SET idCnpj = :idCnpj, pessoaResponsavel = :pessoaResponsavel, email = :email,";
            $sql .= " telefone = :telefone, indicacao = :indicacao, observacao = :observacao, loja = :loja,";
            $sql .= " razaoSocial = :razaoSocial, nomeFantasia = :nomeFantasia WHERE id = :id";

            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $id);
            $cst->bindParam(":idCnpj", $dados['idCnpj']);
            $cst->bindParam(":pessoaResponsavel", $dados['pessoaResponsavel']);
            $cst->bindParam(":email", $dados['email']);
            $cst->bindParam(":telefone", $dados['telefone']);
            $cst->bindParam(":indicacao", $dados['indicacao']);
            $cst->bindParam(":observacao", $dados['observacao']);
            $cst->bindParam(":loja", $dados['loja']);
            $cst->bindParam(":razaoSocial", $dados['razaoSocial']);
            $cst->bindParam(":nomeFantasia", $dados['nomeFantasia']);
            $cst->execute();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function delete($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("UPDATE oportunidade SET ativo = false WHERE id = :id;");
            $cst->bindParam(":id", $id);
            $cst->execute();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    private function insertStatusAtendimento($id)
    {
        try {
            $sql = "INSERT INTO oportunidade_status SET nome = 'ATENDIMENTO', data = :data, id_oportunidade = :id;";
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $id);
            $cst->bindValue(":data", date('Y-m-d H:i:s'));
            $cst->execute();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
}

?>