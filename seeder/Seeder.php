<?php
namespace Maxitsa\Seeder;

use PDO;

class Seeder {
    public static function seed(PDO $pdo) {
        
      
        $pdo->exec("TRUNCATE TABLE transaction, compte, personne RESTART IDENTITY CASCADE;");

        
        $pass1 = password_hash('pass1', PASSWORD_DEFAULT);
        $pass2 = password_hash('pass2', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO personne (id, telephone, password, num_identite, prenom, nom, adresse, type_personne) VALUES
            ('1', '770000001', '$pass1', '1244343455666', 'Khouss', 'Ngom', 'Dakar', 'client'),
            ('2', '770000002', '$pass2', '1234899000999', 'Fallou', 'Senghor', 'Thies', 'client')");

        
        $pdo->exec("INSERT INTO compte (id, telephone, solde, personne_id, type_compte) VALUES
            ('3', '770000001', 10000, '1', 'principal'),
            ('4', '770000002', 5000, '2', 'principal')");

       
        $pdo->exec("INSERT INTO transaction (id, compte_id, montant, date, type_transaction) VALUES
            ('5', '3', 2000, NOW(), 'depot'),
            ('5', '4', 1000, NOW(), 'retrait')");
    }
}
