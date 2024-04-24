<?php

declare(strict_types=1);

namespace dvlpr1996\PhpEnumHelperTrait\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use dvlpr1996\PhpEnumHelperTrait\Tests\FakeEnums\PureEnum;
use dvlpr1996\PhpEnumHelperTrait\Tests\FakeEnums\EmptyEnum;
use dvlpr1996\PhpEnumHelperTrait\Tests\FakeEnums\BackedIntEnum;
use dvlpr1996\PhpEnumHelperTrait\Tests\FakeEnums\BackedStringEnum;

/**
 * @covers EnumHelperTrait
 */
final class EnumHelperTraitTest extends TestCase
{
    private const EMPTY_ENUM_VALUES = [];
    private const PURE_ENUM_VALUES = [];
    private const EMPTY_ENUM_NAMES = [];
    private const BACKED_INT_VALUES = [1, 2, 3, 4];
    private const BACKED_STRING_VALUES = [
        'string one', 'string two', 'string three', 'string four'
    ];

    private const BACKED_INT_NAMES = [
        'BACKED_INT_ONE', 'BACKED_INT_TWO', 'BACKED_INT_THREE', 'BACKED_INT_FOUR'
    ];

    private const BACKED_STRING_NAMES = [
        'BACKED_STRING_ONE', 'BACKED_STRING_TWO', 'BACKED_STRING_THREE', 'BACKED_STRING_FOUR'
    ];

    private const PURE_ENUM_NAMES = [
        'PURE_ENUM_ONE', 'PURE_ENUM_TWO', 'PURE_ENUM_THREE', 'PURE_ENUM_FOUR'
    ];

    public static function enumDataProvider(): array
    {
        return [
            [BackedStringEnum::class, self::BACKED_STRING_VALUES, self::BACKED_STRING_NAMES],
            [BackedIntEnum::class, self::BACKED_INT_VALUES, self::BACKED_INT_NAMES],
            [PureEnum::class, self::PURE_ENUM_VALUES, self::PURE_ENUM_NAMES],
            [EmptyEnum::class, self::EMPTY_ENUM_VALUES, self::EMPTY_ENUM_NAMES],
        ];
    }

    public static function pureEnumDataProvider(): array
    {
        return [
            [PureEnum::class],
            [EmptyEnum::class],
        ];
    }

    public static function backedEnumDataProvider(): array
    {
        return [
            [BackedIntEnum::class],
            [BackedStringEnum::class],
        ];
    }

    #[DataProvider('enumDataProvider')]
    public function testGetAllMethodReturnsArray(string $enum, array $values, array $names): void
    {
        $result = $enum::getAll();
        $this->assertIsArray($result);
    }

    #[DataProvider('enumDataProvider')]
    public function testAsArrayMethodCanReturnsArray(string $enum, array $values, array $names): void
    {
        $result = $enum::asArray();
        $this->assertIsArray($result);
    }

    #[DataProvider('pureEnumDataProvider')]
    public function testIsPureEnumCanDetectThatTheEnumIsPure($enum): void
    {
        $result = $enum::isPureEnum();
        $this->assertTrue($result);
    }

    #[DataProvider('backedEnumDataProvider')]
    public function testIsBackedEnumCanDetectThatTheEnumIsBacked($enum): void
    {
        $result = $enum::isBackedEnum();
        $this->assertTrue($result);
    }

    #[DataProvider('enumDataProvider')]
    public function testIsEmptyCanDetectThatTheEnumIsEmptyAndReturnBoolean($enum): void
    {
        $result = $enum::isEmpty();
        $this->assertIsBool($result);
    }

    #[DataProvider('enumDataProvider')]
    public function testRandomCaseCanReturnOneCaseRandomly(string $enum): void
    {
        $randomCase = $enum::randomCase();

        $this->assertIsObject($randomCase);

        if (empty($randomCase)) {
            $this->assertInstanceOf($enum, $randomCase);
        }
    }

    public function testValuesCanReturnCorrectArrayForBackedIntEnum(): void
    {
        $values = BackedIntEnum::values();
        $this->assertEquals(self::BACKED_INT_VALUES, $values);
    }

    public function testValuesCanReturnCorrectArrayForBackedStringEnum(): void
    {
        $values = BackedStringEnum::values();
        $this->assertEquals(self::BACKED_STRING_VALUES, $values);
    }

    public function testValuesCanReturnCorrectArrayForPureEnum(): void
    {
        $values = PureEnum::values();
        $this->assertEquals(self::PURE_ENUM_VALUES, $values);
    }

    public function testValuesCanReturnCorrectArrayForEmptyEnum(): void
    {
        $values = EmptyEnum::values();
        $this->assertEquals(self::EMPTY_ENUM_VALUES, $values);
    }

    public function testNamesCanReturnCorrectArrayForBackedIntEnum(): void
    {
        $names = BackedIntEnum::names();
        $this->assertEquals(self::BACKED_INT_NAMES, $names);
    }

    public function testNamesCanReturnCorrectArrayForBackedStringEnum(): void
    {
        $names = BackedStringEnum::names();
        $this->assertEquals(self::BACKED_STRING_NAMES, $names);
    }

    public function testNamesCanReturnCorrectArrayForPureEnum(): void
    {
        $names = PureEnum::names();
        $this->assertEquals(self::PURE_ENUM_NAMES, $names);
    }

    public function testNamesCanReturnCorrectArrayForEmptyEnum(): void
    {
        $names = EmptyEnum::names();
        $this->assertEquals(self::EMPTY_ENUM_NAMES, $names);
    }

    #[DataProvider('enumDataProvider')]
    public function testRandomValueCanReturnRandomlyEnumValue(string $enum, array $values): void
    {
        $values = $enum::values();

        if (empty($values)) {
            $this->assertIsArray($values);
            $this->assertEquals([], $values);
            $this->assertEmpty($values);
        }

        if (!empty($values)) {
            $results = [];
            for ($i = 0; $i < 10; $i++) {
                $results[] = $enum::randomValue();
            }

            foreach ($results as $result) {
                $this->assertContains($result, $values);
            }

            $uniqueResults = array_unique($results);
            $this->assertGreaterThan(1, count($uniqueResults));
        }
    }

    #[DataProvider('enumDataProvider')]
    public function testRandomNameCanReturnRandomlyEnumName(string $enum, array $names): void
    {
        $names = $enum::names();

        if (empty($names)) {
            $this->assertIsArray($names);
            $this->assertEquals([], $names);
            $this->assertEmpty($names);
        }

        if (!empty($names)) {
            $results = [];
            for ($i = 0; $i < 10; $i++) {
                $results[] = $enum::randomName();
            }

            foreach ($results as $result) {
                $this->assertContains($result, $names);
            }

            $uniqueResults = array_unique($results);
            $this->assertGreaterThan(1, count($uniqueResults));
        }
    }

    #[DataProvider('enumDataProvider')]
    public function testFlipCanReturnFlipTheEnumCases(string $enum, array $values): void
    {
        $enumAsArray = $enum::asArray();

        if (empty($enumAsArray)) {
            $this->assertEquals([], $enumAsArray);
        }

        if ($enum::isPureEnum()) {
            $this->assertEquals([], $enum::flip());
        }

        if (!empty($enumAsArray) && !$enum::isPureEnum()) {
            $flippedCases = $enum::flip();

            $this->assertCount(count($values), $flippedCases);

            foreach ($values as $value) {
                $this->assertArrayHasKey($value, $flippedCases);
            }

            $expectedArray = array_flip($enum::asArray());
            $this->assertEquals($expectedArray, $flippedCases);
        }
    }

    #[DataProvider('enumDataProvider')]
    public function testIsValueExistsMethodCanCheckTheValueExist(string $enum, array $values): void
    {
        $enumValues = $enum::values();

        if (empty($enumValues)) {
            $this->assertEquals([], $values);
        }

        if (!empty($enumValues)) {
            $valueToCheck = $enumValues[0];

            $exists = $enum::isValueExists($valueToCheck);

            $this->assertTrue($exists);

            $valueNotInEnum = 'Non Existing Value';

            $exists = $enum::isValueExists($valueNotInEnum);

            $this->assertFalse($exists);
        }
    }

    #[DataProvider('enumDataProvider')]
    public function testIsNameExistsMethodCanCheckTheNameExist(string $enum, array $names): void
    {
        $enumNames = $enum::names();

        if (empty($enumNames)) {
            $this->assertEquals([], $names);
        }

        if (!empty($enumNames)) {
            $nameToCheck = $enumNames[0];

            $exists = $enum::isNameExists($nameToCheck);

            $this->assertTrue($exists);

            $nameNotInEnum = 'Non Existing Name';

            $exists = $enum::isNameExists($nameNotInEnum);

            $this->assertFalse($exists);
        }
    }

    #[DataProvider('enumDataProvider')]
    public function testGetNameFromValueCanReturnsEnumNameIfExists(string $enum, array $values, array $names): void
    {

        if (empty($values)) {
            $this->markTestSkipped('Values array is empty.');
            return;
        }

        foreach ($values as $key => $value) {
            $result = $enum::getNameFromValue($value);
            $this->assertEquals($names[$key] ?? null, $result);
        }
    }

    #[DataProvider('enumDataProvider')]
    public function testGetNameFromValueMethodCanReturnsNullIfValueDoesNotExist(string $enum): void
    {
        $valueNotInEnum = 'Non Existing Value';
        $result = $enum::getNameFromValue($valueNotInEnum);
        $this->assertNull($result);
    }

    #[DataProvider('enumDataProvider')]
    public function testToJsonMethodCanReturnsJsonRepresentationOfEnum(string $enum): void
    {
        $json = $enum::toJson();

        if ($json !== null) {
            $decodedJson = json_decode($json);
            $this->assertNotNull($decodedJson);
        }

        if ($json === null) {
            $this->assertNull($json);
        }
    }

    #[DataProvider('enumDataProvider')]
    public function testToJsonMethodCanReturnsNullForEmptyEnum(string $enum): void
    {
        $jsonData = $enum::toJson();

        if ($jsonData === null) {
            $this->assertNull($jsonData);
        }

        if ($jsonData !== null) {
            if (
                !is_string($jsonData) || !is_array(json_decode($jsonData, true)) ||
                (json_last_error() !== JSON_ERROR_NONE)
            ) {
                $this->assertNull($jsonData);
            }

            $this->assertNotNull($jsonData);
        }
    }

    # test for toJson Exception
    # test for xml

    #[DataProvider('enumDataProvider')]
    public function testInfoMethodReturnsEnumInfo(string $enum): void
    {
        $info = $enum::info();

        $this->assertIsArray($info);

        $this->assertArrayHasKey('name', $info);
        $this->assertArrayHasKey('type', $info);
        $this->assertArrayHasKey('backed_type', $info);
        $this->assertArrayHasKey('cases_count', $info);
        $this->assertArrayHasKey('traitNames', $info);
        $this->assertArrayHasKey('parent_class', $info);
        $this->assertArrayHasKey('namespace', $info);
        $this->assertArrayHasKey('user_defined', $info);

        $this->assertIsString($info['name']);
        $this->assertIsString($info['type']);

        if ($info['type'] === 'Backed') {
            $this->assertNotEmpty($info['backed_type']);
        }

        $this->assertIsString($info['backed_type']);
        $this->assertIsInt($info['cases_count']);
        $this->assertIsArray($info['traitNames']);
        $this->assertIsString($info['namespace']);
        $this->assertIsBool($info['user_defined']);
    }

    #[DataProvider('enumDataProvider')]
    public function testFilterValuesByPrefixMethodCanFilterValues(string $enum, array $values): void
    {
        if (empty($values)) {
            $value = '';
        } else {
            $randomKey = array_rand($values);
            $value = is_int($randomKey) ? (int) substr((string) $randomKey, 0, 2) : substr((string) $randomKey, 0, 2);
        }

        $filteredValue = $enum::filterValuesByPrefix($value);

        $this->assertIsArray($filteredValue);
    }

    #[DataProvider('enumDataProvider')]
    public function testFilterNamesByPrefixMethodCanFilterNames(string $enum, array $names): void
    {
        $prefix = empty($names) ? '' : substr((string)$names[array_rand($names)], 0, 2);
        $filteredName = $enum::filterNamesByPrefix($prefix);

        $this->assertIsArray($filteredName);
    }

    public function testFilterValuesBySuffixMethodCanFilterStringValueBySuffix()
    {
        $filteredValues = BackedStringEnum::filterValuesBySuffix('ee');
        $this->assertEquals('string three', $filteredValues[0]);
        $this->assertIsArray($filteredValues);
    }

    public function testFilterValuesBySuffixMethodCanFilterIntValueBySuffix()
    {
        $filteredValues = BackedIntEnum::filterValuesBySuffix('1');
        $this->assertEquals('1', $filteredValues[0]);
        $this->assertIsArray($filteredValues);
    }

    public function testFilterValuesBySuffixMethodCanReturnEmptyArrayIfEnumHasNoValue()
    {
        $filteredValues = PureEnum::filterValuesBySuffix('1');
        $this->assertEquals([], $filteredValues);
        $this->assertIsArray($filteredValues);
    }

    public function testFilterNamesBySuffixMethodCanFilterBackedStringEnumBySuffix()
    {
        $filteredValues = BackedStringEnum::filterNamesBySuffix('ONE');
        $this->assertEquals('BACKED_STRING_ONE', $filteredValues[0]);
        $this->assertIsArray($filteredValues);
    }

    public function testFilterNamesBySuffixMethodCanFilterBackedIntEnumBySuffix()
    {
        $filteredValues = BackedIntEnum::filterNamesBySuffix('ONE');
        $this->assertEquals('BACKED_INT_ONE', $filteredValues[0]);
        $this->assertIsArray($filteredValues);
    }

    public function testFilterNamesBySuffixMethodCanFilterPureEnumBySuffix()
    {
        $filteredValues = PureEnum::filterNamesBySuffix('ONE');
        $this->assertEquals('PURE_ENUM_ONE', $filteredValues[0]);
        $this->assertIsArray($filteredValues);
    }

    public function testFilterNamesBySuffixMethodCanReturnEmptyArrayIfThereIsNoNameInEnum()
    {
        $filteredValues = EmptyEnum::filterNamesBySuffix('ONE');
        $this->assertEquals([], $filteredValues);
        $this->assertIsArray($filteredValues);
    }

    #[DataProvider('enumDataProvider')]
    public function testIsValueInMethodCanCheckTheValueExisting(string $enum, array $values): void
    {
        $value = empty($values) ? 'a' : array_rand($values);
        $result = $enum::isValueIn($value);
        $this->assertIsBool($result);
    }

    #[DataProvider('enumDataProvider')]
    public function testIsNotValueInMethodCanCheckTheValueIsNotExisting(string $enum): void
    {
        $result = $enum::isNotValueIn('non existing value');
        $this->assertTrue($result);
    }

    #[DataProvider('enumDataProvider')]
    public function testIsNameInMethodCanCheckTheNameExisting(string $enum): void
    {
        $name = empty($value) ? 'a' : array_rand($value);
        $result = $enum::isNameIn($name);
        $this->assertIsBool($result);
    }

    #[DataProvider('enumDataProvider')]
    public function testIsNotNameInMethodCanCheckTheNameIsNotExisting(string $enum): void
    {
        $result = $enum::isNotNameIn('non existing name');
        $this->assertTrue($result);
    }
}
