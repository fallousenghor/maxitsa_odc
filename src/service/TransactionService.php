<?php
namespace Maxitsa\Service;


use Maxitsa\Entity\Transaction;
use Maxitsa\Repository\TransactionRepository;

class TransactionService extends AbstractService {
    private TransactionRepository $transactionRepository;

    public function __construct() {
        $this->transactionRepository = new TransactionRepository();
    }

  
    public function transferer(string $typeTransfert, string $sourceTelephone, string $destinataireTelephone, float $montant) {
        $db = \Maxitsa\Core\App::getDependency('core', 'Database')->getConnection();
        try {
            $db->beginTransaction();
          
            $stmt = $db->prepare('SELECT * FROM compte WHERE telephone = :telephone');
            $stmt->execute(['telephone' => $sourceTelephone]);
            $compteSource = $stmt->fetch();
            if (!$compteSource) {
                return "Compte source introuvable.";
            }
            if ($compteSource['solde'] < $montant) {
                return "Solde insuffisant.";
            }
            
            $stmt = $db->prepare('SELECT * FROM compte WHERE telephone = :telephone');
            $stmt->execute(['telephone' => $destinataireTelephone]);
            $compteDestinataire = $stmt->fetch();
            if (!$compteDestinataire) {
                if ($typeTransfert === 'numero') {
                    $db->rollBack();
                    return "Numéro destinataire introuvable.";
                } else {
                    $db->rollBack();
                    return "Compte secondaire introuvable.";
                }
            }
           
            $stmt = $db->prepare('UPDATE compte SET solde = solde - :montant WHERE id = :id');
            $stmt->execute(['montant' => $montant, 'id' => $compteSource['id']]);
         
            $stmt = $db->prepare('UPDATE compte SET solde = solde + :montant WHERE id = :id');
            $stmt->execute(['montant' => $montant, 'id' => $compteDestinataire['id']]);

           
            $transactionSource = new Transaction(
                uniqid(),
                $montant,
                \Maxitsa\Entity\Compte::toObject($compteSource),
                'transfert',
                new \DateTime()
            );
            $this->transactionRepository->insert($transactionSource);

         
            $transactionDest = new Transaction(
                uniqid(),
                $montant,
                \Maxitsa\Entity\Compte::toObject($compteDestinataire),
                'depot',
                new \DateTime()
            );
            $this->transactionRepository->insert($transactionDest);

            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollBack();
            return $e->getMessage();
        }
    }
}
