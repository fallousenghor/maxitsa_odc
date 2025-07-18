<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des transactions</title>
    <script src="https://cdn.tailwindcss.com"></script>
  
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
   
    <div class="gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-5"></div>
        <div class="relative h-24 flex items-center justify-between px-6">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <a href="javascript:history.back()" class="flex items-center space-x-2 text-white hover:text-orange-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Retour</span>
            </a>
        </div>
    </div>

    
    <div class="px-6 py-8 max-w-lg mx-auto">
      
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-1">Historique des transactions</h1>
                <p class="text-gray-500 text-sm">Vos dernières opérations</p>
            </div>
            <a href="/tout-historique">
                <button class="bg-gradient-to-r from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    Voir plus
                </button>
            </a>
        </div>

       
        <div class="space-y-4">
            <?php foreach ($transactions as $transaction): ?>
                <?php
                    $typeRaw = isset($transaction['type']) ? $transaction['type'] : '';
                    $type = strtolower(trim((string)$typeRaw));
                    $montant = isset($transaction['montant']) ? (float)$transaction['montant'] : 0;
                    $date = isset($transaction['date']) ? date('d/m/Y H:i', strtotime((string)$transaction['date'])) : '';
                    $isDepot = $type === 'depot';
                    $isTransfert = $type === 'transfert';
                    $isPaiement = $type === 'paiement';
                    $isRetrait = $type === 'retrait';
                ?>
                <div class="bg-white card-hover rounded-2xl p-5 flex items-center justify-between shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="transaction-icon
                            <?php if ($isDepot) echo 'bg-green-50 text-green-600 border border-green-100'; ?>
                            <?php if ($isTransfert) echo 'bg-red-50 text-red-600 border border-red-100'; ?>
                            <?php if ($isPaiement) echo 'bg-blue-50 text-blue-600 border border-blue-100'; ?>
                            <?php if ($isRetrait) echo 'bg-yellow-50 text-yellow-600 border border-yellow-100'; ?>">
                            <?php if ($isDepot): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            <?php elseif ($isTransfert): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            <?php elseif ($isPaiement): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            <?php elseif ($isRetrait): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m0 0l-4-4m4 4l4-4" />
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800"><?= htmlspecialchars($type) ?></p>
                            <p class="text-sm text-gray-500"><?= $date ?></p>
                        </div>
                    </div>
                    <div class="amount-badge <?php if ($isDepot) echo 'text-green-600'; ?>">
                        <?= $isDepot ? '+' : '-' ?> <?= number_format($montant, 0, '', ' ') ?> FCFA
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

  <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 50%, #fdba74 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .transaction-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .amount-badge {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            color: #374151;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
    </style>