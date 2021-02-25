<?php

namespace App\Service;

use DateTime;

class GetCurrentDateService
{
    public static function getCurrentDate(): string
    {
        $date = new DateTime();
        return date_format($date, ' l jS F Y');
    }

    public function __toString(): string
    {
        return self::getCurrentDate();
    }
}
