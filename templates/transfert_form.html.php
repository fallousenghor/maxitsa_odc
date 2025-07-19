<!-- Nouveau formulaire transfert, design adapté à l'application -->
<div class="max-w-lg mx-auto mt-12">
  <div class="bg-gradient-to-br from-orange-400 to-yellow-500 rounded-2xl shadow-xl p-8 border border-orange-300">
    <h2 class="text-2xl font-bold text-center text-white mb-8">Transfert d'argent</h2>
    <form action="/transfert" method="POST" class="space-y-6">
      <div>
        <label for="type_transfert" class="block text-base font-semibold text-white mb-2">Type de transfert</label>
        <select id="type_transfert" name="type_transfert" class="w-full rounded-lg px-4 py-3 border border-orange-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-300 bg-white text-gray-800">
          <option value="numero">Vers un autre numéro</option>
          <option value="secondaire">Vers un compte secondaire</option>
        </select>
      </div>
      <div id="champ_numero" style="display:block;">
        <label for="destinataire" class="block text-base font-semibold text-white mb-2">Numéro du destinataire</label>
        <input type="text" id="destinataire" name="destinataire" class="w-full rounded-lg px-4 py-3 border border-orange-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-300 bg-white text-gray-800 placeholder-gray-400" placeholder="Saisir le numéro du destinataire" autocomplete="off">
      </div>
      <div id="champ_secondaire" style="display:none;">
        <label for="compte_secondaire" class="block text-base font-semibold text-white mb-2">Sélectionner un compte secondaire</label>
        <select id="compte_secondaire" name="compte_secondaire" class="w-full rounded-lg px-4 py-3 border border-orange-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-300 bg-white text-gray-800">
          <option value="">-- Choisir un compte secondaire --</option>
          <?php if (isset($user_comptes) && is_array($user_comptes)):
            foreach ($user_comptes as $compte): ?>
              <option value="<?= htmlspecialchars($compte['telephone']) ?>">
                <?= htmlspecialchars($compte['telephone']) ?>
              </option>
            <?php endforeach;
          endif; ?>
        </select>
      </div>
      <!-- Montant -->
      <div>
        <label for="montant" class="block text-base font-semibold text-white mb-2">Montant à transférer</label>
        <input type="number" id="montant" name="montant" min="1" step="0.01" class="w-full rounded-lg px-4 py-3 border border-orange-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-300 bg-white text-gray-800 placeholder-gray-400" placeholder="Montant" required>
      </div>
      <button type="submit" class="w-full py-3 px-4 bg-white text-orange-600 font-bold rounded-lg shadow hover:bg-orange-100 transition">Valider le transfert</button>
    </form>
    <script>
      const typeTransfert = document.getElementById('type_transfert');
      const champNumero = document.getElementById('champ_numero');
      const champSecondaire = document.getElementById('champ_secondaire');
      typeTransfert.addEventListener('change', function() {
        if (this.value === 'numero') {
          champNumero.style.display = 'block';
          champSecondaire.style.display = 'none';
        } else {
          champNumero.style.display = 'none';
          champSecondaire.style.display = 'block';
        }
      });
    </script>
  </div>
</div>
