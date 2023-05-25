<?php
require_once('Banco.class.php');

class Usuario
{
    public $id;
    public $nome;
    public $senha;
    public $id_nivel;
    public $descricao;
    public $foto;
    public $email;
    public $senha_vazio = false;

    public function Cadastrar()
    {
        $banco = Banco::conectar();
        $sql = "CALL registrar_usuario(?, ?, ?, ?, ?, ?)";

        // Obter o hash da senha:
        $hashSenha = hash("sha256", $this->senha);

        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);

        $comando->execute(array($this->nome, $hashSenha, $this->id_nivel, $this->email, $this->descricao, $this->foto));
        Banco::desconectar();
        // Se der certo, devolve 1 (tratar erros posteriormente)
        return 1;
    }

    public function Logar()
    {
        $banco = Banco::conectar();
        $sql = "SELECT * FROM usuarios_login WHERE email = ? AND senha = ?";

        // Obter o hash da senha:
        $hashSenha = hash('sha256', $this->senha);

        $comando = $banco->prepare($sql);
        $comando->execute(array($this->email, $hashSenha));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

        Banco::desconectar();

        return $resultado;
    }

    public function Editar()
    {
        $banco = Banco::conectar();
        $sql = "CALL modificar_usuario(?, ?, ?, ?, ?, ?, ?)";

        // Verificar se a senha o campo senha está vazio:
        if ($this->senha_vazio == false) {
            $hashSenha = hash('sha256', $this->senha);
        }else{
            $hashSenha = $this->senha;
        }
        
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->nome, $hashSenha, $this->email, $this->id_nivel, $this->id, $this->descricao, $this->foto));
        Banco::desconectar();
        // Retornar a qtd de linhas modificadas:
        return $comando->rowCount();
    }

    public function ListarUnico()
    {
        $banco = Banco::conectar();
        $sql = "SELECT * FROM usuarios_login WHERE ID = ?";
        $comando = $banco->prepare($sql);
        $comando->execute(array($this->id));
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

        Banco::desconectar();

        return $resultado;
    }

    public function ListarUsuarios()
    {
        $banco = Banco::conectar();
        $sql = "SELECT * FROM usuarios_login";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

        Banco::desconectar();

        return $resultado;
    }

    public function NivelUsuario()
    {
        $banco = Banco::conectar();
        $sql = "SELECT * FROM nivel_usuario ORDER BY nome DESC";
        $comando = $banco->prepare($sql);
        $comando->execute();
        // "Salvar" o resultado da consulta (tabela) na $resultado
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

        Banco::desconectar();

        return $resultado;
    }


    public function Excluir()
    {
        $banco = Banco::conectar();
        $sql = "DELETE FROM usuarios WHERE ID = ?";
        $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $comando = $banco->prepare($sql);
        // Tratamento de erro:
        try {
            $comando->execute(array($this->id));
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
