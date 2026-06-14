<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;

/**
 * Class to handle message objects
 */
class Message extends AbstractClass
{
    private int $userId;
    private ?int $discussionId = null;
    private string $content;
    private bool $isRead;
    private string $userPhoto;

    /**
     * Message class constructor.
     * 
     * @param int $userId User ID of use sending the message.
     * @param string $content Text content of the message.
     * @param bool $isRead false if not read, true if it is read. 
     */
    public function __construct(
        int $userId,
        string $content,
        bool $isRead = false,
        ?int $id = null,
        ?DateTime $creationDate = null,
        ?int $discussionId = null,
        ?string $userPhoto = ''
    ) {
        $this->userId = $userId;
        $this->discussionId = $discussionId;
        $this->content = $content;
        $this->isRead = $isRead;
        $this->userPhoto = $userPhoto;
        return parent::__construct($id, $creationDate);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDiscussionId(): ?int
    {
        return $this->discussionId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatus(): bool
    {
        return $this->isRead;
    }

    public function getUserPhoto(): string
    {
        return $this->userPhoto;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setDiscussionId(int $discussionId): void
    {
        $this->discussionId = $discussionId;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setStatus(bool $isRead): void
    {
        $this->isRead = $isRead;
    }

    public function setUserPhoto(string $userPhoto): void
    {
        $this->userPhoto = $userPhoto;
    }
}
