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

?>
<section class="grow flex flex-col items-center w-full h-auto bg-cassian-secondary xl:bg-cassian-primary max-w-94.25 xl:max-w-cassian-1440 mx-auto">
    <div class="flex flex-1 xl:w-285 min-h-full">
        <!-- Discussion list -->
        <div class="flex flex-col w-83.75 xl:w-77 min-h-full bg-cassian-secondary">
            <h1 class="xl:ml-8.5 mt-13.75 font-cassian-playfair text-[26px]">Messagerie</h1>
            <div class="flex flex-col">
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

                    $lastMessageKey = array_key_last($discussion->getMessages());
                    $message = $discussion->getMessages()[$lastMessageKey];
                    $lastMessageContent = $message->getContent();
                    $lastMessageDate = Ml\App\Services\Utils::displayDiscussionDate($message->getCreationDate());

                    ?>
                    <div class="flex pl-8.5 pt-4.5 pr-10.5 pb-4.5">
                        <img src="<?= $otherUserPhoto !== '' ?
                                        htmlspecialchars($otherUserPhoto) :
                                        './assets/images/anonymous.png' ?>"
                            alt=""
                            class="w-12 h-12 rounded-full">
                        <div>
                            <div>
                                <h3 class="font-cassian-inter text-[14px]">
                                    <?= htmlspecialchars($otherUserPseudo ?? '') ?>
                                </h3>
                                <p class="font-cassian-inter text-[12px]">
                                    <?= htmlspecialchars($lastMessageDate ?? '') ?>
                                </p>
                            </div>
                            <p><?= htmlspecialchars($lastMessageContent ?? '') ?></p>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Discussion messages -->
        <div class="hidden xl:flex w-83.75 xl:flex-1 min-h-full bg-cassian-secondary xl:bg-cassian-primary">

        </div>
    </div>
</section>