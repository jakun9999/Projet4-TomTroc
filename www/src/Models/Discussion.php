<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;
use Override;

/**
 * Class to handle discussion objects
 */
class Discussion extends AbstractClass
{
    private int $user1Id;
    private int $user2Id;
    private string $user1Pseudo;
    private string $user2Pseudo;
    private string $user1Photo;
    private string $user2Photo;
    private array $messages;

    public function __construct(
        int $user1Id,
        int $user2Id,
        ?string $user1Pseudo = '',
        ?string $user2Pseudo = '',
        ?string $user1Photo = '',
        ?string $user2Photo = '',
        ?int $id = null,
        ?DateTime $creationDate = null,
    ) {
        $this->user1Id = $user1Id;
        $this->user2Id = $user2Id;
        $this->user1Pseudo = $user1Pseudo;
        $this->user2Pseudo = $user2Pseudo;
        $this->user1Photo = $user1Photo;
        $this->user2Photo = $user2Photo;
        return parent::__construct($id, $creationDate);
    }

    public function getUser1Id(): int
    {
        return $this->user1Id;
    }

    public function getUser2Id(): int
    {
        return $this->user2Id;
    }

    public function getUser1Pseudo(): string
    {
        return $this->user1Pseudo;
    }

    public function getUser2Pseudo(): string
    {
        return $this->user2Pseudo;
    }

    public function getUser1Photo(): string
    {
        return $this->user1Photo;
    }

    public function getUser2Photo(): string
    {
        return $this->user2Photo;
    }

    public function setUser1Id(int $userId): void
    {
        $this->user1Id = $userId;
    }

    public function setUser2Id(int $userId): void
    {
        $this->user2Id = $userId;
    }

    public function setUser1Pseudo(string $userPseudo): void
    {
        $this->user1Pseudo = $userPseudo;
    }

    public function setUser2Pseudo(string $userPseudo): void
    {
        $this->user2Pseudo = $userPseudo;
    }

    public function setUser1Photo(string $userPhoto): void
    {
        $this->user1Photo = $userPhoto;
    }

    public function setUser2Photo(string $userPhoto): void
    {
        $this->user2Photo = $userPhoto;
    }
}
