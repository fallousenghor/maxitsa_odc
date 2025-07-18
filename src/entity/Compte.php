<?php
namespace Maxitsa\Entity;

use Maxitsa\Abstract\AbstractEntity;

class Compte extends AbstractEntity {
    private string $id;
    private string $telephone;
    private float $solde;
    private $personne; // Personne
    private array $transactions = []; // Transaction[]
    private string $typeCompte;

    public function __construct(
        string $id = '',
        string $telephone = '',
        float $solde = 0.0,
        $personne = null,
        array $transactions = [],
        string $typeCompte = ''
    ) {
        $this->id = $id;
        $this->telephone = $telephone;
        $this->solde = $solde;
        $this->personne = $personne;
        $this->transactions = $transactions;
        $this->typeCompte = $typeCompte;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getTelephone() { return $this->telephone; }
    public function setTelephone($telephone) { $this->telephone = $telephone; }
    public function getSolde() { return $this->solde; }
    public function setSolde($solde) { $this->solde = $solde; }
    public function getPersonne() { return $this->personne; }
    public function setPersonne($personne) { $this->personne = $personne; }
    public function addTransaction($transaction) { $this->transactions[] = $transaction; }
    public function getTypeCompte() { return $this->typeCompte; }
    public function setTypeCompte($type) { $this->typeCompte = $type; }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'telephone' => $this->telephone,
            'typeCompte' => $this->typeCompte,
            'solde' => $this->solde,
            'personne' => $this->personne && method_exists($this->personne, 'toArray') ? $this->personne->toArray() : null,
            'transactions' => array_map(fn($transaction) => $transaction->toArray(), $this->transactions)
        ];
    }

    public static function toObject(array $data): object {
        return new static(
            $data['id'] ?? '',
            $data['telephone'] ?? '',
            (float)($data['solde'] ?? 0),
            isset($data['personne']) && is_array($data['personne']) ? Personne::toObject($data['personne']) : null,
            isset($data['transactions']) && is_array($data['transactions']) ? array_map([Transaction::class, 'toObject'], $data['transactions']) : [],
            $data['typeCompte'] ?? ''
        );
    }
}