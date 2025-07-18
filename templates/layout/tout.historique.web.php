<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des transactions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header avec barre de recherche et flèche retour -->
    <header class="bg-orange-500 px-4 py-3">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <a href="javascript:history.back()" class="flex items-center space-x-2 text-white hover:text-orange-200 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Retour</span>
            </a>
            <div class="flex space-x-4">
                <!-- Recherche par type -->
                <div class="relative">
                    <input type="text" placeholder="Rechercher par type" class="bg-white rounded-full px-4 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-orange-600 rounded-full p-1.5 hover:bg-orange-700 transition-colors">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Recherche par date -->
                <div class="relative">
                    <input type="text" placeholder="Rechercher par date" class="bg-white rounded-full px-4 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-orange-600 rounded-full p-1.5 hover:bg-orange-700 transition-colors">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Avatar utilisateur -->
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="max-w-4xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Historique des transactions</h1>
        
        <!-- Liste des transactions -->
        <div class="space-y-3">
            <!-- Transaction 1 - Transfert -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex justify-between items-center hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    </div>
                    <span class="text-orange-600 font-medium">Transfert</span>
                </div>
                <span class="text-gray-700 font-medium">10000 fcfa</span>
            </div>

            <!-- Transaction 2 - Depot -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex justify-between items-center hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="text-green-600 font-medium">Depot</span>
                </div>
                <span class="text-gray-700 font-medium">10000 fcfa</span>
            </div>

            <!-- Transaction 3 - Depot -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex justify-between items-center hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="text-green-600 font-medium">Depot</span>
                </div>
                <span class="text-gray-700 font-medium">10000 fcfa</span>
            </div>

            <!-- Transaction 4 - Transfert -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex justify-between items-center hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    </div>
                    <span class="text-orange-600 font-medium">Transfert</span>
                </div>
                <span class="text-gray-700 font-medium">10000 fcfa</span>
            </div>

            <!-- Transaction 5 - Paiement -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex justify-between items-center hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-yellow-600 font-medium">Paiement</span>
                </div>
                <span class="text-gray-700 font-medium">10000 fcfa</span>
            </div>

            <!-- Transaction 6 - Transfert -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex justify-between items-center hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    </div>
                    <span class="text-orange-600 font-medium">Transfert</span>
                </div>
                <span class="text-gray-700 font-medium">10000 fcfa</span>
            </div>

            <!-- Transaction 7 - Depot -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex justify-between items-center hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="text-green-600 font-medium">Depot</span>
                </div>
                <span class="text-gray-700 font-medium">10000 fcfa</span>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center space-x-2 mt-8">
            <button class="px-3 py-2 rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-50 transition-colors">
                &lt;&lt;
            </button>
            <button class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                1
            </button>
            <button class="px-3 py-2 rounded-lg bg-orange-500 text-white font-medium">
                2
            </button>
            <button class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                3
            </button>
            <button class="px-3 py-2 rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-50 transition-colors">
                &gt;&gt;
            </button>
        </div>
    </main>

    <script>
        // Fonctionnalité de recherche
        document.addEventListener('DOMContentLoaded', function() {
            const searchButtons = document.querySelectorAll('button[class*="bg-orange-600"]');
            const searchInputs = document.querySelectorAll('input[placeholder*="Rechercher"]');
            
            searchButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    const searchTerm = searchInputs[index].value.toLowerCase();
                    console.log('Recherche:', searchTerm);
                    // Ici vous pourriez ajouter la logique de filtrage
                });
            });
            
            // Recherche en temps réel
            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    // Logique de filtrage en temps réel
                });
            });
        });
    </script>
</body>
</html>