<?php
namespace Maxitsa\Controller;
use Maxitsa\Core\App;
require_once dirname(__DIR__,2) . '/app/config/helpers.php';
use Maxitsa\Abstract\AbstractController;

class HomeController extends AbstractController {
    public function annulerTransfert()
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('login');
        }
        $transactionId = $_POST['transaction_id'] ?? null;
        $message = null;
        if ($transactionId) {
            $service = new \Maxitsa\Service\TransactionService();
            $result = $service->annulerTransfert($transactionId);
            if ($result === true) {
                $message = "Transfert annulé et fonds retournés !";
            } else {
                $message = "Erreur : " . $result;
            }
        } else {
            $message = "Identifiant de transaction manquant.";
        }
        // Recharge l'historique
        $transactions = [];
        if (isset($_SESSION['compte']['id'])) {
            $db = App::getDependency('core', 'Database')->getConnection();
            $stmt = $db->prepare("SELECT * FROM transaction WHERE compte_id = :compte_id ORDER BY date DESC LIMIT 10");
            $stmt->execute(['compte_id' => $_SESSION['compte']['id']]);
            $transactions = $stmt->fetchAll();
        }
        $this->renderHtml('layout/tout.historique.web.php', [
            'transactions' => $transactions,
            'message' => $message
        ], "Tout l'historique");
    }
    public function transfert()
    {
        $user = $_SESSION['user'] ?? null;
        $compte_courant = $_SESSION['compte'] ?? null;
        if (!$user || !$compte_courant) {
            redirect('login');
        }
        $typeTransfert = $_POST['type_transfert'] ?? '';
        $montant = isset($_POST['montant']) ? (float)$_POST['montant'] : 0;
        $sourceTelephone = $compte_courant['telephone'];
        $destinataireTelephone = '';
        if ($typeTransfert === 'numero') {
            $destinataireTelephone = $_POST['destinataire'] ?? '';
        } elseif ($typeTransfert === 'secondaire') {
            $destinataireTelephone = $_POST['compte_secondaire'] ?? '';
        }
        $message = null;
        if ($typeTransfert && $sourceTelephone && $destinataireTelephone && $montant > 0) {
            $service = new \Maxitsa\Service\TransactionService();
            $result = $service->transferer($typeTransfert, $sourceTelephone, $destinataireTelephone, $montant);
            if ($result === true) {
                $message = "Transfert réussi !";
                redirect('accueil');
            } else {
                $message = "Erreur : " . $result;
            }
        } else {
            $message = "Veuillez remplir tous les champs.";
        }
       
        $comptes = $this->getComptesByPersonneId($user['id']);
        $this->renderHtml('transfert_form.html.php', [
            'user_telephone' => $sourceTelephone,
            'user_comptes' => $comptes,
            'message' => $message
        ], 'Transfert');
    }
    public function showTransfertForm()
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('login');
        }
        $compte_courant = $_SESSION['compte'] ?? null;
        $comptes = $this->getComptesByPersonneId($user['id']);
        $this->renderHtml('transfert_form.html.php', [
            'user_telephone' => $compte_courant['telephone'] ?? '',
            'user_comptes' => $comptes
        ], 'Transfert');
    }
    
    public function toutHistorique()
    {
        
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('login');
            return;
        }
        $transactions = [];
        if (isset($_SESSION['compte']['id'])) {
            $db = App::getDependency('core', 'Database')->getConnection();
            $stmt = $db->prepare("SELECT * FROM transaction WHERE compte_id = :compte_id ORDER BY date DESC LIMIT 10");
            $stmt->execute(['compte_id' => $_SESSION['compte']['id']]);
            $transactions = $stmt->fetchAll();
        }
        $this->renderHtml('layout/tout.historique.web.php', ['transactions' => $transactions], "Tout l'historique");
    }
    public function index()
    {
        
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('login');
        }
        $compte_courant = $_SESSION['compte'] ?? null;
        $comptes = $this->getComptesByPersonneId($user['id']);
        $message = null;
        if ($compte_courant) {
            $user_telephone = $compte_courant['telephone'];
            $user_solde = $compte_courant['solde'];
        } elseif ($comptes && count($comptes) > 0) {
            $user_telephone = $comptes[0]['telephone'];
            $user_solde = $comptes[0]['solde'];
            $_SESSION['compte'] = $comptes[0]; 
        } else {
            $user_telephone = $user['telephone'] ?? '';
            $user_solde = null;
            $message = "Aucun compte trouvé pour cet utilisateur.";
        }
        $transactions = [];
        if (isset($_SESSION['compte']['id'])) {
            $db = App::getDependency('core', 'Database')->getConnection();
            $stmt = $db->prepare("SELECT * FROM transaction WHERE compte_id = :compte_id ORDER BY date DESC LIMIT 10");
            $stmt->execute(['compte_id' => $_SESSION['compte']['id']]);
            $transactions = $stmt->fetchAll();
        }
        $this->renderHtml('layout/accueil.html.php', [
            'user_telephone' => $user_telephone,
            'user_solde' => $user_solde,
            'message' => $message,
            'user_comptes' => $comptes,
            'transactions' => $transactions
        ], 'Accueil');
    }

    private function getComptesByPersonneId($personne_id) {
        $db = App::getDependency('core', 'Database')->getConnection();
        $stmt = $db->prepare("SELECT * FROM compte WHERE personne_id = :personne_id");
        $stmt->execute(['personne_id' => $personne_id]);
        return $stmt->fetchAll();
    }

    public function create(){}

    public function transactions()
    {
        
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('login');
            return;
        }
        $transactions = [];
        if (isset($_SESSION['compte']['id'])) {
            $db = App::getDependency('core', 'Database')->getConnection();
            $stmt = $db->prepare("SELECT * FROM transaction WHERE compte_id = :compte_id ORDER BY date DESC LIMIT 10");
            $stmt->execute(['compte_id' => $_SESSION['compte']['id']]);
            $transactions = $stmt->fetchAll();
        }
        $this->renderHtml('layout/transction.web.php', ['transactions' => $transactions], 'Transactions');
    }

    public function changerCompte()
    {
        
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('login');
        }
        $compte_id = $_POST['compte_id'] ?? null;
        if ($compte_id) {
            $db = App::getDependency('core', 'Database')->getConnection();
            $stmt = $db->prepare("SELECT * FROM compte WHERE id = :id AND personne_id = :personne_id");
            $stmt->execute(['id' => $compte_id, 'personne_id' => $user['id']]);
            $compte = $stmt->fetch();
            if ($compte) {
              
                $_SESSION['compte'] = $compte;
               
                $_SESSION['user_solde'] = $compte['solde'];
                redirect('accueil');
                exit;
            }
        }
    }
}
