<?php 
require_once('Banco.class.php');

class Evento{
    public $id;
    public $nome_evento;
    public $link;
    public $data_evento;
    public $descricao_evento;
    public $id_categoria;
    public $id_estabelecimento;
    public $id_usu_resp;
    public $id_cidade_evento;
    public $foto;
    public $foto2;
    public $id_img;

    // Variaveis para limitar a pagina;
    public int $inicio;
    public int $maximo;
    

    public static function ListarTudo(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_eventos";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public static function ObterQtdRegistro(){
        $banco = Banco::conectar();
        $sql = "SELECT COUNT(*) AS 'qtd' FROM view_eventos";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function ListarPag(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_eventos LIMIT :inicio,:fim";
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
        $sql = "SELECT * FROM view_eventos WHERE Nome LIKE CONCAT('%' ,?, '%') ";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->nome_evento));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public static function ListarEventos(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_eventos WHERE data_evento > CURDATE() LIMIT 5;";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public static function ListarEventosAnteriores(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_eventos WHERE data_evento <= CURDATE() LIMIT 5;";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function Listar_Imagens(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM imagens_evento WHERE id_evento = ? AND img_principal = 0";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function ListarImagemPrincipal(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM imagens_evento WHERE img_principal = 1";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function Cadastrar(){
        $banco = Banco::conectar();
        $sql = "CALL registrar_evento(?, ?, ?, ?, ?, ?, ?, ?, ?)";        

        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);

        $comando->execute(array($this->nome_evento, $this->link, $this->data_evento, $this->descricao_evento,
        $this->id_categoria, $this->id_estabelecimento, $this->id_cidade_evento, $this->foto, $this->id_usu_resp));
            Banco::desconectar();
            // Se der certo, devolve 1 (tratar erros posteriormente)
            return 1;
    }

    public function Editar(){
        $banco = Banco::conectar();
        $sql = "CALL modificar_evento(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->nome_evento, $this->foto, $this->link, $this->data_evento, $this->descricao_evento,
        $this->id_categoria, $this->id_estabelecimento, $this->id_cidade_evento, $this->id, $this->id_img, $this->id_usu_resp));
            Banco::desconectar();
            // Retornar a qtd de linhas modificadas:
            return $comando->rowCount();      
    }

    public function Apagar(){
        $banco = Banco::conectar();
        $sql = "DELETE FROM evento WHERE id = ?";
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

    public function Inserir_imagem_0(){
        $banco = Banco::conectar();
        $sql = "INSERT INTO imagens_evento(id_evento, img, img_principal) VALUES (?, ?, 0)";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id,$this->foto2));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }
    public function Listar_especif(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_eventos WHERE id_usu_resp = ?";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id_usu_resp));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public static function Listar_especif2(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_eventos WHERE data_evento >= CURDATE() ORDER BY RAND() LIMIT 5;";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function Listar_especif3(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM view_eventos WHERE id = ?";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }

    public function FiltrarEvento(){
        $banco = Banco::conectar();
        $sql = "SELECT * FROM evento WHERE nome_evento LIKE '?%' ";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->nome_evento));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
 
        Banco::desconectar();
 
        return $resultado;
    }
}
