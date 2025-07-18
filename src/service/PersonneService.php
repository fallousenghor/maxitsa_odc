<?php
namespace Maxitsa\Service;
use Maxista\Enum\TypePersonne;
use Maxitsa\Core\App;
use Maxitsa\Middlewares\AshPassWord;
use Maxitsa\Repository\PersonneRepository;
use Maxitsa\Entity\Personne;
use Maxitsa\Service\CompteService;
class PersonneService extends AbstractService {
    private PersonneRepository $personneRepository;

    protected function __construct() {
        $this->personneRepository = PersonneRepository::getInstance();
    }
   
    public function inscrire(array $data): bool {
        $db =App::getDependency('core', 'Database')->getConnection();
        try {
            $db->beginTransaction();
            $personne = new Personne();
            $personne->id = $data['id'];
            $personne->telephone = $data['telephone'];
           
            $personne->password = (new AshPassWord())($data['password']);
            $personne->num_identite = $data['num_identite'];
            $personne->photo_recto = $data['photo_recto'];
            $personne->photo_verso = $data['photo_verso'];
            $personne->prenom = $data['prenom'];
            $personne->nom = $data['nom'];
            $personne->adresse = $data['adresse'];
            $personne->typePersonne = 'client';
            $okPersonne = $this->personneRepository->insert($personne);

            if ($okPersonne) {
                $compteData = [
                    'id' => uniqid(),
                    'telephone' => $data['telephone'],
                    'solde' => 0,
                    'personne' => $personne,
                    'type_compte' => 'principal'
                ];
                $compteService = CompteService::getInstance();
                $okCompte = $compteService->creerCompte($compteData);
                if ($okCompte) {
                    $db->commit();
                    return true;
                }
            }
            $db->rollBack();
            return false;
        } catch (\Exception $e) {
            $db->rollBack();
            return false;
        }
    }

    public function connecter($telephone, $password): bool {
        session_start();
        $personne = $this->personneRepository->findByTelephone($telephone);
        if ($personne && password_verify($password, $personne['password'])) {
            $_SESSION['user'] = $personne;
            return true;
        }
        return false;
    }
}
