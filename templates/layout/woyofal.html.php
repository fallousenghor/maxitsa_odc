<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Woyofal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-50 to-yellow-100 flex items-center justify-center p-4" style="height: 100vh;">
    <div class="bg-white/90 rounded-3xl shadow-2xl p-10 w-full max-w-lg flex flex-col items-center justify-center mx-auto border border-orange-100 relative" style="min-height: 380px; box-shadow: 0 8px 32px 0 rgba(255,140,0,0.15); position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <a href="/accueil" class="absolute top-4 left-4 flex items-center gap-1 text-orange-500 hover:text-orange-700 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="font-semibold text-base group-hover:underline">Retour</span>
        </a>
        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gradient-to-br from-orange-400 to-yellow-300 rounded-full p-4 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h2.586A2 2 0 0110 5.586l1.414 1.414A2 2 0 0113.414 7H16a2 2 0 012 2v7c0 2.21-3.582 4-8 4z" /></svg>
        </div>
        <?php if (!empty($_SESSION['errors']['global'][0] ?? null)): ?>
            <div class="mb-4 w-full">
                <p class="text-red-600 text-center text-base font-semibold bg-red-100 border border-red-300 rounded-lg py-2 px-4">
                    <?php echo htmlspecialchars($_SESSION['errors']['global'][0]); ?>
                </p>
            </div>
        <?php endif; ?>

       
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    unset($_SESSION['errors'], $_SESSION['old']);
}
?>
        <h2 class="text-3xl font-extrabold text-orange-600 mb-8 text-center tracking-tight drop-shadow">Paiement Woyofal</h2>
        <form id="woyofal-form" class="w-full space-y-6 mt-8" autocomplete="off">
            <div>
                <label for="compteur" class="block text-sm font-medium text-gray-700">Numéro de compteur</label>
                <input type="text" id="compteur" name="compteur" value="<?php echo htmlspecialchars($_SESSION['old']['compteur'] ?? '') ?>"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none" />
                <?php if (!empty($_SESSION['errors']['compteur'][0] ?? null)): ?>
                    <p class="text-red-600 text-xs mt-1"><?php echo htmlspecialchars($_SESSION['errors']['compteur'][0]); ?></p>
                <?php endif; ?>
            </div>
            <div>
                <label for="montant" class="block text-sm font-medium text-gray-700">Montant</label>
                <input type="number" id="montant" name="montant" value="<?php echo htmlspecialchars($_SESSION['old']['montant'] ?? '') ?>"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none" />
                <?php if (!empty($_SESSION['errors']['montant'][0] ?? null)): ?>
                    <p class="text-red-600 text-xs mt-1"><?php echo htmlspecialchars($_SESSION['errors']['montant'][0]); ?></p>
                <?php endif; ?>
            </div>
            <button type="submit"
                class="w-full bg-gradient-to-r from-orange-400 to-yellow-300 text-white font-bold py-2 rounded-lg shadow hover:from-orange-500 hover:to-yellow-400 transition">
                Payer
            </button>
        </form>

        <div id="achat-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
            <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md relative">
                <button id="close-modal" class="absolute top-2 right-2 text-gray-400 hover:text-orange-500 text-2xl">&times;</button>
                <h2 class="text-xl font-bold mb-4 text-orange-500">Détails de l'achat</h2>
                <div id="achat-details" class="space-y-2 text-sm text-gray-700"></div>
            </div>
        </div>

        <script>
        document.getElementById('woyofal-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const compteur = document.getElementById('compteur').value;
            const montant = Number(document.getElementById('montant').value);

            const response = await fetch('https://appwoyofall.onrender.com/achats', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ numero_compteur: compteur, montant: montant })
            });

            let html = '';
            let result = null;
            try {
                result = await response.json();
            } catch (err) {
                html = `<div class="text-red-600">Erreur inattendue côté client.</div>`;
            }

            if (response.ok && result && result.data) {
                for (const [key, value] of Object.entries(result.data)) {
                    if (key !== 'id' && key !== 'localisation') { 
                        html += `<div><span class="font-semibold">${key.replace(/_/g, ' ')}:</span> ${value}</div>`;
                    }
                }
            } else {
                html = `<div class="text-red-600">${result && result.message ? result.message : "Erreur lors de l'achat."}</div>`;
            }
            document.getElementById('achat-details').innerHTML = html;
            document.getElementById('achat-modal').classList.remove('hidden');
        });

     
        document.getElementById('close-modal').onclick = function() {
            document.getElementById('achat-modal').classList.add('hidden');
        };
        </script>
    </div>
</body>
</html>
