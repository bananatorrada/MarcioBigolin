<?php
class Equipe {
    private $id_equipe;
    private $nome_equipe;
    private $regimento;
    private $slot1;
    private $slot2;
    private $slot3;
    private $slot4;
    private $slot5;
    private $slot6;

    private $pdo; //conexão

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    //getters & setters
    public function getIdEquipe() { return $this->id_equipe; }
    public function getNomeEquipe() { return $this->nome_equipe; }
    public function getRegimento() { return $this->regimento; }
    public function getSlot1() { return $this->slot1; }
    public function getSlot2() { return $this->slot2; }
    public function getSlot3() { return $this->slot3; }
    public function getSlot4() { return $this->slot4; }
    public function getSlot5() { return $this->slot5; }
    public function getSlot6() { return $this->slot6; }

    //id NÃO será settado!
    public function setNomeEquipe($nome_equipe) { $this->nome_equipe = $nome_equipe; }
    public function setRegimento($regimento) { $this->regimento = $regimento; }
    public function setSlot1($slot1) { $this->slot1 = $slot1; }
    public function setSlot1($slot2) { $this->slot2 = $slot2; }
    public function setSlot1($slot3) { $this->slot3 = $slot3; }
    public function setSlot1($slot4) { $this->slot4 = $slot4; }
    public function setSlot1($slot5) { $this->slot5 = $slot5; }
    public function setSlot1($slot6) { $this->slot6 = $slot6; }

    //salvar ou atualizar
    public function save() {
        if ($this->id_equipe) {
            $sql = "UPDATE Equipe SET nome_equipe=:n_equipe, regimento=:r, slot1=:s1, slot2=:s2, slot3=:s3, slot4=:s4, slot5=:s5, slot6=:s6 WHERE id_equipe=:id_equipe";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':n_equipe' => $this->nome_equipe,
                ':r' => $this->regimento,
                ':s1' => $this->slot1,
                ':s2' => $this->slot2,
                ':s3' => $this->slot3,
                ':s4' => $this->slot4,
                ':s5' => $this->slot5,
                ':s6' => $this->slot6,
                ':id_equipe' => $this->id_equipe
            ]);
        } else {
            $sql = "INSERT INTO Equipe (nome_equipe, regimento, slot1, slot2, slot3, slot4, slot5, slot6) VALUES (:n_equipe, :r, :s1, :s2, :s3, :s4, :s5, :s6)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                ':n_equipe' => $this->nome_equipe,
                ':r' => $this->regimento,
                ':s1' => $this->slot1,
                ':s2' => $this->slot2,
                ':s3' => $this->slot3,
                ':s4' => $this->slot4,
                ':s5' => $this->slot5,
                ':s6' => $this->slot6
            ]);
            if ($ok) {
                $this->id_equipe = $this->pdo->lastInsertId();
            }
            return $ok;
        }
    }

    //carregar
    public function load($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Equipe WHERE id_equipe=:id_equipe");
        $stmt->execute([':id_equipe' => $id_equipe]);
        if ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->id_equipe = $dados['id_equipe'];
            $this->nome_equipe = $dados['nome_equipe'];
            $this->regimento = $dados['regimento'];
            $this->slot1 = $dados['slot1'];
            $this->slot2 = $dados['slot2'];
            $this->slot3 = $dados['slot3'];
            $this->slot4 = $dados['slot4'];
            $this->slot5 = $dados['slot5'];
            $this->slot6 = $dados['slot6'];
            return true;
        }
        return false;
    }

    //excluir
    public function delete() {
        if (!$this->id_equipe) return false;
        $stmt = $this->pdo->prepare("DELETE FROM Equipe WHERE id_equipe=:id_equipe");
        return $stmt->execute([':id_equipe' => $this->id_equipe]);
    }

    //listar todos
    public static function all(PDO $pdo) {
        $stmt = $pdo=query("SELECT * FROM Equipe");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>