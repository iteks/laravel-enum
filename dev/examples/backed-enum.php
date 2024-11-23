<?php

use Iteks\Support\Enums\ExampleBackedEnum;
use Iteks\Support\Facades\Enum;

// Enum Helpers (BackedEnum)
echo '<details>';
echo '<summary>Enum Helpers (BackedEnum)</summary>';

echo '<pre>';
$selectArray = Enum::asSelectArray(ExampleBackedEnum::class);
echo '$selectArray = Enum::asSelectArray(ExampleBackedEnum::class);';
dump($selectArray);

$label = Enum::toLabel(ExampleBackedEnum::CurrentlyActive);
echo '$label = Enum::toLabel(ExampleBackedEnum::CurrentlyActive);';
dump($label);

$labels = Enum::toLabels(ExampleBackedEnum::class);
echo '$labels = Enum::toLabels(ExampleBackedEnum::class);';
dump($labels);
echo '</pre>';
echo '</details>';

// Enum Traits (BackedEnum)
echo '<details>';
echo '<summary>Enum Traits (BackedEnum)</summary>';

echo '<pre>';
$selectArray = ExampleBackedEnum::asSelectArray();
echo '$selectArray = ExampleBackedEnum::asSelectArray();';
dump($selectArray);

$enum = ExampleBackedEnum::fromName('CurrentlyActive');
echo '$enum = ExampleBackedEnum::fromName(\'CurrentlyActive\');';
dump($enum);

$caseName = ExampleBackedEnum::name(1);
echo '$caseName = ExampleBackedEnum::name(1);';
dump($caseName);

$caseNames = ExampleBackedEnum::names();
echo '$caseNames = ExampleBackedEnum::names();';
dump($caseNames);

$label = ExampleBackedEnum::toLabel(1);
echo '$label = ExampleBackedEnum::toLabel(1);';
dump($label);

$labels = ExampleBackedEnum::toLabels();
echo '$labels = ExampleBackedEnum::toLabels();';
dump($labels);

$enum = ExampleBackedEnum::tryFromName('CurrentlyActive');
echo '$enum = ExampleBackedEnum::tryFromName(\'CurrentlyActive\');';
dump($enum);

$simplerValue = ExampleBackedEnum::value('CurrentlyActive');
echo '$simplerValue = ExampleBackedEnum::value(\'CurrentlyActive\');';
dump($simplerValue);

$simplerValues = ExampleBackedEnum::values();
echo '$simplerValues = ExampleBackedEnum::values();';
dump($simplerValues);
echo '</pre>';
echo '</details>';
