<?php
namespace Maxitsa\Entity;

use Maxitsa\Abstract\AbstractEntity;

class Transaction extends AbstractEntity {
    private string $id;
    private float $montant;
    private Compte $compte;
    private string $type;
    private \DateTime $date;

    public function __construct(string $id, float $montant, Compte $compte, string $type, \DateTime $date) {
        $this->id = $id;
        $this->montant = $montant;
        $this->compte = $compte;
        $this->type = $type;
        $this->date = $date;
    }

    public function getMontant(): float { return $this->montant; }
    public function setMontant(float $montant): void { $this->montant = $montant; }
    public function getType(): string { return $this->type; }
    public function setType(string $type): void { $this->type = $type; }
    public function getDate(): \DateTime { return $this->date; }
    public function setDate(\DateTime $date): void { $this->date = $date; }
    public function getCompte(): Compte { return $this->compte; }
    public function setCompte(Compte $compte): void { $this->compte = $compte; }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'montant' => $this->montant,
            'type' => $this->type,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'compte' => $this->compte ? $this->compte->toArray() : null
        ];
    }

    public static function toObject(array $data): object {
        return new static(
            $data['id'] ?? '',
            (float)($data['montant'] ?? 0),
            isset($data['compte']) && is_array($data['compte']) ? Compte::toObject($data['compte']) : null,
            $data['type'] ?? '',
            isset($data['date']) ? new \DateTime($data['date']) : new \DateTime()
        );
    }
}