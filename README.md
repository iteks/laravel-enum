<p align="center"><img src="https://raw.githubusercontent.com/iteks/art/master/logo-packages/laravel-enum.svg" width="400" alt="Laravel ENUM"></p>

<p align="center">
<a href="https://packagist.org/packages/iteks/laravel-enum"><img src="https://img.shields.io/packagist/dt/iteks/laravel-enum" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/iteks/laravel-enum"><img src="https://img.shields.io/packagist/v/iteks/laravel-enum" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/iteks/laravel-enum"><img src="https://img.shields.io/packagist/l/iteks/laravel-enum" alt="License"></a>
</p>

The **Laravel Enum** package enriches Laravel's enum support, integrating advanced features like attribute handling, select array transformation, and facade access for streamlined enum operations. Designed for Laravel applications, it offers a suite of utilities for both backed enums and attribute-enhanced enums, including descriptive annotations, ID management, label generation, and metadata association. This package streamlines working with enums in Laravel by providing intuitive, fluent interfaces for common tasks, enhancing enum usability in forms, API responses, and more. Whether you're defining select options, querying enum attributes, or integrating enums tightly with Laravel features, **Laravel Enum** simplifies these processes, making enum management in Laravel applications both powerful and efficient. Offered by iteks, Developed by <a href="https://github.com/jeramyhing">jeramyhing</a>.

## Get Started

> **Requires [PHP 8.1+](https://php.net/releases/)**

Install **Laravel Enum** via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require iteks/laravel-enum
```

## Usage

- [EnumExample class](#enumexample-class)
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

The **Laravel Enum** methods are designed for [PHP 8 Backed Enumeration](https://www.php.net/manual/en/language.enumerations.backed.php) classes.

**Laravel Enum** helper and trait methods extend an existing backed enum class for more versatile enum handling. Additionally, **Laravel Enum** offers a fluent way to add and manage attributes on backed enum cases. This package comes with four available attributes to readily assign to your enum cases: **Description**, **Id**, **Label**, and **Metadata**. The ExampleEnum class below demonstrates how you can apply these attributes to you enums.

[top](#usage)

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

## Enum Helpers (BackedEnum)

### Enum::asSelectArray()

Get a backed enum class as an array to populate a select element. The array will consist of a `text` key column containing values of the case name in display format, and a `value` keys column containing values using the original simpler values.

[top](#usage)

```php
Enum::asSelectArray(ExampleEnum::class);
```

```sh
array:3 [▼ 
  0 => array:2 [▼
    "text" => "First Example"
    "value" => 1
  ]
  1 => array:2 [▼
    "text" => "Second Example"
    "value" => 2
  ]
  2 => array:2 [▼
    "text" => "Third Example"
    "value" => 3
  ]
]
```

### Enum::toLabel()

Create a label from the case name.

[top](#usage)

```php
Enum::toLabel(ExampleEnum::FirstExample);
```

```sh
"First Example"
```

### Enum::toLabels()

Create and compile an array of labels from the case names.

[top](#usage)

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

## Enum Helpers (HasAttributes)

### Enum::attributes()

Retrieve all of the attributes for all cases.

[top](#usage)

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

### Enum::description()

Retrieve the description attribute.

[top](#usage)

```php
Enum::description(ExampleEnum::FirstExample);
```

```sh
"Lorem ipsum dolor sit amet, consectetur adipiscing elit."
```

### Enum::descriptions()

Retrieve the description attribute for all cases.

[top](#usage)

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

### Enum::id()

Retrieve the id attribute.

[top](#usage)

```php
Enum::id(ExampleEnum::FirstExample);
```

```sh
0
```

### Enum::ids()

Retrieve the id attribute for all cases.

[top](#usage)

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

### Enum::label()

Retrieve the label attribute.

[top](#usage)

```php
Enum::label(ExampleEnum::FirstExample);
```

```sh
"First-Example"
```

### Enum::labels()

Retrieve the label attribute for all cases.

[top](#usage)

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

### Enum::metadata()

Retrieve the metadata attribute.

[top](#usage)

```php
Enum::metadata(ExampleEnum::FirstExample);
```

```sh
array:1 [▼
  "key" => "value"
]
```

### Enum::metadatum()

Retrieve the metadata attribute for all cases.

[top](#usage)

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

## Enum Traits (BackedEnum)

### asSelectArray()

Get a backed enum class as an array to populate a select element. The array will consist of a `text` key column containing values of the case name in display format, and a `value` keys column containing values using the original simpler values.

[top](#usage)

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

### fromName()

Maps a scalar to an enum instance.

[top](#usage)

```php
ExampleEnum::fromName('FirstExample');
```

```sh
App\Enums\ExampleEnum {#297 ▼
  +name: "FirstExample"
  +value: 1
}
```

### name()

Retrieve the case name for the given simpler value.

[top](#usage)

```php
ExampleEnum::name(1);
```

```sh
"FirstExample"
```

### names()

Retrieve an array containing all of the case names.

[top](#usage)

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

### toLabel()

Create a label from the case name.

[top](#usage)

```php
ExampleEnum::toLabel(1);
```

```sh
"First Example"
```

### toLabels()

Create and compile an array of labels from the case names.

[top](#usage)

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

### tryFromName()

Maps a scalar to an enum instance or null.

[top](#usage)

```php
ExampleEnum::tryFromName('FirstExample');
```

```sh
App\Enums\ExampleEnum {#297 ▼
  +name: "FirstExample"
  +value: 1
}
```

### value()

Retrieve the simpler value for the given case name.

[top](#usage)

```php
ExampleEnum::value('FirstExample');
```

```sh
1
```

### values()

Retrieve an array containing all of the simpler values.

[top](#usage)

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

## Enum Traits (HasAttributes)

### attributes()

Retrieve all of the attributes for all cases.

[top](#usage)

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

### description()

Retrieve the description attribute.

[top](#usage)

```php
ExampleEnum::description('FirstExample');
```

```sh
"Lorem ipsum dolor sit amet, consectetur adipiscing elit."
```

### descriptions()

Retrieve the description attribute for all cases.

[top](#usage)

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

### id()

Retrieve the id attribute.

[top](#usage)

```php
ExampleEnum::id('FirstExample');
```

```sh
0
```

### ids()

Retrieve the id attribute for all cases.

[top](#usage)

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

### label()

Retrieve the label attribute.

[top](#usage)

```php
ExampleEnum::label('FirstExample');
```

```sh
"First-Example"
```

### labels()

Retrieve the label attribute for all cases.

[top](#usage)

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

### metadata()

Retrieve the metadata attribute.

[top](#usage)

```php
ExampleEnum::metadata('FirstExample');
```

```sh
array:1 [▼
  "key" => "value"
]
```

### metadatum()

Retrieve the metadata attribute for all cases.

[top](#usage)

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

## String Helper Macros

### Str::splitConstantCase()

Splits a "CONSTANT_CASE" string into words separated by whitespace.

[top](#usage)

```php
Str::splitConstantCase('FIRST_EXAMPLE');
```

```sh
"FIRST EXAMPLE"
```

### Str::splitEnumCase()

Splits a "EnumCase" string into words separated by whitespace.

[top](#usage)

```php
Str::splitEnumCase('FirstExample');
```

```sh
"First Example"
```
