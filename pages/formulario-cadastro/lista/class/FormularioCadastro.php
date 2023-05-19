<?php
include_once "../../../class/GenericClass.php";

class FormularioCadastro extends GenericClass
{

    // METODOS DE CONSULTA
    public function findByAll()
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT id, nome, loja, formulario, idCnpj, data, status, tipo FROM formulario WHERE ativo IS TRUE ORDER BY data;");
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetchAll();
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function findById($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM formulario WHERE id = 1;");
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetch();
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    // METODOS DE CRUD
    public function update($dados, $file)
    {
        try {
            $ativo = 0;
            if (isset($dados['ativo'])) {
                $ativo = 1;
            }
            
            $sql = "UPDATE bannermodal SET ativo = :ativo WHERE id = 1";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":ativo", $ativo);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            
            $this->updateImagem($file);
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    private function updateImagem($file)
    {
        try {
            if (!empty($file['imagem']['tmp_name'])) {
                
                if ($file['imagem']['size'] >= 2097152) {
                    throw new DefaultException("Oops, para um melhor desempenho do seu site o arquivo deve ter menos de 2 megabytes.");
                }
                
                $fileTemp = $file['imagem']['tmp_name'];
                $diretorio = "../../../../files/banner-modal/";
                $nameFileTemp = $file['imagem']['name'];
                $nomeArquivo = "image" . date('YmdHis') . strrchr($nameFileTemp, '.');
    
                // MOVE ARQUIVO DO INPUT FILE PARA O NOVO DIRETORIO CRIADO
                move_uploaded_file($fileTemp, $diretorio . $nomeArquivo);
                chmod($diretorio . $nomeArquivo, 0755);
    
                $cst = $this->con->conectar()->prepare("UPDATE bannermodal SET imagem = :imagem WHERE id = 1;");
                $cst->bindParam(":imagem", $nomeArquivo);
                
                if (! $cst->execute()) {
                    throw new MyException(implode(" ", $cst->errorInfo()));
                }
            }
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }

}

?>