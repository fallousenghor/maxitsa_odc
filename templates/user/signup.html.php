<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    // Affiche le nom du fichier sélectionné sur le bouton
    function handleFileUpload(input, labelId) {
        if (input.files && input.files[0]) {
            document.getElementById(labelId).querySelector('span').textContent = input.files[0].name;
        } else {
            document.getElementById(labelId).querySelector('span').textContent = 'Télécharger';
        }
    }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
   
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 relative overflow-x-hidden">
  
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
        <div class="absolute top-20 left-10 w-32 h-32 bg-amber-200 rounded-full opacity-20 floating-icon"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-orange-200 rounded-full opacity-30 floating-icon" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-16 h-16 bg-yellow-200 rounded-full opacity-25 floating-icon" style="animation-delay: 2s;"></div>
    </div>


    

   
    <div class="max-w-4xl mx-auto px-6 pb-12">
        <div class="card-container rounded-3xl p-8 md:p-12 slide-in">
            <form class="space-y-8" method="post" action="/signup" enctype="multipart/form-data">
                <?php
                use Maxitsa\Core\Session;
                $session = Session::getInstance();
                $errors = $session->get('errors') ?? [];
                $old = $session->get('old') ?? [];
                ?>
               
                <div class="form-section">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        Informations personnelles
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-user text-amber-500 mr-2"></i>
                                Prénom
                            </label>
                            <input 
                                type="text" 
                                id="prenom" 
                                name="prenom"
                                placeholder="Entrez votre prénom" 
                                class="input-modern w-full px-4 py-4 rounded-xl focus:outline-none text-gray-800 font-medium"
                                value="<?= htmlspecialchars($old['prenom'] ?? '') ?>"
                            >
                            <?php if (!empty($errors['prenom'])): ?>
                                <div class="text-red-500 text-sm mt-1">
                                    <?= implode('<br>', $errors['prenom']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-user text-amber-500 mr-2"></i>
                                Nom
                            </label>
                            <input 
                                type="text" 
                                id="nom" 
                                name="nom"
                                placeholder="Entrez votre nom" 
                                class="input-modern w-full px-4 py-4 rounded-xl focus:outline-none text-gray-800 font-medium"
                                value="<?= htmlspecialchars($old['nom'] ?? '') ?>"
                            >
                            <?php if (!empty($errors['nom'])): ?>
                                <div class="text-red-500 text-sm mt-1">
                                    <?= implode('<br>', $errors['nom']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Contact -->
                <div class="form-section">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-phone text-white text-sm"></i>
                        </div>
                        Informations de contact
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-phone text-amber-500 mr-2"></i>
                                Téléphone
                            </label>
                            <input 
                                type="tel" 
                                id="telephone" 
                                name="telephone"
                                placeholder="+221 XX XXX XX XX" 
                                class="input-modern w-full px-4 py-4 rounded-xl focus:outline-none text-gray-800 font-medium"
                                value="<?= htmlspecialchars($old['telephone'] ?? '') ?>"
                            >
                            <?php if (!empty($errors['telephone'])): ?>
                                <div class="text-red-500 text-sm mt-1">
                                    <?= implode('<br>', $errors['telephone']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-map-marker-alt text-amber-500 mr-2"></i>
                                Adresse
                            </label>
                            <input 
                                type="text" 
                                id="address" 
                                name="adresse"
                                placeholder="Votre adresse complète" 
                                class="input-modern w-full px-4 py-4 rounded-xl focus:outline-none text-gray-800 font-medium"
                                value="<?= htmlspecialchars($old['adresse'] ?? '') ?>"
                            >
                            <?php if (!empty($errors['adresse'])): ?>
                                <div class="text-red-500 text-sm mt-1">
                                    <?= implode('<br>', $errors['adresse']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

              
                <div class="form-section">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-id-card text-white text-sm"></i>
                        </div>
                        Pièce d'identité
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-id-card text-amber-500 mr-2"></i>
                                Numéro CNI
                            </label>
                            <input 
                                type="text" 
                                id="numeroCni" 
                                name="num_identite"
                                placeholder="Votre numéro CNI" 
                                class="input-modern w-full px-4 py-4 rounded-xl focus:outline-none text-gray-800 font-medium"
                                value="<?= htmlspecialchars($old['num_identite'] ?? '') ?>"
                            >
                            <?php if (!empty($errors['num_identite'])): ?>
                                <div class="text-red-500 text-sm mt-1">
                                    <?= implode('<br>', $errors['num_identite']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-image text-amber-500 mr-2"></i>
                                CNI Recto
                            </label>
                            <input type="file" id="cniRecto" name="photo_recto" accept="image/*" class="hidden" onchange="handleFileUpload(this, 'recto-label')">
                            <button 
                                type="button" 
                                id="recto-label"
                                onclick="document.getElementById('cniRecto').click()" 
                                class="file-upload-modern w-full px-4 py-4 rounded-xl text-center text-gray-700 font-medium focus:outline-none"
                            >
                                <i class="fas fa-cloud-upload-alt text-amber-500 mr-2"></i>
                                <span id="recto-filename">Télécharger recto</span>
                            </button>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-image text-amber-500 mr-2"></i>
                                CNI Verso
                            </label>
                            <input type="file" id="cniVerso" name="photo_verso" accept="image/*" class="hidden" onchange="handleFileUpload(this, 'verso-label')">
                <!-- Section 5: Type de personne -->
                <!-- Type de personne retiré : par défaut, le type sera "client" côté serveur -->
                            <button 
                                type="button" 
                                id="verso-label"
                                onclick="document.getElementById('cniVerso').click()" 
                                class="file-upload-modern w-full px-4 py-4 rounded-xl text-center text-gray-700 font-medium focus:outline-none"
                            >
                                <i class="fas fa-cloud-upload-alt text-amber-500 mr-2"></i>
                                <span id="verso-filename">Télécharger verso</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Sécurité -->
                <div class="form-section">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <div class="w-8 h-8 gradient-bg rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-lock text-white text-sm"></i>
                        </div>
                        Sécurité du compte
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center" for="password">
                                <i class="fas fa-lock text-amber-500 mr-2"></i>
                                Mot de passe
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password"
                                    placeholder="Créez un mot de passe sécurisé" 
                                    class="input-modern w-full px-4 py-4 pr-12 rounded-xl focus:outline-none text-gray-800 font-medium"
                                    aria-required="true"
                                >
                                <?php if (!empty($errors['password'])): ?>
                                    <div class="text-red-500 text-sm mt-1">
                                        <?= implode('<br>', $errors['password']) ?>
                                    </div>
                                <?php endif; ?>
                                <button type="button" onclick="togglePassword()" class="absolute right-4 top-4 text-gray-500 hover:text-amber-600 transition-colors" tabindex="-1">
                                    <i id="passwordToggle" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center" for="password_confirm">
                                <i class="fas fa-lock text-amber-500 mr-2"></i>
                                Confirmer le mot de passe
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirm" 
                                    name="password_confirm"
                                    placeholder="Confirmez le mot de passe" 
                                    class="input-modern w-full px-4 py-4 pr-12 rounded-xl focus:outline-none text-gray-800 font-medium"
                                    aria-required="true"
                                >
                                <?php if (!empty($errors['password_confirm'])): ?>
                                    <div class="text-red-500 text-sm mt-1">
                                        <?= implode('<br>', $errors['password_confirm']) ?>
                                    </div>
                                <?php endif; ?>
                <?php if (!empty($errors['global'])): ?>
                    <div class="text-red-500 text-sm mt-1 text-center">
                        <?= implode('<br>', $errors['global']) ?>
                    </div>
                <?php endif; ?>
                                <button type="button" onclick="togglePasswordConfirm()" class="absolute right-4 top-4 text-gray-500 hover:text-amber-600 transition-colors" tabindex="-1">
                                    <i id="passwordConfirmToggle" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

               
                <div class="form-section flex justify-center pt-8">
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="btn-modern gradient-bg text-white px-12 py-4 rounded-xl font-semibold text-lg shadow-lg focus:outline-none focus:ring-4 focus:ring-amber-300 flex items-center space-x-3"
                    >
                        <i class="fas fa-user-plus"></i>
                        <span>Créer mon compte</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
            <div class="text-center mt-6 text-color-gray-600">

                <?php
                $session->unset('errors');
                $session->unset('old');
                ?>
                <a  href="/login">retour a la page de connexion</a>
            </div>
        </div>
    </div>
</body>
</html>

 <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
        }
        
        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .input-modern {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box, 
                        linear-gradient(135deg, #fbbf24, #f59e0b) border-box;
        }
        
        .input-modern:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.3);
            border-color: transparent;
        }
        
        .input-modern::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }
        
        .btn-modern {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }
        
        .btn-modern:hover::before {
            left: 100%;
        }
        
        .btn-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(251, 191, 36, 0.4);
        }
        
        .file-upload-modern {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px dashed #fbbf24;
            background: linear-gradient(135deg, #fefbf3, #fef3c7);
        }
        
        .file-upload-modern:hover {
            border-color: #f59e0b;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.2);
        }
        
        .floating-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .slide-in {
            animation: slideIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        }
        
        .progress-bar {
            height: 4px;
            background: linear-gradient(90deg, #fbbf24, #f59e0b);
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        
        .form-section {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .form-section:nth-child(1) { animation-delay: 0.1s; }
        .form-section:nth-child(2) { animation-delay: 0.2s; }
        .form-section:nth-child(3) { animation-delay: 0.3s; }
        .form-section:nth-child(4) { animation-delay: 0.4s; }
        .form-section:nth-child(5) { animation-delay: 0.5s; }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }
        
        @keyframes pulse-ring {
            0% {
                transform: scale(0.33);
                opacity: 1;
            }
            80%, 100% {
                transform: scale(1);
                opacity: 0;
            }
        }
    </style>

    <script src="../js/forms.js"></script>