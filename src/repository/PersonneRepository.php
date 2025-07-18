<?php
namespace Maxitsa\Repository;
use Maxitsa\Abstract\AbstractRepository;
use Maxitsa\Core\App;
use Maxitsa\Entity\Personne;
use PDO;
require_once dirname(__DIR__,2) . '/app/core/App.php';

class PersonneRepository extends AbstractRepository {
  
    public function insert($entity = null) {
        $db = App::getDependency('core', 'Database')->getConnection();
        $data = method_exists($entity, 'toArray') ? $entity->toArray() : (array)$entity;
        $stmt = $db->prepare("INSERT INTO personne (id, telephone, password, num_identite, photo_recto, photo_verso, prenom, nom, adresse, type_personne) VALUES (:id, :telephone, :password, :num_identite, :photo_recto, :photo_verso, :prenom, :nom, :adresse, :type_personne)");
        return $stmt->execute([
            'id' => $data['id'] ?? null,
            'telephone' => $data['telephone'] ?? null,
            'password' => $data['password'] ?? null,
            'num_identite' => $data['num_identite'] ?? null,
            'photo_recto' => $data['photoRecto'] ?? $data['photo_recto'] ?? null,
            'photo_verso' => $data['photoVerso'] ?? $data['photo_verso'] ?? null,
            'prenom' => $data['prenom'] ?? null,
            'nom' => $data['nom'] ?? null,
            'adresse' => $data['adresse'] ?? null,
            'type_personne' => $data['typePersonne'] ?? $data['type_personne'] ?? 'client'
        ]);
    }
    public function toObject(array $row): object {
        return Personne::toObject($row);
    }
    public function toJson($personne): string {
        return method_exists($personne, 'toJson') ? $personne->toJson() : json_encode($personne);
    }

    public function findByTelephone($telephone) {
        $db = App::getDependency('core', 'Database')->getConnection();
        $stmt = $db->prepare("SELECT * FROM personne WHERE telephone = :telephone");
        $stmt->execute(['telephone' => $telephone]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    public function update(){}
}
