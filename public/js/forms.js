document.addEventListener('DOMContentLoaded', function() {
    const cniInput = document.getElementById('numeroCni');
    if (!cniInput) return;
    cniInput.addEventListener('input', async function() {
        const cniValue = cniInput.value.trim();
        console.log('CNI saisi:', cniValue); 
        if (/^\d{13}$/.test(cniValue)) {
            try {
                console.log('Envoi requête fetch...');
                const response = await fetch(`https://appdaf-cifa.onrender.com/citoyen?nci=${cniValue}`);
                console.log('Réponse fetch:', response);
                if (response.ok) {
                    const citoyen = await response.json();
                    console.log('Citoyen reçu:', citoyen);
                    if (citoyen && citoyen.data) {
                        document.getElementById('prenom').value = citoyen.data.prenom || '';
                        document.getElementById('nom').value = citoyen.data.nom || '';
                        document.getElementById('telephone').value = citoyen.data.telephone || '';
                        document.getElementById('address').value = citoyen.data.lieuNaissance || '';
                       
                        document.getElementById('prenom').readOnly = true;
                        document.getElementById('nom').readOnly = true;
                       
                        document.getElementById('address').readOnly = true;
                    }
                } else {
                    document.getElementById('prenom').value = '';
                    document.getElementById('nom').value = '';
                    document.getElementById('telephone').value = '';
                    document.getElementById('address').value = '';
                   
                  
                }
            } catch (e) {
                console.error('Erreur lors de la récupération du citoyen:', e);
            }
        }
    });
});