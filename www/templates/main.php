<?php
/**
 * Template for the main layout page.
 * Using bootstrap and custom css for styling, this template
 * includes a header with a navigation bar, a content section 
 * where the specific page content will be injected, and a 
 * footer with legal links and branding.
 */

/** @var string $title */
/** @var string $content */
/** @var string $template */

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header: Navigation bar with collapse functionality -->
    <nav class="navbar navbar-expand-lg bg-cassian-primary fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#"><img src="./assets/images/logo_hd.png" class="navbar-cassian-logo" alt="Logo TomTroc"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mt-2 mt-lg-0 ms-lg-5 me-auto mb-lg-0">
        <li class="nav-item me-lg-5">
          <a class="nav-link <?= $template === 'home' ? 'active ft-cassian-inter-600' : 'ft-cassian-inter-400' ?>" aria-current="Page d'accueil" href="/index?action=home">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $template === 'books' ? 'active ft-cassian-inter-600' : 'ft-cassian-inter-400' ?>" aria-current="Nos livres à l'échange" href="/index?action=books">Nos livres à l'échange</a>
        </li>       
      </ul>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item me-lg-5">
            <!-- d-inline-flex gap-1 align-items-center to manage spacing between elements -->
          <a class="nav-link d-inline-flex gap-1 align-items-center <?= $template === 'messaging' ? 'active ft-cassian-inter-600' : 'ft-cassian-inter-400' ?>" aria-current="Messagerie" href="/index?action=messaging">        
        <span class="ico-cassian-messaging"></span>Messagerie<span class="rounded-5 ico-cassian-message px-1">3</span>
        </a>
        </li>
        <li class="nav-item me-lg-5">
            <!-- d-inline-flex gap-1 align-items-center to manage spacing between elements -->
          <a class="nav-link d-inline-flex gap-1 align-items-center <?= $template === 'account' ? 'active ft-cassian-inter-600' : 'ft-cassian-inter-400' ?>" aria-current="Mon compte" href="/index?action=account">        
        <span class="ico-cassian-account"></span>Mon compte
        </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $template === 'login' ? 'active ft-cassian-inter-600' : 'ft-cassian-inter-400' ?>" aria-current="Connexion" href="/index?action=login">Connexion</a>
        </li>       
      </ul>
    </div>
  </div>
</nav>
    <!-- Page content -->
    <?= $content ?>
    <!-- Footer -->
     <div class="container text-center bg-cassian-white">
        <div class="row justify-content-end align-items-center">
            <div class="col-12 col-lg-2 my-2 px-0 ft-cassian-inter-300">Politique de confidentialité</div>
            <div class="col-12 col-lg-2 my-2 px-0 ft-cassian-inter-300">Mentions légales</div>
            <div class="col-12 col-lg-1 my-2 px-0 ft-cassian-inter-300">Tom Troc&#xA9;</div>
            <div class="col-12 col-lg-1 my-2 px-0"><img src="./assets/images/logo_alone.png" alt="Logo TomTroc"></div>
            </div>
        </div>
     </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>