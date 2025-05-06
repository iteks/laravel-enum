<?php

use Iteks\Support\Enums\BackedEnumShape;
use Iteks\Support\Facades\Enum;

// Enum Helpers (HasAttributes)
echo '<details>';
echo '<summary>Enum Helpers (HasAttributes)</summary>';

echo '<pre>';
$attributes = Enum::attributes(BackedEnumShape::RoundCircle);
echo '$attributes = Enum::attributes(BackedEnumShape::RoundCircle);';
dump($attributes);

$attributes = Enum::attributes(BackedEnumShape::RoundCircle, ['id', 'label']);
echo '$attributes = Enum::attributes(BackedEnumShape::RoundCircle, [\'id\', \'label\']);';
dump($attributes);

$attributes = Enum::attributes(BackedEnumShape::class);
echo '$attributes = Enum::attributes(BackedEnumShape::class);';
dump($attributes);

$attributes = Enum::attributes(BackedEnumShape::class, ['label', 'description']);
echo '$attributes = Enum::attributes(BackedEnumShape::class, [\'label\', \'description\']);';
dump($attributes);

$description = Enum::description(BackedEnumShape::RoundCircle);
echo '$description = Enum::description(BackedEnumShape::RoundCircle);';
dump($description);

$descriptions = Enum::descriptions(BackedEnumShape::class);
echo '$descriptions = Enum::descriptions(BackedEnumShape::class);';
dump($descriptions);

$descriptions = Enum::descriptions(BackedEnumShape::class, 'name');
echo '$descriptions = Enum::descriptions(BackedEnumShape::class, \'name\');';
dump($descriptions);

$id = Enum::id(BackedEnumShape::RoundCircle);
echo '$id = Enum::id(BackedEnumShape::RoundCircle);';
dump($id);

$ids = Enum::ids(BackedEnumShape::class);
echo '$ids = Enum::ids(BackedEnumShape::class);';
dump($ids);

$ids = Enum::ids(BackedEnumShape::class, 'value');
echo '$ids = Enum::ids(BackedEnumShape::class, \'name\');';
dump($ids);

$label = Enum::label(BackedEnumShape::RoundCircle);
echo '$label = Enum::label(BackedEnumShape::RoundCircle);';
dump($label);

$labels = Enum::labels(BackedEnumShape::class);
echo '$labels = Enum::labels(BackedEnumShape::class);';
dump($labels);

$labels = Enum::labels(BackedEnumShape::class, 'name');
echo '$labels = Enum::labels(BackedEnumShape::class, \'name\');';
dump($labels);

$metadata = Enum::metadata(BackedEnumShape::RoundCircle);
echo '$metadata = Enum::metadata(BackedEnumShape::RoundCircle);';
dump($metadata);

$metadatum = Enum::metadatum(BackedEnumShape::class);
echo '$metadatum = Enum::metadatum(BackedEnumShape::class);';
dump($metadatum);

$metadatum = Enum::metadatum(BackedEnumShape::class, 'name');
echo '$metadatum = Enum::metadatum(BackedEnumShape::class, \'name\');';
dump($metadatum);
echo '</pre>';
echo '</details>';

// Enum Traits (HasAttributes)
echo '<details>';
echo '<summary>Enum Traits (HasAttributes)</summary>';

echo '<pre>';
$attributes = BackedEnumShape::attributes('RoundCircle');
echo '$attributes = BackedEnumShape::attributes(\'RoundCircle\');';
dump($attributes);

$attributes = BackedEnumShape::attributes('RoundCircle', ['id', 'label']);
echo '$attributes = BackedEnumShape::attributes(\'RoundCircle\', [\'id\', \'label\']);';
dump($attributes);

$attributes = BackedEnumShape::attributes();
echo '$attributes = BackedEnumShape::attributes();';
dump($attributes);

$attributes = BackedEnumShape::attributes(null, ['description', 'metadata']);
echo '$attributes = BackedEnumShape::attributes(null, [\'description\', \'metadata\']);';
dump($attributes);

$description = BackedEnumShape::description('RoundCircle');
// $description = BackedEnumShape::RoundCircle->description();
echo '$description = BackedEnumShape::description(\'RoundCircle\');';
dump($description);

$descriptions = BackedEnumShape::descriptions();
echo '$descriptions = BackedEnumShape::descriptions();';
dump($descriptions);

$descriptions = BackedEnumShape::descriptions('name');
echo '$descriptions = BackedEnumShape::descriptions(\'name\');';
dump($descriptions);

$id = BackedEnumShape::id('PointedStar');
// $id = BackedEnumShape::PointedStar->id();
echo '$id = BackedEnumShape::id(\'PointedStar\');';
dump($id);

$ids = BackedEnumShape::ids();
echo '$ids = BackedEnumShape::ids();';
dump($ids);

$ids = BackedEnumShape::ids('name');
echo '$ids = BackedEnumShape::ids(\'name\');';
dump($ids);

$label = BackedEnumShape::label('PolygonRectangle');
// $label = BackedEnumShape::PolygonRectangle->label();
echo '$label = BackedEnumShape::label(\'PolygonRectangle\');';
dump($label);

$labels = BackedEnumShape::labels();
echo '$labels = BackedEnumShape::labels();';
dump($labels);

$labels = BackedEnumShape::labels('name');
echo '$labels = BackedEnumShape::labels(\'name\');';
dump($labels);

$metadata = BackedEnumShape::metadata('RoundCircle');
// $metadata = BackedEnumShape::RoundCircle->metadata();
echo '$metadata = BackedEnumShape::metadata(\'RoundCircle\');';
dump($metadata);

$metadatum = BackedEnumShape::metadatum();
echo '$metadatum = BackedEnumShape::metadatum();';
dump($metadatum);
echo '</pre>';
echo '</details>';

echo '<details>';
echo '<summary>NEW Metadata Accessors</summary>';

// NEW Metadata Options
echo '<h3>Accessing metadata through helper and trait methods:</h3>';

echo '<pre>';
echo '// All metadata<br>';
echo 'Enum::metadata(BackedEnumShape::BoxSquare); // [\'color\' => \'blue\', \'sides\' => 4, \'type\' => \'polygon\', \'regular\' => true]<br>';
echo '// Single key<br>';
echo 'Enum::metadata(BackedEnumShape::BoxSquare, \'color\'); // \'blue\'<br>';
echo '// Multiple keys<br>';
echo 'Enum::metadata(BackedEnumShape::BoxSquare, [\'color\', \'sides\']); // [\'color\' => \'blue\', \'sides\' => 4]<br>';
dump([
    'All metadata' => Enum::metadata(BackedEnumShape::BoxSquare),
    'Single key' => Enum::metadata(BackedEnumShape::BoxSquare, 'color'),
    'Multiple keys' => Enum::metadata(BackedEnumShape::BoxSquare, ['color', 'sides']),
]);

echo '// All metadatum<br>';
echo 'Enum::metadatum(BackedEnumShape::class); // [[\'color\' => \'red\', \'sides\' => 0, \'type\' => \'curved\'], ...each case metadata]<br>';
echo '// Single key<br>';
echo 'Enum::metadatum(BackedEnumShape::class, \'color\'); // [\'red\', \'blue\', \'green\', \'yellow\', \'purple\']<br>';
echo '// Multiple keys<br>';
echo 'Enum::metadatum(BackedEnumShape::class, [\'color\', \'sides\']); // [[\'color\' => \'red\', \'sides\' => 0], ...each case metadata]<br>';
dump([
    'All metadatum' => Enum::metadatum(BackedEnumShape::class),
    'Single key' => Enum::metadatum(BackedEnumShape::class, 'color'),
    'Multiple keys' => Enum::metadatum(BackedEnumShape::class, ['color', 'sides'], 'value'),
]);

echo '// All metadata<br>';
echo 'BackedEnumShape::metadata(\'BoxSquare\'); // [\'color\' => \'blue\', \'sides\' => 4, \'type\' => \'polygon\', \'regular\' => true]<br>';
echo '// Single key<br>';
echo 'BackedEnumShape::metadata(\'BoxSquare\', \'color\'); // \'blue\'<br>';
echo '// Multiple keys<br>';
echo 'BackedEnumShape::metadata(\'BoxSquare\', [\'color\', \'sides\']); // [\'color\' => \'blue\', \'sides\' => 4]<br>';
dump([
    'All metadata' => BackedEnumShape::metadata('BoxSquare'),
    'Single key' => BackedEnumShape::metadata('BoxSquare', 'color'),
    'Multiple keys' => BackedEnumShape::metadata('BoxSquare', ['color', 'sides']),
]);

echo '// All metadatum<br>';
echo 'BackedEnumShape::metadatum(); // [[\'color\' => \'red\', \'sides\' => 0, \'type\' => \'curved\'], ...each case metadata]<br>';
echo '// Single key<br>';
echo 'BackedEnumShape::metadatum(\'color\'); // [\'red\', \'blue\', \'green\', \'yellow\', \'purple\']<br>';
echo '// Multiple keys<br>';
echo 'BackedEnumShape::metadatum([\'color\', \'sides\']); // [[\'color\' => \'red\', \'sides\' => 0], ...each case metadata]<br>';
dump([
    'All metadatum' => BackedEnumShape::metadatum(),
    'Single key' => BackedEnumShape::metadatum('color', 'value'),
    'Multiple keys' => BackedEnumShape::metadatum(['color', 'sides'], 'name'),
]);
echo '</pre>';

// NEW Metadata Trait Accessors
echo '<h3>Accessing metadata through meta() property accessor:</h3>';

echo '<pre>';
echo 'BackedEnumShape::RoundCircle->meta()->color;<br>';
echo 'BackedEnumShape::RoundCircle->meta()->type;<br>';
echo 'BackedEnumShape::BoxSquare->meta()->color;<br>';
echo 'BackedEnumShape::BoxSquare->meta()->sides;<br>';
dump([
    'RoundCircle->color' => BackedEnumShape::RoundCircle->meta()->color,
    'RoundCircle->type' => BackedEnumShape::RoundCircle->meta()->type,
    'BoxSquare->color' => BackedEnumShape::BoxSquare->meta()->color,
    'BoxSquare->sides' => BackedEnumShape::BoxSquare->meta()->sides,
]);

echo 'BackedEnumShape::BoxSquare->meta()->nonexistent;<br>';
dump(BackedEnumShape::BoxSquare->meta()->nonexistent);
echo '</pre>';
echo '</details>';
