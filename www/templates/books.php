<?php

/**
 * Template for the books page to display 
 * the list of available books.
 */

if (isset($params['books'])) {
    $books = $params['books'];
}
?>
<section
    class="flex flex-col flex-1 justify-center w-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div
        class="flex flex-col xl:flex-row gap-4.5 xl:justify-between xl:gap-0 xl:mx-66 mt-13.75 xl:mt-32.5 xl:items-center">
        <h1 class="font-cassian-playfair text-[30px] xl:text-[36px] text-cassian-black ml-5 xl:ml-0">Nos livres à
            l'échange</h1>
        <div class="relative w-83.75 xl:w-80.5 h-12.5 ml-5 xl:ml-0 xl:self-end">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg class="w-[15.85px] h-[15.15px] text-gray-400 font-light" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <input
                type="text"
                id="search-bar"
                placeholder="Rechercher un livre"
                aria-label="Rechercher un livre sur le site"
                class="w-full h-12.5 pl-10 pr-[12.15px] bg-cassian-white text-cassian-gray 
                placeholder-cassian-gray border border-cassian-border-form rounded-md font-cassian-inter 
                text-[14px] focus:outline-cassian-green">
        </div>

    </div>
    <?php if (!isset($books) || empty($books)): ?>
        <div class="flex-1 h-full mt-17.5 flex flex-col justify-center items-center">
            <h2 class="font-cassian-playfair text-[38px]">Aucun livre à afficher</h2>
        </div>
    <?php else: ?>
        <div
            class="flex-1 mt-17.5 grid grid-cols-2 xl:grid-cols-4 gap-3.75 xl:gap-x-9.5 xl:gap-y-12 mb-[55.4px] xl:mb-20 mx-auto">
            <?php for ($i = 0; $i < count($books); $i++): ?>
                <a href="/book?id=<?= htmlspecialchars($books[$i]->getId()) ?? '' ?>" class="book-card"
                    data-title="<?= strtolower(htmlspecialchars($books[$i]->getTitle() ?? '')) ?>"
                    data-author="<?= strtolower(htmlspecialchars($books[$i]->getAuthor() ?? '')) ?>"
                    data-pseudo="<?= strtolower(htmlspecialchars($books[$i]->getUserPseudo() ?? '')) ?>">
                    <div
                        class="w-40 h-[259.2px] xl:w-50 xl:h-81 pb-[18.4px] xl:pb-5.75 flex flex-col justify-start items-start bg-cassian-white">
                        <img src="<?= $books[$i]->getImageUrl() !== '' ? 'get_image.php?name=' . htmlspecialchars($books[$i]->getImageUrl()) : './assets/images/new_book_cover.png' ?>"
                            alt="Couverture du livre <?= $books[$i]->getTitle() ?>." class="w-40 h-40 xl:w-50 xl:h-50 object-cover">
                        <p
                            class="font-cassian-inter ml-[11.2px] xl:ml-3.5 text-cassian-black text-[13px] xl:text-[16px] mt-4 xl:mt-5 truncate max-w-34.5 xl:max-w-43">
                            <?= htmlspecialchars($books[$i]->getTitle() ?? '') ?></p>
                        <p
                            class="font-cassian-inter ml-[11.2px] xl:ml-3.5 text-cassian-gray text-[11px] xl:text-[14px] mt-[5.6px] xl:mt-2 truncate max-w-34.5 xl:max-w-43">
                            <?= htmlspecialchars($books[$i]->getAuthor() ?? '') ?></p>
                        <p
                            class="font-cassian-inter ml-[11.2px] xl:ml-3.5 text-cassian-gray text-[8px] xl:text-[10px] italic mt-[18.2px] xl:mt-5.5 truncate max-w-34.5 xl:max-w-43">
                            Vendu par : <?= htmlspecialchars($books[$i]->getUserPseudo() ?? '') ?></p>
                    </div>
                </a>
            <?php endfor; ?>
        </div>
        <div id="no-results" class="hidden flex-1 flex-col justify-center items-center py-10">
            <h2 class="font-cassian-playfair text-[28px] text-cassian-black">Aucun livre ne correspond à votre recherche.
            </h2>
        </div>
    <?php endif; ?>
</section>