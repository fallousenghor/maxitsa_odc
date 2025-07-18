<?php
use Maxitsa\Core\Session;
$session = Session::getInstance();
$errors = $session->get('errors') ?? [];
$old = $session->get('old') ?? [];
$session->unset('errors');
$session->unset('old');
?>
<div class="min-h-screen bg-orange-400 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full min-w-[600px] min-h-[300px] ">
        <form  method="post" action="/signin" class="space-y-6">
            <!-- Champ Téléphone -->
            <div>
                <input 
                    type="tel" 
                    name="telephone"
                    placeholder="Téléphone"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                    value="<?= htmlspecialchars($old['telephone'] ?? '') ?>"
                >
                <?php if (!empty($errors['telephone'])): ?>
                    <div class="text-red-500 text-sm mt-1">
                        <?= implode('<br>', $errors['telephone']) ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Champ Mot de passe -->
            <div>
                <input 
                    type="password" 
                    name="password"
                    placeholder="Mot de passe"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                >
                <?php if (!empty($errors['password'])): ?>
                    <div class="text-red-500 text-sm mt-1">
                        <?= implode('<br>', $errors['password']) ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($errors['global'])): ?>
                <div class="text-red-500 text-sm mt-1 text-center">
                    <?= implode('<br>', $errors['global']) ?>
                </div>
            <?php endif; ?>
            <!-- Boutons -->
            <div class="flex justify-between space-x-4 pt-4">
                <a href="/signup" class="px-6 py-2 border border-orange-400 text-orange-400 rounded-lg hover:bg-orange-50 transition-colors">s'inscrire</a>
                <button 
                    type="submit"
                    class="px-6 py-2 bg-orange-400 text-white rounded-lg hover:bg-orange-500 transition-colors"
                >
                    Connexion
                </button>
            </div>
        </form>
    </div>
