<?php
class Habilidade {
    private $id_habilidade;
    private $nome_habilidade;
    private $descricao;
    private $dano;
    private $efeito_colateral;
    private $chance_efeito;

    private $pdo; //conexão

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    //getters & setters
    public function getIdHabilidade() { return $this->id_habilidade; }
    public function getNomeHabilidade() { return $this->nome_habilidade; }
    public function getDescricao() { return $this->descricao; }
    public function getDano() { return $this->dano; }
    public function getEfeitoColateral() { return $this->efeito_colateral; }
    public function getChanceEfeito() { return $this->chance_efeito; }

    //id NÃO será settado!
    public function setNomeHabilidade($nome_habilidade) { $this->nome_habilidade = $nome_habilidade; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }
    public function setDano($dano) { $this->dano = $dano; }
    public function setEfeitoColateral($efeito_colateral) { $this->efeito_colateral = $efeito_colateral; }
    public function setChanceEfeito($chance_efeito) { $this->chance_efeito = $chance_efeito; }

    //salvar ou atualizar
    public function save() {
        if ($this->id_habilidade) {
            $sql = "UPDATE habilidade SET nome_habilidade=:n_habilidade, descricao=:d, dano=:da, efeito_colateral=:e, chance_efeito=:c WHERE id_habilidade=:id_habilidade";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':n_habilidade' => $this->nome_habilidade,
                ':d' => $this->descricao,
                ':da' => $this->dano,
                ':e' => $this->efeito_colateral,
                ':c' => $this->chance_efeito,
                ':id_habilidade' => $this->id_habilidade
            ]);
        } else {
            $sql = "INSERT INTO habilidade (nome_habilidade, descricao, dano, efeito_colateral, chance_efeito) VALUES (:n_habilidade, :d, :s, :da, :e, :c)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                ':n_habilidade' => $this->nome_habilidade,
                ':d' => $this->descricao,
                ':da' => $this->dano,
                ':e' => $this->efeito_colateral,
                ':c' => $this->chance_efeito
            ]);
            if ($ok) {
                $this->id_habilidade = $this->pdo->lastInsertId();
            }
            return $ok;
        }
    }

    //carregar
    public function load($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM habilidade WHERE id_habilidade=:id_habilidade");
        $stmt->execute([':id_habilidade' => $id_habilidade]);
        if ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->id_habilidade = $dados['id_habilidade'];
            $this->nome_habilidade = $dados['nome_habilidade'];
            $this->descricao = $dados['descricao'];
            $this->dano = $dados['dano'];
            $this->efeito_colateral = $dados['efeito_colateral'];
            $this->chance_efeito = $dados['chance_efeito'];
            return true;
        }
        return false;
    }

    //excluir
    public function delete() {
        if (!$this->id_habilidade) return false;
        $stmt = $this->pdo->prepare("DELETE FROM habilidade WHERE id_habilidade=:id_habilidade");
        return $stmt->execute([':id_habilidade' => $this->id_habilidade]);
    }

    //listar todos
    public static function all(PDO $pdo) {
        $stmt = $pdo=query("SELECT * FROM habilidade");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>