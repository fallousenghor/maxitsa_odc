<?php
namespace Maxitsa\Entity;
use Maxista\Enum\TypePersonne;
use Maxitsa\Abstract\AbstractEntity;


class Personne extends AbstractEntity {
    public function toJson(): string {
        return json_encode($this->toArray());
    }
    protected int $id;
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
   
    public function getId(): int { return $this->id; }
    public function getTelephone(): string { return $this->telephone; }
    public function getPassword(): string { return $this->password; }
    public function getNumIdentite(): string { return $this->num_identite; }
    public function getPhotoRecto(): string { return $this->photoRecto; }
    public function getPhotoVerso(): string { return $this->photoVerso; }
    public function getPrenom(): string { return $this->prenom; }
    public function getNom(): string { return $this->nom; }
    public function getAdresse(): string { return $this->adresse; }
    public function getComptes(): array { return $this->comptes; }
    public function getTypePersonne(): string { return $this->typePersonne; }

   
    public function setId(int $id): void { $this->id = $id; }
    public function setTelephone(string $telephone): void { $this->telephone = $telephone; }
    public function setPassword(string $password): void { $this->password = $password; }
    public function setNumIdentite(string $num_identite): void { $this->num_identite = $num_identite; }
    public function setPhotoRecto(string $photoRecto): void { $this->photoRecto = $photoRecto; }
    public function setPhotoVerso(string $photoVerso): void { $this->photoVerso = $photoVerso; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setAdresse(string $adresse): void { $this->adresse = $adresse; }
    public function setComptes(array $comptes): void { $this->comptes = $comptes; }
    public function setTypePersonne(string $typePersonne): void { $this->typePersonne = $typePersonne; }

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
            'photo_recto' => $this->photoRecto,
            'photo_verso' => $this->photoVerso,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'type_personne' => $this->typePersonne,
            'comptes' => array_map(fn($compte) => $compte->toArray(), $this->comptes)
        ];
    }

 

    public function __construct(
        int $id = 1,
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
            isset($data['id']) ? (int)$data['id'] : 0,
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