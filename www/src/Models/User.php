<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;

/**
 * Class User represents a user of the application. 
 * It extends the AbstractClass, which provides common 
 * properties and methods for all models.
 */
class User extends AbstractClass
{
    private string $pseudo;
    private string $email;
    private string $password;
    private string $photo;

    /**
     * Construct a new User instance.
     * 
     * With optionnal parameters for id and creationDate, which are handled by the parent class.
     * The photo parameter is also optionnal, as it can be set later by the user.
     * 
     * @param string $pseudo
     * @param string $email
     * @param string $password
     * @param ?string $photo Optional photo of the user, can be set later.
     * @param ?int $id Optional id of the user, managed by mysql with user is newly created.
     * @param ?DateTime $creationDate Optional creation date of the user, managed by mysql
     */
    public function __construct(
        string $pseudo,
        string $email,
        string $password,
        string $photo = '',
        ?int $id = null,
        ?DateTime $creationDate = null
    ) {
        parent::__construct($id, $creationDate);
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo;
    }

    /**
     * Get the pseudo of the user.
     *
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * Set the pseudo of the user.
     *
     * @param string $pseudo
     * @return void
     */
    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * Get the email of the user.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the email of the user.
     *
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get the password of the user.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the password of the user.
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Get the photo of the user.
     *
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * Set the photo of the user.
     *
     * @param string $photo
     * @return void
     */
    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }
}
