<?php
namespace Maxitsa\Service; 

use Maxitsa\Entity\Compte;
use Maxitsa\Repository\CompteRepository;






class CompteService extends AbstractService {
    private CompteRepository $compteRepository;

    protected function __construct() {
        $this->compteRepository = CompteRepository::getInstance();
    }
  

    public function creerCompte(array $data): bool {
        $compte = new Compte();
        $compte->setId($data['id']);
        $compte->setTelephone($data['telephone']);
        $compte->setSolde($data['solde']);
        // On passe un tableau avec l'id pour garantir le mapping
        $personneId = $data['personne_id'] ?? $data['personne'] ?? null;
        $compte->setPersonne(['id' => $personneId]);
        $compte->setTypeCompte($data['type_compte'] ?? $data['typeCompte'] ?? null);
        return $this->compteRepository->insert($compte);
    }
}
