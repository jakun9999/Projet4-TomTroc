<?php

/**
 * Template for the error page to display an error message
 * when an error occurs or a page is not found.
 */

use Ml\App\Controllers\ErrorController;

/** @var array @params */
?>
<section class="w-full h-full bg-cassian-secondary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-col gap-5 justify-center items-start xl:ml-37.5 py-32.5 px-5 xl:px-0">
        <h1 class="font-cassian-playfair text-[38px]">Une erreur est survenue !</h1>
        <?php if (!empty($params)): ?>
            <?php if (isset($params['exception_message']) && isset($params['exception_trace'])): ?>
                <h2 class="ml-1 font-cassian-playfair text-[22px]"><?= htmlspecialchars($params['exception_message'] ?? '') ?></h2>
            <?php elseif (isset($params['message'])): ?>
                <h2 class="ml-1 font-cassian-playfair text-[22px]"><?= htmlspecialchars($params['message'] ?? '') ?></h2>
            <?php endif; ?>
        <?php else: ?>
            <h2 class="ml-1 font-cassian-playfair text-[22px]"><?= htmlspecialchars(ErrorController::MSG_UNKOWN) ?></h2>
        <?php endif; ?>
    </div>
</section>