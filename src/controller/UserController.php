<?php
namespace Maxitsa\Controller;

use Maxitsa\Abstract\AbstractController;
use Maxitsa\Service\CompteService;
use Maxitsa\Service\UploadService;
use Maxitsa\Core\Session;
use Maxitsa\Core\Validator;
use Maxitsa\Service\PersonneService;

require_once dirname(__DIR__,2) . '/app/core/App.php';
require_once dirname(__DIR__,2) . '/app/config/helpers.php';

class UserController extends AbstractController
{
    public function login()
    {
        $this->layout = 'security.layout.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST, EXTR_SKIP);
            Validator::reset();
            array_map(function($k,$v){if(!Validator::getValidators()['empty']($v))Validator::addError($k,Session::getErrorMessage($k));},array_keys(['telephone'=>$telephone??'','password'=>$password??'']),['telephone'=>$telephone??'','password'=>$password??'']);
            $errors=Validator::getErrors();
            $old=['telephone'=>$telephone??''];
            if(empty($errors)&&PersonneService::getInstance()->connecter($telephone??'', $password??''))redirect('accueil');
            if(empty($errors))Validator::addError('global','Identifiants invalides.');
            Session::getInstance()->set('errors',Validator::getErrors());
            Session::getInstance()->set('old',$old);
            redirect('login');
            exit;
        }
        $this->renderHtml('user/login.html.php');
    }
    public function addSecondaryAccount()
    {
        $session = Session::getInstance();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $telephone = $_POST['telephone'] ?? '';
            Validator::reset();
            if (Validator::getValidators()['empty']($telephone)) {
                Validator::addError('telephone', Session::getErrorMessage('telephone'));
            } elseif (!Validator::getValidators()['telephone']($telephone)) {
                Validator::addError('telephone', Session::getErrorMessage('telephone_format'));
            } elseif (!Validator::getValidators()['unique_telephone']($telephone)) {
                Validator::addError('telephone', 'Ce numéro est déjà associé à un compte');
            }
            $errors = Validator::getErrors();
            if (empty($errors)) {
               
                $user = $session->get('user');
                if ($user) {
                    $data = [
                        'telephone' => $telephone,
                        'solde' => 0,
                        'personne' => $user['id'], 
                        'personne_id' => $user['id'],
                        'type_compte' => 'secondaire'
                    ];
                    try {
                        $success = CompteService::getInstance()->creerCompte($data);
                        if ($success) {
                            redirect('accueil');
                        } else {
                            Validator::addError('global', 'Erreur lors de la création du compte secondaire.');
                        }
                    } catch (\PDOException $e) {
                        if ($e->getCode() === '23505') {
                            Validator::addError('telephone', 'Ce numéro est déjà associé à un compte');
                        } else {
                            Validator::addError('global', 'Erreur lors de la création du compte secondaire.');
                        }
                    }
                } else {
                    Validator::addError('global', 'Utilisateur non connecté.');
                }
            }
            $session->set('errors', $errors);
            $session->set('old', ['telephone' => $telephone]);
            redirect('accueil');
        }
    }
    public function signup()
    {
        // ...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST, EXTR_SKIP);
            $photoRectoPath = (isset($_FILES['photo_recto']) && $_FILES['photo_recto']['error'] === UPLOAD_ERR_OK)
                ? UploadService::upload($_FILES['photo_recto'], __DIR__ . '/../../../public/images/uploads/') : '';
            $photoVersoPath = (isset($_FILES['photo_verso']) && $_FILES['photo_verso']['error'] === UPLOAD_ERR_OK)
                ? UploadService::upload($_FILES['photo_verso'], __DIR__ . '/../../../public/images/uploads/') : '';
            $data = [
                'telephone' => $telephone ?? '',
                'password' => $password ?? '',
                'password_confirm' => $password_confirm ?? '',
                'num_identite' => $num_identite ?? '',
                'photo_recto' => $photoRectoPath,
                'photo_verso' => $photoVersoPath,
                'prenom' => $prenom ?? '',
                'nom' => $nom ?? '',
                'adresse' => $adresse ?? '',
                'type_personne' => 'client'
            ];
            $old = $data;
            Validator::reset();
            $requiredFields = [
                'prenom', 'nom', 'telephone', 'adresse', 'num_identite', 'password', 'password_confirm', 'photo_recto', 'photo_verso'
            ];
            foreach ($requiredFields as $field) {
                if (Validator::getValidators()['empty']($data[$field])) {
                    Validator::addError($field, Session::getErrorMessage($field) ?: 'Ce champ est requis.');
                }
            }
            if ($data['password'] !== $data['password_confirm']) {
                Validator::addError('password_confirm', Session::getErrorMessage('password_confirm'));
            }
            Validator::validatePersonneData($data['telephone'], $data['num_identite']);
            $errors = Validator::getErrors();
            if (empty($errors)) {
                try {
                    if (PersonneService::getInstance()->inscrire($data)) {
                        redirect('login?signup');
                    } else {
                        error_log('Echec inscription: $data = ' . print_r($data, true) . ' | erreurs session = ' . print_r(Session::getInstance()->get('errors'), true));
                        Validator::addError('global', 'Erreur lors de l\'inscription.');
                    }
                } catch (\PDOException $e) {
                    error_log('Exception inscription: ' . $e->getMessage() . ' | code: ' . $e->getCode());
                    if ($e->getCode() === '23505') {
                        Validator::addError('telephone', 'Ce numéro est déjà associé à un compte');
                    } else {
                        Validator::addError('global', 'Erreur lors de l\'inscription.');
                    }
                }
            }
            Session::getInstance()->set('errors', Validator::getErrors());
            Session::getInstance()->set('old', $old);
            redirect('signup');
            exit;
        }
        $this->renderHtml('user/signup.html.php');
    }
    public function signin()
    {
        $errors = [];
        $old = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $telephone = $_POST['telephone'] ?? '';
            $password = $_POST['password'] ?? '';
            $old = ['telephone' => $telephone];
            Validator::reset();
            $fields = [
                'telephone' => $telephone,
                'password' => $password
            ];
            foreach ($fields as $key => $value) {
                if (Validator::isEmpty($value)) {
                    Validator::addError($key, Session::getErrorMessage($key));
                }
            }
            $errors = Validator::getErrors();
            if (empty($errors)) {
                $personneService = PersonneService::getInstance();
                $ok = $personneService->connecter($telephone, $password);
                if ($ok) {
                    redirect('accueil');
                    exit;
                } else {
                    Validator::addError('global', 'Identifiants invalides.');
                    $errors = Validator::getErrors();
                }
            }
            Session::getInstance()->set('errors', $errors);
            Session::getInstance()->set('old', $old);
            redirect('login');
            exit;
        }
        $this->layout = 'security.layout.php';
        $this->renderHtml('user/login.html.php');
    }

    public function logout()
    {
        $session = Session::getInstance();
        $session->destroy();
        redirect('login');
        exit;
    }

    public function create(){}  
}
