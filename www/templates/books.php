<?php

/**
 * Template for the books page to display 
 * the list of available books.
 */
?>
<section class="w-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-col xl:flex-row gap-4.5 xl:justify-between xl:mx-66 mt-13.75 xl:mt-32.5 xl:items-center ">
        <h1 class="font-cassian-playfair text-[30px] xl:text-[36px] text-cassian-black ml-5">Nos livres à l'échange</h1>
        <div class="relative w-83.75 xl:w-80.5 h-12.5 ml-5">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg class="w-[15.85px] h-[15.15px] text-gray-400 font-light" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <input
                type="text"
                id="search-bar"
                placeholder="Rechercher un livre"
                class="w-full h-12.5 pl-10 pr-[12.15px] bg-cassian-white text-cassian-gray placeholder-cassian-gray border border-cassian-border-form rounded-md font-cassian-inter text-[14px] focus:outline-cassian-green">
        </div>
        <div class="mt-17.5">

        </div>
    </div>
</section>