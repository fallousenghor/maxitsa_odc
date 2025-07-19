<?php
namespace Maxitsa\Migrations;

use PDO;

class Migration {
    public static function migrate(PDO $pdo) {
        $queries = [
            
            "CREATE TABLE IF NOT EXISTS personne (
                id VARCHAR(255) PRIMARY KEY,
                telephone VARCHAR(20),
                password VARCHAR(255),
                num_identite VARCHAR(50),
                photo_recto TEXT,
                photo_verso TEXT,
                prenom VARCHAR(100),
                nom VARCHAR(100),
                adresse TEXT,
                type_personne VARCHAR(50)
            );",
            "CREATE TABLE IF NOT EXISTS compte (
                id VARCHAR(255) PRIMARY KEY,
                telephone VARCHAR(20),
                solde FLOAT,
                personne_id VARCHAR(255),
                type_compte VARCHAR(50),
                FOREIGN KEY (personne_id) REFERENCES personne(id)
            );",
            "CREATE TABLE IF NOT EXISTS transaction (
                id VARCHAR(255) PRIMARY KEY,
                compte_id VARCHAR(255),
                montant FLOAT,
                date TIMESTAMP,
                type_transaction VARCHAR(50),
                FOREIGN KEY (compte_id) REFERENCES compte(id)
            );",
            
            "DO $$ BEGIN IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_name='transaction' AND column_name='type_transaction') THEN ALTER TABLE transaction ADD COLUMN type_transaction VARCHAR(50); END IF; END $$;"
        ];
        foreach ($queries as $query) {
            $pdo->exec($query);
        }
    }
}
