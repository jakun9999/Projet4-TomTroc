<?php

/**
 * Template for the subscribe page to allow 
 * visitors to create an account.
 */
?>
<!-- Subscribe section -->

<section class="w-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-col xl:flex-row justify-center items-start w-full">
        <div class="flex flex-col justify-center items-start order-1 xl:order-1 px-5 xl:px-0 xl:ml-37.5 w-full xl:w-auto">
            <h1 class="font-cassian-playfair text-[30px] xl:text-[2.25rem] text-cassian-black mt-19.5 xl:mt-32.5">Inscription</h1>
            <form action="#" class="flex flex-col mt-8 xl:mt-14 xl:w-80.5 w-full">
                <label for="username" class="font-cassian-inter text-cassian-gray text-[14px]">Pseudo</label>
                <input type="text" id="username" name="username" required class="h-12.5 border border-cassian-border-form rounded-[10px] mt-2.5 w-full xl:w-80.5">
                <label for="email" class="font-cassian-inter text-cassian-gray text-[14px] mt-8">Adresse email</label>
                <input type="email" id="email" name="email" required class="h-12.5 border border-cassian-border-form rounded-[10px] mt-2.5 w-full xl:w-80.5">
                <label for="password" class="font-cassian-inter text-cassian-gray text-[14px] mt-8">Mot de passe</label>
                <input type="password" id="password" name="password" required class="h-12.5 border border-cassian-border-form rounded-[10px] mt-2.5 w-full xl:w-80.5">
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