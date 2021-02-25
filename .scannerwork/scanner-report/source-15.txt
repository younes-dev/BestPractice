<?php

namespace App\Service;

use DateTime;

class GetCurrentDateService
{
    public static function getCurrentDate(): string
    {
        $time = new DateTime();
        return date_format($time, ' l jS F Y');
    }

    public function __toString(): string
    {
        return self::getCurrentDate();
    }
}
