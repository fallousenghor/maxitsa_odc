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
        // Ne garder que les champs attendus par la requête SQL
        $fields = ['telephone','password','num_identite','photo_recto','photo_verso','prenom','nom','adresse','type_personne'];
        $filtered = array_intersect_key($data, array_flip($fields));
        error_log('PersonneRepository::insert filtered: ' . print_r($filtered, true));
        $stmt = $db->prepare("INSERT INTO personne (telephone, password, num_identite, photo_recto, photo_verso, prenom, nom, adresse, type_personne) VALUES (:telephone, :password, :num_identite, :photo_recto, :photo_verso, :prenom, :nom, :adresse, :type_personne)");
        $result = $stmt->execute([
            'telephone' => $filtered['telephone'] ?? null,
            'password' => $filtered['password'] ?? null,
            'num_identite' => $filtered['num_identite'] ?? null,
            'photo_recto' => $filtered['photo_recto'] ?? null,
            'photo_verso' => $filtered['photo_verso'] ?? null,
            'prenom' => $filtered['prenom'] ?? null,
            'nom' => $filtered['nom'] ?? null,
            'adresse' => $filtered['adresse'] ?? null,
            'type_personne' => $filtered['type_personne'] ?? 'client'
        ]);
        if (!$result) {
            $errorInfo = $stmt->errorInfo();
            error_log('Erreur PDO : ' . print_r($errorInfo, true));
            \Maxitsa\Core\Session::getInstance()->set('errors', ['global' => ["Erreur PDO : " . ($errorInfo[2] ?? 'Erreur inconnue') . " | Data: " . print_r($data, true)]]);
        }
        return $result;
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
