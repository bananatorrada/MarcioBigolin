<?php
class Item {
    private $id_item;
    private $nome_item;
    private $descricao;
    private $buffs;

    private $pdo; //conexão

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    //getters & setters
    public function getIdItem() { return $this->id_item; }
    public function getNomeItem() { return $this->nome_item; }
    public function getDescricao() { return $this->descricao; }
    public function getBuffs() { return $this->buffs; }

    //id NÃO será settado!
    public function setNomeItem($nome_item) { $this->nome_item = $nome_item; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }
    public function setBuffs($buffs) { $this->buffs = $buffs; }

    //salvar ou atualizar
    public function save() {
        if ($this->id_item) {
            $sql = "UPDATE item SET nome_item=:n_item, descricao=:d, buffs=:b WHERE id_item=:id_item";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':n_item' => $this->nome_item,
                ':d' => $this->descricao,
                ':b' => $this->buffs,
                ':id_item' => $this->id_item
            ]);
        } else {
            $sql = "INSERT INTO item (nome_item, descricao, buffs) VALUES (:n_item, :d, :b)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                ':n_item' => $this->nome_item,
                ':d' => $this->descricao,
                ':b' => $this->buffs
            ]);
            if ($ok) {
                $this->id_item = $this->pdo->lastInsertId();
            }
            return $ok;
        }
    }

    //carregar
    public function load($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM item WHERE id_item=:id_item");
        $stmt->execute([':id_item' => $id_item]);
        if ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->id_item = $dados['id_item'];
            $this->nome_item = $dados['nome_item'];
            $this->descricao = $dados['descricao'];
            $this->buffs = $dados['buffs'];
            return true;
        }
        return false;
    }

    //excluir
    public function delete() {
        if (!$this->id_item) return false;
        $stmt = $this->pdo->prepare("DELETE FROM item WHERE id_item=:id_item");
        return $stmt->execute([':id_item' => $this->id_item]);
    }

    //listar todos
    public static function all(PDO $pdo) {
        $stmt = $pdo=query("SELECT * FROM item");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>