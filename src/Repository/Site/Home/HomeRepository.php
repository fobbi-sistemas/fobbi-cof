<?php
namespace Src\Repository\Site\Home;

use Src\Repository\GenericRepository;
use Src\Exception\MyException;
use Exception;
use PDOException;
use Src\Exception\DefaultException;

class HomeRepository extends GenericRepository
{

    // METODOS DE CONSULTA
    public function findById()
    {
        try {
            $sql = "SELECT id, banner, modal, modalAtivo, titulo1, corTitulo1, titulo2, corTitulo2, descricao FROM site";
            $sql .= " WHERE id = 1;";
            
            $cst = $this->con->conectar()->prepare($sql);

            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetch();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    // METODOS DE CRUD
    public function save($dados, $files)
    {
        try {
            $this->updateBanner($files);
            $this->updateModal($files);
            $this->update($dados);
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    private function update($dados)
    {
        try {
            $modalAtivo = 0;
            if (isset($dados['modalAtivo'])) {
                $modalAtivo = 1;
            }

            $sql = "UPDATE site SET modalAtivo = :modalAtivo, titulo1 = :titulo1, titulo2 = :titulo2,";
            $sql .= " corTitulo1 = :corTitulo1, corTitulo2 = :corTitulo2, descricao = :descricao WHERE id = 1";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":modalAtivo", $modalAtivo);
            $cst->bindParam(":titulo1", $dados['titulo1']);
            $cst->bindParam(":titulo2", $dados['titulo2']);
            $cst->bindParam(":corTitulo1", $dados['corTitulo1']);
            $cst->bindParam(":corTitulo2", $dados['corTitulo2']);
            $cst->bindParam(":descricao", $dados['descricao']);

            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    private function updateBanner($file)
    {
        try {
            if (! empty($file['banner']['tmp_name'])) {

                if ($file['banner']['size'] >= 2097152) {
                    throw new DefaultException("Oops, para um melhor desempenho do seu site o arquivo deve ter menos de 2 megabytes.");
                }

                $fileTemp = $file['banner']['tmp_name'];
                $diretorio = "../../../../../files/site/";
                $nameFileTemp = $file['banner']['name'];
                $nomeArquivo = "image" . date('YmdHis') . strrchr($nameFileTemp, '.');

                // MOVE ARQUIVO DO INPUT FILE PARA O NOVO DIRETORIO CRIADO
                move_uploaded_file($fileTemp, $diretorio . $nomeArquivo);
                chmod($diretorio . $nomeArquivo, 0755);

                $cst = $this->con->conectar()->prepare("UPDATE site SET banner = :imagem WHERE id = 1;");
                $cst->bindParam(":imagem", $nomeArquivo);

                if (! $cst->execute()) {
                    throw new PDOException(implode(" ", $cst->errorInfo()));
                }
            }
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    private function updateModal($file)
    {
        try {
            if (! empty($file['modal']['tmp_name'])) {

                if ($file['modal']['size'] >= 2097152) {
                    throw new DefaultException("Oops, para um melhor desempenho do seu site o arquivo deve ter menos de 2 megabytes.");
                }

                $fileTemp = $file['modal']['tmp_name'];
                $diretorio = "../../../../../files/site/";
                $nameFileTemp = $file['modal']['name'];
                $nomeArquivo = "image" . date('YmdHis') . strrchr($nameFileTemp, '.');

                // MOVE ARQUIVO DO INPUT FILE PARA O NOVO DIRETORIO CRIADO
                move_uploaded_file($fileTemp, $diretorio . $nomeArquivo);
                chmod($diretorio . $nomeArquivo, 0755);

                $cst = $this->con->conectar()->prepare("UPDATE site SET modal = :imagem WHERE id = 1;");
                $cst->bindParam(":imagem", $nomeArquivo);

                if (! $cst->execute()) {
                    throw new PDOException(implode(" ", $cst->errorInfo()));
                }
            }
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
}

?>