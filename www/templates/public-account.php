<?php

/**
 * Template for the public account page to display
 * a user's public profile information.
 */

use Ml\App\Services\Utils;

if (isset($params['user'])) {
    $user = $params['user'];
}

if (isset($params['books'])) {
    $books = $params['books'];
}
$booksCount = $params['books_count'] ?? '0';
?>


<section class="grow w-full h-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-col justify-center ml-5 xl:ml-37.5">

        <!-- Account details -->
        <div class="flex flex-col xl:flex-row gap-8.25 xl:gap-7 mt-18.25 xl:mt-25.75">

            <!-- Account information (photo, name, library summary) -->
            <div class="flex flex-col pt-12 xl:pb-14 rounded-[20px] items-center w-83.75 xl:w-85.25 h-144.75 bg-cassian-white">
                <!-- Photo and modify link -->
                <div class="flex flex-col items-center">
                    <img
                        src="<?= $user->getPhoto() ?? '' !== '' ? htmlspecialchars($user->getPhoto()) : './assets/images/anonymous.png' ?>"
                        alt=""
                        class="rounded-full w-33.75 h-33.75 object-cover">
                </div>
                <!-- separator -->
                <hr class="w-60.5 h-px mt-17.5 bg-cassian-primary text-cassian-primary ">
                <!-- Account summary -->
                <div class="flex flex-col items-center mt-12">
                    <h1 class="font-cassian-playfair text-cassian-black-light text-[24px]"><?= $user->getPseudo(); ?></h1>
                    <p class="font-cassian-inter text-cassian-gray text-[14px] mt-2.75">
                        Membre depuis <?= htmlspecialchars(Utils::age($user->getCreationDate())) ?>
                    </p>
                    <h3 class="font-cassian-inter font-semibold text-cassian-black-light text-[8px] tracking-[0.64px] mt-5.25">BIBLIOTHEQUE</h3>
                    <p class="flex justify-center items-center mt-1.5">
                        <span class="shrink-0 w-[10.41px] h-[13.71px] bg-current inline-block mask-library text-cassian-black-light"></span>
                        <span class="font-cassian-inter text-[14px] text-cassian-black-light">&nbsp;
                            <?= htmlspecialchars($booksCount) ?>
                            <?= $booksCount > 1 ? 'livres' : 'livre' ?>
                        </span>
                    </p>
                    <a href="/books" class="flex justify-center items-center w-53.75 h-15.75 mx-auto mt-11.25 font-cassian-inter border text-cassian-green border-cassian-green font-semibold text-base rounded-[10px] transition-colors duration-300 ease-in-out hover:bg-cassian-green-strong hover:text-cassian-white">
                        Écrire un message
                    </a>
                </div>
            </div>

            <!-- Book list area -->
            <div class="flex flex-col rounded-[20px] w-83.75 xl:w-192.75 bg-cassian-white">
                <?php if (isset($books) && !empty($books)): ?>
                    <table class="w-full table-fixed">
                        <thead>
                            <tr class="font-cassian-inter font-semibold text-[8px]">
                                <th>PHOTO</th>
                                <th>TITRE</th>
                                <th>AUTEUR</th>
                                <th>DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody class="font-cassian-inter text-[12px]">
                            <?php $number = 0; ?>
                            <?php foreach ($books as $book): ?>
                                <tr class="odd:bg-cassian-white even:bg-cassian-gray-strong align-middle border border-cassian-primary">
                                    <td class="pl-16.5 py-6.5">
                                        <img
                                            src="<?= $book->getImageUrl() ?? '' !== '' ? htmlspecialchars($book->getImageUrl()) : './assets/images/new_book_cover.png' ?>"
                                            alt="Photo de la couverture de <?= htmlspecialchars($book->getTitle() ?? '') ?>"
                                            class="w-19.5 h-19.5 object-cover">
                                    </td>
                                    <td class="truncate"><?= htmlspecialchars($book->getTitle() ?? '') ?></td>
                                    <td class="truncate"><?= htmlspecialchars($book->getAuthor() ?? '') ?></td>
                                    <td class="align-middle pr-15.75">
                                        <p class="line-clamp-3 italic">
                                            <?= htmlspecialchars($book->getDescription() ?? '') ?>
                                        </p>
                                    </td>
                                </tr>
                                <?php $number++ ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <h2 class="font-cassian-playfair text-[28px] text-cassian-black">Aucun livre dans la bibliothèque de <?= htmlspecialchars($user->getPseudo() ?? '') ?></h2>
                <?php endif; ?>


            </div>
        </div>

        <!-- Account library -->

    </div>
</section>