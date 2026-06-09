<?php

/**
 * Template for the messaging page to display
 * the messaging interface.
 */

/** @var array $params */
if (!isset($_SESSION['user'])) {
    header('location: /login');
}

if (isset($params['discussions'])) {
    $discussions = $params['discussions'];
}

$userPseudo = $_SESSION['user']->getPseudo();
$userId = $_SESSION['user']->getId();
$selectedDiscussion = $params['selected_discussion'] ?? null;
$selectedDiscussionMessages = $params['selected_discussion_message'] ?? [];
$discussionCount = 0; // used to display first discussion as selected.

// discussion details to be displayed in main DIV if no discussion was
// previously selected.
if (is_null($selectedDiscussion) && !empty($discussions)) {
    $selectedDiscussion = $discussions[0];
}

?>
<section class="grow flex flex-col items-center w-full h-auto bg-cassian-secondary xl:bg-cassian-primary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-1 xl:w-285 min-h-full">
        <!-- Discussion list -->
        <div class="flex flex-col w-83.75 xl:w-77 min-h-full bg-cassian-secondary">
            <h1 class="xl:ml-8.5 mt-13.75 font-cassian-playfair text-[26px]">Messagerie</h1>
            <div class="flex flex-col mt-6.75">
                <?php foreach ($discussions as $discussion): ?>
                    <?php
                    // For each discussion we load the user with whom
                    // current use has exchanged, his/her photo url,
                    // last message content and date.
                    if ($discussion->getUser1Pseudo() === $userPseudo) {
                        $otherUserPseudo = $discussion->getUser2Pseudo();
                        $otherUserPhoto = $discussion->getUser2Photo();
                    } else {
                        $otherUserPseudo = $discussion->getUser1Pseudo();
                        $otherUserPhoto = $discussion->getUser1Photo();
                    }

                    if (!empty($selectedDiscussionMessages)) {
                        $lastMessageKey = array_key_last($selectedDiscussionMessages);
                        $message = $selectedDiscussionMessages[$lastMessageKey];
                        $lastMessageContent = $message->getContent();
                        $lastMessageDate = Ml\App\Services\Utils::displayDiscussionDate($message->getCreationDate());
                    }

                    ?>
                    <a href="/show-discussion?id=<?= $discussion->getId() ?? 'new' ?>"
                        class="flex pl-8.5 pt-4.5 pr-10.5 pb-4.5 
                        <?php
                        if ($discussionCount === 0 && is_null($selectedDiscussion)) {
                            echo 'bg-cassian-white';
                            $discussionCount++;
                        }
                        ?>
                        ">
                        <img src="<?= $otherUserPhoto !== '' ?
                                        htmlspecialchars($otherUserPhoto) :
                                        './assets/images/anonymous.png' ?>"
                            alt="Photo de profil de <?= htmlspecialchars($otherUserPseudo ?? '') ?>"
                            class="w-12 h-12 rounded-full">
                        <div class="flex flex-col ml-3">
                            <div class="flex justify-between items-start">
                                <h3 class="w-33.5 font-cassian-inter text-[14px] truncate">
                                    <?= htmlspecialchars($otherUserPseudo ?? '') ?>
                                </h3>
                                <p class="font-cassian-inter text-[12px] self-end">
                                    <?= htmlspecialchars($lastMessageDate ?? '') ?>
                                </p>
                            </div>
                            <p class="w-43 font-cassian-inter text-[12px] text-cassian-gray truncate">
                                <?= htmlspecialchars($lastMessageContent ?? '') ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Discussion messages -->
        <div class="hidden xl:flex flex-col w-83.75 xl:flex-1 min-h-full bg-cassian-secondary
         xl:bg-cassian-primary">
            <?php if (!isset($discussions) || empty($discussions)): ?>
                <p class="font-cassian-playfair text-4xl">Aucune discussion à afficher</p>
            <?php else: ?>
                <?php
                // For each discussion we load the user with whom
                // current use has exchanged, his/her photo url,
                // last message content and date.
                if ($selectedDiscussion->getUser1Pseudo() === $userPseudo) {
                    $otherUserPseudo = $selectedDiscussion->getUser2Pseudo();
                    $otherUserPhoto = $selectedDiscussion->getUser2Photo();
                    $otherUserId = $selectedDiscussion->getUser2Id();
                } else {
                    $otherUserPseudo = $selectedDiscussion->getUser1Pseudo();
                    $otherUserPhoto = $selectedDiscussion->getUser1Photo();
                    $otherUserId = $selectedDiscussion->getUser1Id();
                }
                ?>
                <p class="xl:hidden font-cassian-inter text-[14px] text-cassian-gray">retour</p>
                <div class="flex gap-3 xl:ml-11 mt-2.75 xl:mt-8.75 items-center">
                    <img src="
                            <?= $otherUserPhoto ?? '' !== '' ?
                                htmlspecialchars($otherUserPhoto) :
                                './assets/images/anynymous.png'
                            ?>"
                        alt="" class="w-12 h-12 object-cover">
                    <p class="font-cassian-inter font-semibold text-[14px]">
                        <?= htmlspecialchars($otherUserPseudo ??  '') ?>
                    </p>
                </div>
                <div class="self-end">
                    <!-- Messages -->
                    <div class="flex flex-row xl:w-191">
                        <?php foreach ($selectedDiscussionMessages as $message): ?>
                            <?php if ($message->getUserId() === $userId): ?>
                                <div class="flex flex-col items-end mt-8 xl:mt-6.25">
                                    <p class="font-cassian-inter text-[12px]">
                                        <?php
                                        $dateString = Ml\App\Services\Utils::displayMessageDateTime(
                                            $message->getCreationDate()
                                        );
                                        echo htmlspecialchars($dateString);
                                        ?>
                                    </p>
                                    <p class="font-cassian-inter text-[12px] bg-cassian-gray-strong px-4.5 py-2.5">
                                        <?= htmlspecialchars($message->getContent() ?? '') ?>
                                    </p>
                                </div>
                            <?php else: ?>
                                <div class="flex flex-col items-start mt-8 xl:mt-6.25">
                                    <div class="flex gap-1.5">
                                        <img src="
                                    <?= $otherUserPhoto ?? '' !== '' ?
                                        htmlspecialchars($otherUserPhoto) :
                                        './assets/images/anynymous.png'
                                    ?>"
                                            alt="" class="w-6 h-6 object-cover">
                                        <p class="font-cassian-inter text-[12px]">
                                            <?php
                                            $dateString = Ml\App\Services\Utils::displayMessageDateTime(
                                                $message->getCreationDate()
                                            );
                                            echo htmlspecialchars($dateString);
                                            ?>
                                        </p>
                                    </div>
                                    <p class="font-cassian-inter text-[12px] bg-cassian-white px-4.5 py-2.5">
                                        <?= htmlspecialchars($message->getContent() ?? '') ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- new message form -->
                    <form action="/send-message?to=<?= htmlspecialchars($otherUserId) ?>"
                        method="GET"
                        class="flex flex-col xl:flex-row self-end xl:gap-5.25">
                        <input type="text" id="message" name="message" placeholder="Tapez votre message ici"
                            class="w-83.75 xl:w-157 h-12.25 bg-cassian-white rounded-md border border-cassian-border-form
                            font-cassian-inter text-[14px] px-5.5 xl:px-10.5 ">
                        <?php
                        /**
                         * Call to generate an hidden field with CSRF token
                         */
                        echo Ml\App\Services\Web::generateCsrfToken();
                        ?>
                        <button class="w-83.75 xl:w-33 h-12.25 font-cassian-inter bg-cassian-green 
                        text-cassian-white font-semibold text-base rounded-[10px] px-9.5 py-4 transition-colors 
                        duration-300 ease-in-out hover:bg-cassian-green-strong">
                            Envoyer
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>