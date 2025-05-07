<p align="center"><img src="https://raw.githubusercontent.com/iteks/art/master/logo-packages/laravel-enum.svg" width="400" alt="Laravel ENUM"></p>

<p align="center">
<a href="https://packagist.org/packages/iteks/laravel-enum"><img src="https://img.shields.io/packagist/dt/iteks/laravel-enum" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/iteks/laravel-enum"><img src="https://img.shields.io/packagist/v/iteks/laravel-enum" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/iteks/laravel-enum"><img src="https://img.shields.io/packagist/l/iteks/laravel-enum" alt="License"></a>
</p>

The **Laravel Enum** package enriches Laravel's enum support, integrating advanced features like attribute handling, select array transformation, and facade access for streamlined enum operations. Designed for Laravel applications, it offers a suite of utilities for both backed enums and attribute-enhanced enums, including descriptive annotations, ID management, label generation, and metadata association. This package streamlines working with enums in Laravel by providing intuitive, fluent interfaces for common tasks, enhancing enum usability in forms, API responses, and more. Whether you're defining select options, querying enum attributes, or integrating enums tightly with Laravel features, **Laravel Enum** simplifies these processes, making enum management in Laravel applications both powerful and efficient. Offered by <a href="https://github.com/iteks/">iteks</a>, Developed by <a href="https://github.com/jeramyhing/">jeramyhing</a>.

## Get Started

> **Requires <a href="https://php.net/releases/" target="_blank">PHP 8.1+</a>**

Install **Laravel Enum** via the <a href="https://getcomposer.org/" target="_blank">Composer</a> package manager:

```bash
composer require iteks/laravel-enum
```

## Usage

- [Attributes](#attributes)
- [Enum Helpers (BackedEnum)](#enum-helpers-backedenum)
  - [Enum::asSelectArray()](#enumasselectarray)
  - [Enum::toLabel()](#enumtolabel)
  - [Enum::toLabels()](#enumtolabels)
- [Enum Helpers (HasAttributes)](#enum-helpers-hasattributes)
  - [Enum::attributes()](#enumattributes)
  - [Enum::description()](#enumdescription)
  - [Enum::descriptions()](#enumdescriptions)
  - [Enum::id()](#enumid)
  - [Enum::ids()](#enumids)
  - [Enum::label()](#enumlabel)
  - [Enum::labels()](#enumlabels)
  - [Enum::metadata()](#enummetadata) **filterable**
  - [Enum::metadatum()](#enummetadatum) **filterable**
- [Enum Traits (BackedEnum)](#enum-traits-backedenum)
  - [asSelectArray()](#asselectarray)
  - [fromName()](#fromname)
  - [name()](#name)
  - [names()](#names)
  - [toLabel()](#tolabel)
  - [toLabels()](#tolabels)
  - [tryFromName()](#tryfromname)
  - [value()](#value)
  - [values()](#values)
- [Enum Traits (HasAttributes)](#enum-traits-hasattributes)
  - [attributes()](#attributes)
  - [description()](#description)
  - [descriptions()](#descriptions)
  - [id()](#id)
  - [ids()](#ids)
  - [label()](#label)
  - [labels()](#labels)
  - [metadata()](#metadata) **filterable**
  - [metadatum()](#metadatum) **filterable**
  - [meta()](#meta) **Metadata property accessor**
- [String Helper Macros](#string-helper-macros)
  - [Str::splitConstantCase()](#strsplitconstantcase)
  - [Str::splitEnumCase()](#strsplitenumcase)

## Attributes

The **Laravel Enum** methods are designed for <a href="https://www.php.net/manual/en/language.enumerations.backed.php" target="_blank">PHP 8 Backed Enumeration</a> classes.

**Laravel Enum** helper and trait methods extend an existing backed enum class for more versatile enum handling. Additionally, **Laravel Enum** offers a fluent way to add and manage <a href="https://www.php.net/manual/en/language.attributes.overview.php" target="_blank">PHP 8 Attributes</a> on backed enum cases. This package comes with four available attributes to readily assign to your enum cases: **Description**, **Id**, **Label**, and **Metadata**. The example enum classes linked below demonstrate how you can apply these attributes to your enums. You may pick and choose which attributes you wish to take advantage of.

- [BackedEnumShape.php](src/Enums/BackedEnumShape.php)
- [BackedEnumStatus.php](src/Enums/BackedEnumStatus.php)

To apply an attribute to an enum, be sure to import the `BackedEnum` and the `HasAttributes` traits and the attribute class needed.

```php
use Iteks\Attributes\Description;
use Iteks\Traits\BackedEnum;
use Iteks\Traits\HasAttributes;

enum BackedEnumShape: string
{
    use BackedEnum;
    use HasAttributes;

    #[Description('A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center')]
    case RoundCircle = 'circle';
}
```

The package provides the following four attributes to enhance your enum classes and cases:

### Description Attribute

Provides descriptive text for enum classes and cases.

```php
enum BackedEnumShape: string
{
    #[Description('A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center')]
    case RoundCircle = 'circle';
}
```

### Id Attribute

Provides unique identifiers for enum cases.

```php
enum BackedEnumShape: string
{
    #[Id(1)]
    case RoundCircle = 'circle';
}
```

### Label Attribute

Provides human-readable labels for enum cases.

```php
enum BackedEnumShape: string
{
    #[Label('Round Circle')]
    case RoundCircle = 'circle';
}
```

### Metadata Attribute

Provides additional metadata for enum classes and cases. Metadata can be specified as either an array or a JSON string (must use double quotes for valid JSON).

```php
enum BackedEnumShape: string
{
    #[Metadata(['color' => 'red', 'sides' => 0, 'type' => 'curved'])] // Metadata as array
    case RoundCircle = 'circle';

    #[Metadata('{"color": "blue", "sides": 4, "type": "polygon", "regular": true}')] // Metadata as JSON string
    case BoxSquare = 'square';
}
```

The metadata values can be accessed in three ways:

1. Through the `meta()` accessor (recommended for property-like access)
   - [meta()](#meta)
2. Using the `metadata()` method with optional key filtering (recommended for case specific data)
   - [Enum::metadata()](#enummetadata)
   - [metadata()](#metadata)
3. Using the `metadatum()` method with optional key filtering (recommended for all enum cases within the class)
   - [Enum::metadatum()](#enummetadatum)
   - [metadatum()](#metadatum)

> **Note**: While Id and Label attributes technically support class-level usage, this is deprecated and will be removed in v2.0.0. Please use these attributes only on enum cases.

[top](#usage)

## Enum Helpers (BackedEnum)

The **Laravel Enum** package provides a set of helper methods through the `Enum` facade to work with backed enums. These methods are available for any enum that uses the `BackedEnum` trait.

To use the Enum facade, start by importing the Enum helper into the file where your logic will be:

```php
use Iteks\Facades\Enum;
```

### Enum::asSelectArray()

Convert an enum to a select array format, useful for form select elements.

The array will consist of a `text` key column containing values of the case name in display format, and a `value` keys column containing values using the original simpler values.

_Note: This method will first check for **Label** and **Id** attributes applied to the target enum class. If they are present, the method will prioritize those values. If not present, the method will return a mutated Headline value from the case name._

```php
$options = Enum::asSelectArray(BackedEnumShape::class);
```

```php
// Result:
[
    ['text' => 'Round Circle', 'value' => 1],
    ['text' => 'Perfect Square', 'value' => 2],
    ['text' => 'Right-Triangle', 'value' => 3],
    ['text' => '5 Point Star', 'value' => 4],
    ['text' => 'Poly-Rectangle', 'value' => 5]
]
```

### Enum::toLabel()

Convert an enum case to its label representation.

```php
$label = Enum::toLabel(BackedEnumShape::RoundCircle);
```

```php
// Result:
'Round Circle'
```

### Enum::toLabels()

Convert multiple enum cases to their label representations.

```php
$labels = Enum::toLabels();
```

```php
// Result:
['Round Circle', 'Box Square', 'Right Triangle', 'Pointed Star', 'Polygon Rectangle']
```

[top](#usage)

## Enum Helpers (HasAttributes)

The **Laravel Enum** package provides a rich set of helper methods through the `Enum` facade to work with enum attributes. These methods are available for any enum that uses both the `BackedEnum` and `HasAttributes` traits.

To use the Enum facade, start by importing the Enum helper into the file where your logic will be:

```php
use Iteks\Facades\Enum;
```

### Enum::attributes()

Get all attributes for an enum instance or all class instances.

```php
$attributes = Enum::attributes(BackedEnumShape::RoundCircle);
```

```php
// Result:
[
    'simpleValue' => 'circle',
    'description' => 'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
    'id' => 1,
    'label' => 'Round Circle',
    'metadata' => [
        'color' => 'red',
        'sides' => 0,
        'type' => 'curved'
    ]
]
```

Filter attributes for the enum instance.

```php
$attributes = Enum::attributes(BackedEnumShape::RoundCircle, ['id', 'label']);
```

```php
// Result:
[
    'id' => 1,
    'label' => 'Round Circle'
]
```

Get all attributes for each instance in the class.

```php
$attributes = Enum::attributes(BackedEnumShape::class);
```

```php
// Result:
[
    'RoundCircle' => [
        'simpleValue' => 'circle',
        'description' => 'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
        'id' => 1,
        'label' => 'Round Circle',
        'metadata' => [,
            'color' => 'red',
            'sides' => 0,
            'type' => 'curved'
        ]
    ],
    'BoxSquare' => [
        'simpleValue' => 'square',
        'description' => 'A square is a regular quadrilateral',
        'id' => 2,
        'label' => 'Perfect Square',
        'metadata' => [
            'color' => 'blue',
            'sides' => 4,
            'type' => 'polygon',
            'regular' => true
        ]
    ],
    'RightTriangle' => [
        'simpleValue' => 'triangle',
        'description' => 'A triangle is a polygon with three edges and three vertices',
        'id' => 3,
        'label' => 'Right-Triangle',
        'metadata' => [,
            'color' => 'green',
            'sides' => 3,
            'type' => 'polygon'
        ]
    ],
    ...
]
```

Filter all attributes for each instance in the class by key(s).

```php
$attributes = Enum::attributes(BackedEnumShape::class, ['description', 'label']);
```

```php
// Result:
[
    'RoundCircle' => [
        'description' => 'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
        'label' => 'Round Circle'
    ],
    'BoxSquare' => [
        'description' => 'A square is a regular quadrilateral',
        'label' => 'Perfect Square'
    ],
    'RightTriangle' => [
        'description' => 'A triangle is a polygon with three edges and three vertices',
        'label' => 'Right-Triangle'
    ],
    ...
]
```

### Enum::description()

Get the description for an enum case.

```php
$description = Enum::description(BackedEnumShape::RoundCircle);
```

```php
// Result:
'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center'
```

### Enum::descriptions()

Get descriptions for multiple enum cases.

```php
$descriptions = Enum::descriptions(BackedEnumShape::class);
```

```php
// Result:
[
    'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
    'A square is a regular quadrilateral',
    'A triangle is a polygon with three edges and three vertices',
    'A star is a self-intersecting, equilateral polygon',
    'A rectangle is a quadrilateral with four right angles'
]
```

Use the `keyBy` argument to get an associative array using the case name or simple value as the keys/indices.

```php
$descriptions = Enum::descriptions(BackedEnumShape::class, 'name');
```

```php
// Result:
[
    'RoundCircle' => 'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
    'BoxSquare' => 'A square is a regular quadrilateral',
    ...
]
```

### Enum::id()

Get the ID attribute for an enum case.

```php
$id = Enum::id(BackedEnumShape::PointedStar);
```

```php
// Result:
4
```

### Enum::ids()

Get IDs for multiple enum cases.

```php
$ids = Enum::ids(BackedEnumShape::class);
```

```php
// Result:
[1, 2, 3, 4, 5]
```

Use the `keyBy` argument to get an associative array using the case name or simple value as the keys/indices.

```php
$ids = Enum::ids(BackedEnumShape::class, 'value');
```

```php
// Result:
['circle' => 1, 'square' => 2, 'triangle' => 3, 'star' => 4, 'rectangle' => 5]
```

### Enum::label()

Get the label for an enum case.

```php
$label = Enum::label(BackedEnumShape::PolygonRectangle);
```

```php
// Result:
'Poly-Rectangle'
```

### Enum::labels()

Get labels for multiple enum cases.

```php
$labels = Enum::labels(BackedEnumShape::class);
```

```php
// Result:
['Round Circle', 'Perfect Square', 'Right-Triangle', '5 Point Star', 'Poly-Rectangle']
```

### Enum::metadata()

Retrieve the metadata attribute or specific metadata values by key(s).

```php
$allMetadata = Enum::metadata(BackedEnumShape::BoxSquare);
```

```php
// Result:
[
    'color' => 'blue',
    'sides' => 4,
    'type' => 'polygon',
    'regular' => true
]
```

Get specific metadata value.

```php
$specific = Enum::metadata(BackedEnumShape::BoxSquare, 'color');
```

```php
// Result:
'blue'
```

Filter metadata by specific keys.

```php
$filteredMetadata = Enum::metadata(BackedEnumShape::BoxSquare, ['color', 'type']);
```

```php
// Result:
[
    'color' => 'blue',
    'type' => 'polygon'
]
```

### Enum::metadatum()

Retrieve the metadata attribute for all cases, optionally filtered by key.

```php
$allMetadatum = Enum::metadatum(BackedEnumShape::class);
```

```php
// Result:
[
    ['color' => 'red', 'sides' => 0, 'type' => 'curved'],
    ['color' => 'blue', 'sides' => 4, 'type' => 'polygon', 'regular' => true],
    ['color' => 'green', 'sides' => 3, 'type' => 'polygon'],
    ['color' => 'yellow', 'points' => 5, 'type' => 'star', 'symmetrical' => true],
    ['color' => 'purple', 'sides' => 4, 'type' => 'polygon', 'regular' => false]
]
```

Get specific metadatum values for the class.

```php
$specific = Enum::metadatum(BackedEnumShape::class, 'color');
```

```php
// Result:
['red', 'blue', 'green', 'yellow', 'purple']
```

Use the `keyBy` argument to get an associative array using the case name or simple value as the keys/indices.

```php
$keyBy = Enum::metadatum(BackedEnumShape::class, 'color', 'value');
```

```php
// Result:
[
    'circle' => 'red',
    'square' => 'blue',
    'triangle' => 'green',
    'star' => 'yellow',
    'rectangle' => 'purple'
]
```

Filter metadatum by specific keys.

```php
$filteredMetadatum = Enum::metadatum(BackedEnumShape::class, ['color', 'sides']);
```

```php
// Result:
[
    ['color' => 'red', 'sides' => 0],
    ['color' => 'blue', 'sides' => 4],
    ['color' => 'green', 'sides' => 3],
    ['color' => 'yellow'],
    ['color' => 'purple', 'sides' => 4]
]
```

[top](#usage)

## Enum Traits (BackedEnum)

The `BackedEnum` trait provides instance methods for working with backed enums. Apply this trait to your enum class to access these methods directly on enum instances.

```php
use Iteks\Traits\BackedEnum;

enum BackedEnumShape: string
{
    use BackedEnum;
    ...
```

### asSelectArray()

Convert the enum to a select array format, useful for form select elements.

```php
$options = BackedEnumShape::asSelectArray();
```

```php
// Result:
[
    ['text' => 'Round Circle', 'value' => 1],
    ['text' => 'Perfect Square', 'value' => 2],
    ['text' => 'Right-Triangle', 'value' => 3],
    ['text' => '5 Point Star', 'value' => 4],
    ['text' => 'Poly-Rectangle', 'value' => 5]
]
```

### fromName()

Create an enum instance from a case name.

```php
$enum = BackedEnumShape::fromName('RoundCircle');
```

```php
// Result:
// The enum instance of BackedEnumShape::RoundCircle
{
    +name: "RoundCircle"
    +value: "circle"
}
```

### name()

Get the case name of an enum instance.

```php
$name = BackedEnumShape::name('square');
```

```php
// Result:
'BoxSquare'
```

### names()

Get all case names from the enum.

```php
$names = BackedEnumShape::names();
```

```php
// Result:
[
    'RoundCircle',
    'BoxSquare',
    'RightTriangle',
    'PointedStar',
    'PolygonRectangle'
]
```

### toLabel()

Convert an enum instance to its label representation.

```php
$label = BackedEnumShape::toLabel('triangle');
```

```php
// Result:
'Right-Triangle'
```

### toLabels()

Convert multiple enum instances to their label representations.

```php
$labels = BackedEnumShape::toLabels();
```

```php
// Result:
[
    'Round Circle',
    'Box Square',
    'Right Triangle',
    'Pointed Star',
    'Polygon Rectangle'
]
```

### tryFromName()

Attempt to create an enum instance from a case name, returning null if the name doesn't exist.

```php
$enum = BackedEnumShape::tryFromName('RoundCircle');
```

```php
// Result:
// The enum instance of BackedEnumShape::RoundCircle
{
    +name: "RoundCircle"
    +value: "circle"
}
```

### value()

Get the backed value of an enum instance.

```php
$value = BackedEnumShape::value('RoundCircle');
```

```php
// Result:
'circle'
```

### values()

Get all backed values from the enum.

```php
$values = BackedEnumShape::values();
```

```php
// Result:
[
    'circle',
    'square',
    'triangle',
    'star',
    'rectangle'
]
```

[top](#usage)

## Enum Traits (HasAttributes)

The `HasAttributes` trait provides instance methods for working with enum attributes. Apply this trait along with `BackedEnum` to access these methods directly on enum instances.

```php
use Iteks\Traits\BackedEnum;
use Iteks\Traits\HasAttributes;

enum BackedEnumShape: string
{
    use BackedEnum;
    use HasAttributes;
    ...
```

### attributes()

Get all attributes for an enum instance or all class instances.

```php
$attributes = BackedEnumShape::attributes('RoundCircle');
```

```php
// Result:
[
    'simpleValue' => 'circle',
    'description' => 'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
    'id' => 1,
    'label' => 'Round Circle',
    'metadata' => [
        'color' => 'red',
        'sides' => 0,
        'type' => 'curved'
    ]
]
```

Filter attributes for the enum instance.

```php
$attributes = BackedEnumShape::attributes('RoundCircle', ['id', 'label']);

// Result:
[
    'id' => 1,
    'label' => 'Round Circle'
]
```

Get all attributes for each instance in the class.

```php
$attributes = BackedEnumShape::attributes();
```

```php
// Result:
[
    'RoundCircle' => [
        'simpleValue' => 'circle',
        'description' => 'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
        'id' => 1,
        'label' => 'Round Circle',
        'metadata' => [,
            'color' => 'red',
            'sides' => 0,
            'type' => 'curved'
        ]
    ],
    'BoxSquare' => [
        'simpleValue' => 'square',
        'description' => 'A square is a regular quadrilateral',
        'id' => 2,
        'label' => 'Perfect Square',
        'metadata' => [
            'color' => 'blue',
            'sides' => 4,
            'type' => 'polygon',
            'regular' => true
        ]
    ],
    'RightTriangle' => [
        'simpleValue' => 'triangle',
        'description' => 'A triangle is a polygon with three edges and three vertices',
        'id' => 3,
        'label' => 'Right-Triangle',
        'metadata' => [,
            'color' => 'green',
            'sides' => 3,
            'type' => 'polygon'
        ]
    ],
    ...
]
```

Filter all attributes for each instance in the class by key(s).

```php
$attributes = BackedEnumShape::attributes(['description', 'label']);
```

```php
// Result:
[
    'RoundCircle' => [
        'description' => 'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
        'label' => 'Round Circle'
    ],
    'BoxSquare' => [
        'description' => 'A square is a regular quadrilateral',
        'label' => 'Perfect Square'
    ],
    'RightTriangle' => [
        'description' => 'A triangle is a polygon with three edges and three vertices',
        'label' => 'Right-Triangle'
    ],
    ...
]
```

### description()

Get the description(s) for an enum instance or class.

```php
$description = BackedEnumShape::description('RoundCircle');
```

```php
// Result:
'A square is a regular quadrilateral, all sides have equal length and all angles are 90 degrees'
```

### descriptions()

Get descriptions for all enum cases.

```php
$descriptions = BackedEnumShape::descriptions();
```

```php
// Result:
[
    'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
    'A square is a regular quadrilateral, all sides have equal length and all angles are 90 degrees',
    'A triangle is a polygon with three edges and three vertices',
    'A star is a self-intersecting, equilateral polygon',
    'A rectangle is a quadrilateral with four right angles'
]
```

Use the `keyBy` argument to get an associative array using the case name or simple value as the keys/indices.

```php
$descriptions = BackedEnumShape::descriptions('name');

// Result:
[
    'RoundCircle' => 'A circle is a perfectly round geometric figure, every point on the circle is equidistant from the center',
    'BoxSquare' => 'A square is a regular quadrilateral',
    ...
]

```

### id()

Get the ID attribute for an enum instance.

```php
$id = BackedEnumShape::id('PointedStar');
```

```php
// Result:
4
```

### ids()

Get IDs for all enum cases.

```php
$ids = BackedEnumShape::ids();
```

```php
// Result:
[1, 2, 3, 4, 5]
```

Use the `keyBy` argument to get an associative array using the case name or simple value as the keys/indices.

```php
$ids = BackedEnumShape::ids('value');
```

```php
// Result:
['circle' => 1, 'square' => 2, 'triangle' => 3, 'star' => 4, 'rectangle' => 5]
```

### label()

Get the label for an enum instance.

```php
$label = BackedEnumShape::PolygonRectangle->label();
```

```php
// Result:
'Poly-Rectangle'
```

### labels()

Get labels for all enum cases.

```php
$labels = BackedEnumShape::labels();
```

```php
// Result:
['Round Circle', 'Perfect Square', 'Right-Triangle', '5 Point Star', 'Poly-Rectangle']
```

### metadata()

Retrieve the metadata attribute or specific metadata values by key(s).

```php
$allMetadata = BackedEnumShape::metadata('BoxSquare');
```

```php
// Result:
[
    'color' => 'blue',
    'sides' => 4,
    'type' => 'polygon',
    'regular' => true
]
```

Get specific metadata value.

```php
$specific = BackedEnumShape::metadata('BoxSquare', 'color');
```

```php
// Result:
'blue'
```

Filter metadata by specific keys.

```php
$filteredMetadata = BackedEnumShape::metadata('BoxSquare', ['color', 'type']);
```

```php
// Result:
[
    'color' => 'blue',
    'type' => 'polygon'
]

```

### metadatum()

Retrieve the metadata attribute for all cases, optionally filtered by key.

```php
$allMetadatum = BackedEnumShape::metadatum();
```

```php
// Result:
[
    ['color' => 'red', 'sides' => 0, 'type' => 'curved'],
    ['color' => 'blue', 'sides' => 4, 'type' => 'polygon', 'regular' => true],
    ['color' => 'green', 'sides' => 3, 'type' => 'polygon'],
    ['color' => 'yellow', 'points' => 5, 'type' => 'star', 'symmetrical' => true],
    ['color' => 'purple', 'sides' => 4, 'type' => 'polygon', 'regular' => false]
]
```

Get specific metadatum values only for the class.

```php
$specific = BackedEnumShape::metadatum('color');
```

```php
// Result:
['red', 'blue', 'green', 'yellow', 'purple']
```

Use the `keyBy` argument to get an associative array using the case name or simple value as the keys/indices.

```php
$keyBy = BackedEnumShape::metadatum('color', 'value');
```

```php
// Result:
[
    'circle' => 'red',
    'square' => 'blue',
    'triangle' => 'green',
    'star' => 'yellow',
    'rectangle' => 'purple'
]
```

Filter metadatum by specific keys.

```php
$filteredMetadatum = BackedEnumShape::metadatum(['color', 'sides']);

// Result:
[
    ['color' => 'red', 'sides' => 0],
    ['color' => 'blue', 'sides' => 4],
    ['color' => 'green', 'sides' => 3],
    ['color' => 'yellow'],
    ['color' => 'purple', 'sides' => 4]
]
```

### meta()

Access metadata values using property-like syntax. This is the recommended way to access individual metadata values.

```php
// Access metadata values directly
$color = BackedEnumShape::RoundCircle->meta()->color; // 'red'
$sides = BackedEnumShape::RoundCircle->meta()->sides; // 0
$type = BackedEnumShape::RoundCircle->meta()->type; // 'curved'

// Safely access non-existent properties
$unknown = BackedEnumShape::RoundCircle->meta()->nonexistent; // null

// Access nested JSON string metadata
$regular = BackedEnumShape::BoxSquare->meta()->regular; // true
```

[top](#usage)

## String Helper Macros

The **Laravel Enum** package extends Laravel's `Str` facade with additional helper methods for working with enum case names.

### Str::splitConstantCase()

Split a constant case string into its constituent words. This is useful when working with enum case names that follow constant case naming conventions (a.k.a. Snake case).

```php
use Illuminate\Support\Str;

// Split a Snake case (ALL CAPS) string
$words = Str::splitConstantCase('CONSTANT_CASE'); // 'CONSTANT CASE'
// Split a Snake case (Title) string
$words = Str::splitConstantCase('Constant_Case'); // 'Constant Case'
// Split a Snake case (all lowercase) string
$words = Str::splitConstantCase('constant_case'); // 'constant case'
```

### Str::splitEnumCase()

Split an enum case name into its constituent words. This is useful when working with enum case names that follow enum case (a.k.a. Pascal case) naming conventions. Also, handles Camel case strings.

```php
use Illuminate\Support\Str;

// Split an Pascal case string
$words = Str::splitEnumCase('EnumCase'); // 'Enum Case'
// Split an Camel case string
$words = Str::splitEnumCase('enumCase'); // 'enum Case'
```

These string helper macros are particularly useful when you need to:

- Generate human-readable labels from enum case names
- Parse enum case names for display or processing
- Create consistent formatting across your application

[top](#usage)
