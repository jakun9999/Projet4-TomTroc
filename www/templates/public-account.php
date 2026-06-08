<?php

/**
 * Template for the public account page to display
 * a user's public profile information.
 */

use Ml\App\Models\Book;
use Ml\App\Services\Utils;

if (isset($params['user'])) {
    $user = $params['user'];
}

if (isset($params['books'])) {
    $books = $params['books'];
}
$booksCount = $params['books_count'] ?? '0';
?>

<section class="bg-cassian-secondary xl:max-w-cassian-1440 mx-auto h-full w-full max-w-94.25 grow">
    <div class="ml-5 flex flex-col justify-center xl:ml-37.5">
        <!-- Account details -->
        <div class="mt-18.25 flex flex-col gap-8.25 xl:mt-25.75 xl:flex-row xl:gap-7">
            <!-- Account information (photo, name, library summary) -->
            <div
                class="bg-cassian-white flex h-144.75 w-83.75 flex-col items-center rounded-[20px] pt-12 xl:w-85.25 
                xl:pb-14">
                <!-- Photo and modify link -->
                <div class="flex flex-col items-center">
                    <img src="
                    <?= $user->getPhoto() ?? '' !== '' ?
                        htmlspecialchars($user->getPhoto()) :
                        './assets/images/anonymous.png' ?>"
                        alt="" class="h-33.75 w-33.75 rounded-full object-cover" />
                </div>
                <!-- separator -->
                <hr class="bg-cassian-primary text-cassian-primary mt-17.5 h-px w-60.5" />
                <!-- Account summary -->
                <div class="mt-12 flex flex-col items-center">
                    <h1 class="font-cassian-playfair text-cassian-black-light text-[24px]"><?= $user->getPseudo(); ?>
                    </h1>
                    <p class="font-cassian-inter text-cassian-gray mt-2.75 text-[14px]">Membre depuis
                        <?= htmlspecialchars(Utils::age($user->getCreationDate())) ?></p>
                    <h3
                        class="font-cassian-inter text-cassian-black-light mt-5.25 text-[8px] font-semibold 
                        tracking-[0.64px]">
                        BIBLIOTHEQUE</h3>
                    <p class="mt-1.5 flex items-center justify-center">
                        <span
                            class="mask-library text-cassian-black-light inline-block h-[13.71px] w-[10.41px] 
                            shrink-0 bg-current"></span>
                        <span class="font-cassian-inter text-cassian-black-light text-[14px]">&nbsp;
                            <?= htmlspecialchars($booksCount) ?> <?= $booksCount > 1 ? 'livres' : 'livre' ?></span>
                    </p>
                    <a href="/books"
                        class="font-cassian-inter text-cassian-green border-cassian-green 
                        hover:bg-cassian-green-strong hover:text-cassian-white mx-auto mt-11.25 flex h-15.75 
                        w-53.75 items-center justify-center rounded-[10px] border text-base font-semibold 
                        transition-colors duration-300 ease-in-out">Écrire
                        un message</a>
                </div>
            </div>

            <!-- Book list area -->
            <div class="bg-cassian-secondary flex w-83.75 flex-col gap-4 xl:gap-0 rounded-[20px] xl:w-192.75 
            mb-10.75 xl:mb-53">
                <!-- Book list header row -->
                <div class="hidden xl:flex xl:flex-row bg-cassian-white font-cassian-inter text-[8px] font-semibold 
                pt-[33.24px] pb-[8.25px] rounded-t-[20px]">
                    <span class="ml-16.5">PHOTO</span>
                    <span class="ml-31.75">TITRE</span>
                    <span class="ml-38.75">AUTEUR</span>
                    <span class="ml-34.5">DESCRIPTION</span>
                </div>
                <?php if (isset($books) && !empty($books)): ?>
                    <?php $number = 0; ?>
                    <?php foreach ($books as $book): ?>
                        <?php $number++ ?>
                        <div class="flex flex-col xl:flex-row xl:justify-start xl:items-center px-14 
                        xl:pl-16.5 xl:pr-15.75 pt-13 pb-9.25 xl:py-6.5 font-cassian-inter text-[14px] xl:text-[12px] 
                        border-t border-cassian-primary h-62.75 w-83.25 xl:h-32.5 xl:w-192.75 rounded-[20px] 
                        xl:rounded-none
                        <?= $number % 2 === 1 ? 'bg-cassian-white' : 'bg-cassian-white xl:bg-cassian-gray-strong' ?> 
                        <?= $number === count($books) ? 'xl:rounded-b-[20px]' : '' ?>">
                            <div class="flex items-center">
                                <img src="<?= ($book->getImageUrl() ?? '') !== ''
                                                ? htmlspecialchars($book->getImageUrl())
                                                : './assets/images/new_book_cover.png' ?>"
                                    alt="Photo de couverture du livre <?= htmlspecialchars($book->getTitle() ?? '') ?>"
                                    class="w-19.75 h-19.75 xl:w-19.5 xl:h-19.5 object-cover">
                                <div class="flex flex-col xl:flex-row xl:items-center ml-4.5 xl:ml-20">
                                    <p class=" w-31 xl:w-44 pr-1.5 truncate xl:line-clamp-3">
                                        <?= htmlspecialchars($book->getTitle() ?? '') ?>
                                    </p>
                                    <p class=" w-31 xl:w-42.5 pr-1.5 truncate xl:line-clamp-3">
                                        <?= htmlspecialchars($book->getAuthor() ?? '') ?>
                                    </p>
                                </div>
                            </div>
                            <p class="italic line-clamp-3 xl:line-clamp-4 mt-5.25 xl:mt-0 xl:w-32">
                                <?= htmlspecialchars($book->getDescription() ?? '') ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <h2 class="font-cassian-playfair text-cassian-black 
                    text-[28px]">Aucun livre dans la bibliothèque de
                        <?= htmlspecialchars($user->getPseudo() ?? '') ?></h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>