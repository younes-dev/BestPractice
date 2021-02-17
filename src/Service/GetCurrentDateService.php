<?php

namespace App\Service;

class GetCurrentDateService
{
    public static function getCurrentDate(): string
    {
        $time = new \DateTime();

        return date_format($time, ' l jS F Y');
        //################################################
//        $time = new \DateTime();
//        $timestamp = $time->getTimestamp();
//        return  strftime('%A %d %B %Y',$timestamp);
    }

    public function __toString(): string
    {
        return self::getCurrentDate();
    }
}
