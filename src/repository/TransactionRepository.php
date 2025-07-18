<?php
namespace Maxitsa\Repository;

use Maxitsa\Core\App;
use Maxitsa\Entity\Transaction;

use Maxitsa\Abstract\AbstractRepository;

class TransactionRepository extends AbstractRepository {
    
    private static array $transactions = null;

 
    public function save(Transaction $transaction): void {
        self::$transactions[] = $transaction;
    }

   

     public function findAll(): array {
        return self::$transactions;
    }
       public function insert($entity = null){}
}
