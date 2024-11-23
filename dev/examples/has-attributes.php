<?php

use Iteks\Support\Enums\ExampleBackedEnum;
use Iteks\Support\Facades\Enum;

// Enum Helpers (HasAttributes)
echo '<details>';
echo '<summary>Enum Helpers (HasAttributes)</summary>';

echo '<pre>';
$attributes = Enum::attributes(ExampleBackedEnum::CurrentlyActive);
echo '$attributes = Enum::attributes(ExampleBackedEnum::CurrentlyActive);';
dump($attributes);

$attributes = Enum::attributes(ExampleBackedEnum::CurrentlyActive, ['id', 'label']);
echo '$attributes = Enum::attributes(ExampleBackedEnum::CurrentlyActive, [\'id\', \'label\']);';
dump($attributes);

$attributes = Enum::attributes(ExampleBackedEnum::class);
echo '$attributes = Enum::attributes(ExampleBackedEnum::class);';
dump($attributes);

$attributes = Enum::attributes(ExampleBackedEnum::class, ['description', 'metadata']);
echo '$attributes = Enum::attributes(ExampleBackedEnum::class, [\'description\', \'metadata\']);';
dump($attributes);

$description = Enum::description(ExampleBackedEnum::CurrentlyActive);
echo '$description = Enum::description(ExampleBackedEnum::CurrentlyActive);';
dump($description);

$descriptions = Enum::descriptions(ExampleBackedEnum::class);
echo '$descriptions = Enum::descriptions(ExampleBackedEnum::class);';
dump($descriptions);

$id = Enum::id(ExampleBackedEnum::CurrentlyActive);
echo '$id = Enum::id(ExampleBackedEnum::CurrentlyActive);';
dump($id);

$ids = Enum::ids(ExampleBackedEnum::class);
echo '$ids = Enum::ids(ExampleBackedEnum::class);';
dump($ids);

$label = Enum::label(ExampleBackedEnum::CurrentlyActive);
echo '$label = Enum::label(ExampleBackedEnum::CurrentlyActive);';
dump($label);

$labels = Enum::labels(ExampleBackedEnum::class);
echo '$labels = Enum::labels(ExampleBackedEnum::class);';
dump($labels);

$metadata = Enum::metadata(ExampleBackedEnum::CurrentlyActive);
echo '$metadata = Enum::metadata(ExampleBackedEnum::CurrentlyActive);';
dump($metadata);

$metadatum = Enum::metadatum(ExampleBackedEnum::class);
echo '$metadatum = Enum::metadatum(ExampleBackedEnum::class);';
dump($metadatum);
echo '</pre>';
echo '</details>';

// Enum Traits (HasAttributes)
echo '<details>';
echo '<summary>Enum Traits (HasAttributes)</summary>';

echo '<pre>';
$attributes = ExampleBackedEnum::attributes('CurrentlyActive');
echo '$attributes = ExampleBackedEnum::attributes(\'CurrentlyActive\');';
dump($attributes);

$attributes = ExampleBackedEnum::attributes('CurrentlyActive', ['id', 'label']);
echo '$attributes = ExampleBackedEnum::attributes(\'CurrentlyActive\', [\'id\', \'label\']);';
dump($attributes);

$attributes = ExampleBackedEnum::attributes();
echo '$attributes = ExampleBackedEnum::attributes();';
dump($attributes);

$attributes = ExampleBackedEnum::attributes(null, ['description', 'metadata']);
echo '$attributes = ExampleBackedEnum::attributes(null, [\'description\', \'metadata\']);';
dump($attributes);

$description = ExampleBackedEnum::description('CurrentlyActive');
echo '$description = ExampleBackedEnum::description(\'CurrentlyActive\');';
dump($description);

$descriptions = ExampleBackedEnum::descriptions();
echo '$descriptions = ExampleBackedEnum::descriptions();';
dump($descriptions);

$id = ExampleBackedEnum::id('CurrentlyActive');
echo '$id = ExampleBackedEnum::id(\'CurrentlyActive\');';
dump($id);

$ids = ExampleBackedEnum::ids();
echo '$ids = ExampleBackedEnum::ids();';
dump($ids);

$label = ExampleBackedEnum::label('CurrentlyActive');
echo '$label = ExampleBackedEnum::label(\'CurrentlyActive\');';
dump($label);

$labels = ExampleBackedEnum::labels();
echo '$labels = ExampleBackedEnum::labels();';
dump($labels);

$metadata = ExampleBackedEnum::metadata('CurrentlyActive');
echo '$metadata = ExampleBackedEnum::metadata(\'CurrentlyActive\');';
dump($metadata);

$metadatum = ExampleBackedEnum::metadatum();
echo '$metadatum = ExampleBackedEnum::metadatum();';
dump($metadatum);
echo '</pre>';
echo '</details>';
