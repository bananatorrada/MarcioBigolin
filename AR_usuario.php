<?php
class Usuario {
    private $id_usuario;
    private $nome_usuario;
    private $email;
    private $senha;
    private $pontos;

    private $pdo; //conexão

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    //getters & setters
    public function getIdUsuario() { return $this->id_usuario; }
    public function getNomeUsuario() { return $this->nome_usuario; }
    public function getEmail() { return $this->email; }
    public function getSenha() { return $this->senha; }
    public function getPontos() { return $this->pontos; }

    //id NÃO será settado!
    public function setNomeUsuario($nome_usuario) { $this->nome_usuario = $nome_usuario; }
    public function setEmail($email) { $this->email = $email; }
    public function setSenha($id_senha) { $this->senha = $senha; }
    public function setPontos($pontos) { $this->pontos = $pontos; }

    //salvar ou atualizar
    public function save() {
        if ($this->id_usuario) {
            $sql = "UPDATE Usuario SET nome_usuario=:n_usuario, email=:e, senha=:s, pontos=:p WHERE id_usuario=:id_usuario";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':n_usuario' => $this->nome_usuario,
                ':e' => $this->email,
                ':s' => $this->senha,
                ':p' => $this->pontos,
                ':id_usuario' => $this->id_usuario
            ]);
        } else {
            $sql = "INSERT INTO Usuario (nome_usuario, email, senha, pontos) VALUES (:n_usuario, :e, :s, :p)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                ':n_usuario' => $this->nome_usuario,
                ':e' => $this->email,
                ':s' => $this->senha,
                ':p' => $this->pontos
            ]);
            if ($ok) {
                $this->id_usuario = $this->pdo->lastInsertId();
            }
            return $ok;
        }
    }

    //carregar
    public function load($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuario WHERE id_usuario=:id_usuario");
        $stmt->execute([':id_usuario' => $id_usuario]);
        if ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->id_usuario = $dados['id_usuario'];
            $this->nome_usuario = $dados['nome_usuario'];
            $this->email = $dados['email'];
            $this->senha = $dados['senha'];
            $this->pontos = $dados['pontos'];
            return true;
        }
        return false;
    }

    //excluir
    public function delete() {
        if (!$this->id_usuario) return false;
        $stmt = $this->pdo->prepare("DELETE FROM Usuario WHERE id_usuario=:id_usuario");
        return $stmt->execute([':id_usuario' => $this->id_usuario]);
    }

    //listar todos
    public static function all(PDO $pdo) {
        $stmt = $pdo=query("SELECT * FROM Usuario");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>