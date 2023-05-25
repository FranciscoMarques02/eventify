<?php
require_once('Banco.class.php');

class Tag
{
    public $id_tag;
    public $id_usuario;
    public $nome;

    public function ListarTags(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_tags WHERE id_usuario = ?";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id_usuario));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }
    public function ListarTudoTag(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM tags ";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }    

    public function Cadastrar(){
        $banco = Banco::conectar();
        $sql = "INSERT INTO relacao_usuario(id_usuario,id_tag) VALUES (?, ?)";        

        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);

        $comando->execute(array($this->id_usuario,$this->id_tag));
            Banco::desconectar();
            // Se der certo, devolve 1 (tratar erros posteriormente)
            return 1;
    }
    public function Excluir()
    {
        $banco = Banco::conectar();
        $sql = "DELETE FROM relacao_usuario WHERE id_usuario = ? AND id_tag = ?";
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        // Tratamento de erro:
        try {
            $comando->execute(array($this->id_usuario,$this->id_tag));
            Banco::desconectar();
            // Retornar quantidade de linhas apagadas:
            return $comando->rowCount();
        } catch (PDOException $e) {
            // return $e->getCode(); 
            Banco::desconectar();
            // Se der errado, devolve -1:
            return -1;
        }
    }
    public function Adicionar()
    {
        $banco = Banco::conectar();
        $sql = "INSERT INTO tags(nome) VALUES (?)";
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        // Tratamento de erro:
        try {
            $comando->execute(array($this->nome));
            Banco::desconectar();
            // Retornar quantidade de linhas apagadas:
            return $comando->rowCount();
        } catch (PDOException $e) {
            // return $e->getCode(); 
            Banco::desconectar();
            // Se der errado, devolve -1:
            return -1;
        }
    }

}
