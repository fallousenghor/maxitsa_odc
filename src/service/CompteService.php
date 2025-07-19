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
        // Extraction stricte de l'id utilisateur
        $personneId = null;
        if (isset($data['personne_id']) && !empty($data['personne_id'])) {
            $personneId = $data['personne_id'];
        } elseif (isset($data['personne'])) {
            if (is_array($data['personne']) && isset($data['personne']['id'])) {
                $personneId = $data['personne']['id'];
            } elseif (is_object($data['personne'])) {
                if (property_exists($data['personne'], 'id')) {
                    $personneId = $data['personne']->id;
                } elseif (method_exists($data['personne'], 'getId')) {
                    $personneId = $data['personne']->getId();
                }
            } elseif (is_string($data['personne'])) {
                $personneId = $data['personne'];
            }
        }
        if (empty($personneId) || !is_string($personneId)) {
            // On refuse la création si l'id est absent ou invalide
            return false;
        }
        // Préparation des données pour l'insertion sans utiliser toArray/toObject/toJson
        $insertData = [
            'id' => $data['id'] ?? null,
            'telephone' => $data['telephone'] ?? null,
            'solde' => $data['solde'] ?? 0,
            'personne_id' => $personneId,
            'type_compte' => $data['type_compte'] ?? $data['typeCompte'] ?? null
        ];
        return $this->compteRepository->insert($insertData);
    }
}
