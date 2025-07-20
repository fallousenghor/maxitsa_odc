<?php
namespace Maxitsa\Service;

use Maxitsa\Core\App;
use Maxitsa\Entity\Compte;
use Maxitsa\Entity\Transaction;
use Maxitsa\Repository\TransactionRepository;

class TransactionService extends AbstractService {
    private TransactionRepository $transactionRepository;

    public function __construct() {
        $this->transactionRepository = new TransactionRepository();
    }

    private function generateSafeIntId(): int {
        return random_int(1_000_000, 2_000_000_000); // Dans la limite de PostgreSQL INT
    }

    public function annulerTransfert(string $transactionId) {
        $db = App::getDependency('core', 'Database')->getConnection();
        try {
            $db->beginTransaction();

            $stmt = $db->prepare('SELECT * FROM transaction WHERE id = :id AND type = \'transfert\'');
            $stmt->execute(['id' => $transactionId]);
            $transaction = $stmt->fetch();
            if (!$transaction) {
                return "Transaction de transfert introuvable.";
            }

            $montant = $transaction['montant'];
            $sourceId = $transaction['compte_id'];

            $stmt = $db->prepare('SELECT * FROM transaction WHERE montant = :montant AND type = \'depot\' AND date = :date');
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
                $this->generateSafeIntId(),
                $montant,
                Compte::toObject($compteSource),
                'annulation_recu',
                new \DateTime()
            );
            $this->transactionRepository->insert($annulationSource);

            $annulationDest = new Transaction(
                $this->generateSafeIntId(),
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

    public function transferer(string $typeTransfert, string $sourceTelephone, string $destinataireTelephone, float $montant) {
        $db = App::getDependency('core', 'Database')->getConnection();
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
                $db->rollBack();
                return $typeTransfert === 'numero' ? "Numéro destinataire introuvable." : "Compte secondaire introuvable.";
            }

            $stmt = $db->prepare('UPDATE compte SET solde = solde - :montant WHERE id = :id');
            $stmt->execute(['montant' => $montant, 'id' => $compteSource['id']]);

            $stmt = $db->prepare('UPDATE compte SET solde = solde + :montant WHERE id = :id');
            $stmt->execute(['montant' => $montant, 'id' => $compteDestinataire['id']]);

            $transactionSource = new Transaction(
                $this->generateSafeIntId(),
                $montant,
                Compte::toObject($compteSource),
                'transfert',
                new \DateTime()
            );
            $this->transactionRepository->insert($transactionSource);

            $transactionDest = new Transaction(
                $this->generateSafeIntId(),
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
