<?php
namespace Maxitsa\Repository;

use Maxitsa\Abstract\AbstractRepository;
use Maxitsa\Core\App;
use Maxitsa\Entity\Compte;

class CompteRepository extends AbstractRepository{
  

     public function insert($compte = null){
         $db = App::getDependency('core', 'Database')->getConnection();
       
         if (is_array($compte)) {
             $data = $compte;
         } else {
             $data = (array)$compte;
         }
         $stmt = $db->prepare("INSERT INTO compte (id, telephone, solde, personne_id, type_compte) VALUES (:id, :telephone, :solde, :personne_id, :type_compte)");
      
         $personneId = null;
         if (isset($data['personne_id'])) {
             $personneId = $data['personne_id'];
         } elseif (isset($data['personne']) && is_array($data['personne']) && isset($data['personne']['id'])) {
             $personneId = $data['personne']['id'];
         } elseif (isset($data['personne']) && is_string($data['personne'])) {
             $personneId = $data['personne'];
         }
         return $stmt->execute([
             'id' => $data['id'] ?? ($compte->getId() ?? null),
             'telephone' => $data['telephone'] ?? ($compte->getTelephone() ?? null),
             'solde' => $data['solde'] ?? ($compte->getSolde() ?? 0),
             'personne_id' => $personneId,
             'type_compte' => $data['type_compte'] ?? $data['typeCompte'] ?? ($compte->getTypeCompte() ?? null)
         ]);
     }
     public function toObject(array $row): object {
         return Compte::toObject($row);
     }
     public function toJson($compte): string {
         return method_exists($compte, 'toJson') ? $compte->toJson() : json_encode($compte);
     }
     public function update(){}
  
 }