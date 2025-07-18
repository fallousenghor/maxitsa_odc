<?php
namespace Maxitsa\Enum;

enum ErrorMessage: string { 
    case prenom = 'Le prénom est requis.';
    case nom = 'Le nom est requis.';
    case telephone = 'Le téléphone est requis.';
    case adresse = "L'adresse est requise.";
    case num_identite = "Le numéro d'identité est requis.";
    case password = 'Le mot de passe est requis.';
    case password_confirm = 'Les mots de passe ne correspondent pas.';
    case login_invalid = 'Identifiants invalides.';
    case signup_error = "Erreur lors de l'inscription.";
    case account_create_error = "Erreur lors de la création du compte.";
    case upload = "Erreur lors de l'upload des fichiers.";
    case transaction_error = "Erreur lors de la transaction.";
    case solde_insuffisant = "Solde insuffisant.";
    case transaction_success = "Transaction effectuée avec succès.";
    case telephone_format = 'Le format du numéro de téléphone est invalide.';
    case telephone_unique = 'Ce numéro de téléphone existe déjà.';
    case identite_format = "Le format du numéro d'identité est invalide.";
    case identite_unique = "Ce numéro d'identité existe déjà.";
    case field_required = "Ce champ est requis.";
    case unknown_error = "Une erreur inconnue est survenue.";
}
