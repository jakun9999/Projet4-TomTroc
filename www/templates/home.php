<?php

/**
 * Template for the home page to display 
 * the main landing page.
 */

if (isset($params['books'])) {
    $books = $params['books'];
}
?>

<!-- Discover section -->
<section class="w-full bg-cassian-primary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="xl:pt-13 pb-12 xl:pb-25.25 xl:px-4">
        <div class="flex flex-col xl:flex-row xl:gap-x-26.25 justify-center items-center">
            <div class="order-2 xl:order-1 xl:items-end flex flex-col">
                <div class="xl:text-left px-5 xl:px-0">
                    <h1 class="font-cassian-playfair text-[30px] lg:text-[2.25rem] text-cassian-black mt-8 xl:mt-0 xl:mb-4 max-w-82.25">
                        Rejoignez nos lecteurs passionnés
                    </h1>
                    <p class="font-cassian-inter font-light text-[16px] text-cassian-black xl:mb-10 xl:max-w-82 mt-4 xl:mt-0">
                        Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture.
                        Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
                    </p>
                    <a href="/books" class="mt-8 xl:mt-0 w-full text-center font-cassian-inter inline-block bg-cassian-green text-cassian-white font-semibold text-base rounded-[10px] px-9.5 py-4 transition-colors duration-300 ease-in-out hover:bg-cassian-green-strong">
                        Découvrir
                    </a>
                </div>
            </div>

            <div class="order-1 xl:order-2 xl:text-left">
                <div class="inline-block">
                    <img src="./assets/images/hamza.png" class="xl:w-101 xl:h-134.75 w-94.25 h-125.75 object-cover max-w-full" alt="Photo de Hamza au milieu de livres">
                    <span class="font-cassian-inter block text-right text-[12px] italic text-cassian-gray mt-1.25 xl:mt-3 xl:pr-0.75 pr-6.75">Hamza</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Last added books section -->
<?php if (isset($books)): ?>
    <section class="w-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
        <div class="pt-12 xl:pt-20 pb-[80.8px] xl:pb-16 flex flex-col xl:gap-12 justify-center items-center px-5 xl:px-0">
            <h2 class="font-cassian-playfair text-cassian-black-light font-normal text-[28px] xl:text-[32px] mb-[34.39px] xl:mb-8 text-center">Les derniers livres ajoutés</h2>
            <div class="grid grid-cols-2 xl:grid-cols-4 gap-3.75 xl:gap-9.5">
                <?php for ($i = 0; $i < count($books); $i++): ?>
                    <a href="/book?id=<?= htmlspecialchars($books[$i]->getId()) ?? '' ?>">
                        <div class="w-40 h-[259.2px] xl:w-50 xl:h-81 pb-[18.4px] xl:pb-5.75 flex flex-col justify-start items-start bg-cassian-white">
                            <img src="<?= $books[$i]->getImageUrl() !== '' ? htmlspecialchars($books[$i]->getImageUrl()) : './assets/images/new_book_cover.png' ?>" alt="Dernier livre" class="w-40 h-40 xl:w-50 xl:h-50 object-cover">
                            <p class="font-cassian-inter ml-[11.2px] xl:ml-3.5 text-cassian-black text-[13px] xl:text-[16px] mt-4 xl:mt-5"> <?= htmlspecialchars($books[$i]->getTitle() ?? '') ?></p>
                            <p class="font-cassian-inter ml-[11.2px] xl:ml-3.5 text-cassian-gray text-[11px] xl:text-[14px] mt-[5.6px] xl:mt-2"><?= htmlspecialchars($books[$i]->getAuthor() ?? '') ?></p>
                            <p class="font-cassian-inter ml-[11.2px] xl:ml-3.5 text-cassian-gray text-[8px] xl:text-[10px] italic mt-[18.2px] xl:mt-5.5">Vendu par : <?= htmlspecialchars($books[$i]->getUserPseudo() ?? '') ?> </p>
                        </div>
                    </a>
                <?php endfor; ?>
            </div>
            <a href="/books" class="hidden mx-auto font-cassian-inter xl:inline-block bg-cassian-green text-cassian-white font-semibold text-base rounded-[10px] px-9.5 py-4 transition-colors duration-300 ease-in-out hover:bg-cassian-green-strong">
                Voir tous les livres
            </a>
        </div>
    </section>
<?php endif; ?>
<!-- How it works -->
<section class="w-full max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="pt-12 xl:py-20 px-5 xl:px-0 flex flex-col justify-center items-center">
        <h2 class="font-cassian-playfair text-cassian-black-light font-normal text-[28px] xl:text-[32px]">Comment ça marche ?</h2>
        <p class="text-center font-cassian-inter font-light xl:w-99.25 text-cassian-black-light text-[14px] xl:text-[16px] mt-4 xl:mt-6">Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-4 xl:gap-9 mt-8 xl:mt-10 w-full xl:w-auto">
            <div class="bg-cassian-white w-full h-34.75 xl:w-53.75 xl:h-34.75 rounded-[10px] flex justify-center items-center">
                <p class="flex items-center text-center w-70 xl:h-12.75 xl:w-45 font-cassian-inter text-[14px] align-middle">Inscrivez-vous gratuitement sur notre plateforme.</p>
            </div>
            <div class="bg-cassian-white w-full h-34.75 xl:w-53.75 xl:h-34.75 rounded-[10px] flex justify-center items-center">
                <p class="flex items-center text-center w-70 xl:h-12.75 xl:w-45 font-cassian-inter text-[14px] align-middle">Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
            </div>
            <div class="bg-cassian-white w-full h-34.75 xl:w-53.75 xl:h-34.75 rounded-[10px] flex justify-center items-center">
                <p class="flex items-center text-center w-70 xl:h-12.75 xl:w-45 font-cassian-inter text-[14px] align-middle">Parcourez les livres disponibles chez d'autres membres.</p>
            </div>
            <div class="bg-cassian-white w-full h-34.75 xl:w-53.75 xl:h-34.75 rounded-[10px] flex justify-center items-center">
                <p class="flex items-center text-center w-70 xl:h-12.75 xl:w-45 font-cassian-inter text-[14px] align-middle">Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
            </div>
        </div>
        <a href="/books" class="mb-12 xl:mb-0 w-full xl:w-auto text-center mx-auto mt-8 xl:mt-12 font-cassian-inter inline-block border text-cassian-green border-cassian-green font-semibold text-base rounded-[10px] px-9.5 py-4 transition-colors duration-300 ease-in-out hover:bg-cassian-green-strong hover:text-cassian-white">
            Voir tous les livres
        </a>
    </div>
</section>
<!-- Our core values -->
<section class="pb-22.25 max-w-94.25 xl:max-w-cassian-1440 mx-auto w-full">
    <div class="flex flex-col justify-start items-center">
        <img src="./assets/images/values_hd.png" alt="Nos valeurs" class="hidden xl:block">
        <img src="./assets/images/values_sd.png" alt="Nos valeurs" class="xl:hidden w-93.75 h-106.25 object-cover">
        <div class="flex flex-col justify-center items-start mt-8.25 xl:mt-20 px-5 xl:px-0">
            <h2 class="font-cassian-playfair text-cassian-black-light font-normal text-[28px] xl:text-[32px]">Nos valeurs</h2>
            <p class="mt-7.25 xl:w-98 font-cassian-inter font-light text-cassian-black-light text-[14px] xl:text-[16px]">Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes. <br /><br />Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé. <br /><br />Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>
            <div class="flex flex-col xl:flex-row justify-start items-start mt-7 xl:mt-6.25 w-full">
                <p class="pt-3.5 font-cassian-inter italic font-normal text-cassian-gray text-[12px]">L'équipe Tom Troc</p>
                <img src="./assets/images/signature.png" alt="Signature de l'équipe TomTroc" class="mt-15.5 xl:mt-0 block mx-auto xl:mx-0 xl:ml-59.75 w-30 h-25.5 object-cover">
            </div>
        </div>

    </div>
</section>