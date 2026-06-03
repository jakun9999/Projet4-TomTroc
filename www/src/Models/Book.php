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
    private string $authorFirstName;
    private string $authorLastName;
    private string $authorPseudo;
    private string $description;
    private bool $status;
    private int $userId;
    private string $imageUrl;

    /**
     * Construct a new Book instance.
     * 
     * With optionnal parameters for id and creationDate, which are handled by the parent class.
     * The imageUrl parameter is also optionnal, as it can be set later by the user.
     * 
     * @param string $title
     * @param string $authorFirstName
     * @param string $authorLastName
     * @param string $authorPseudo
     * @param string $description
     * @param ?string $imageUrl
     * @param ?int $id
     * @param ?DateTime $creationDate
     */
    public function __construct(

        string $title,
        string $authorFirstName,
        string $authorLastName,
        string $authorPseudo,
        string $description,
        ?string $imageUrl = '',
        ?int $id = null,
        ?DateTime $creationDate = null

    ) {
        parent::__construct($id, $creationDate);
        $this->title = $title;
        $this->authorFirstName = $authorFirstName;
        $this->authorLastName = $authorLastName;
        $this->authorPseudo = $authorPseudo;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthorFirstName(): string
    {
        return $this->authorFirstName;
    }

    public function getAuthorLastName(): string
    {
        return $this->authorLastName;
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

    public function getStatus(): bool
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

    public function setAuthorFirstName(string $authorFirstName): void
    {
        $this->authorFirstName = $authorFirstName;
    }

    public function setAuthorLastName(string $authorLastName): void
    {
        $this->authorLastName = $authorLastName;
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

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}
