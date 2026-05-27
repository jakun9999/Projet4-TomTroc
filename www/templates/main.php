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
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/styles.css">
    
    
</head>

<body class="m-0 p-0 overflow-x-hidden flex flex-col min-h-dvh xl:min-h-screen w-full bg-cassian-primary">
<!-- Responsive Navigation -->
<!-- switching from standard menu to mobile menu -->
<!-- @1280px to keep a nice menu-->
    <header class="w-full mx-auto max-w-94.25 xl:max-w-cassian-1440 bg-cassian-primary">
      <nav class="mx-5 xl:mx-37.5 pt-3.75 pb-[15.34px] xl:pb-3.5 flex flex-col xl:flex-row xl:items-center justify-between font-cassian-inter">
        
        <div class="flex items-center justify-between w-full xl:w-auto">
      <a href="#" class="inline-block">
        <img src="./assets/images/logo_hd.png" class="h-[25.66px] w-19.5 xl:h-12.75 xl:w-38.75" alt="Logo Tom Troc">
      </a>
      
      <button id="menu-toggler" type="button" class="xl:hidden text-cassian-gray hover:text-cassian-black-light focus:outline-none" aria-label="Toggle navigation">
        <svg class="h-3.75 w-5.5 fill-current" viewBox="0 0 24 24">
          <path id="menu-icon" fill-rule="evenodd" d="M4 5h16a1 1 0 010 2H4a1 1 0 110-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2z"/>
        </svg>
      </button>
    </div>

        <div id="nav-menu" class="items-end hidden w-full xl:flex xl:items-center xl:w-auto xl:grow flex-col xl:flex-row mt-4 xl:mt-0">
          
          <ul class="flex flex-col xl:flex-row gap-4 xl:gap-0 mb-4 xl:mb-0 items-end xl:items-stretch xl:w-full">
            <li class="flex xl:ml-19.5">
              <a class="flex items-center py-1 xl:py-0 text-[14px] font-cassian-inter transition-all duration-200 <?= $template === 'home' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=home">Accueil</a>
            </li>
            <li class="flex xl:ml-11">
              <a class="flex items-center py-1 xl:py-0 text-[14px] font-cassian-inter transition-all duration-200 <?= $template === 'books' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=books">Nos livres à l'échange</a>
            </li>                
            <li class="flex xl:ml-auto">
              <a class="flex gap-1.5 items-center py-1 xl:py-0  text-[14px] font-cassian-inter transition-all duration-200 <?= $template === 'messaging' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=messaging">        
                <span class="shrink-0 w-3.75 h-[13.13px] bg-current inline-block mask-messaging"></span>
                <span>Messagerie</span>
                <span class="shrink-0 rounded-full bg-cassian-black-light text-white text-[0.75rem] px-1.5 font-normal">3</span>
              </a>
            </li>
            <li class="flex xl:ml-14.5">
              <a class="flex gap-1.5 items-center py-1 xl:py-0 text-[14px] font-cassian-inter transition-all duration-200 <?= $template === 'account' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=account">        
                <span class="shrink-0 w-[9.29px] h-3.25 bg-current inline-block mask-account"></span>
                <span>Mon compte</span>
              </a>
            </li>
            <li class="flex xl:ml-14.5">
              <a class="flex items-center py-1 xl:py-0 text-[14px] font-cassian-inter transition-all duration-200 <?= $template === 'login' ? 'font-semibold text-cassian-black-light' : 'font-normal text-cassian-black-light hover:font-semibold' ?>" href="/index?action=login">Connexion</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <main class="grow w-full">
        <?= $content ?>
    </main>

    <footer class="bg-cassian-white pt-7.75 pb-[31.64px] xl:pt-5.25 xl:pb-[22.64px] mt-auto max-w-94.25 xl:max-w-cassian-1440 mx-auto w-full">
      
        <div class="flex flex-col xl:flex-row xl:justify-end items-center xl:grow gap-5 xl:gap-4 text-[0.75rem] font-light text-cassian-black-light font-cassian-inter">
          <div>Politique de confidentialité</div>
          <div class="xl:ml-10">Mentions légales</div>
          <div class="xl:ml-10">Tom Troc&copy;</div>          
          <img src="./assets/images/logo_alone.svg" class="w-5.5 h-[17.36] xl:ml-10 xl:mr-11.5 xl:pl-2" alt="Logo Tom Troc">          
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