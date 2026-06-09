<?php

/**
 * Template for the messaging page to display
 * the messaging interface.
 */

/** @var array $params */
if (isset($_SESSION['user'])) {
    $discussions = [];
}

?>
<section class="grow flex flex-col items-center w-full h-auto bg-cassian-secondary xl:bg-cassian-primary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-1 xl:w-285 min-h-full">
        <!-- Discussion list -->
        <div class="flex flex-col w-83.75 xl:w-77 min-h-full bg-cassian-secondary">
            <h1 class="xl:ml-8.5 mt-13.75 font-cassian-playfair text-[26px]">Messagerie</h1>
            <div class="flex flex-col"></div>
        </div>
        <!-- Discussion messages -->
        <div class="hidden xl:flex w-83.75 xl:flex-1 min-h-full bg-cassian-secondary xl:bg-cassian-primary">

        </div>
    </div>
</section>