<?php
namespace Maxitsa\Repository;
use Maxitsa\Abstract\AbstractRepository;
use Maxitsa\Core\App;
use PDO;
require_once dirname(__DIR__,2) . '/app/core/App.php';

class PersonneRepository extends AbstractRepository {
  
    public function insert($entity = null) {
        $db = App::getDependency('core', 'Database')->getConnection();
        $stmt = $db->prepare("INSERT INTO personne (id, telephone, password, num_identite, photo_recto, photo_verso, prenom, nom, adresse, type_personne) VALUES (:id, :telephone, :password, :num_identite, :photo_recto, :photo_verso, :prenom, :nom, :adresse, :type_personne)");
        return $stmt->execute([
            'id' => $entity->id,
            'telephone' => $entity->telephone,
            'password' => $entity->password,
            'num_identite' => $entity->num_identite,
            'photo_recto' => $entity->photo_recto,
            'photo_verso' => $entity->photo_verso,
            'prenom' => $entity->prenom,
            'nom' => $entity->nom,
            'adresse' => $entity->adresse,
            'type_personne' => $entity->typePersonne ?? 'client'
        ]);
    }

    public function findByTelephone($telephone) {
        $db = App::getDependency('core', 'Database')->getConnection();
        $stmt = $db->prepare("SELECT * FROM personne WHERE telephone = :telephone");
        $stmt->execute(['telephone' => $telephone]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    public function update(){}
}
