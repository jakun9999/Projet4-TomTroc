<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;

/**
 * Class to handle discussion objects
 */
class Discussion extends AbstractClass
{
    private int $currentUserId;
    private int $otherUserId;
    private string $currentUserPseudo;
    private string $otherUserPseudo;
    private string $currentUserPhoto;
    private string $otherUserPhoto;

    /**
     * Discussion class constructor.
     * 
     * @param int $currentUserId user id of the logged in user who's loading 
     * discussions.
     * @param int $otherUserId user id of people with whom current user has
     * discussions.
     * @param string $currentUserPseudo 
     * @param string $otherUserPseudo
     * @param string $currentUserPhoto
     * @param string $otherUserPhoto
     */
    public function __construct(
        int $currentUserId,
        int $otherUserId,
        string $currentUserPseudo = '',
        string $otherUserPseudo = '',
        string $currentUserPhoto = '',
        string $otherUserPhoto = '',
        ?int $id = null,
        ?DateTime $creationDate = null,
    ) {
        $this->currentUserId = $currentUserId;
        $this->otherUserId = $otherUserId;
        $this->currentUserPseudo = $currentUserPseudo;
        $this->otherUserPseudo = $otherUserPseudo;
        $this->currentUserPhoto = $currentUserPhoto;
        $this->otherUserPhoto = $otherUserPhoto;
        return parent::__construct($id, $creationDate);
    }

    public function getCurrentUserId(): int
    {
        return $this->currentUserId;
    }

    public function getOtherUserId(): int
    {
        return $this->otherUserId;
    }

    public function getCurrentUserPseudo(): string
    {
        return $this->currentUserPseudo;
    }

    public function getOtherUserPseudo(): string
    {
        return $this->otherUserPseudo;
    }

    public function getCurrentUserPhoto(): string
    {
        return $this->currentUserPhoto;
    }

    public function getOtherUserPhoto(): string
    {
        return $this->otherUserPhoto;
    }

    public function setCurrentUserId(int $userId): void
    {
        $this->currentUserId = $userId;
    }

    public function setOtherUserId(int $userId): void
    {
        $this->otherUserId = $userId;
    }

    public function setCurrentUserPseudo(string $userPseudo): void
    {
        $this->currentUserPseudo = $userPseudo;
    }

    public function setOtherUserPseudo(string $userPseudo): void
    {
        $this->otherUserPseudo = $userPseudo;
    }

    public function setCurrentUserPhoto(string $userPhoto): void
    {
        $this->currentUserPhoto = $userPhoto;
    }

    public function setOtherUserPhoto(string $userPhoto): void
    {
        $this->otherUserPhoto = $userPhoto;
    }
}
