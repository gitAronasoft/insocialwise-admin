<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DateHelper
{
    public static function getAdminTimezone(): string
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user()->timezone ?? 'UTC';
        }
        return 'UTC';
    }

    public static function format($date, string $format = 'M d, Y g:i A'): string
    {
        if (empty($date)) {
            return 'N/A';
        }

        $timezone = self::getAdminTimezone();
        
        if ($date instanceof Carbon) {
            return $date->setTimezone($timezone)->format($format);
        }

        return Carbon::parse($date)->setTimezone($timezone)->format($format);
    }

    public static function formatDate($date, string $format = 'M d, Y'): string
    {
        return self::format($date, $format);
    }

    public static function formatDateTime($date, string $format = 'M d, Y g:i A'): string
    {
        return self::format($date, $format);
    }

    public static function formatTime($date, string $format = 'g:i A'): string
    {
        return self::format($date, $format);
    }

    public static function formatDateTimeSeconds($date, string $format = 'M d, Y g:i:s A'): string
    {
        return self::format($date, $format);
    }

    public static function diffForHumans($date): string
    {
        if (empty($date)) {
            return 'N/A';
        }

        $timezone = self::getAdminTimezone();

        if ($date instanceof Carbon) {
            return $date->setTimezone($timezone)->diffForHumans();
        }

        return Carbon::parse($date)->setTimezone($timezone)->diffForHumans();
    }

    public static function isToday($date): bool
    {
        if (empty($date)) {
            return false;
        }

        $timezone = self::getAdminTimezone();

        if ($date instanceof Carbon) {
            return $date->setTimezone($timezone)->isToday();
        }

        return Carbon::parse($date)->setTimezone($timezone)->isToday();
    }

    public static function isYesterday($date): bool
    {
        if (empty($date)) {
            return false;
        }

        $timezone = self::getAdminTimezone();

        if ($date instanceof Carbon) {
            return $date->setTimezone($timezone)->isYesterday();
        }

        return Carbon::parse($date)->setTimezone($timezone)->isYesterday();
    }

    public static function getTimezoneList(): array
    {
        $timezones = timezone_identifiers_list();
        $result = [];

        foreach ($timezones as $timezone) {
            $offset = (new \DateTimeZone($timezone))->getOffset(new \DateTime('now', new \DateTimeZone('UTC')));
            $hours = intdiv($offset, 3600);
            $minutes = abs($offset % 3600 / 60);
            $sign = $hours >= 0 ? '+' : '-';
            $offsetString = sprintf('UTC%s%02d:%02d', $sign, abs($hours), $minutes);
            $result[$timezone] = "($offsetString) $timezone";
        }

        asort($result);
        return $result;
    }

    public static function getCommonTimezones(): array
    {
        return [
            'UTC' => '(UTC+00:00) UTC',
            'America/New_York' => '(UTC-05:00) Eastern Time (US & Canada)',
            'America/Chicago' => '(UTC-06:00) Central Time (US & Canada)',
            'America/Denver' => '(UTC-07:00) Mountain Time (US & Canada)',
            'America/Los_Angeles' => '(UTC-08:00) Pacific Time (US & Canada)',
            'America/Anchorage' => '(UTC-09:00) Alaska',
            'Pacific/Honolulu' => '(UTC-10:00) Hawaii',
            'Europe/London' => '(UTC+00:00) London, Edinburgh',
            'Europe/Paris' => '(UTC+01:00) Paris, Berlin, Rome, Madrid',
            'Europe/Moscow' => '(UTC+03:00) Moscow, St. Petersburg',
            'Asia/Dubai' => '(UTC+04:00) Dubai, Abu Dhabi',
            'Asia/Kolkata' => '(UTC+05:30) Mumbai, Chennai, Kolkata',
            'Asia/Dhaka' => '(UTC+06:00) Dhaka',
            'Asia/Bangkok' => '(UTC+07:00) Bangkok, Hanoi, Jakarta',
            'Asia/Shanghai' => '(UTC+08:00) Beijing, Shanghai, Hong Kong',
            'Asia/Singapore' => '(UTC+08:00) Singapore, Kuala Lumpur',
            'Asia/Tokyo' => '(UTC+09:00) Tokyo, Seoul',
            'Australia/Sydney' => '(UTC+11:00) Sydney, Melbourne',
            'Pacific/Auckland' => '(UTC+13:00) Auckland, Wellington',
        ];
    }
}
