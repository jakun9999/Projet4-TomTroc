<?php

/**
 * Template for the account page to display 
 * user account information, settings and book list.
 */

use Ml\App\Services\Utils;

/** @var array $params */

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header('location: /login');
    exit();
}

if (isset($params['books'])) {
    $books = $params['books'];
}

$emailMessage = $params['email_message'] ?? '';
$pseudoMessage = $params['pseudo_message'] ?? '';
$passwordMessage = $params['password_message'] ?? '';
$booksCount = $params['books_count'] ?? '0';
$success = $params['success'] ?? false;

?>

<?php if (isset($_SESSION['user'])): ?>
    <section class="grow w-full h-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
        <div class="flex flex-col justify-center ml-5 xl:ml-37.5">
            <h1 class="font-cassian-playfair text-[30px] xl:text-[26px] text-cassian-black w-full mt-19.5 xl:mt-22.5">
                Mon compte
            </h1>

            <!-- Account details -->
            <form
                action="/update-account"
                method="POST"
                enctype="multipart/form-data"
                class="flex flex-col xl:flex-row gap-8 xl:gap-8.25 mt-10 xl:mt-12">
                <script src="./assets/js/upload.js" defer></script>
                <!-- Account information (photo, name, library summary) -->
                <div
                    class="flex flex-col gap-12 pt-12 pb-9 xl:pb-23.25 rounded-[20px] items-center w-83.75 xl:w-136.75 
                    h-112.75 xl:h-127 bg-cassian-white">
                    <!-- Photo and modify link -->
                    <div class="flex flex-col items-center">
                        <img
                            id="preview"
                            src="<?= $user->getPhoto() ?? '' !== '' ?
                                        'get_image.php?name=' . htmlspecialchars($user->getPhoto()) :
                                        './assets/images/anonymous.png'
                                    ?>"
                            alt="Ma photo de profil."
                            class="rounded-full w-33.75 h-33.75 object-cover">
                        <input
                            hidden
                            aria-hidden="true"
                            aria-label="lien de ma nouvelle photo de profil"
                            type="file"
                            id="cover"
                            name="cover"
                            accept="image/*">
                        <button
                            type="button"
                            id="change-cover"
                            class="font-cassian-inter text-[14px] text-cassian-gray mt-1.25 underline 
                        hover:cursor-pointer">
                            modifier
                        </button>
                    </div>
                    <!-- separator -->
                    <hr class="w-60.5 h-px bg-cassian-primary text-cassian-primary ">
                    <!-- Account summary -->
                    <div class="flex flex-col items-center">
                        <h2 class="font-cassian-playfair text-cassian-black-light text-[24px]">
                            <?= $user->getPseudo(); ?>
                        </h2>
                        <p class="font-cassian-inter text-cassian-gray text-[14px] mt-2.75">
                            Membre depuis <?= Utils::age($user->getCreationDate()) ?>
                        </p>
                        <h3 class="font-cassian-inter font-semibold text-cassian-black-light text-[8px] 
                            tracking-[0.64px] mt-5.25
                            ">
                            BIBLIOTHEQUE
                        </h3>
                        <p class="flex justify-center items-center mt-1.5">
                            <span
                                class="shrink-0 w-[10.41px] h-[13.71px] bg-current inline-block mask-library 
                                text-cassian-black-light">
                            </span>
                            <span class="font-cassian-inter text-[14px] text-cassian-black-light">&nbsp;
                                <?= htmlspecialchars($booksCount) ?>
                                <?= $booksCount > 1 ? 'livres' : 'livre' ?>
                            </span>
                        </p>
                        <a href="/new-book" class="font-cassian-inter text-[14px] text-cassian-black-light mt-3">
                            Ajouter un livre
                        </a>
                    </div>
                </div>

                <!-- Account modification area -->
                <div
                    class="flex flex-col rounded-[20px] items-center justify-center w-83.75 xl:w-138.75 h-129.75 
                    xl:h-127 bg-cassian-white">
                    <div class="w-67.25 xl:w-80.5 flex flex-col items-start">
                        <h3 class="text-left font-cassian-inter text-[16px] text-cassian-black-light">
                            Vos informations personnelles
                        </h3>
                        <div class="flex flex-col mt-5.5 xl:mt-6.5 xl:w-80.5 w-full">

                            <label for="email" class="font-cassian-inter text-cassian-gray text-[14px]">Adresse
                                email</label>
                            <input type="email" value="
                            <?= htmlspecialchars($user->getEmail()) ?>
                            " id="email" name="email" required class="pl-3.5 focus:outline-cassian-green 
                            bg-cassian-gray-strong h-12.5 font-cassian-inter text-[14px] border 
                            border-cassian-border-form rounded-md mt-2.5 w-full xl:w-80.5">

                            <?php
                            if ($emailMessage !== '') {
                                if (!$success) {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-red-500 italic">' .
                                        htmlspecialchars($emailMessage) . '</p>';
                                } else {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-cassian-green 
                                    italic">' . htmlspecialchars($emailMessage) . '</p>';
                                }
                            }
                            ?>

                            <label for="password" class="font-cassian-inter text-cassian-gray text-[14px] mt-8">
                                Mot de passe
                            </label>
                            <input type="password" value="********" id="password" name="password" required
                                class="pl-3.5 focus:outline-cassian-green bg-cassian-gray-strong h-12.5 
                                font-cassian-inter text-[14px] border border-cassian-border-form rounded-md 
                                mt-2.5 w-full xl:w-80.5">

                            <?php
                            if ($passwordMessage !== '') {
                                if (!$success) {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-red-500 italic">' .
                                        htmlspecialchars($passwordMessage) . '</p>';
                                } else {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-cassian-green 
                                    italic">' . htmlspecialchars($passwordMessage) . '</p>';
                                }
                            }
                            ?>

                            <label for="pseudo" class="font-cassian-inter text-cassian-gray text-[14px] mt-8">
                                Pseudo
                            </label>
                            <input type="text" value="<?= htmlspecialchars($user->getPseudo()) ?>"
                                id="pseudo" name="pseudo" required class="pl-3.5 focus:outline-cassian-green 
                             bg-cassian-gray-strong h-12.5 font-cassian-inter text-[14px] border 
                             border-cassian-border-form rounded-md mt-2.5 w-full xl:w-80.5">
                            <?php
                            if ($pseudoMessage !== '') {
                                if (!$success) {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-red-500 italic">' .
                                        htmlspecialchars($pseudoMessage) . '</p>';
                                } else {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-cassian-green 
                                    italic">' . htmlspecialchars($pseudoMessage) . '</p>';
                                }
                            }
                            ?>
                            <?php
                            /**
                             * Call to generate an hidden field with CSRF token
                             */
                            echo Ml\App\Services\Web::generateCsrfToken();
                            ?>
                            <button type="submit"
                                class="mt-8 h-15.75 w-full xl:w-37.5 text-center font-cassian-inter inline-block 
                                bg-cassian-primary hover:text-cassian-white border-cassian-green border 
                                text-cassian-green font-semibold text-base rounded-[10px] py-4 transition-colors 
                                duration-300 ease-in-out hover:bg-cassian-green-strong">
                                Enregistrer
                            </button>
                        </div>
                    </div>

                </div>
            </form>

            <!-- Account library -->
            <!-- Book list area -->
            <div class="bg-cassian-secondary flex w-83.75 xl:w-285 flex-col gap-4 xl:gap-0 mb-10.75 
            xl:mb-25.5 mt-8">

                <?php if (isset($books) && !empty($books)): ?>
                    <!-- Book list header row -->
                    <div class="hidden xl:flex xl:flex-row bg-cassian-white font-cassian-inter text-[8px] 
                    font-semibold pt-[33.24px] pb-[8.25px] rounded-t-[20px]">
                        <span class="ml-16.5">PHOTO</span>
                        <span class="ml-31.75">TITRE</span>
                        <span class="ml-38.75">AUTEUR</span>
                        <span class="ml-34.5">DESCRIPTION</span>
                        <span class="ml-36.5">DISPONIBILITE</span>
                        <span class="ml-20.25">ACTION</span>
                    </div>
                    <?php $number = 0; ?>
                    <?php foreach ($books as $book): // Render each div for each book 
                    ?>
                        <?php $number++ ?>
                        <div class="flex flex-col xl:flex-row xl:justify-start xl:items-center px-14 
                        xl:pl-16.5 xl:pr-15.75 pt-13 pb-9.25 xl:py-6.5 font-cassian-inter text-[14px] xl:text-[12px] 
                        border-t border-cassian-primary h-81.75 w-83.25 xl:h-32.5 xl:w-285 rounded-[20px] 
                        xl:rounded-none 
                        <?= $number % 2 === 1 ? 'bg-cassian-white' : 'bg-cassian-white xl:bg-cassian-gray-strong' ?> 
                        <?= $number === count($books) ? 'xl:rounded-b-[20px]' : '' ?>">
                            <div class="flex">
                                <img src="<?= ($book->getImageUrl() ?? '') !== ''
                                                ? 'get_image.php?name=' . htmlspecialchars($book->getImageUrl())
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
                                    <p
                                        class="block xl:hidden xl:ml-16.25 w-[70.62px] h-[18.4px] rounded-[29.58px] 
                                        font-cassian-inter font-medium text-[8.88px] text-cassian-white py-[3.7px] 
                                        px-[13.31px] text-center mt-4 xl:mt-0
                                        <?php if ($book->getStatus()) {
                                            echo ' bg-cassian-green-light';
                                        } else {
                                            echo ' bg-cassian-status-red';
                                        }
                                        ?>
                                        " aria-hidden="true">
                                        <?php if ($book->getStatus()) {
                                            echo 'disponible';
                                        } else {
                                            echo 'non dispo.';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <p class="italic h-auto line-clamp-3 xl:line-clamp-4 mt-5.25 xl:mt-0 xl:w-32">
                                <?= htmlspecialchars($book->getDescription() ?? '') ?>
                            </p>
                            <p
                                class="hidden xl:block xl:ml-16.25 w-[70.62px] h-[18.4px] rounded-[29.58px] 
                                font-cassian-inter font-medium text-[8.88px] text-cassian-white py-[3.7px] 
                                px-[13.31px] text-center 
                                <?php if ($book->getStatus()) {
                                    echo ' bg-cassian-green-light';
                                } else {
                                    echo ' bg-cassian-status-red';
                                }
                                ?>
                            " aria-hidden="true">
                                <?php if ($book->getStatus()) {
                                    echo 'disponible';
                                } else {
                                    echo 'non dispo.';
                                }
                                ?>
                            </p>
                            <div class="flex font-cassian-inter text-[12px] underline mt-10.75 xl:mt-0 ml-1.25 
                            xl:ml-17.75">
                                <a href="/edit-book?book=<?= $book->getId() ?>" class="text-cassian-black-light">Éditer</a>
                                <button onclick="confirmDelete(<?= $book->getId() ?>)"
                                    class="text-cassian-text-red ml-7 cursor-pointer">
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <script>
                        function confirmDelete(id) {
                            // Display a confirmation popup before deleting a book.
                            const choice = confirm(
                                "Êtes-vous sûr de vouloir supprimer ce livre ? Cette action est irréversible."
                            );

                            if (choice) {
                                // User confirms suppression, we redirect to the correct url
                                window.location.href = "/delete-book?book=" + id;
                            } else {
                                // User has canceled, no action
                                console.log("Suppression annulée");
                            }
                        }
                    </script>
                <?php else: ?>
                    <h2 class=" font-cassian-playfair text-cassian-black text-[28px] self-center xl:mt-8">
                        Aucun livre votre bibliothèque
                    </h2>

                <?php endif; ?>
            </div>
        </div>
    </section>
<?php else: ?>
    header('location: /login');
    exit();
<?php endif; ?>