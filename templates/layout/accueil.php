<?php ob_start(); ?>
<!-- Ici, vous pouvez mettre le contenu d'accueil ou un dashboard -->
<div class="text-center">
    <h1 class="text-3xl font-bold mb-4">Bienvenue sur la page d'accueil</h1>
    <p class="text-lg">Vous êtes connecté !</p>
</div>
<?php $content = ob_get_clean();
$title = 'Accueil';
require __DIR__ . '/../layout/layout.php';
