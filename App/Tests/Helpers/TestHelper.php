<?php

declare(strict_types=1);

namespace App\Tests\Helpers;

final class TestHelper
{
    /**
     * @const int
     */
    private const DEFAULT_STRING_LENGTH = 5;

    /**
     * @const int
     */
    private const DEFAULT_MAX_INTEGER_VALUE = 9999;

    /**
     * @const int
     */
    private const DEFAULT_ARRAY_LENGTH = 5;

    /**
     * Return a random string of the indicated length.
     *
     * @param int $length
     *
     * @return string
     */
    public static function getRandomString(int $length = self::DEFAULT_STRING_LENGTH) : string
    {
        $lower_case_characters = 'abcdefghijklmnopqrstuvwxyz';
        $upper_case_characters = strtoupper($lower_case_characters);
        $numbers = '0123456789';
        $special_characters = '!@#$%^&*()';

        $all_characters = $lower_case_characters .
            $upper_case_characters .
            $numbers .
            $special_characters;

        return substr(str_shuffle($all_characters), 0, $length);
    }

    /**
     * Return a random integer.
     *
     * @param int $max_value
     *
     * @return int
     */
    public static function getRandomInteger(
        int $max_value = self::DEFAULT_MAX_INTEGER_VALUE
    ) : int
    {
        return rand(0, $max_value);
    }

    /**
     * Return a random array.
     *
     * @return array
     */
    public static function getRandomStringArray(
        int $length = SELF::DEFAULT_ARRAY_LENGTH,
    ) : array
    {
        $array = [];

        for ($i = 0; $i < $length; $i++) {
            $array[] = self::getRandomString();
        }

        return $array;
    }
}