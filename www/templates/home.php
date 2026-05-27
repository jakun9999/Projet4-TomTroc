<?php
/**
 * Template for the home page to display 
 * the main landing page.
 */
?>

    <!-- Discover section -->
<section>
    <div class="pt-13 pb-25.25 mx-auto max-w-cassian-1440 px-4">    
        
        <div class="flex lg:gap-x-26.25 justify-center items-center">
            
            <div class="order-2 lg:order-1 lg:items-end flex flex-col">      
                <div class="lg:text-left">
                    <h1 class="font-cassian-playfair text-[2.25rem] text-cassian-black mb-4 max-w-82.25">
                        Rejoignez nos lecteurs passionnés
                    </h1>            
                    <p class="font-cassian-inter font-light text-[16px] text-cassian-black mb-10 max-w-82 ">
                        Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. 
                        Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
                    </p>            
                    <a href="/index?action=books" class="font-cassian-inter inline-block bg-cassian-green text-cassian-white font-semibold text-base rounded-[10px] px-[2.375rem] py-4 transition-colors duration-300 ease-in-out hover:bg-cassian-green-strong">
                        Découvrir
                    </a>      
                </div>      
                  
            </div>        
            
            <div class="order-1 lg:order-2 lg:text-left">            
                <div class="inline-block">
                    <img src="./assets/images/hamza.png" class="w-101 h-134.75 object-cover max-w-full" alt="Photo de Hamza au milieu de livres">        
                    <span class="font-cassian-inter block text-right text-xs italic text-cassian-gray mt-3 pr-0.75 ">Hamza</span>
                </div>
            </div>            
        </div>  
    </div>
</section>
<!-- Last added books section -->
<section>
    <div class="pt-20 pb-16 bg-cassian-secondary max-w-cassian-1440 flex flex-col gap-12 justify-center items-center mx-auto">
        <h2 class="font-cassian-playfair text-cassian-black-light font-normal text-[32px] mb-8">Les derniers livres ajoutés</h2>
        <div class="grid grid-cols-4 gap-9.5">
            <div class="w-50 h-81 flex flex-col justify-start items-start bg-cassian-white">
                <img src="./assets/images/test_book_cover.png" alt="Dernier livre" class="w-50 h-50 object-cover">
                <p class="font-cassian-inter ml-3.5 text-cassian-black text-[16px] mt-5">Esther</p>
                <p class="font-cassian-inter ml-3.5 text-cassian-gray text-[14px] mt-2">Alabaster</p>
                <p class="font-cassian-inter ml-3.5 text-cassian-gray text-[10px] italic mt-5.5">Vendu par : xxx</p>
            </div>
             <div class="w-50 h-81 flex flex-col justify-start items-start bg-cassian-white">
                <img src="./assets/images/test_book_cover.png" alt="Dernier livre" class="w-50 h-50 object-cover">
                <p class="font-cassian-inter ml-3.5 text-cassian-black text-[16px] mt-5">Esther</p>
                <p class="font-cassian-inter ml-3.5 text-cassian-gray text-[14px] mt-2">Alabaster</p>
                <p class="font-cassian-inter ml-3.5 text-cassian-gray text-[10px] italic mt-5.5">Vendu par : xxx</p>
            </div>
             <div class="w-50 h-81 flex flex-col justify-start items-start bg-cassian-white">
                <img src="./assets/images/test_book_cover.png" alt="Dernier livre" class="w-50 h-50 object-cover">
                <p class="font-cassian-inter ml-3.5 text-cassian-black text-[16px] mt-5">Esther</p>
                <p class="font-cassian-inter ml-3.5 text-cassian-gray text-[14px] mt-2">Alabaster</p>
                <p class="font-cassian-inter ml-3.5 text-cassian-gray text-[10px] italic mt-5.5">Vendu par : xxx</p>
            </div>
             <div class="w-50 h-81 flex flex-col justify-start items-start bg-cassian-white">
                <img src="./assets/images/test_book_cover.png" alt="Dernier livre" class="w-50 h-50 object-cover">
                <p class="font-cassian-inter ml-3.5 text-cassian-black text-[16px] mt-5">Esther</p>
                <p class="font-cassian-inter ml-3.5 text-cassian-gray text-[14px] mt-2">Alabaster</p>
                <p class="font-cassian-inter ml-3.5 text-cassian-gray text-[10px] italic mt-5.5">Vendu par : xxx</p>
            </div>
        </div>
        <a href="/index?action=books" class="mx-auto font-cassian-inter inline-block bg-cassian-green text-cassian-white font-semibold text-base rounded-[10px] px-9.5 py-4 transition-colors duration-300 ease-in-out hover:bg-cassian-green-strong">
            Voir tous les livres
        </a>   
    </div>
</section>
<section class="">
    <div class="py-20 flex flex-col justify-center items-center mx-auto">
        <h2 class="font-cassian-playfair text-cassian-black-light font-normal text-[32px]">Comment ça marche ?</h2>
        <p class="text-center font-cassian-inter font-light w-99.25 text-cassian-black-light text-[16px] mt-6">Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
        <div class="grid grid-cols-4 gap-9 mt-10">
            <div class="bg-cassian-white  w-53.75 h-34.75 rounded-[10px] flex justify-center items-center">
                <p class="flex items-center text-center h-12.75 w-45 font-cassian-inter text-[14px] align-middle">Inscrivez-vous gratuitement sur 
<br />notre plateforme.</p>
            </div>
            <div class="bg-cassian-white  w-53.75 h-34.75 rounded-[10px] flex justify-center items-center">
                <p class="flex items-center text-center h-12.75 w-45 font-cassian-inter text-[14px] align-middle">Ajoutez les livres que vous souhaitez échanger à<br /> votre profil.</p>
            </div>
            <div class="bg-cassian-white  w-53.75 h-34.75 rounded-[10px] flex justify-center items-center">
                <p class="flex items-center text-center h-12.75 w-45 font-cassian-inter text-[14px] align-middle">Parcourez les livres disponibles chez d'autres membres.</p>
            </div>
            <div class="bg-cassian-white  w-53.75 h-34.75 rounded-[10px] flex justify-center items-center">
                <p class="flex items-center text-center h-12.75 w-45 font-cassian-inter text-[14px] align-middle">Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
            </div>
        </div>
        <a href="/index?action=books" class="mx-auto mt-12 font-cassian-inter inline-block border text-cassian-green border-cassian-green font-semibold text-base rounded-[10px] px-9.5 py-4 transition-colors duration-300 ease-in-out hover:bg-cassian-green-strong hover:text-cassian-white">
            Voir tous les livres
        </a>   
    </div>
</section>
<!-- Our core values -->
<section class="pb-22.25 max-w-cassian-1440 mx-auto">
    <div class="flex flex-col justify-start items-center">
        <img src="./assets/images/values_hd.png" alt="Nos valeurs">
        <div class="flex flex-col justify-center items-start mt-20">
            <h2 class="font-cassian-playfair text-cassian-black-light font-normal text-[32px]">Nos valeurs</h2>
            <p class="mt-7.25 w-98 font-cassian-inter font-light text-cassian-black-light text-[16px]">Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes. <br /><br />Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé. <br /><br />Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>
            <div class="flex justify-start items-start mt-6.25">
                <p class="pt-3.5 font-cassian-inter italic font-normal text-cassian-gray text-[12px]">L'équipe Tom Troc</p>
                <img src="./assets/images/signature.png" alt="Signature de l'équipe TomTroc" class="ml-59.75 w-30 h-25.5 object-cover">    
            </div>            
        </div>        
        
    </div>
</section>
