<?php
namespace Maxitsa\Controller;

use Maxitsa\Abstract\AbstractController;
use Maxitsa\Core\Validator;
use Maxitsa\Core\Session;
use Maxitsa\Enum\ErrorMessage;

class WoyofalController extends AbstractController
{
   
    public function showForm()
    {
        $this->renderHtml('layout/woyofal.html.php');
    }

    public function paiement()
    {
        Validator::reset();
        $compteur = $_POST['compteur'] ?? '';
        $montant = $_POST['montant'] ?? '';
        $session = Session::getInstance();

        if (Validator::getValidators()['empty']($compteur)) {
            Validator::addError('compteur', Validator::getErrorMessage('field_required'));
        } elseif (!preg_match('/^\d{6,}$/', $compteur)) {
            Validator::addError('compteur', Validator::getErrorMessage('compteur_format'));
        }
        if (Validator::getValidators()['empty']($montant)) {
            Validator::addError('montant', Validator::getErrorMessage('field_required'));
        } elseif (!is_numeric($montant) || $montant < 100) {
            Validator::addError('montant', Validator::getErrorMessage('montant_format'));
        }

        $errors = Validator::getErrors();
        $session->set('errors', $errors);
        $session->set('old', ['compteur' => $compteur, 'montant' => $montant]);

        if (!empty($errors)) {
            $this->renderHtml('layout/woyofal.html.php');
            return;
        }

        $session->set('success', Validator::getErrorMessage('transaction_success'));
        header('Location: /paiement-woyofal');
        exit;
    }

     public function create()
    {
       
    }
}
