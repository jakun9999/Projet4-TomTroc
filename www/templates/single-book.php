<?php

/**
 * Template for the single book page to display
 * the details of a specific book.
 */

/** @var array $params */
if (isset($params['book'])) {
    $book = $params['book'];
}

if (isset($params['user'])) {
    $user = $params['user'];
}

?>

<section class="grow w-full h-full bg-cassian-primary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-col xl:flex-row justify-center xl:justify-start items-start w-full">
        <div class="order-1 xl:order-1 xl:shrink-0">
            <img
                src="<?= htmlspecialchars($book->getImageUrl() ?? '' !== '' ? htmlspecialchars($book->getImageUrl()) : './assets/images/new_book_cover.png') ?>"
                alt="Photo couverture du livre <?= htmlspecialchars($book->getTitle() ?? '') ?>"
                class="w-93.75 h-[449.48px] xl:w-180 xl:h-215.75 object-cover mt-0">
        </div>
        <div class="flex flex-col justify-start items-start bg-cassian-secondary order-2 xl:order-2 pt-[40.52px] xl:pt-14.75 px-5 xl:px-21.25 pb-20 w-full">
            <h1 class="font-cassian-playfair text-[30px] xl:text-[2.25rem] text-cassian-black">
                <?= htmlspecialchars($book->getTitle() ?? '') ?>
            </h1>
            <h2 class="font-cassian-inter text-[16px] text-cassian-gray mt-10 xl:mt-4">
                par <?= htmlspecialchars($book->getAuthor() ?? '') ?>
            </h2>
            <div class="h-px w-6.75 bg-cassian-gray mt-[32.5px]"></div>
            <h3 class="font-cassian-inter font-semibold text-[8px] text-cassian-black-light mt-[32.5px]">DESCRIPTION</h3>
            <p class="font-cassian-inter text-[14px] w-83.5 xl:w-121.25 xl:h-72.25 mt-4">
                <?= htmlspecialchars($book->getDescription() ?? '') ?>
            </p>
            <h3 class="font-cassian-inter font-semibold text-[8px] text-cassian-black-light mt-10 xl:mt-8">PROPRIÉTAIRE</h3>
            <a href="#">
                <div class="flex rounded-[114px] w-39.25 h-15 bg-cassian-white mt-4 pl-1.5 gap-3 justify-start items-center">
                    <img
                        src="<?= htmlspecialchars($user->getPhoto() ?? '') !== '' ? htmlspecialchars($user->getPhoto()) : './assets/images/anonymous.png' ?>"
                        alt="Photo de profil de <?= htmlspecialchars($user->getPseudo() ?? 'Inconnu') ?>"
                        class="w-12 h-12 rounded-[114px]">
                    <span class="font-cassian-inter text-[14px]"><?= htmlspecialchars($user->getPseudo() ?? 'Inconnu') ?></span>
                </div>
            </a>
            <a href="#"
                class="flex justify-center items-center w-83.5 xl:w-121.25 h-15.75 bg-cassian-green hover:bg-cassian-green-strong font-cassian-inter font-semibold text-cassian-white text-[16px] rounded-[10px] mt-10 xl:mt-20">
                Envoyer un message
            </a>
        </div>
    </div>
</section>