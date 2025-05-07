<?php

use Iteks\Support\Enums\BackedEnumShape;
use Iteks\Support\Facades\Enum;

// Enum Helpers (BackedEnum)
echo '<details>';
echo '<summary>Enum Helpers (BackedEnum)</summary>';

echo '<pre>';
$options = Enum::asSelectArray(BackedEnumShape::class);
echo '$options = Enum::asSelectArray(BackedEnumShape::class);';
dump($options);

$label = Enum::toLabel(BackedEnumShape::RoundCircle);
echo '$label = Enum::toLabel(BackedEnumShape::RoundCircle);';
dump($label);

$labels = Enum::toLabels(BackedEnumShape::class);
echo '$labels = Enum::toLabels(BackedEnumShape::class);';
dump($labels);
echo '</pre>';
echo '</details>';

// Enum Traits (BackedEnum)
echo '<details>';
echo '<summary>Enum Traits (BackedEnum)</summary>';

echo '<pre>';
$options = BackedEnumShape::asSelectArray();
echo '$options = BackedEnumShape::asSelectArray();';
dump($options);

$enum = BackedEnumShape::fromName('RoundCircle');
echo '$enum = BackedEnumShape::fromName(\'RoundCircle\');';
dump($enum);

$name = BackedEnumShape::name('circle');
// $name = BackedEnumShape::RoundCircle->name();
echo '$name = BackedEnumShape::name(\'circle\');';
dump($name);

$names = BackedEnumShape::names();
echo '$names = BackedEnumShape::names();';
dump($names);

$label = BackedEnumShape::toLabel('circle');
// $label = BackedEnumShape::RoundCircle->toLabel();
echo '$label = BackedEnumShape::toLabel(\'circle\');';
dump($label);

$labels = BackedEnumShape::toLabels();
echo '$labels = BackedEnumShape::toLabels();';
dump($labels);

$enum = BackedEnumShape::tryFromName('RoundCircle');
echo '$enum = BackedEnumShape::tryFromName(\'RoundCircle\');';
dump($enum);

$simplerValue = BackedEnumShape::value('RoundCircle');
echo '$simplerValue = BackedEnumShape::value(\'RoundCircle\');';
dump($simplerValue);

$simplerValues = BackedEnumShape::values();
echo '$simplerValues = BackedEnumShape::values();';
dump($simplerValues);
echo '</pre>';
echo '</details>';
