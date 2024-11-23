<?php

use Illuminate\Support\Str;

// Str Helper Macros
echo '<details>';
echo '<summary>Str Helper Macros</summary>';

echo '<pre>';
$string = Str::splitConstantCase('CONSTANT_CASE');
echo '$string = Str::splitConstantCase(\'CONSTANT_CASE\');';
dump($string);

$string = Str::splitEnumCase('EnumCase');
echo '$string = Str::splitEnumCase(\'EnumCase\');';
dump($string);
echo '</pre>';
echo '</details>';
