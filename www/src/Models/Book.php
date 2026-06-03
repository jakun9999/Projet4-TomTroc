<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;

/**
 * Model representing a book in the TomTroc application.
 */
class Book extends AbstractClass
{
    private string $title;
    private string $author;
    private string $authorPseudo;
    private string $description;
    private int $status;
    private int $userId;
    private string $imageUrl;

    /**
     * Construct a new Book instance.
     * 
     * With optionnal parameters for id and creationDate, which are handled by the parent class.
     * The imageUrl parameter is also optionnal, as it can be set later by the user.
     * 
     * @param string $title
     * @param string $author
     * @param string $authorPseudo
     * @param string $description
     * @param int $status
     * @param int $userId
     * @param ?string $imageUrl
     * @param ?int $id
     * @param ?DateTime $creationDate
     */
    public function __construct(

        string $title,
        string $author,
        string $authorPseudo,
        string $description,
        int $status,
        int $userId,
        ?string $imageUrl = '',
        ?int $id = null,
        ?DateTime $creationDate = null

    ) {
        parent::__construct($id, $creationDate);
        $this->title = $title;
        $this->author = $author;
        $this->authorPseudo = $authorPseudo;
        $this->description = $description;
        $this->status = $status;
        $this->userId = $userId;
        $this->imageUrl = $imageUrl;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getAuthorPseudo(): string
    {
        return $this->authorPseudo;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setAuthorPseudo(string $authorPseudo): void
    {
        $this->authorPseudo = $authorPseudo;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}
