     
        document.getElementById('woyofal-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const compteur = document.getElementById('compteur').value;
            const montant = Number(document.getElementById('montant').value);

            const response = await fetch('http://localhost:8081/achats', {
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
      