<?php 
require_once('Banco.class.php');

class Cidade{
    public $id;
    public $nome;

    public static function ListarTudo(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM cidade ORDER BY nome";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function Cadastrar(){
        $banco = Banco::conectar();
        $sql = "INSERT INTO cidade(nome) VALUES(?)";        

        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);

        $comando->execute(array($this->nome));
            Banco::desconectar();
            // Se der certo, devolve 1 (tratar erros posteriormente)
            return 1;
    }

    public function Editar(){
        $banco = Banco::conectar();
        $sql = "UPDATE cidade SET nome=? WHERE id=?";
        
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->nome,$this->id));
            Banco::desconectar();
            // Retornar a qtd de linhas modificadas:
            return $comando->rowCount();      
    }

    public function Apagar(){
        $banco = Banco::conectar();
        $sql = "DELETE FROM cidade WHERE id = ?";
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        // Tratamento de erro:
        try{
           $comando->execute(array($this->id));
            Banco::desconectar();
            // Retornar quantidade de linhas apagadas:
            return $comando->rowCount();
 
         }catch(PDOException $e){
            // return $e->getCode(); 
            Banco::desconectar();
            // Se der errado, devolve -1:
            return -1;
         }
    }
}
?>