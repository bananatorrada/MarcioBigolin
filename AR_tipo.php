<?php
class Tipo {
    private $id_tipo;
    private $nome_tipo;
    private $descricao;

    private $pdo; //conexão

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    //getters & setters
    public function getIdTipo() { return $this->id_tipo; }
    public function getNomeTipo() { return $this->nome_tipo; }
    public function getDescricao() { return $this->descricao; }

    //id NÃO será settado!
    public function setNometipo($nome_tipo) { $this->nome_tipo = $nome_tipo; }
    public function setdescricao($descricao) { $this->descricao = $descricao; }

    //salvar ou atualizar
    public function save() {
        if ($this->id_tipo) {
            $sql = "UPDATE Tipo SET nome_tipo=:n_tipo, descricao=:d WHERE id_tipo=:id_tipo";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':n_tipo' => $this->nome_tipo,
                ':d' => $this->descricao,
                ':id_tipo' => $this->id_tipo
            ]);
        } else {
            $sql = "INSERT INTO Tipo (nome_tipo, descricao) VALUES (:n_tipo, :d)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                ':n_tipo' => $this->nome_tipo,
                ':d' => $this->descricao
            ]);
            if ($ok) {
                $this->id_tipo = $this->pdo->lastInsertId();
            }
            return $ok;
        }
    }

    //carregar
    public function load($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Tipo WHERE id_tipo=:id_tipo");
        $stmt->execute([':id_tipo' => $id_tipo]);
        if ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->id_tipo = $dados['id_tipo'];
            $this->nome_tipo = $dados['nome_tipo'];
            $this->descricao = $dados['descricao'];
            return true;
        }
        return false;
    }

    //excluir
    public function delete() {
        if (!$this->id_tipo) return false;
        $stmt = $this->pdo->prepare("DELETE FROM Tipo WHERE id_tipo=:id_tipo");
        return $stmt->execute([':id_tipo' => $this->id_tipo]);
    }

    //listar todos
    public static function all(PDO $pdo) {
        $stmt = $pdo=query("SELECT * FROM Tipo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>