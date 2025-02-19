<?php
namespace Src\Model;

class Card
{

    // ATRIBUTOS
    private $id;

    private $ativo;

    private $nome;

    private $imagem;

    private $segmento;

    private $link;

    // CONSTRUTORES
    public static function withPost($id, array $dados)
    {
        $instance = new self();
        $instance->id = $id;
        $instance->nome = $dados['nome'];
        $instance->segmento = $dados['segmento'];
        $instance->link = $dados['link'];
        $instance->ativo = $dados['ativo'];
        return $instance;
    }

    // GETTER & SETTER
    public function getId()
    {
        return $this->id;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function getSegmento()
    {
        return $this->segmento;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    public function setSegmento($segmento)
    {
        $this->segmento = $segmento;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }
}

?>