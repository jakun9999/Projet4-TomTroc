<?php
/**
 * Template for the main layout page converted to Tailwind CSS.
 * Includes header navigation, dynamic content area, and legal footer.
 */

/** @var string $title */
/** @var string $content */
/** @var string $template */

?>
<!DOCTYPE html>
<html lang="fr" class="m-0 p-0 overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/styles.css">
    
    
</head>

<body class="m-0 p-0 overflow-x-hidden flex flex-col min-h-screen bg-cassian-primary text-cassian-black">

    <header class="w-full  mx-auto max-w-cassian-1440 bg-cassian-primary">
      <nav class="mx-[150px] py-4 lg:py-7 flex flex-wrap items-center justify-between font-cassian-inter">
        
        <a href="#" class="inline-block">
          <img src="./assets/images/logo_hd.png" class="h-[3.1875rem] w-auto" alt="Logo TomTroc">
        </a>
        
        <button id="menu-toggler" type="button" class="lg:hidden p-2 text-cassian-black-light hover:text-cassian-black focus:outline-none" aria-label="Toggle navigation">
          <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
            <path id="menu-icon" fill-rule="evenodd" d="M4 5h16a1 1 0 010 2H4a1 1 0 110-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2z"/>
          </svg>
        </button>

        <div id="nav-menu" class="hidden w-full lg:flex lg:items-center lg:w-auto grow flex-col lg:flex-row justify-between mt-4 lg:mt-0">
          
          <ul class="flex flex-col lg:flex-row gap-4 lg:gap-10 lg:ml-12 mr-auto mb-4 lg:mb-0">
            <li>
              <a class="block py-1 text-sm transition-all duration-200 <?= $template === 'home' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=home">Accueil</a>
            </li>
            <li>
              <a class="block py-1 text-sm transition-all duration-200 <?= $template === 'books' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=books">Nos livres à l'échange</a>
            </li>       
          </ul>
          
          <ul class="flex flex-col lg:flex-row gap-4 lg:gap-10 items-start lg:items-center mb-2 lg:mb-0">
            <li>
              <a class="inline-flex gap-1.5 items-center py-1 text-sm transition-all duration-200 <?= $template === 'messaging' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=messaging">        
                <span class="w-4 h-4 bg-current inline-block mask-messaging"></span>
                <span>Messagerie</span>
                <span class="rounded-full bg-cassian-black-light text-white text-[0.75rem] px-1.5 font-normal">3</span>
              </a>
            </li>
            <li>
              <a class="inline-flex gap-1.5 items-center py-1 text-sm transition-all duration-200 <?= $template === 'account' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=account">        
                <span class="lw-4 h-4 bg-current inline-block mask-account"></span>
                <span>Mon compte</span>
              </a>
            </li>
            <li>
              <a class="block py-1 text-sm transition-all duration-200 <?= $template === 'login' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=login">Connexion</a>
            </li>
          </ul>

        </div>
      </nav>
    </header>

    <main class="grow">
        <?= $content ?>
    </main>

    <footer class="bg-cassian-white py-4 mt-auto max-w-cassian-1440 mx-auto w-full">
      
        <div class="flex flex-col px-4 lg:flex-row lg:justify-end items-center lg:grow gap-4 lg:gap-8 text-[0.75rem] font-light text-cassian-black-light">
          <div class="cursor-pointer hover:underline">Politique de confidentialité</div>
          <div class="cursor-pointer hover:underline">Mentions légales</div>
          <div>Tom Troc&copy;</div>
          
            <img src="./assets/images/logo_alone.png" class="w-[22px] lg:mr-[46px] lg:pl-2" alt="Logo TomTroc" class="">
          
        </div>
      
    </footer>

    <script>
      document.getElementById('menu-toggler').addEventListener('click', function() {
        var menu = document.getElementById('nav-menu');
        menu.classList.toggle('hidden');
      });
    </script>
</body>
</html>