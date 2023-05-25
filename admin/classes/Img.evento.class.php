<?php

require_once('Banco.class.php');

class Imagens_evento
{
    public $id_img;
    public $id_evento;
    public $img;

    public function Cadastrar(){
        $banco = Banco::conectar();
        $sql = "INSERT INTO imagens_evento (id_evento, img) 
        VALUES (?, ?)";

        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
 
        $comando->execute(array($this->id_evento, $this->img));
            Banco::desconectar();
            // Se der certo, devolve 1 (tratar erros posteriormente)
            return 1;
    }

    public function Apagar(){
        $banco = Banco::conectar();
        $sql = "DELETE FROM imagens_evento WHERE id = ?";
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        // Tratamento de erro:
        try{
           $comando->execute(array($this->id_img));
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