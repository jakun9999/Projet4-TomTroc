<?php

declare(strict_types=1);

namespace Ml\App\Services;

use DateTime;
use DateTimeZone;

/**
 * Utils class with DateTime management
 */
class Utils
{

    /**
     * Generate a string with "Aujourd'hui" + hour (HH:MM)
     * or Date (DD.MM) + hour (HH:MM).
     * 
     * @param DateTime $dateTime DateTime to be converted for message time.
     * 
     * @return string A formated string more convenient for message and 
     * discussion date and time display.
     */
    public static function displayMessageDateTime(DateTime $dateTime): string
    {
        $today = new DateTime('now');

        if ($dateTime->format('Y-m-d') === $today('Y-m-d')) {
            return "Aujourd'hui " . $dateTime->format('H:i');
        } else {
            return $dateTime->format('d.m H:i');
        }
    }

    /**
     * Generate a string with last message hour if last message is from today
     * or the date (d.m) if last message is older.
     * 
     * @param DateTime $dateTime DateTime to be converted to a string.
     * 
     * @return string Formated string
     */
    public static function displayDiscussionDate(DateTime $dateTime): string
    {
        $today = new DateTime('now');

        if ($dateTime->format('Y-m-d') === $today->format('Y-m-d')) {
            return $dateTime->format('H:i');
        } else {
            return $dateTime->format('d.m');
        }
    }

    /**
     * Generate a string with the age based on the
     * difference between a DateTime and today.
     * 
     * Used for account information summary in account
     * management page and account public display page.
     * 
     * @param DateTime $dateTime DateTime to be compared with
     * today's DateTime.
     * 
     * @return ?string Returns a formated string with age and 
     * day, month or year suffix.
     */
    public static function age(DateTime $dateTime): ?string
    {
        // MySQL is storing datetime based on UTC
        // We do the calculation based on that.

        $dateClone = clone $dateTime;

        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $today = new DateTime('now', new DateTimeZone('UTC'));

        // In case of error with time zone
        // we return a standard text
        if ($dateClone > $today) {
            return 'quelques secondes';
        }

        // Now calculating time difference.
        $difference = $today->diff($dateTime);

        if ($difference->y > 1) {
            return (string)$difference->y . ' ans';
        }
        if ($difference->y === 1) {
            return '1 an';
        }

        if ($difference->m > 0) {
            return (string)$difference->m . ' mois';
        }

        if ($difference->d > 0) {
            return (string)$difference->d . ' jours';
        }

        if ($difference->h > 0) {
            return (string)$difference->h . ' heures';
        }

        if ($difference->i > 0) {
            return (string)$difference->i . ' minutes';
        }

        // Return a default string if comparison failed to 
        // match above criterias.
        return 'quelques secondes';
    }
}
