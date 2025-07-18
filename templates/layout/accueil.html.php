<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bancaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
   
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg px-6 py-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-university text-white text-lg"></i>
                </div>
                <h1 class="text-white text-xl font-bold">MAXITSA</h1>
            </div>
            <div class="flex items-center space-x-4">
                <button id="btn-ajouter-compte" class="btn-shine bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-2 rounded-lg font-medium transition-all duration-300 backdrop-blur-sm">
                    Ajouter compte
                </button>
                <button id="btn-changer-compte" class="btn-shine bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-2 rounded-lg font-medium transition-all duration-300 backdrop-blur-sm">
                    Changer compte
                </button>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center cursor-pointer hover:bg-opacity-30 transition-all duration-300">
                    <i class="fas fa-user text-white text-lg"></i>
                </div>
                <span class="text-white font-bold"> <?php echo htmlspecialchars($user_telephone ?? ''); ?></span>
                <a href="/logout">
                    <button class="btn-shine bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-2 rounded-lg font-medium transition-all duration-300 backdrop-blur-sm">
                        Déconnexion
                    </button>
                </a>
            </div>
        </div>
    </header>

    <!-- Popup Modal -->
    <div id="popup-ajouter-compte" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-sm absolute" style="top:70px;left:50%;transform:translateX(-50%);">
            <button id="close-popup" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4">Ajouter un compte secondaire</h2>
            <form method="post" action="/add-secondary-account" class="space-y-4">
                <div>
                    <label for="telephone" class="block text-gray-700 mb-2">Numéro de téléphone</label>
                    <input type="text" name="telephone" id="telephone" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup Changer Compte -->
    <div id="popup-changer-compte" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-sm absolute" style="top:70px;left:50%;transform:translateX(-50%);">
            <button id="close-changer-popup" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4">Changer de compte</h2>
            <form method="post" action="/changer-compte" class="space-y-4">
                <div>
                    <label for="compte_id" class="block text-gray-700 mb-2">Sélectionnez un compte</label>
                    <select name="compte_id" id="compte_id" class="w-full border rounded px-3 py-2" required>
                        <?php if (isset($user_comptes) && is_array($user_comptes)):
                            foreach ($user_comptes as $compte): ?>
                                <option value="<?= htmlspecialchars($compte['id']) ?>">
                                    <?= htmlspecialchars($compte['telephone']) ?>
                                </option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded">Changer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const btnAjouterCompte = document.getElementById('btn-ajouter-compte');
        const popup = document.getElementById('popup-ajouter-compte');
        const closePopup = document.getElementById('close-popup');
        btnAjouterCompte.addEventListener('click', () => popup.classList.remove('hidden'));
        closePopup.addEventListener('click', () => popup.classList.add('hidden'));
        window.addEventListener('click', (e) => {
            if (e.target === popup) popup.classList.add('hidden');
        });
        // Changer compte popup
        const btnChangerCompte = document.getElementById('btn-changer-compte');
        const popupChanger = document.getElementById('popup-changer-compte');
        const closeChangerPopup = document.getElementById('close-changer-popup');
        btnChangerCompte.addEventListener('click', () => popupChanger.classList.remove('hidden'));
        closeChangerPopup.addEventListener('click', () => popupChanger.classList.add('hidden'));
        window.addEventListener('click', (e) => {
            if (e.target === popupChanger) popupChanger.classList.add('hidden');
        });
    </script>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-12">
        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Solde Card -->
            <div class="card-hover gradient-bg rounded-2xl p-8 text-white shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Solde :</h2>
                    <div id="toggle-solde" class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center cursor-pointer">
                        <i class="fas fa-eye text-2xl"></i>
                    </div>
                </div>
                <div class="text-right">
                    <p id="solde-value" class="text-3xl font-black">
                        <?php 
                        if (isset($message) && $message) {
                            echo htmlspecialchars($message);
                        } elseif (isset($user_solde)) {
                            echo '••••••';
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </p>
                    <p id="solde-label" class="text-sm opacity-80 mt-2">Afficher Solde</p>
                </div>
            </div>

            <!-- Faire un Transfert Card -->
            <div class="card-hover gradient-bg rounded-2xl p-8 text-white shadow-xl cursor-pointer">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Faire un Transfert</h2>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-exchange-alt text-2xl"></i>
                    </div>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center space-x-2 bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                        <i class="fas fa-arrow-right"></i>
                        <span class="font-medium">Transférer</span>
                    </div>
                </div>
            </div>

            <!-- Faire un Paiement Card -->
            <div class="card-hover gradient-bg rounded-2xl p-8 text-white shadow-xl cursor-pointer">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Faire un paiement</h2>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-credit-card text-2xl"></i>
                    </div>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center space-x-2 bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                        <i class="fas fa-dollar-sign"></i>
                        <span class="font-medium">Payer</span>
                    </div>
                </div>
            </div>

            <!-- Derniers Transactions Card -->
            <a href="/transactions" style="text-decoration: none;">
                <div class="card-hover gradient-bg rounded-2xl p-8 text-white shadow-xl cursor-pointer md:col-span-2 lg:col-span-1">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">derniers transactions</h2>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-history text-2xl"></i>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center space-x-2 bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                            <i class="fas fa-list"></i>
                            <span class="font-medium">Voir tout</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        
    </main>

  

    <script>
        // Affichage/Masquage du solde
        const toggleBtn = document.getElementById('toggle-solde');
        const soldeValue = document.getElementById('solde-value');
        const soldeLabel = document.getElementById('solde-label');
        // Valeur réelle du solde côté PHP
        const realSolde = <?php echo isset($user_solde) ? json_encode($user_solde . ' F CFA') : 'null'; ?>;
        let visible = false;
        if (toggleBtn && soldeValue && realSolde !== null) {
            toggleBtn.addEventListener('click', function() {
                visible = !visible;
                if (visible) {
                    soldeValue.textContent = realSolde;
                    soldeLabel.textContent = 'Cliquez pour masquer';
                } else {
                    soldeValue.textContent = '••••••';
                    soldeLabel.textContent = 'Cliquez sur l\'œil pour afficher';
                }
            });
        }
    </script>
</body>
</html>

 <style>
        
        
        .gradient-bg {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }
        .btn-shine:hover::before {
            left: 100%;
        }
    </style>