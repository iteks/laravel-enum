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

- [ExampleBackedEnum class](#examplebackedenum-class)
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
    - [Enum::metadata()](#enummetadata)
    - [Enum::metadatum()](#enummetadatum)
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
    - [metadata()](#metadata)
    - [metadatum()](#metadatum)
- [String Helper Macros](#string-helper-macros)
    - [Str::splitConstantCase()](#strsplitconstantcase)
    - [Str::splitEnumCase()](#strsplitenumcase)


## ExampleBackedEnum class

The **Laravel Enum** methods are designed for <a href="https://www.php.net/manual/en/language.enumerations.backed.php" target="_blank">PHP 8 Backed Enumeration</a> classes.

**Laravel Enum** helper and trait methods extend an existing backed enum class for more versatile enum handling. Additionally, **Laravel Enum** offers a fluent way to add and manage <a href="https://www.php.net/manual/en/language.attributes.overview.php" target="_blank">PHP 8 Attributes</a> on backed enum cases. This package comes with four available attributes to readily assign to your enum cases: `Description`, `Id`, `Label`, and `Metadata`. The ExampleBackedEnum class below demonstrates how you can apply these attributes to you enums. You may pick and choose which attributes you wish to take advantage of.

```php
use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use Iteks\Traits\BackedEnum;
use Iteks\Traits\HasAttributes;

enum ExampleBackedEnum: int
{
    use BackedEnum;
    use HasAttributes;

    #[Description('Active status indicating the resource is currently in use')]
    #[Id(101)]
    #[Label('Active')]
    #[Metadata(['status_type' => 'positive', 'display_color' => 'green'])]
    case CurrentlyActive = 1;

    #[Description('Pending status indicating the resource is awaiting processing or approval')]
    #[Id(102)]
    #[Label('Pending')]
    #[Metadata('{"status_type": "neutral", "display_color": "yellow"}')]
    case PendingReview = 2;

    #[Description('Temporarily suspended status indicating the resource is on hold')]
    #[Id(103)]
    #[Label('Suspended (!)')]
    #[Metadata([])]
    case TemporarilySuspended = 3;
}
```

[top](#usage)

## Attributes

The package provides four attributes to enhance your enum classes and cases:

### Description Attribute
Provides descriptive text for enum classes and cases.

```php
#[Description('A collection of status codes')] // Class-level description
enum Status: int
{
    #[Description('Operation completed successfully')] // Case-level description
    case Success = 200;
}
```

### Id Attribute
Provides unique identifiers for enum cases.

```php
enum Status: int
{
    #[Id(1)]
    case Draft = 0;
}
```

### Label Attribute
Provides human-readable labels for enum cases.

```php
enum Status: int
{
    #[Label('In Progress')]
    case Processing = 1;
}
```

### Metadata Attribute
Provides additional metadata for enum classes and cases. Supports multiple metadata attributes and can be used on both the enum class and its cases.

```php
#[Metadata(['version' => '1.0'])] // Class-level metadata
enum Status: int
{
    #[Metadata(['severity' => 'error'])] // Case-level metadata
    case Error = 500;
}
```

### Attribute Capabilities Summary
- **Description**: Class + Cases
- **Id**: Cases Only
- **Label**: Cases Only
- **Metadata**: Class + Cases

[top](#usage)

## Enum Helpers (BackedEnum)

First, import the helper class:

```php
use Iteks\Support\Facades\Enum;
```

_Note: This group of helpers **does NOT require any trait to be applied** to the target enum class. You may immediately use the the following methods:_

### Enum::asSelectArray()

Get a backed enum class as an array to populate a select element. The array will consist of a `text` key column containing values of the case name in display format, and a `value` keys column containing values using the original simpler values.

_Note: This method will first check for **Label** and **Id** attributes applied to the target enum class. If they are present, the method will prioritize those values. If not present, the method will return a mutated Headline value from the case name._

```php
$selectArray = Enum::asSelectArray(ExampleBackedEnum::class);
```

```sh
# Result:
array:3 [▼
  0 => array:2 [▼
    "text" => "Active"
    "value" => 101
  ]
  1 => array:2 [▼
    "text" => "Pending"
    "value" => 102
  ]
  2 => array:2 [▼
    "text" => "Suspended (!)"
    "value" => 103
  ]
]
```

### Enum::toLabel()

Create a label from the case name.

```php
$label = Enum::toLabel(ExampleBackedEnum::CurrentlyActive); // 'Currently Active'
```

### Enum::toLabels()

Create and compile an array of labels from the case names.

```php
$labels = Enum::toLabels(ExampleBackedEnum::class);
```

```sh
# Result:
array:3 [▼
  0 => "Currently Active"
  1 => "Pending Review"
  2 => "Temporarily Suspended"
]
```

[top](#usage)

## Enum Helpers (HasAttributes)

First, ensure that the target enum class has the `HasAttributes` trait applied, as shown in the [ExampleBackedEnum class](#examplebackedenum-class) above.

Then, import the helper class:

```php
use Iteks\Support\Facades\Enum;
```

You may then use the following methods:

### Enum::attributes()

Accessing attributes.

Retrieve all attributes for a given case.

```php
$attributes = Enum::attributes(ExampleBackedEnum::CurrentlyActive);
```

```sh
# Result:
array:5 [▼
  "simpleValue" => 1
  "description" => "Active status indicating the resource is currently in use"
  "id" => 101
  "label" => "Active"
  "metadata" => array:2 [▼
    "status_type" => "positive"
    "display_color" => "green"
  ]
]
```

Retrieve a subset of the attributes for a given case.

```php
$attributes = Enum::attributes(ExampleBackedEnum::CurrentlyActive, ['id', 'label']);
```

```sh
# Result:
array:2 [▼
  "id" => 101
  "label" => "Active"
]
```

Retrieve all attributes for all cases.

```php
$attributes = $Enum::attributes(ExampleBackedEnum::class);
```

```sh
# Result:
array:3 [▼
  "CurrentlyActive" => array:5 [▼
    "simpleValue" => 1
    "description" => "Active status indicating the resource is currently in use"
    "id" => 101
    "label" => "Active"
    "metadata" => array:2 [▶]
  ]
  "PendingReview" => array:5 [▼
    "simpleValue" => 2
    "description" => "Pending status indicating the resource is awaiting processing or approval"
    "id" => 102
    "label" => "Pending"
    "metadata" => "{"status_type": "neutral", "display_color": "yellow"}"
  ]
  "TemporarilySuspended" => array:5 [▼
    "simpleValue" => 3
    "description" => "Temporarily suspended status indicating the resource is on hold"
    "id" => 103
    "label" => "Suspended (!)"
    "metadata" => []
  ]
]
```

Retrieve a subset of the attributes for all cases.

```php
$attributes = $Enum::attributes(ExampleBackedEnum::class, ['description', 'metadata']);
```

```sh
# Result:
array:3 [▼
  "CurrentlyActive" => array:2 [▼
    "description" => "Active status indicating the resource is currently in use"
    "metadata" => array:2 [▶]
  ]
  "PendingReview" => array:2 [▼
    "description" => "Pending status indicating the resource is awaiting processing or approval"
    "metadata" => "{"status_type": "neutral", "display_color": "yellow"}"
  ]
  "TemporarilySuspended" => array:2 [▼
    "description" => "Temporarily suspended status indicating the resource is on hold"
    "metadata" => []
  ]
]
```

### Enum::description()

Retrieve the description attribute.

```php
$description = Enum::description(ExampleBackedEnum::CurrentlyActive);
```

```sh
# Result:
"Active status indicating the resource is currently in use"
```

### Enum::descriptions()

Retrieve the description attribute for all cases.

```php
$descriptions = Enum::descriptions(ExampleBackedEnum::class);
```

```sh
# Result:
array:3 [▼
  0 => "Active status indicating the resource is currently in use"
  1 => "Pending status indicating the resource is awaiting processing or approval"
  2 => "Temporarily suspended status indicating the resource is on hold"
]
```

### Enum::id()

Retrieve the id attribute.

```php
$id = Enum::id(ExampleBackedEnum::CurrentlyActive); //101
```

### Enum::ids()

Retrieve the id attribute for all cases.

```php
$ids = Enum::ids(ExampleBackedEnum::class);
```

```sh
# Result:
array:3 [▼
  0 => 101
  1 => 102
  2 => 103
]
```

### Enum::label()

Retrieve the label attribute.

```php
$label = Enum::label(ExampleBackedEnum::TemporarilySuspended); // 'Suspended (!)'
```

### Enum::labels()

Retrieve the label attribute for all cases.

```php
$labels = Enum::labels(ExampleBackedEnum::class);
```

```sh
# Result:
array:3 [▼
  0 => "Active"
  1 => "Pending"
  2 => "Suspended (!)"
]
```

### Enum::metadata()

Retrieve the metadata attribute.

```php
$metadata = Enum::metadata(ExampleBackedEnum::CurrentlyActive);
```

```sh
# Result:
array:2 [▼
  "status_type" => "positive"
  "display_color" => "green"
]
```

### Enum::metadatum()

Retrieve the metadata attribute for all cases.

```php
$metadatum = Enum::metadatum(ExampleBackedEnum::class);
```

```sh
# Result:
array:3 [▼
  0 => array:2 [▼
    "status_type" => "positive"
    "display_color" => "green"
  ]
  1 => "{"status_type": "neutral", "display_color": "yellow"}"
  2 => []
]
```

[top](#usage)

## Enum Traits (BackedEnum)

First, ensure that the target enum class has the `BackedEnum` trait applied, as shown in the [ExampleBackedEnum class](#examplebackedenum-class) above.

Then, you may then use the following methods:

### asSelectArray()

Get a backed enum class as an array to populate a select element. The array will consist of a `text` key column containing values of the case name in display format, and a `value` keys column containing values using the original simpler values.

_Note: This method will first check for `Label` and `Id` attributes applied to the target enum class. If they are present, the method will prioritize those values. If not present, the method will return a mutated Headline value from the case name._

```php
$selectArray = ExampleBackedEnum::asSelectArray();
```

```sh
# Result:
array:3 [▼
  0 => array:2 [▼
    "text" => "Active"
    "value" => 101
  ]
  1 => array:2 [▼
    "text" => "Pending"
    "value" => 102
  ]
  2 => array:2 [▼
    "text" => "Suspended (!)"
    "value" => 103
  ]
]
```

### fromName()

Maps a scalar to an enum instance.

```php
$enum = ExampleBackedEnum::fromName('CurrentlyActive');
```

```sh
# Result:
App\Enums\ExampleBackedEnum { ▼
  +name: "CurrentlyActive"
  +value: 1
}
```

### name()

Retrieve the case name for the given simpler value.

```php
$caseName = ExampleBackedEnum::name(1); // 'CurrentlyActive'
```

### names()

Retrieve an array containing all of the case names.

```php
$caseNames = ExampleBackedEnum::names();
```

```sh
# Result:
array:3 [▼
  0 => "CurrentlyActive"
  1 => "PendingReview"
  2 => "TemporarilySuspended"
]
```

### toLabel()

Create a label from the case name.

```php
$label = ExampleBackedEnum::toLabel(1); // 'Currently Active'
```

### toLabels()

Create and compile an array of labels from the case names.

```php
$labels = ExampleBackedEnum::toLabels();
```

```sh
# Result:
array:3 [▼
  0 => "Currently Active"
  1 => "Pending Review"
  2 => "Temporarily Suspended"
]
```

### tryFromName()

Maps a scalar to an enum instance or null.

```php
$enum = ExampleBackedEnum::tryFromName('CurrentlyActive');
```

```sh
# Result:
App\Enums\ExampleBackedEnum { ▼
  +name: "CurrentlyActive"
  +value: 1
}
```

### value()

Retrieve the simpler value for the given case name.

```php
$simplerValue = ExampleBackedEnum::value('CurrentlyActive'); // 1
```

### values()

Retrieve an array containing all of the simpler values.

```php
$simplerValues = ExampleBackedEnum::values();
```

```sh
# Result:
array:3 [▼
  0 => 1
  1 => 2
  2 => 3
]
```

[top](#usage)

## Enum Traits (HasAttributes)

First, ensure that the target enum class has the `HasAttributes` trait applied, as shown in the [ExampleBackedEnum class](#examplebackedenum-class) above.

Then, you may then use the following methods:

### attributes()

Retrieve the attributes for a given case.

```php
$attributes = ExampleBackedEnum::attributes('CurrentlyActive');
```

```sh
# Result:
array:5 [▼
  "simpleValue" => 1
  "description" => "Active status indicating the resource is currently in use"
  "id" => 101
  "label" => "Active"
  "metadata" => array:2 [▼
    "status_type" => "positive"
    "display_color" => "green"
  ]
]
```

Retrieve a subset of the attributes for a given case.

```php
$attributes = ExampleBackedEnum::attributes('CurrentlyActive', ['id', 'label']);
```

```sh
# Result:
array:2 [▼
  "id" => 101
  "label" => "Active"
]
```

Retrieve the attributes for all cases.

```php
$attributes = ExampleBackedEnum::attributes();
```

```sh
# Result:
array:3 [▼
  "CurrentlyActive" => array:5 [▼
    "simpleValue" => 1
    "description" => "Active status indicating the resource is currently in use"
    "id" => 101
    "label" => "Active"
    "metadata" => array:2 [▼
      "status_type" => "positive"
      "display_color" => "green"
    ]
  ]
  "PendingReview" => array:5 [▼
    "simpleValue" => 2
    "description" => "Pending status indicating the resource is awaiting processing or approval"
    "id" => 102
    "label" => "Pending"
    "metadata" => "{"status_type": "neutral", "display_color": "yellow"}"
  ]
  "TemporarilySuspended" => array:5 [▼
    "simpleValue" => 3
    "description" => "Temporarily suspended status indicating the resource is on hold"
    "id" => 103
    "label" => "Suspended (!)"
    "metadata" => []
  ]
]
```

Retrieve a subset of the attributes for all cases/

```php
$attributes = ExampleBackedEnum::attributes(null, ['description', 'metadata']);
```

```sh
# Result:
array:3 [▼
  "CurrentlyActive" => array:2 [▼
    "description" => "Active status indicating the resource is currently in use"
    "metadata" => array:2 [▼
      "status_type" => "positive"
      "display_color" => "green"
    ]
  ]
  "PendingReview" => array:2 [▼
    "description" => "Pending status indicating the resource is awaiting processing or approval"
    "metadata" => "{"status_type": "neutral", "display_color": "yellow"}"
  ]
  "TemporarilySuspended" => array:2 [▼
    "description" => "Temporarily suspended status indicating the resource is on hold"
    "metadata" => []
  ]
]
```

### description()

Retrieve the description attribute.

```php
$description = ExampleBackedEnum::description('CurrentlyActive');
```

```sh
# Result:
"Active status indicating the resource is currently in use"
```

### descriptions()

Retrieve the description attribute for all cases.

```php
$descriptions = ExampleBackedEnum::descriptions();
```

```sh
# Result:
array:3 [▼
  0 => "Active status indicating the resource is currently in use"
  1 => "Pending status indicating the resource is awaiting processing or approval"
  2 => "Temporarily suspended status indicating the resource is on hold"
]
```

### id()

Retrieve the id attribute.

```php
$id = ExampleBackedEnum::id('CurrentlyActive'); // 101
```

### ids()

Retrieve the id attribute for all cases.

```php
$ids = ExampleBackedEnum::ids();
```

```sh
# Result:
array:3 [▼
  0 => 101
  1 => 102
  2 => 103
]
```

### label()

Retrieve the label attribute.

```php
$label = ExampleBackedEnum::label('CurrentlyActive'); // 'Active'
```

### labels()

Retrieve the label attribute for all cases.

```php
$labels = ExampleBackedEnum::labels();
```

```sh
# Result:
array:3 [▼
  0 => "Active"
  1 => "Pending"
  2 => "Suspended (!)"
]
```

### metadata()

Retrieve the metadata attribute.

```php
$metadata = ExampleBackedEnum::metadata('CurrentlyActive');
```

```sh
# Result:
array:2 [▼
  "status_type" => "positive"
  "display_color" => "green"
]
```

### metadatum()

Retrieve the metadata attribute for all cases.

```php
$metadatum = ExampleBackedEnum::metadatum();
```

```sh
# Result:
array:3 [▼
  0 => array:2 [▼
    "status_type" => "positive"
    "display_color" => "green"
  ]
  1 => "{"status_type": "neutral", "display_color": "yellow"}"
  2 => []
]
```

[top](#usage)

## String Helper Macros

These helperas are booted when installing the package and are immediately available for use.

### Str::splitConstantCase()

Splits a "CONSTANT_CASE" string into words separated by whitespace.

```php
$string = Str::splitConstantCase('CONSTANT_CASE'); // 'CONSTANT CASE'
```

### Str::splitEnumCase()

Splits a "EnumCase" string into words separated by whitespace.

```php
$string = Str::splitEnumCase('EnumCase'); // 'Enum Case'
```

[top](#usage)
