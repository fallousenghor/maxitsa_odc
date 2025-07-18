<?php
namespace Maxista\Enum;
enum TypePersonne: string {
    case CLIENT = 'client';
    case COMMERCIAL = 'commercial';
}

enum TypeCompte: string {
    case PRINCIPAL = 'principal';
    case SECONDAIRE = 'secondaire';
}

enum TypeTransaction: string {
    case DEPOT = 'depot';
    case RETRAIT = 'retrait';
    case PAIEMENT = 'paiement';
}