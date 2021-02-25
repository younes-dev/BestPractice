<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;

interface ServiceInterface
{
    /**
     * @return mixed
     */
    public function getAll();
}
