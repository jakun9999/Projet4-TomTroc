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

$emailMessage = $params['email_message'] ?? '';
$pseudoMessage = $params['pseudo_message'] ?? '';
$passwordMessage = $params['password_message'] ?? '';
$success = $params['success'] ?? false;

?>

<?php if (isset($_SESSION['user'])): ?>
    <section class="grow w-full h-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
        <div class="flex flex-col justify-center ml-5 xl:ml-37.5">
            <h1 class="font-cassian-playfair text-[30px] xl:text-[26px] text-cassian-black w-full mt-19.5 xl:mt-22.5">Mon compte</h1>

            <!-- Account details -->
            <div class="flex flex-col xl:flex-row gap-8 xl:gap-8.25 mt-10 xl:mt-12">

                <!-- Account information (photo, name, library summary) -->
                <div class="flex flex-col gap-12 pt-12 pb-9 xl:pb-23.25 rounded-[20px] items-center w-83.75 xl:w-136.75 h-112.75 xl:h-127 bg-cassian-white">
                    <!-- Photo and modify link -->
                    <div class="flex flex-col items-center">
                        <img src="./assets/images/anonymous.png" alt="" class="rounded-full w-33.75 h-33.75 object-cover">
                        <a href="#" class="font-cassian-inter text-[14px] text-cassian-gray mt-1.25 underline">modifier</a>
                    </div>
                    <!-- separator -->
                    <hr class="w-60.5 h-px bg-cassian-primary text-cassian-primary ">
                    <!-- Account summary -->
                    <div class="flex flex-col items-center">
                        <h2 class="font-cassian-playfair text-cassian-black-light text-[24px]"><?= $user->getPseudo(); ?></h2>
                        <p class="font-cassian-inter text-cassian-gray text-[14px] mt-2.75">
                            Membre depuis <?= Utils::age($user->getCreationDate()) ?>
                        </p>
                        <h3 class="font-cassian-inter font-semibold text-cassian-black-light text-[8px] tracking-[0.64px] mt-5.25">BIBLIOTHEQUE</h3>
                        <p class="flex justify-center items-center mt-1.5">
                            <span class="shrink-0 w-[10.41px] h-[13.71px] bg-current inline-block mask-library text-cassian-black-light"></span>
                            <span class="font-cassian-inter text-[14px] text-cassian-black-light">&nbsp;X livres</span>
                        </p>
                        <a href="/new-book" class="font-cassian-inter text-[14px] text-cassian-black-light mt-3">Ajouter un livre</a>
                    </div>
                </div>

                <!-- Account modification area -->
                <div class="flex flex-col rounded-[20px] items-center justify-center w-83.75 xl:w-136.75 h-129.75 xl:h-127 bg-cassian-white">
                    <div class="w-67.25 xl:w-80.5 flex flex-col items-start">
                        <h3 class="text-left font-cassian-inter text-[16px] text-cassian-black-light">Vos informations personnelles</h3>
                        <form action="/update-account" method="POST" class="flex flex-col mt-5.5 xl:mt-6.5 xl:w-80.5 w-full">

                            <label for="email" class="font-cassian-inter text-cassian-gray text-[14px]">Adresse email</label>
                            <input type="email" value="<?= htmlspecialchars($user->getEmail()) ?>" id="email" name="email" required class="pl-3.5 focus:outline-cassian-green bg-cassian-gray-strong h-12.5 font-cassian-inter text-[14px] border border-cassian-border-form rounded-md mt-2.5 w-full xl:w-80.5">

                            <?php
                            if ($emailMessage !== '') {
                                if (!$success) {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-red-500 italic">' . htmlspecialchars($emailMessage) . '</p>';
                                } else {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-cassian-green italic">' . htmlspecialchars($emailMessage) . '</p>';
                                }
                            }
                            ?>

                            <label for="password" class="font-cassian-inter text-cassian-gray text-[14px] mt-8">Mot de passe</label>
                            <input type="password" value="********" id="password" name="password" required class="pl-3.5 focus:outline-cassian-green bg-cassian-gray-strong h-12.5 font-cassian-inter text-[14px] border border-cassian-border-form rounded-md mt-2.5 w-full xl:w-80.5">

                            <?php
                            if ($passwordMessage !== '') {
                                if (!$success) {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-red-500 italic">' . htmlspecialchars($passwordMessage) . '</p>';
                                } else {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-cassian-green italic">' . htmlspecialchars($passwordMessage) . '</p>';
                                }
                            }
                            ?>

                            <label for="pseudo" class="font-cassian-inter text-cassian-gray text-[14px] mt-8">Pseudo</label>
                            <input type="text" value="<?= htmlspecialchars($user->getPseudo()) ?>" id="pseudo" name="pseudo" required class="pl-3.5 focus:outline-cassian-green bg-cassian-gray-strong h-12.5 font-cassian-inter text-[14px] border border-cassian-border-form rounded-md mt-2.5 w-full xl:w-80.5">
                            <?php
                            if ($pseudoMessage !== '') {
                                if (!$success) {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-red-500 italic">' . htmlspecialchars($pseudoMessage) . '</p>';
                                } else {
                                    echo '<p class="mt-1 pl-3 font-cassian-inter text-[10px] text-cassian-green italic">' . htmlspecialchars($pseudoMessage) . '</p>';
                                }
                            }
                            ?>
                            <?php
                            /**
                             * Call to generate an hidden field with CSRF token
                             */
                            echo Ml\App\Services\Web::generateCsrfToken();
                            ?>
                            <button type="submit" class="mt-8 h-15.75 w-full xl:w-37.5 text-center font-cassian-inter inline-block bg-cassian-primary hover:text-cassian-white border-cassian-green border text-cassian-green font-semibold text-base rounded-[10px] py-4 transition-colors duration-300 ease-in-out hover:bg-cassian-green-strong">
                                Enregistrer
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            <!-- Account library -->

        </div>
    </section>
<?php else: ?>
    header('location: /login');
    exit();
<?php endif; ?>