<?php
namespace Maxitsa\Repository;

use Maxitsa\Abstract\AbstractRepository;
use Maxitsa\Core\App;

class CompteRepository extends AbstractRepository{
  

     public function insert($compte = null){
         $db = App::getDependency('core', 'Database')->getConnection();
         $stmt = $db->prepare("INSERT INTO compte (id, telephone, solde, personne_id, type_compte) VALUES (:id, :telephone, :solde, :personne_id, :type_compte)");
         $personne_id = null;
         if ($compte !== null && method_exists($compte, 'getPersonne')) {
             $personne = $compte->getPersonne();
             if(is_object($personne) && (property_exists($personne, 'id') || method_exists($personne, 'getId'))) {
                 $personne_id = method_exists($personne, 'getId') ? $personne->getId() : $personne->id;
             } else {
                 $personne_id = $personne;
             }
         }
         return $stmt->execute([
             'id' => $compte->getId(),
             'telephone' => $compte->getTelephone(),
             'solde' => $compte->getSolde(),
             'personne_id' => $personne_id,
             'type_compte' => $compte->getTypeCompte()
         ]);
     }
     public function update(){}
  
 }