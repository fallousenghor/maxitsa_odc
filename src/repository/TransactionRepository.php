<?php
namespace Maxitsa\Repository;

use Maxitsa\Core\App;
use Maxitsa\Entity\Transaction;

use Maxitsa\Abstract\AbstractRepository;

class TransactionRepository extends AbstractRepository {
    public function insert($entity = null) {
        $db = App::getDependency('core', 'Database')->getConnection();
        $data = method_exists($entity, 'toArray') ? $entity->toArray() : (array)$entity;
        $stmt = $db->prepare("INSERT INTO transaction (id, montant, type, date, compte_id) VALUES (:id, :montant, :type, :date, :compte_id)");
        return $stmt->execute([
            'id' => $data['id'] ?? null,
            'montant' => $data['montant'] ?? null,
            'type' => $data['type'] ?? null,
            'date' => $data['date'] ?? null,
            'compte_id' => $data['compte']['id'] ?? null
        ]);
    }
    public function toObject(array $row): object {
        return Transaction::toObject($row);
    }
    public function toJson($transaction): string {
        return method_exists($transaction, 'toJson') ? $transaction->toJson() : json_encode($transaction);
    }
    
    private static array $transactions = null;

 
    public function save(Transaction $transaction): void {
        self::$transactions[] = $transaction;
    }

   

     public function findAll(): array {
        return self::$transactions;
    }
       // ...existing code...
}
