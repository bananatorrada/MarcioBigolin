<?php
class Pokemon {
    private $id_pokemon;
    private $nome_pokemon;
    private $hp;
    private $atk;
    private $def;
    private $spatk;
    private $spdef;
    private $spe;
    private $acc;
    private $evas;
    private $bst;
    private $tipo;
    private $item;
    private $habilidade;

    private $pdo; //conexão

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    //getters & setters
    public function getIdPokemon() { return $this->id_pokemon; }
    public function getNomePokemon() { return $this->nome_pokemon; }
    public function getHP() { return $this->hp; }
    public function getATK() { return $this->atk; }
    public function getDEF() { return $this->def; }
    public function getSPATK() { return $this->spatk; }
    public function getSPDEF() { return $this->spdef; }
    public function getSPE() { return $this->spe; }
    public function getACC() { return $this->acc; }
    public function getEVAS() { return $this->evas; }
    public function getBST() { return $this->bst; }
    public function getTipo() { return $this->tipo; }
    public function getItem() { return $this->item; }
    public function getHabilidade() { return $this->habilidade; }

    //id NÃO será settado!
    public function setNomePokemon($nome_pokemon) { $this->nome_pokemon = $nome_pokemon; }
    public function setHP($hp) { $this->hp = $hp; }
    public function setATK($atk) { $this->atk = $atk; }
    public function setDEF($def) { $this->def = $def; }
    public function setSPATK($spatk) { $this->spatk = $spatk; }
    public function setSPDEF($spdef) { $this->spdef = $spdef; }
    public function setSPE($spe) { $this->spe = $spe; }
    public function setACC($acc) { $this->acc = $acc; }
    public function setEVAS($evas) { $this->evas = $evas; }
    public function setBST($bst) { $this->bst = $bst; }
    public function setTipo($tipo) { $this->tipo = $tipo; }
    public function setItem($item) { $this->item = $item; }
    public function setHabilidade($habilidade) { $this->habilidade = $habilidade; }

    //salvar ou atualizar
    public function save() {
        if ($this->id_pokemon) {
            $sql = "UPDATE Pokemon SET nome_pokemon=:n_pokemon, hp=:hp, atk=:atk, def=:def, spatk=:spatk, spdef=:spdef, spe=:spe, acc=:acc, evas=:evas, bst=:bst, tipo=:t, item=:i, habilidade=:h WHERE id_pokemon=:id_pokemon";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':n_pokemon' => $this->nome_pokemon,
                ':hp' => $this->hp,
                ':atk' => $this->atk,
                ':def' => $this->def,
                ':spatk' => $this->spatk,
                ':spdef' => $this->spdef,
                ':spe' => $this->spe,
                ':acc' => $this->acc,
                ':evas' => $this->evas,
                ':bst' => $this->bst,
                ':t' => $this->tipo,
                ':i' => $this->item,
                ':h' => $this->habilidade,
                ':id_pokemon' => $this->id_pokemon
            ]);
        } else {
            $sql = "INSERT INTO Pokemon (nome_pokemon, hp, atk, def, spatk, spdef, spe, acc, evas, bst, t, i, h) VALUES (:n_pokemon)";
            $stmt = $this->pdo->prepare($sql);
            $ok = $stmt->execute([
                ':n_pokemon' => $this->nome_pokemon,
                ':hp' => $this->hp,
                ':atk' => $this->atk,
                ':def' => $this->def,
                ':spatk' => $this->spatk,
                ':spdef' => $this->spdef,
                ':spe' => $this->spe,
                ':acc' => $this->acc,
                ':evas' => $this->evas,
                ':bst' => $this->bst,
                ':t' => $this->tipo,
                ':i' => $this->item,
                ':h' => $this->habilidade
            ]);
            if ($ok) {
                $this->id_pokemon = $this->pdo->lastInsertId();
            }
            return $ok;
        }
    }

    //carregar
    public function load($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM pokemon WHERE id_pokemon=:id_pokemon");
        $stmt->execute([':id_pokemon' => $id_pokemon]);
        if ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->id_pokemon = $dados['id_pokemon'];
            $this->nome_pokemon = $dados['nome_pokemon'];
            $this->hp = $dados['hp'];
            $this->atk = $dados['atk'];
            $this->def = $dados['def'];
            $this->spatk = $dados['spatk'];
            $this->spdef = $dados['spdef'];
            $this->spe = $dados['spe'];
            $this->acc = $dados['acc'];
            $this->evas = $dados['evas'];
            $this->bst = $dados['bst'];
            $this->tipo = $dados['tipo'];
            $this->item = $dados['item'];
            $this->habilidade = $dados['habilidade'];
            return true;
        }
        return false;
    }

    //excluir
    public function delete() {
        if (!$this->id_pokemon) return false;
        $stmt = $this->pdo->prepare("DELETE FROM pokemon WHERE id_pokemon=:id_pokemon");
        return $stmt->execute([':id_pokemon' => $this->id_pokemon]);
    }

    //listar todos
    public static function all(PDO $pdo) {
        $stmt = $pdo=query("SELECT * FROM pokemon");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>