<?php

/**
 * Template for the subscribe page to allow 
 * visitors to create an account.
 */

// Values used if errors on a previous subscription attempt.
$pseudoMessage = $params['pseudo_message'] ?? '';
$pseudoOldValue = $params['pseudo_value'] ?? '';
$emailMessage = $params['email_message'] ?? '';
$emailOldValue = $params['email_value'] ?? '';
$passwordMessage = $params['password_message'] ?? '';

?>
<!-- Subscribe section -->

<section class="grow w-full h-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-col xl:flex-row justify-center items-start w-full">
        <div class="flex flex-col justify-center items-start order-1 xl:order-1 px-5 xl:px-0 xl:ml-37.5 w-full xl:w-auto">
            <h1 class="font-cassian-playfair text-[30px] xl:text-[2.25rem] text-cassian-black mt-19.5 xl:mt-32.5">Inscription</h1>
            <form action="/register" method="POST" class="flex flex-col mt-8 xl:mt-14 xl:w-80.5 w-full">
                <label for="pseudo" class="font-cassian-inter text-cassian-gray text-[14px]">Pseudo</label>
                <input type="text" value="<?= htmlspecialchars($pseudoOldValue) ?>" id="pseudo" name="pseudo" required class="focus:outline-cassian-green bg-cassian-white h-12.5 font-cassian-inter text-[14px] border border-cassian-border-form rounded-[10px] mt-2.5 w-full xl:w-80.5">
                <?= $pseudoMessage !== '' ? '<p class="mt-1 font-cassian-inter text-[10px] text-red-500 italic">' . htmlspecialchars($pseudoMessage) . '</p>' : '';  ?>
                <label for="email" class="font-cassian-inter text-cassian-gray text-[14px] mt-8">Adresse email</label>
                <input type="email" value="<?= htmlspecialchars($emailOldValue) ?>" id="email" name="email" required class="focus:outline-cassian-green bg-cassian-white h-12.5 font-cassian-inter text-[14px] border border-cassian-border-form rounded-[10px] mt-2.5 w-full xl:w-80.5">
                <?= $emailMessage !== '' ? '<p class="mt-1 font-cassian-inter text-[10px] text-red-500 italic">' . htmlspecialchars($emailMessage) . '</p>' : '';  ?>
                <label for="password" class="font-cassian-inter text-cassian-gray text-[14px] mt-8">Mot de passe</label>
                <input type="password" id="password" name="password" required class="focus:outline-cassian-green bg-cassian-white h-12.5 font-cassian-inter text-[14px] border border-cassian-border-form rounded-[10px] mt-2.5 w-full xl:w-80.5">
                <?= $passwordMessage !== '' ? '<p class="mt-1 font-cassian-inter text-[10px] text-red-500 italic">' . htmlspecialchars($passwordMessage) . '</p>' : '';  ?>
                <?php
                /**
                 * Call to generate an hidden field with CSRF token
                 */
                echo Ml\App\Services\Web::generateCsrfToken();
                ?>
                <button type="submit" class="mt-8 w-full xl:w-80.5 text-center font-cassian-inter inline-block bg-cassian-green text-cassian-white font-semibold text-base rounded-[10px] px-9.5 py-4 transition-colors duration-300 ease-in-out hover:bg-cassian-green-strong">
                    S'inscrire
                </button>
            </form>
            <p class="flex items-center mt-8 xl:mt-10 font-cassian-inter text-[16px] xl:text-[14px] gap-1">
                <span>Déjà inscrit ?</span>
                <a href="/login" class="underline">Connectez-vous</a>
            </p>
        </div>
        <div class="order-2 xl:order-2 xl:shrink-0 xl:ml-auto">
            <img src="./assets/images/login.png" alt="Des livres dans une librairie" class="w-[375.44px] h-115.5 xl:w-180 xl:h-221.5 object-cover mt-25 xl:mt-0">
        </div>
    </div>

</section>