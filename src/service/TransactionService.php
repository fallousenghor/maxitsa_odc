<?php
namespace Maxitsa\Service;


use Maxitsa\Entity\Compte;
use Maxitsa\Entity\Transaction;
use Maxitsa\Repository\TransactionRepository;

class TransactionService extends AbstractService {
    
    public function annulerTransfert(string $transactionId) {
        $db = \Maxitsa\Core\App::getDependency('core', 'Database')->getConnection();
        try {
            $db->beginTransaction();
          
            $stmt = $db->prepare('SELECT * FROM transaction WHERE id = :id AND type = "transfert"');
            $stmt->execute(['id' => $transactionId]);
            $transaction = $stmt->fetch();
            if (!$transaction) {
                return "Transaction de transfert introuvable.";
            }
            $montant = $transaction['montant'];
            $sourceId = $transaction['compte_id'];
           
            $stmt = $db->prepare('SELECT * FROM transaction WHERE montant = :montant AND type = "depot" AND date = :date');
            $stmt->execute(['montant' => $montant, 'date' => $transaction['date']]);
            $transactionDepot = $stmt->fetch();
            if (!$transactionDepot) {
                return "Transaction de depot associée introuvable.";
            }
            $destinataireId = $transactionDepot['compte_id'];
           
            $stmt = $db->prepare('SELECT * FROM compte WHERE id = :id');
            $stmt->execute(['id' => $destinataireId]);
            $compteDestinataire = $stmt->fetch();
            if (!$compteDestinataire) {
                return "Compte destinataire introuvable.";
            }
            if ($compteDestinataire['solde'] < $montant) {
                return "Solde du destinataire insuffisant pour annuler.";
            }
           
            $stmt = $db->prepare('UPDATE compte SET solde = solde - :montant WHERE id = :id');
            $stmt->execute(['montant' => $montant, 'id' => $destinataireId]);
          
            $stmt = $db->prepare('UPDATE compte SET solde = solde + :montant WHERE id = :id');
            $stmt->execute(['montant' => $montant, 'id' => $sourceId]);
           
            $stmt = $db->prepare('SELECT * FROM compte WHERE id = :id');
            $stmt->execute(['id' => $sourceId]);
            $compteSource = $stmt->fetch();
            $annulationSource = new Transaction(
                uniqid(),
                $montant,
                Compte::toObject($compteSource),
                'annulation_recu',
                new \DateTime()
            );
            $this->transactionRepository->insert($annulationSource);
            
            $annulationDest = new Transaction(
                uniqid(),
                $montant,
                Compte::toObject($compteDestinataire),
                'annulation_envoye',
                new \DateTime()
            );
            $this->transactionRepository->insert($annulationDest);
            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollBack();
            return $e->getMessage();
        }
    }
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
                Compte::toObject($compteSource),
                'transfert',
                new \DateTime()
            );
            $this->transactionRepository->insert($transactionSource);

         
            $transactionDest = new Transaction(
                uniqid(),
                $montant,
                Compte::toObject($compteDestinataire),
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

