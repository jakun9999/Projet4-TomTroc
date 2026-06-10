<?php

/**
 * Template for the messaging page to display
 * the messaging interface.
 */

use Ml\App\Services\Utils;

/** @var array $params */

// A valid user must be authenticated to load this template.
if (!isset($_SESSION['user'])) {
    header('location: /login');
}

$discussions = $params['discussions'] ?? [];
$selectedDiscussion = $params['selected_discussion'] ?? null;
$messages = $params['messages'] ?? [];

// discussion details to be displayed in main DIV if no discussion was
// previously selected.
if (is_null($selectedDiscussion) && !empty($discussions)) {
    $selectedDiscussion = $discussions[0];
}

?>
<section class="grow flex flex-col items-center w-full h-auto bg-cassian-secondary xl:bg-cassian-primary 
max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-1 xl:w-285 min-h-full">

        <!-- Discussion list left pane -->
        <div class="flex flex-col w-83.75 xl:w-77 min-h-full bg-cassian-secondary">
            <h1 class="xl:ml-8.5 mt-13.75 font-cassian-playfair text-[26px]">Messagerie</h1>
            <div class="flex flex-col mt-6.75">
                <?php foreach ($discussions as $discussion): ?>
                    <?php

                    // We need to find current selected discussion and if it has
                    // messages to display last message under otherUserPseudo
                    if (!is_null($discussion->getId())) {
                        if (!empty($messages)) {
                            $lastMessageKey = array_key_last($messages[$discussion->getId()]);
                            $message = $messages[$discussion->getId()][$lastMessageKey];
                            $lastMessageContent = $message->getContent();
                            $lastMessageDate = Utils::displayDiscussionDate($message->getCreationDate());
                        }
                    }

                    ?>
                    <a href="<?= is_null($discussion->getId()) ? '#' :
                                    '/show-discussion?with=' .
                                    $discussion->getOtherUserId() ?>"
                        class="flex pl-8.5 pt-4.5 pr-10.5 pb-4.5 
                        <?php
                        if ($discussion->getId() === $selectedDiscussion->getId()) {
                            echo 'bg-cassian-white';
                        }
                        ?>
                        ">
                        <img src="<?= $discussion->getOtherUserPhoto() !== '' ?
                                        htmlspecialchars($discussion->getOtherUserPhoto()) :
                                        './assets/images/anonymous.png' ?>"
                            alt="Photo de profil de <?= htmlspecialchars($discussion->getOtherUserPseudo() ?? '') ?>"
                            class="w-12 h-12 object-cover rounded-full">
                        <div class="flex flex-col ml-3">
                            <div class="flex justify-between items-start">
                                <h3 class="w-33.5 font-cassian-inter text-[14px] truncate">
                                    <?= htmlspecialchars($discussion->getOtherUserPseudo() ?? '') ?>
                                </h3>
                                <p class="font-cassian-inter text-[12px] self-end">
                                    <?= htmlspecialchars($lastMessageDate ?? '') ?>
                                </p>
                            </div>
                            <p class="w-43 font-cassian-inter text-[12px] text-cassian-gray mt-1.75 truncate">
                                <?= htmlspecialchars($lastMessageContent ?? '') ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Discussion messages -->
        <div class="hidden xl:flex flex-col w-83.75 xl:w-208 xl:flex-1 min-h-full xl:pl-11 xl:pt-8.75 xl:pb-24.5 
        bg-cassian-secondary
         xl:bg-cassian-primary">
            <?php if (!isset($discussions) || empty($discussions)): ?>
                <p class="font-cassian-playfair text-4xl">Aucune discussion à afficher</p>
            <?php else: ?>
                <p class="xl:hidden font-cassian-inter text-[14px] text-cassian-gray">retour</p>
                <div class="flex gap-3 items-center flex-none">
                    <img src="
                            <?= $selectedDiscussion->getOtherUserPhoto() ?? '' !== '' ?
                                htmlspecialchars($selectedDiscussion->getOtherUserPhoto()) :
                                './assets/images/anonymous.png'
                            ?>"
                        alt="" class="w-12 h-12 object-cover rounded-full">
                    <p class="font-cassian-inter font-semibold text-[14px]">
                        <?= htmlspecialchars($selectedDiscussion->getOtherUserPseudo() ??  '') ?>
                    </p>
                </div>

                <!-- Messages -->
                <div class="flex flex-col xl:w-191 xl:grow xl:overflow-y-auto xl:pb-24.5">
                    <?php foreach ($messages[$selectedDiscussion->getId()] ?? [] as $message): // Message from current user
                    ?>
                        <?php if ($message->getUserId() === $_SESSION['user']->getId()): ?>
                            <div class="flex flex-col items-end mt-8 xl:mt-6.25">
                                <p class="font-cassian-inter text-[12px] text-cassian-gray">
                                    <?php
                                    $dateString = Utils::displayMessageDateTime($message->getCreationDate());
                                    echo htmlspecialchars($dateString);
                                    ?>
                                </p>
                                <p class="font-cassian-inter text-[12px] bg-cassian-gray-strong px-4.5 py-2.5 mt-2">
                                    <?= htmlspecialchars($message->getContent() ?? '') ?>
                                </p>
                            </div>
                        <?php else: ?>
                            <div class="flex flex-col items-start mt-8 xl:mt-6.25">
                                <div class="flex gap-1.5 items-center">
                                    <img src="
                                    <?= $selectedDiscussion->getOtherUserPhoto() ?? '' !== '' ?
                                        htmlspecialchars($selectedDiscussion->getOtherUserPhoto()) :
                                        './assets/images/anonymous.png'
                                    ?>"
                                        alt="" class="w-6 h-6 object-cover rounded-full">
                                    <p class="font-cassian-inter text-[12px] text-cassian-gray">
                                        <?php
                                        $dateString = Utils::displayMessageDateTime($message->getCreationDate());
                                        echo htmlspecialchars($dateString);
                                        ?>
                                    </p>
                                </div>
                                <p class="font-cassian-inter text-[12px] bg-cassian-white px-4.5 py-2.5 mt-2">
                                    <?= htmlspecialchars($message->getContent() ?? '') ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <!-- new message form -->
                <form action="/send-message"
                    method="POST"
                    class="flex flex-col xl:flex-row self-end xl:gap-5.25 flex-none">
                    <input type="text" id="message" name="message" placeholder="Tapez votre message ici"
                        class="w-83.75 xl:w-157 h-12.25 bg-cassian-white rounded-md border 
                        border-cassian-border-form font-cassian-inter text-[14px] px-5.5 xl:px-10.5 ml-1.5 
                        focus:outline-cassian-green">
                    <?php
                    /**
                     * Call to generate an hidden field with CSRF token
                     */
                    echo Ml\App\Services\Web::generateCsrfToken();
                    ?>
                    <input hidden name="to" value="<?= htmlspecialchars($selectedDiscussion->getOtherUserId()) ?>">
                    <button class="w-83.75 xl:w-33 h-12.25 font-cassian-inter bg-cassian-green 
                        text-cassian-white font-semibold text-center rounded-[10px] px-9.5 py-4 transition-colors 
                        duration-300 ease-in-out hover:bg-cassian-green-strong">
                        Envoyer
                    </button>
                </form>
        </div>
    <?php endif; ?>
    </div>
    </div>
</section>