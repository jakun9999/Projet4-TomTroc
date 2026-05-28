<?php

declare(strict_types=1);

namespace Ml\App\Models;

use DateTime;

/**
 * Abstract class for all models. Should not be instantiated directly.
 * 
 * Make $id and $creationDate properties protected, so they can be used 
 * in all models that extend this class.
 */
class AbstractClass
{

    protected int $id;
    protected DateTime $creationDate;

    /**
     * Construct a new instance of the class.
     *
     * @param int|null $id
     * @param DateTime|null $creationDate
     */
    protected function __construct(?int $id = null, ?DateTime $creationDate = null)
    {
        $this->id = $id;
        $this->creationDate = $creationDate;
    }

    /**
     * Get the value of id
     * 
     * @return int $id Id of the model
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     * @return void 
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of creationDate
     * 
     * @return DateTime $creationDate Creation date of the model
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @param DateTime $creationDate
     * @return void 
     */
    public function setCreationDate(DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }
}
