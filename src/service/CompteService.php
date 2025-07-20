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
        if (empty($personneId)) {
            error_log('Echec creation compte: personne_id manquant ou vide. Data: ' . print_r($data, true));
            return false;
        }
        $insertData = [
            'telephone' => $data['telephone'] ?? null,
            'solde' => $data['solde'] ?? 0,
            'personne_id' => (is_numeric($personneId) ? (int)$personneId : $personneId),
            'type_compte' => $data['type_compte'] ?? $data['typeCompte'] ?? null
        ];
        $ok = $this->compteRepository->insert($insertData);
        if (!$ok) {
            error_log('Echec creation compte: insertData = ' . print_r($insertData, true));
        }
        return $ok;
    }
}
