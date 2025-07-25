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
            $personne->setTelephone(isset($data['telephone']) ? (string)$data['telephone'] : '');
            $personne->setPassword(isset($data['password']) ? (new AshPassWord())($data['password']) : '');
            $personne->setNumIdentite(isset($data['num_identite']) ? (string)$data['num_identite'] : '');
            $personne->setPhotoRecto(isset($data['photo_recto']) ? (string)$data['photo_recto'] : '');
            $personne->setPhotoVerso(isset($data['photo_verso']) ? (string)$data['photo_verso'] : '');
            $personne->setPrenom(isset($data['prenom']) ? (string)$data['prenom'] : '');
            $personne->setNom(isset($data['nom']) ? (string)$data['nom'] : '');
            $personne->setAdresse(isset($data['adresse']) ? (string)$data['adresse'] : '');
            $personne->setTypePersonne('client');
            $okPersonne = $this->personneRepository->insert($personne);

            if (!$okPersonne) {
             
                $sessionErrors = \Maxitsa\Core\Session::getInstance()->get('errors');
                $errorMsg = isset($sessionErrors['global']) ? implode(' | ', $sessionErrors['global']) : "Erreur lors de l'insertion de la personne.";
                \Maxitsa\Core\Session::getInstance()->set('errors', ['global' => [$errorMsg]]);
                $db->rollBack();
                return false;
            }

           
            $personneId = $db->lastInsertId();
            $personne->setId((int)$personneId);

            $compteData = [
                'telephone' => $data['telephone'],
                'solde' => 0,
                'personne' => $personne,
                'type_compte' => 'principal'
            ];
            $compteService = CompteService::getInstance();
            $okCompte = $compteService->creerCompte($compteData);
            if (!$okCompte) {
                \Maxitsa\Core\Session::getInstance()->set('errors', ['global' => ["Erreur lors de la création du compte principal."]]);
                $db->rollBack();
                return false;
            }

            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollBack();
            \Maxitsa\Core\Session::getInstance()->set('errors', ['global' => ["Exception lors de l'inscription : " . $e->getMessage()]]);
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
