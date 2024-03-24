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

use Exception;
use SimpleXMLElement;

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
 * @method static string toJson(int $flags = 0, int $depth = 512) convert enum to json.
 * @method static string|null toXml() Convert Enum Data To Xml.
 * @method static array info() Return Some Information About Enum.
 * @method static array filterValuesByPrefix(int|string $prefix) Filter Backed Enum Value By Prefix.
 * @method static array filterNamesByPrefix(string $prefix) Filter Backed Enum Name By Prefix.
 * @method static array filterValues(callable $callableFilterFunction) Filter enum values using a custom callable filter function.
 * @method static array filterNames(callable $callableFilterFunction) Filter Enum Names Using A Custom Callable Filter Function.
 * @method static array filterValuesBySuffix(int|string $suffix) Filter Backed Enum Values By Suffix.
 * @method static array filterNamesBySuffix(string $suffix) Filter Backed Enum Name By Suffix.
 * @method static bool isValueIn(array|string|int $needle) Checks Whether The Needle Is In The Values.
 * @method static bool isNotValueIn(array|string|int $needle) Checks Whether The Needle Is Not In The Values.
 * @method static bool isNameIn(array|string $needle) Checks Whether The Needle Is In The Names.
 * @method static bool isNotNameIn(array|string $needle) Checks Whether The Needle Is Not In The Names.
 */
trait EnumHelperTrait
{
    /**
     * Generates A List Of Cases On An Enum
     *
     * @return array
     */
    public static function getAll(): array
    {
        return self::cases();
    }

    /**
     * Return Enum As Associative Array
     *
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
     *
     * @return boolean
     */
    public static function isPureEnum(): bool
    {
        return !self::isBackedEnum();
    }

    /**
     * Check Whether The Enum Is A Backed Enum
     *
     * @return boolean
     */
    public static function isBackedEnum(): bool
    {
        return method_exists(self::class, 'tryFrom');
    }

    /**
     * Check Whether The Enum Is Empty
     *
     * @return boolean
     */
    public static function isEmpty(): bool
    {
        return empty(self::cases());
    }

    /**
     * Return Random Enum Cases
     *
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
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Return All Enum Names
     *
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Return Random Enum Value
     *
     * @return string
     */
    public static function randomValue(): string
    {
        $values = self::values();
        return empty($values) ? '' : $values[array_rand($values)];
    }

    /**
     * Return Random Enum Name
     *
     * @return string
     */
    public static function randomName(): string
    {
        $names = self::names();
        return empty($names) ? '' : $names[array_rand($names)];
    }

    /**
     * Flip Enum Name And Value
     *
     * @return array
     */
    public static function flip(): array
    {
        return array_flip(self::asArray());
    }

    /**
     * Checks If A Value Exists In An Enum
     *
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
     *
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
     *
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
     *
     * @param integer $flags json_encode() $flag argument
     * @param integer $depth json_encode() $depth argument
     * @return string|null JSON Representation Of The Enum otherwise return null
     */
    public static function toJson(int $flags = 0, int $depth = 512): ?string
    {
        $data = self::asArray();

        if (empty($data) && !is_array($data)) {
            return null;
        }

        $jsonData = json_encode($data, $flags, $depth);

        if (!is_array(json_decode($jsonData, true)) && json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $jsonData;
    }

    /**
     * Convert Enum Data To Xml
     *
     * @return string|null Xml Representation Of The Enum Otherwise Return Null
     * @throws Exception If The Xml Data Could Not Be Parsed
     */
    public static function toXml(): ?string
    {
        $data = self::asArray();

        if (empty($data) || !is_array($data)) {
            return null;
        }

        try {
            $xml = new SimpleXMLElement('<enum/>');

            if (self::isBackedEnum()) {
                foreach ($data as $key => $value) {
                    $value = is_string($value) ? htmlspecialchars($value) : (string)$value;
                    $xml->addChild($key, $value);
                }
            }

            if (self::isPureEnum()) {
                foreach ($data as $case) {
                    $xml->addChild('name', $case);
                }
            }

            return $xml->asXML();
        } catch (Exception $e) {
            throw new Exception('Error creating SimpleXMLElement: ' . $e->getMessage());
        }
    }

    /**
     * Return Some Information About Enum
     *
     * @return array
     */
    public static function info(): array
    {
        $reflectionEnum = new \ReflectionEnum(self::class);

        return [
            'name' => $reflectionEnum->getName(),
            'type' => ($reflectionEnum->isBacked()) ? 'Backed' : 'Pure',
            'backed_type' => (string)$reflectionEnum->getBackingType(),
            'cases_count' => count($reflectionEnum->getCases()),
            'traitNames' => $reflectionEnum->getTraitNames(),
            'parent_class' => $reflectionEnum->getParentClass(),
            'namespace' => $reflectionEnum->getNamespaceName(),
            'user_defined' => $reflectionEnum->isUserDefined(),
        ];
    }

    /**
     * Filter Backed Enum Value By Prefix (case sensitive)
     *
     * @param integer|string $prefix
     * @return array Return Filtered Values Otherwise Return Empty Array
     */
    public static function filterValuesByPrefix(int|string $prefix): array
    {
        $filteredArray = array_filter(self::values(), function ($value) use ($prefix) {
            return str_contains((string)$value, (string)$prefix);
        });

        return array_values($filteredArray);
    }

    /**
     * Filter Backed Enum Name By Prefix (case sensitive)
     *
     * @param integer|string $prefix
     * @return array Return Filtered Names Otherwise Return Empty Array
     */
    public static function filterNamesByPrefix(string $prefix): array
    {
        $filteredArray = array_filter(self::names(), function ($name) use ($prefix) {
            return str_contains($name, $prefix);
        });

        return array_values($filteredArray);
    }

    /**
     * Filter enum values using a custom callable filter function
     *
     * @param callable $callableFilterFunction The custom callable filter function
     * @return array The Filtered Enum Values Otherwise Return Empty Array
     */
    public static function filterValues(callable $callableFilterFunction): array
    {
        return array_filter(self::values(), $callableFilterFunction);
    }

    /**
     * Filter Enum Names Using A Custom Callable Filter Function
     *
     * @param callable $callableFilterFunction The custom callable filter function
     * @return array The Filtered Enum Names Otherwise Return Empty Array
     */
    public static function filterNames(callable $callableFilterFunction): array
    {
        return array_filter(self::values(), $callableFilterFunction);
    }

    /**
     * Filter Backed Enum Values By Suffix
     *
     * @param integer|string $suffix
     * @return array Return Filtered Values Otherwise Return Empty Array
     */
    public static function filterValuesBySuffix(int|string $suffix): array
    {
        $values = self::values();

        if (empty($values)) {
            return [];
        }

        $suffix = (string)$suffix;

        $filteredArray = array_filter($values, function ($value) use ($suffix) {
            $value = (string)$value;

            if (strlen($value) <= 1) {
                return stripos($value, $suffix, 0) === 0;
            }

            return stripos($value, $suffix, -strlen($suffix));
        });

        return array_values($filteredArray);
    }

    /**
     * Filter Backed Enum Name By Suffix
     *
     * @param integer|string $suffix
     * @return array Return Filtered Values Otherwise Return Empty Array
     */
    public static function filterNamesBySuffix(string $suffix): array
    {
        $names = self::names();

        if (empty($names)) {
            return [];
        }

        $suffix = (string)$suffix;

        $filteredArray = array_filter($names, function ($name) use ($suffix) {

            if (strlen($name) <= 1) {
                return stripos($name, $suffix, 0) === 0;
            }

            return stripos($name, $suffix, -strlen($suffix));
        });

        return array_values($filteredArray);
    }

    /**
     * Checks Whether The Needle Is In The Values
     *
     * @param array|string|integer $needle
     * @return boolean
     */
    public static function isValueIn(array|string|int $needle): bool
    {
        $values = self::values();

        if (!is_array($needle)) {
            return in_array((string)$needle, $values);
        }

        return empty(array_diff($needle, $values));
    }

    /**
     * Checks Whether The Needle Is Not In The Values
     *
     * @param array|string|integer $needle
     * @return boolean
     */
    public static function isNotValueIn(array|string|int $needle): bool
    {
        return !self::isValueIn($needle);
    }

    /**
     * Checks Whether The Needle Is In The Names
     *
     * @param array|string $needle
     * @return boolean
     */
    public static function isNameIn(array|string $needle): bool
    {
        $values = self::names();

        if (is_string($needle)) {
            return in_array($needle, $values);
        }

        return empty(array_diff($needle, $values));
    }

    /**
     * Checks Whether The Needle Is Not In The Names
     *
     * @param array|string $needle
     * @return boolean
     */
    public static function isNotNameIn(array|string $needle): bool
    {
        return !self::isNameIn($needle);
    }
}
