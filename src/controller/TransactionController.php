<?php
namespace Maxitsa\Controller;

use Maxitsa\Core\App;
use Maxitsa\Abstract\AbstractController;
use Maxitsa\Service\TransactionService;

class TransactionController extends AbstractController {
    private function checkAuth() {
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('login');
            return false;
        }
        return $user;
    }
    public function annulerTransfert()
    {
        if (!$this->checkAuth()) {
            return;
        }
        $transactionId = $_POST['transaction_id'] ?? null;
        $message = null;
        if ($transactionId) {
            $service = new TransactionService();
            $result = $service->annulerTransfert($transactionId);
            if ($result === true) {
                $message = "Transfert annulé et fonds retournés !";
            } else {
                $message = "Erreur : " . $result;
            }
        } else {
            $message = "Identifiant de transaction manquant.";
        }
       
        $transactions = $this->getRecentTransactions();
        $this->renderHtml('layout/tout.historique.web.php', [
            'transactions' => $transactions,
            'message' => $message
        ], "Tout l'historique");
    }

    public function transfert()
    {
        if (!($user = $this->checkAuth())) {
            return;
        }
        $compte_courant = $_SESSION['compte'] ?? null;
        if (!$compte_courant) {
            redirect('accueil');
            return;
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
            $service = new TransactionService();
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
        if (!($user = $this->checkAuth())) {
            return;
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
        if (!$this->checkAuth()) {
            return;
        }
        $transactions = $this->getRecentTransactions();
        $this->renderHtml('layout/tout.historique.web.php', ['transactions' => $transactions], "Tout l'historique");
    }

    public function transactions()
    {
        if (!$this->checkAuth()) {
            return;
        }
        $transactions = $this->getRecentTransactions();
        $this->renderHtml('layout/transction.web.php', ['transactions' => $transactions], 'Transactions');
    }

    private function getComptesByPersonneId($personne_id) {
        $db = App::getDependency('core', 'Database')->getConnection();
        $stmt = $db->prepare("SELECT * FROM compte WHERE personne_id = :personne_id");
        $stmt->execute(['personne_id' => $personne_id]);
        return $stmt->fetchAll();
    }

    public function create() {
     
    }

    public function getRecentTransactions() {
        $transactions = [];
        if (isset($_SESSION['compte']['id'])) {
            $db = App::getDependency('core', 'Database')->getConnection();
            $stmt = $db->prepare("SELECT * FROM transaction WHERE compte_id = :compte_id ORDER BY date DESC LIMIT 10");
            $stmt->execute(['compte_id' => $_SESSION['compte']['id']]);
            $transactions = $stmt->fetchAll();
        }
        return $transactions;
    }
}
