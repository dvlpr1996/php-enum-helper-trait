<?php

/**
 * @Package: php-enum-helper-trait
 * @trait  : EnumHelperTrait
 * @Author : Nima jahan bakhshian / dvlpr1996 <nimajahanbakhshian@gmail.com>
 * @link   : https://github.com/dvlpr1996
 * @License: MIT License Copyright (c) 2024 (until present) Nima jahan bakhshian
 */

declare(strict_types=1);

namespace PhpEnumHelperTrait;

/**
 * Provides utility methods for handling enums in PHP.
 *
 * @method static array getAll() Generates a list of cases on an enum, a wrapper for cases().
 * @method static array asArray() return enum as associative array.
 * @method static bool isPureEnum() check whether the enum is a Pure Enum.
 * @method static bool isBackedEnum() check whether the enum is a Backed Enum.
 * @method static bool isEmpty() check whether the enum is empty.
 * @method static object randomCase() return random enum cases.
 * @method static array values() return all enum values.
 * @method static array names() return all enum names.
 * @method static string randomValue() return random enum value.
 * @method static string randomName() return random enum name.
 * @method static array flip() flip enum name and value.
 * @method static bool isValueExists(int|string $value, bool $strict = true) checks if a value exists in an enum.
 * @method static bool isNameExists(string $name, bool $strict = true) checks if a name exists in an enum.
 * @method static string|null getNameFromValue(int|string $value) get the enum name with enum value.
 * @method static string toJson() convert enum to json.
 */
trait EnumHelperTrait
{
    /**
     * Generates A List Of Cases On An Enum
     * @return array
     */
    public static function getAll(): array
    {
        return self::cases();
    }

    /**
     * Return Enum As Associative Array
     * @return array
     */
    public static function asArray(): array
    {
        $cases = self::cases();

        if (self::isBackedEnum()) {
            return array_column($cases, 'value', 'name');
        }

        return array_map(function ($object) {
            return $object->name;
        }, $cases);
    }

    /**
     * Check Whether The Enum Is A Pure Enum
     * @return boolean
     */
    public static function isPureEnum(): bool
    {
        return !self::isBackedEnum();
    }

    /**
     * Check Whether The Enum Is A Backed Enum
     * @return boolean
     */
    public static function isBackedEnum(): bool
    {
        return method_exists(self::class, 'tryFrom');
    }

    /**
     * Check Whether The Enum Is Empty
     * @return boolean
     */
    public static function isEmpty(): bool
    {
        return empty(self::cases());
    }

    /**
     * Return Random Enum Cases
     * @return object
     */
    public static function randomCase(): object
    {
        $cases = self::cases();

        if (empty($cases)) {
            return (object)[];
        }

        return $cases[array_rand($cases)];
    }

    /**
     * Return All Enum Values
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Return All Enum Names
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Return Random Enum Value
     * @return string
     */
    public static function randomValue(): string
    {
        $values = self::values();
        return empty($values) ? '' : $values[array_rand($values)];
    }

     /**
     * Return Random Enum Name
     * @return string
     */
    public static function randomName(): string
    {
        $names = self::names();
        return empty($names) ? '' : $names[array_rand($names)];
    }

    /**
     * Flip Enum Name And Value
     * @return array
     */
    public static function flip(): array
    {
        return array_flip(self::asArray());
    }

    /**
     * Checks If A Value Exists In An Enum
     * @param integer|string $value enum value to check
     * @param boolean $strict check the types of the value
     * @return boolean
     */
    public static function isValueExists(int|string $value, bool $strict = true): bool
    {
        return in_array($value, array_column(self::cases(), 'value'), $strict);
    }

    /**
     * Checks If A Name Exists In An Enum
     * @param integer|string $name enum name to check
     * @param boolean $strict check the types of the name
     * @return boolean
     */
    public static function isNameExists(string $name, bool $strict = true): bool
    {
        return in_array($name, array_column(self::cases(), 'name'), $strict);
    }

    /**
     * Get The Enum Name With Enum Value
     * @param integer|string $value enum value
     * @return string|null if value not exists return null, otherwise return enum name
     */
    public static function getNameFromValue(int|string $value): ?string
    {
        if (!self::isValueExists($value)) {
            return null;
        }

        $values = self::flip();
        return $values[$value];
    }

    /**
     * Convert Enum To Json
     * @return string JSON Representation Of The Enum
     */
    public static function toJson(): string
    {
        $data = self::asArray();

        if (empty($data) && !is_array($data)) {
            return "";
        }

        $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

        if (!is_array(json_decode($jsonData, true)) && json_last_error() !== JSON_ERROR_NONE) {
            return "";
        }

        return $jsonData;
    }
}
