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

- [EnumExample class](#enumexample-class)
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


## EnumExample class

The **Laravel Enum** methods are designed for <a href="https://www.php.net/manual/en/language.enumerations.backed.php" target="_blank">PHP 8 Backed Enumeration</a> classes.

**Laravel Enum** helper and trait methods extend an existing backed enum class for more versatile enum handling. Additionally, **Laravel Enum** offers a fluent way to add and manage <a href="https://www.php.net/manual/en/language.attributes.overview.php" target="_blank">PHP 8 Attributes</a> on backed enum cases. This package comes with four available attributes to readily assign to your enum cases: **Description**, **Id**, **Label**, and **Metadata**. The ExampleEnum class below demonstrates how you can apply these attributes to you enums. You may pick and choose which attributes you wish to take advantage of.

```php
use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use Iteks\Traits\BackedEnum;
use Iteks\Traits\HasAttributes;

enum ExampleEnum: int
{
    use BackedEnum;
    use HasAttributes;

    #[Description('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')]
    #[Id(0)]
    #[Label('First-Example')]
    #[Metadata(['key' => 'value'])]
    case FirstExample = 1;

    #[Description('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')]
    #[Id(1)]
    #[Label('SecondExample (Example)')]
    #[Metadata('{"key": "value"}')]
    case SecondExample = 2;

    #[Description('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.')]
    #[Id(2)]
    #[Label('3rd Eg.')]
    #[Metadata([])]
    case ThirdExample = 3;
}
```

[top](#usage)

## Attributes

The package provides four attributes to enhance your enum classes and cases:

### Description Attribute
Provides descriptive text for enum classes and cases. Supports multiple descriptions and can be used on both the enum class and its cases.

```php
#[Description('A collection of status codes')] // Class-level description
enum Status: int
{
    #[Description('Operation completed successfully')] // Case-level description
    #[Description('HTTP 200 OK equivalent')] // Multiple descriptions supported
    case Success = 200;
}
```

### Id Attribute
Provides unique identifiers for enum cases. While technically supported on classes, it is recommended to use this attribute only on enum cases.

```php
enum Status: int
{
    #[Id(1)] // Recommended: Use on enum cases only
    case Draft = 0;
}
```

### Label Attribute
Provides human-readable labels for enum cases. While technically supported on classes, it is recommended to use this attribute only on enum cases.

```php
enum Status: int
{
    #[Label('In Progress')] // Recommended: Use on enum cases only
    case Processing = 1;
}
```

### Metadata Attribute
Provides additional metadata for enum classes and cases. Supports multiple metadata attributes and can be used on both the enum class and its cases.

```php
#[Metadata(['version' => '1.0'])] // Class-level metadata
#[Metadata(['category' => 'status'])] // Multiple metadata supported
enum Status: int
{
    #[Metadata(['severity' => 'error'])] // Case-level metadata
    #[Metadata(['deprecated' => true])] // Multiple metadata supported
    case Error = 500;
}
```

### Attribute Capabilities Summary
- **Description**: Class + Cases, Multiple Allowed
- **Id**: Cases Only (recommended), Multiple Not Recommended
- **Label**: Cases Only (recommended), Multiple Not Recommended
- **Metadata**: Class + Cases, Multiple Allowed

> **Note**: While Id and Label attributes technically support class-level usage, this is deprecated and will be removed in v2.0.0. Please use these attributes only on enum cases.

[top](#usage)

## Enum Helpers (BackedEnum)

First, import the helper class:

```php
use Iteks\Support\Facades\Enum;
```

_Note: This group of helpers **does NOT require any trait to be applied** to the target enum class. You may immediately use the the following methods:_

[top](#usage)

### Enum::asSelectArray()

Get a backed enum class as an array to populate a select element. The array will consist of a `text` key column containing values of the case name in display format, and a `value` keys column containing values using the original simpler values.

_Note: This method will first check for **Label** and **Id** attributes applied to the target enum class. If they are present, the method will prioritize those values. If not present, the method will return a mutated Headline value from the case name._

```php
Enum::asSelectArray(ExampleEnum::class);
```

```sh
array:3 [▼ 
  0 => array:2 [▼
    "text" => "First-Example"
    "value" => 1
  ]
  1 => array:2 [▼
    "text" => "SecondExample (Example)"
    "value" => 2
  ]
  2 => array:2 [▼
    "text" => "3rd Eg."
    "value" => 3
  ]
]
```

[top](#usage)

### Enum::toLabel()

Create a label from the case name.

```php
Enum::toLabel(ExampleEnum::FirstExample);
```

```sh
"First Example"
```

[top](#usage)

### Enum::toLabels()

Create and compile an array of labels from the case names.

```php
Enum::toLabels(ExampleEnum::class);
```

```sh
array:3 [▼
  0 => "First Example"
  1 => "Second Example"
  2 => "Third Example"
]
```

[top](#usage)

## Enum Helpers (HasAttributes)

First, ensure that the target enum class has the `HasAttributes` trait applied, as shown in the [ExampleEnum class](#enumexample-class) above.

Then, import the helper class:

```php
use Iteks\Support\Facades\Enum;
```

You may then use the following methods:

[top](#usage)

### Enum::attributes()

Retrieve all of the attributes for all cases.

```php
Enum::attributes(ExampleEnum::FirstExample);
```

```sh
array:5 [▼
  "simpleValue" => 1
  "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
  "id" => 0
  "label" => "First-Example"
  "metadata" => array:1 [▼
    "key" => "value"
  ]
]
```

```php
Enum::attributes(ExampleEnum::FirstExample, ['id', 'label']);
```

```sh
array:2 [▼
  "id" => 0
  "label" => "First-Example"
]
```

```php
Enum::attributes(ExampleEnum::class);
```

```sh
array:3 [▼
  "FirstExample" => array:5 [▼
    "simpleValue" => 1
    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
    "id" => 0
    "label" => "First-Example"
    "metadata" => array:1 [▼
      "key" => "value"
    ]
  ]
  "SecondExample" => array:5 [▼
    "simpleValue" => 2
    "description" => "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
    "id" => 1
    "label" => "SecondExample (Example)"
    "metadata" => "{"key": "value"}"
  ]
  "ThirdExample" => array:5 [▼
    "simpleValue" => 3
    "description" => "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
    "id" => 2
    "label" => "3rd Eg."
    "metadata" => []
  ]
]
```

```php
Enum::attributes(ExampleEnum::class, ['description', 'metadata']);
```

```sh
array:3 [▼
  "FirstExample" => array:2 [▼
    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
    "metadata" => array:1 [▼
      "key" => "value"
    ]
  ]
  "SecondExample" => array:2 [▼
    "description" => "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
    "metadata" => "{"key": "value"}"
  ]
  "ThirdExample" => array:2 [▼
    "description" => "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
    "metadata" => []
  ]
]
```

[top](#usage)

### Enum::description()

Retrieve the description attribute.

```php
Enum::description(ExampleEnum::FirstExample);
```

```sh
"Lorem ipsum dolor sit amet, consectetur adipiscing elit."
```

[top](#usage)

### Enum::descriptions()

Retrieve the description attribute for all cases.

```php
Enum::descriptions(ExampleEnum::class);
```

```sh
array:3 [▼
  0 => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
  1 => "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
  2 => "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
]
```

[top](#usage)

### Enum::id()

Retrieve the id attribute.

```php
Enum::id(ExampleEnum::FirstExample);
```

```sh
0
```

[top](#usage)

### Enum::ids()

Retrieve the id attribute for all cases.

```php
Enum::ids(ExampleEnum::class);
```

```sh
array:3 [▼
  0 => 0
  1 => 1
  2 => 2
]
```

[top](#usage)

### Enum::label()

Retrieve the label attribute.

```php
Enum::label(ExampleEnum::FirstExample);
```

```sh
"First-Example"
```

[top](#usage)

### Enum::labels()

Retrieve the label attribute for all cases.

```php
Enum::labels(ExampleEnum::class);
```

```sh
array:3 [▼
  0 => "First-Example"
  1 => "SecondExample (Example)"
  2 => "3rd Eg."
]
```

[top](#usage)

### Enum::metadata()

Retrieve the metadata attribute.

```php
Enum::metadata(ExampleEnum::FirstExample);
```

```sh
array:1 [▼
  "key" => "value"
]
```

[top](#usage)

### Enum::metadatum()

Retrieve the metadata attribute for all cases.

```php
Enum::metadatum(ExampleEnum::class);
```

```sh
array:3 [▼
  0 => array:1 [▼
    "key" => "value"
  ]
  1 => "{"key": "value"}"
  2 => []
]
```

[top](#usage)

## Enum Traits (BackedEnum)

First, ensure that the target enum class has the `BackedEnum` trait applied, as shown in the [ExampleEnum class](#enumexample-class) above.

Then, you may then use the following methods:

[top](#usage)

### asSelectArray()

Get a backed enum class as an array to populate a select element. The array will consist of a `text` key column containing values of the case name in display format, and a `value` keys column containing values using the original simpler values.

_Note: This method will first check for **Label** and **Id** attributes applied to the target enum class. If they are present, the method will prioritize those values. If not present, the method will return a mutated Headline value from the case name._

```php
ExampleEnum::asSelectArray();
```

```sh
array:3 [▼
  0 => array:2 [▼
    "text" => "First-Example"
    "value" => 0
  ]
  1 => array:2 [▼
    "text" => "SecondExample (Example)"
    "value" => 1
  ]
  2 => array:2 [▼
    "text" => "3rd Eg."
    "value" => 2
  ]
]
```

[top](#usage)

### fromName()

Maps a scalar to an enum instance.

```php
ExampleEnum::fromName('FirstExample');
```

```sh
App\Enums\ExampleEnum {#297 ▼
  +name: "FirstExample"
  +value: 1
}
```

[top](#usage)

### name()

Retrieve the case name for the given simpler value.

```php
ExampleEnum::name(1);
```

```sh
"FirstExample"
```

[top](#usage)

### names()

Retrieve an array containing all of the case names.

```php
ExampleEnum::names();
```

```sh
array:3 [▼
  0 => "FirstExample"
  1 => "SecondExample"
  2 => "ThirdExample"
]
```

[top](#usage)

### toLabel()

Create a label from the case name.

```php
ExampleEnum::toLabel(1);
```

```sh
"First Example"
```

[top](#usage)

### toLabels()

Create and compile an array of labels from the case names.

```php
ExampleEnum::toLabels();
```

```sh
array:3 [▼
  0 => "First Example"
  1 => "Second Example"
  2 => "Third Example"
]
```

[top](#usage)

### tryFromName()

Maps a scalar to an enum instance or null.

```php
ExampleEnum::tryFromName('FirstExample');
```

```sh
App\Enums\ExampleEnum {#297 ▼
  +name: "FirstExample"
  +value: 1
}
```

[top](#usage)

### value()

Retrieve the simpler value for the given case name.

```php
ExampleEnum::value('FirstExample');
```

```sh
1
```

[top](#usage)

### values()

Retrieve an array containing all of the simpler values.

```php
ExampleEnum::values();
```

```sh
array:3 [▼
  0 => 1
  1 => 2
  2 => 3
]
```

[top](#usage)

## Enum Traits (HasAttributes)

First, ensure that the target enum class has the `HasAttributes` trait applied, as shown in the [ExampleEnum class](#enumexample-class) above.

Then, you may then use the following methods:

[top](#usage)

### attributes()

Retrieve all of the attributes for all cases.

```php
ExampleEnum::attributes('FirstExample');
```

```sh
array:5 [▼
  "simpleValue" => 1
  "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
  "id" => 0
  "label" => "First-Example"
  "metadata" => array:1 [▼
    "key" => "value"
  ]
]
```

```php
ExampleEnum::attributes('FirstExample', ['id', 'label']);
```

```sh
array:2 [▼
  "id" => 0
  "label" => "First-Example"
]
```

```php
ExampleEnum::attributes();
```

```sh
array:3 [▼
  "FirstExample" => array:5 [▼
    "simpleValue" => 1
    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
    "id" => 0
    "label" => "First-Example"
    "metadata" => array:1 [▼
      "key" => "value"
    ]
  ]
  "SecondExample" => array:5 [▼
    "simpleValue" => 2
    "description" => "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
    "id" => 1
    "label" => "SecondExample (Example)"
    "metadata" => "{"key": "value"}"
  ]
  "ThirdExample" => array:5 [▼
    "simpleValue" => 3
    "description" => "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
    "id" => 2
    "label" => "3rd Eg."
    "metadata" => []
  ]
]
```

```php
ExampleEnum::attributes(null, ['description', 'metadata']);
```

```sh
array:3 [▼
  "FirstExample" => array:2 [▼
    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
    "metadata" => array:1 [▼
      "key" => "value"
    ]
  ]
  "SecondExample" => array:2 [▼
    "description" => "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
    "metadata" => "{"key": "value"}"
  ]
  "ThirdExample" => array:2 [▼
    "description" => "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
    "metadata" => []
  ]
]
```

[top](#usage)

### description()

Retrieve the description attribute.

```php
ExampleEnum::description('FirstExample');
```

```sh
"Lorem ipsum dolor sit amet, consectetur adipiscing elit."
```

[top](#usage)

### descriptions()

Retrieve the description attribute for all cases.

```php
ExampleEnum::descriptions();
```

```sh
array:3 [▼
  0 => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
  1 => "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
  2 => "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
]
```

[top](#usage)

### id()

Retrieve the id attribute.

```php
ExampleEnum::id('FirstExample');
```

```sh
0
```

[top](#usage)

### ids()

Retrieve the id attribute for all cases.

```php
ExampleEnum::ids();
```

```sh
array:3 [▼
  0 => 0
  1 => 1
  2 => 2
]
```

[top](#usage)

### label()

Retrieve the label attribute.

```php
ExampleEnum::label('FirstExample');
```

```sh
"First-Example"
```

[top](#usage)

### labels()

Retrieve the label attribute for all cases.

```php
ExampleEnum::labels();
```

```sh
array:3 [▼
  0 => "First-Example"
  1 => "SecondExample (Example)"
  2 => "3rd Eg."
]
```

[top](#usage)

### metadata()

Retrieve the metadata attribute.

```php
ExampleEnum::metadata('FirstExample');
```

```sh
array:1 [▼
  "key" => "value"
]
```

[top](#usage)

### metadatum()

Retrieve the metadata attribute for all cases.

```php
ExampleEnum::metadatum();
```

```sh
array:3 [▼
  0 => array:1 [▼
    "key" => "value"
  ]
  1 => "{"key": "value"}"
  2 => []
]
```

[top](#usage)

## String Helper Macros

These helperas are booted when installing the package and are immediately available for use.

[top](#usage)

### Str::splitConstantCase()

Splits a "CONSTANT_CASE" string into words separated by whitespace.

```php
Str::splitConstantCase('FIRST_EXAMPLE');
```

```sh
"FIRST EXAMPLE"
```

[top](#usage)

### Str::splitEnumCase()

Splits a "EnumCase" string into words separated by whitespace.

```php
Str::splitEnumCase('FirstExample');
```

```sh
"First Example"
```

[top](#usage)
