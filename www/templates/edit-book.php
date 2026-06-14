<?php

/**
 * Template for the edit book page to allow users to 
 * modify book information.
 */

/** @var array $params */

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header('location: /login');
    exit();
}

$mode = $params['mode'] ?? 'new'; // 'edit' or 'new'

// If the page called is the edit book page, a book
// instance must be provide or we redirect to user
// account page
if ($mode === 'edit') {
    $book = $params['book'] ?? null;
    if (!$book) {
        header('location: /account');
        exit();
    }

    $imageUrl = $book->getImageUrl();
    $titleValue = $book->getTitle();
    $authorValue = $book->getAuthor();
    $descriptionValue = $book->getDescription();
    $statusValue =  $book->getStatus() ? 1 : 0;
} else {
    $titleValue = $params['title_value'] ?? '';
    $authorValue = $params['author_value'] ?? '';
    $descriptionValue = $params['description_value'] ?? '';
    $statusValue = $params['status_value'] ?? 1;
}


$titleMessage = $params['title_message'] ?? '';
$authorMessage = $params['author_message'] ?? '';
$descriptionMessage = $params['description_message'] ?? '';


?>

<section class="grow w-full h-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto pb-20 xl:pb-23">
    <div class="flex flex-col items-start justify-start">
        <a
            href="/account"
            class="flex items-center font-cassian-inter text-[14px] text-cassian-gray mt-13.5 xl:mt-10 
            ml-5 xl:ml-37.5">
            <span
                class="shrink-0 w-3.75 h-[13.13px] bg-current inline-block mask-back">
            </span>
            <span>
                retour
            </span>
        </a>
        <?php if ($mode === 'edit'): ?>
            <h1 class="font-cassian-playfair text-[30px] xl:text-[26px] text-cassian-black w-67.75 xl:w-auto 
                    mt-1.75 xl:mt-5.75 ml-5 xl:ml-37.5">
                Modifier les informations
            </h1>
        <?php else: ?>
            <h1 class="font-cassian-playfair text-[30px] xl:text-[26px] text-cassian-black w-67.75 mt-1.75 
                    xl:mt-5.75 ml-5 xl:ml-37.5">
                Nouveau livre
            </h1>
        <?php endif; ?>

        <!-- Book Information Form -->
        <form class="flex flex-col xl:flex-row gap-[32.25px] xl:gap-29.5 bg-cassian-white rounded-[20px] 
                w-93.75 xl:w-full xl:max-w-285 h-full xl:h-auto mt-8.75 xl:mt-5.75 xl:ml-37.5 pt-10.5 xl:pt-14 
                xl:px-12.5 pb-11.75 xl:pb-16.5"
            action="<?= $mode === 'edit' ? '/update-book' : '/add-book' ?>"
            method="POST" enctype="multipart/form-data">
            <script src="./assets/js/upload.js" defer></script>
            <!-- Book photo div -->
            <div class="flex flex-col w-83.75 xl:w-122 h-[397.75px] xl:h-auto ml-5 xl:ml-0 xl:shrink-0">
                <p class="font-cassian-inter text-[11px] xl:text-[14px] text-cassian-gray">
                    Photo
                </p>
                <img
                    id="preview"
                    src="<?= $imageUrl ?? '' !== '' ? 'get_image.php?name=' .
                                htmlspecialchars($imageUrl) :
                                './assets/images/new_book_cover.png' ?>"
                    alt="Photo du livre"
                    class="w-83.75 h-83.75 xl:w-122 xl:h-122 object-cover mt-[7.4px] xl:mt-2.5">
                <input
                    hidden
                    type="file"
                    aria-hidden="true"
                    aria-label="Lien nouvelle couverture du livre"
                    id="cover"
                    name="cover"
                    accept="image/*">
                <button
                    type="button"
                    id="change-cover"
                    class="font-cassian-inter text-[16px] xl:text-[12px] mt-6.25 xl:mt-5.75 self-end 
                    underline text-cassian-black-light hover:cursor-pointer">
                    Modifier la photo
                </button>
            </div>

            <!-- Book information form -->
            <div class="flex flex-col ml-5 xl:ml-0">
                <label for="title" class="font-cassian-inter text-[14px] text-cassian-gray xl:mt-0">
                    Titre
                </label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($titleValue ?? '') ?>"
                    class="pl-3.5 focus:outline-cassian-green bg-cassian-gray-strong h-12.5 
                            font-cassian-inter text-[14px] border border-cassian-border-form rounded-md mt-2.5 
                            w-83.75 xl:w-108.75">
                <?php
                if ($titleMessage !== '') {
                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-red-500 italic">' .
                        htmlspecialchars($titleMessage) . '</p>';
                }
                ?>
                <label
                    for="author"
                    class="font-cassian-inter text-[14px] text-cassian-gray mt-8">
                    Auteur
                </label>
                <input
                    type="text"
                    id="author"
                    name="author"
                    value="<?= htmlspecialchars($authorValue ?? '') ?>"
                    class="pl-3.5 focus:outline-cassian-green bg-cassian-gray-strong h-12.5 
                        font-cassian-inter text-[14px] border border-cassian-border-form rounded-md mt-2.5 
                        w-83.75 xl:w-108.75">
                <?php
                if ($authorMessage !== '') {
                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-red-500 italic">' .
                        htmlspecialchars($authorMessage) . '</p>';
                }
                ?>
                <label for="description" class="font-cassian-inter text-[14px] text-cassian-gray mt-8">
                    Commentaire
                </label>
                <textarea id="description" name="description" class="pl-3.5 pt-4 pr-3 
                        focus:outline-cassian-green bg-cassian-gray-strong h-89 font-cassian-inter text-[14px] 
                        border border-cassian-border-form rounded-md 
                        mt-2.5 w-83.75 xl:w-108.75"><?= htmlspecialchars($descriptionValue ?? '') ?></textarea>
                <?php
                if ($descriptionMessage !== '') {
                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-red-500 italic">' .
                        htmlspecialchars($descriptionMessage) . '</p>';
                }
                ?>
                <label
                    for="status"
                    class="font-cassian-inter text-[14px] text-cassian-gray mt-8">
                    Disponibilité
                </label>
                <select
                    id="status"
                    name="status"
                    class="pl-3.5 focus:outline-cassian-green bg-cassian-gray-strong h-12.5 font-cassian-inter 
                text-[14px] border border-cassian-border-form rounded-md mt-2.5 w-83.75 xl:w-108.75">
                    <option value="true" <?= $statusValue === 1 ? 'selected' : '' ?>>Disponible</option>
                    <option value="false" <?= $statusValue === 0 ? 'selected' : '' ?>>Non disponible</option>
                </select>
                <?php
                /**
                 * Call to generate an hidden field with CSRF token
                 */
                echo Ml\App\Services\Web::generateCsrfToken();
                ?>
                <?php
                if ($mode === 'edit') {
                    echo '<input hidden  aria-hidden="true" aria-label="Identifiant du livre" name="book" value="' .
                        $book->getId() . '">';
                }
                ?>
                <button
                    type="submit"
                    class="bg-cassian-green hover:bg-cassian-green-dark text-white font-semibold 
                hover:bg-cassian-green-strong font-cassian-inter text-[14px] py-2.5 px-4 rounded-md 
                mt-11 w-83.75 xl:w-80.5 h-15.75 transition-colors duration-300 ease-in-out">
                    Valider
                </button>
            </div>
        </form>
    </div>
</section>