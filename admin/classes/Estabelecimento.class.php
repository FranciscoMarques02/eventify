<?php 
require_once('Banco.class.php');

class Estabelecimento{
    public $id;
    public $id_catego_estab;
    public $id_usuario;
    public $id_cidade;
    public $nome;
    public $email;
    public $img;
    public $verificador = false;
    public $inicio;
    public $maximo;

    public static function ListarTudo(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_estabelecimento";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $resultado;
    }
    public static function ObterQtdRegistro(){
        $banco = Banco::conectar();
        $sql = "SELECT COUNT(*) AS 'qtd' FROM view_estabelecimento";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        Banco::desconectar();
        return $resultado;
    }

    public function ListarPag(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_estabelecimento LIMIT :inicio,:fim";
        $comando = $banco->prepare($sql);
        $comando->bindParam(":inicio", $this->inicio);
        $comando->bindParam(":inicio", $this->inicio, PDO::PARAM_INT);
        $comando->bindParam(":fim", $this->maximo);
        $comando->bindParam(":fim", $this->maximo, PDO::PARAM_INT);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function Pesquisar(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_estabelecimento WHERE nome LIKE CONCAT('%' ,?, '%') ";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->nome));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function Listar_view_especifico(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_estabelecimento WHERE id = ?";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function Listar_especif(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM estabelecimento WHERE id_usuario = ?";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id_usuario));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function Cadastrar(){
        $banco = Banco::conectar();
        $sql = "CALL registrar_estabelecimento(?, ?, ?, ?, ?, ?)";        

        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);

        $comando->execute(array($this->id_catego_estab, $this->id_usuario, $this->id_cidade,
        $this->nome,$this->email, $this->img));
            Banco::desconectar();
            // Se der certo, devolve 1 (tratar erros posteriormente)
            return 1;
    }

    public function Editar(){
        $banco = Banco::conectar();
        $sql = "UPDATE estabelecimento SET id_catego_estab = ?, id_usuario =?, id_cidade=?, nome=?, email=?, img=? WHERE id=?";
        
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id_catego_estab, $this->id_usuario, $this->id_cidade, 
        $this->nome,$this->email,$this->img, $this->id));
            Banco::desconectar();
            // Retornar a qtd de linhas modificadas:
            return $comando->rowCount();      
    }

    public function Apagar(){
        $banco = Banco::conectar();
        $sql = "DELETE FROM estabelecimento WHERE id = ?";
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
    public function Listar_view(){
        $banco = Banco::conectar();
    }
}
?>