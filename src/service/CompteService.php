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
        $compte->setPersonne($data['personne']);
        $compte->setTypeCompte($data['type_compte']);
        return $this->compteRepository->insert($compte);
    }
}
