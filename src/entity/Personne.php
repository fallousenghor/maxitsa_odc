<?php
namespace Maxitsa\Entity;
use Maxista\Enum\TypePersonne;
use Maxitsa\Abstract\AbstractEntity;


class Personne extends AbstractEntity {
    public function toJson(): string {
        return json_encode($this->toArray());
    }
    protected string $id;
    protected string $telephone;
    protected string $password;
    protected string $num_identite;
    protected string $photoRecto;
    protected string $photoVerso;
    protected string $prenom;
    protected string $nom;
    protected string $adresse;
    protected array $comptes = [];
    protected string $typePersonne;

    // protected function addCompte(Compte $compte): void { }
    // protected function getTypePersonne(): ?TypePersonne {  }
    // protected function setTypePersonne(TypePersonne $type): void { }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'telephone' => $this->telephone,
            'password' => $this->password,
            'num_identite' => $this->num_identite,
            'photoRecto' => $this->photoRecto,
            'photoVerso' => $this->photoVerso,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'typePersonne' => $this->typePersonne,
            'comptes' => array_map(fn($compte) => $compte->toArray(), $this->comptes)
        ];
    }

 

    public function __construct(
        string $id = '',
        string $telephone = '',
        string $password = '',
        string $num_identite = '',
        string $photoRecto = '',
        string $photoVerso = '',
        string $prenom = '',
        string $nom = '',
        string $adresse = '',
        string $typePersonne = '',
        array $comptes = []
    ) {
        $this->id = $id;
        $this->telephone = $telephone;
        $this->password = $password;
        $this->num_identite = $num_identite;
        $this->photoRecto = $photoRecto;
        $this->photoVerso = $photoVerso;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->typePersonne = $typePersonne;
        $this->comptes = $comptes;
    }

    public static function toObject(array $data): object {
        return new static(
            $data['id'] ?? '',
            $data['telephone'] ?? '',
            $data['password'] ?? '',
            $data['num_identite'] ?? '',
            $data['photoRecto'] ?? '',
            $data['photoVerso'] ?? '',
            $data['prenom'] ?? '',
            $data['nom'] ?? '',
            $data['adresse'] ?? '',
            $data['typePersonne'] ?? '',
            isset($data['comptes']) && is_array($data['comptes']) ? array_map([Compte::class, 'toObject'], $data['comptes']) : []
        );
    }
}