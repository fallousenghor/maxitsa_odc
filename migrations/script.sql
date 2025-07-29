CREATE TABLE personne (
    id SERIAL PRIMARY KEY,
    telephone VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    num_identite VARCHAR(50) NOT NULL UNIQUE,
    photo_recto VARCHAR(255),
    photo_verso VARCHAR(255),
    prenom VARCHAR(100) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    adresse VARCHAR(255),
    type_personne VARCHAR(20) NOT NULL
);

CREATE TABLE compte (
    id SERIAL PRIMARY KEY,
    telephone VARCHAR(20) NOT NULL,
    solde NUMERIC(15,2) NOT NULL DEFAULT 0,
    personne_id INTEGER NOT NULL,
    type_compte VARCHAR(20) NOT NULL,
    FOREIGN KEY (personne_id) REFERENCES personne(id) ON DELETE CASCADE
);

CREATE TABLE transaction (
    id SERIAL PRIMARY KEY,
    montant NUMERIC(15,2) NOT NULL,
    compte_id INTEGER NOT NULL,
 
    type VARCHAR(20) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE
);
