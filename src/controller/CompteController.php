<?php


use Maxitsa\Abstract\AbstractController;
use Maxitsa\Service\CompteService;

class CompteController {
      public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'],
                'telephone' => $_POST['telephone'],
                'solde' => $_POST['solde'],
                'personne' => $_POST['personne_id'],
                'type_compte' => $_POST['type_compte']
            ];
            $compteService = CompteService::getInstance();
            $compteCree = $compteService->creerCompte($data);
            if ($compteCree) {
                redirect('comptes?success=1');
                exit;
            } else {
                echo 'Erreur lors de la création du compte.';
            }
        }

         
        require __DIR__ . '/../../templates/compte/create.html.php';
        
    }
      
}