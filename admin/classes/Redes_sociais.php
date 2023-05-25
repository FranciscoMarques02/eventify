<?php 
require_once('Banco.class.php');

class rede_social{
    public $id;
    public $id_estabelecimento;
    public $id_rede;
    public $link_rede;

    public function ListarTudo(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_redes_sociais where id_estab = ?";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id_estabelecimento));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }
    public function Cadastrar(){
        $banco = Banco::conectar();
        $sql = "INSERT INTO relação_estabelecimento(id_rede, link_rede,id_estabelecimento) VALUES(?,?,?)";        

        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);

        $comando->execute(array($this->id_rede,$this->link_rede,$this->id_estabelecimento));
            Banco::desconectar();
            // Se der certo, devolve 1 (tratar erros posteriormente)
            return 1;
    }
    public function Editar(){
        $banco = Banco::conectar();
        $sql = "UPDATE relação_estabelecimento SET id_rede=?,link_rede=?,id_estabelecimento=? WHERE id=?";
        
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id_rede,$this->link_rede,$this->id_estabelecimento,$this->id));
            Banco::desconectar();
            // Retornar a qtd de linhas modificadas:
            return $comando->rowCount();      
    }

    
}
?>