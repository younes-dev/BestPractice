<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseEntity.
 * @ORM\MappedSuperclass()
 */
class BaseEntity
{
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime",nullable=true)
     */
    private DateTime $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return BaseEntity
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return BaseEntity
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist()
     */
    public function updateTimestamps(): void
    {
        $now = new DateTime();
        $this->setUpdatedAt($now);
        if (null == $this->getCreatedAt()) {
            $this->setCreatedAt($now);
        }
    }
}
