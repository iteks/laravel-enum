<?php

namespace Tests\Unit\Attributes;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use ReflectionClass;

#[Description('A collection of test statuses')] // Class-level description
#[Description('Used for testing attribute capabilities')] // Multiple descriptions
#[Metadata(['version' => '1.0'])] // Class-level metadata
#[Metadata(['category' => 'test'])] // Multiple metadata
enum TestEnum: int
{
    #[Description('Operation completed successfully')]
    #[Description('HTTP 200 OK equivalent')]
    #[Id(1)]
    #[Label('Success')]
    #[Metadata(['severity' => 'success'])]
    #[Metadata(['httpCode' => 200])]
    case Success = 200;

    #[Description('Operation failed')]
    #[Id(2)]
    #[Label('Error')]
    #[Metadata(['severity' => 'error'])]
    case Error = 500;
}

describe('Attribute Capabilities', function () {
    it('supports class-level and multiple descriptions', function () {
        $reflector = new ReflectionClass(TestEnum::class);
        $attributes = $reflector->getAttributes(Description::class);

        expect($attributes)->toHaveCount(2)
            ->and($attributes[0]->newInstance()->description)->toBe('A collection of test statuses')
            ->and($attributes[1]->newInstance()->description)->toBe('Used for testing attribute capabilities');
    });

    it('supports case-level and multiple descriptions', function () {
        $reflector = new ReflectionClass(TestEnum::class);
        $constant = $reflector->getReflectionConstant('Success');
        $attributes = $constant->getAttributes(Description::class);

        expect($attributes)->toHaveCount(2)
            ->and($attributes[0]->newInstance()->description)->toBe('Operation completed successfully')
            ->and($attributes[1]->newInstance()->description)->toBe('HTTP 200 OK equivalent');
    });

    it('supports only case-level id', function () {
        $reflector = new ReflectionClass(TestEnum::class);

        // Class should not have Id attribute.
        expect($reflector->getAttributes(Id::class))->toHaveCount(0);

        // Case should have Id attribute.
        $constant = $reflector->getReflectionConstant('Success');
        $attributes = $constant->getAttributes(Id::class);
        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->id)->toBe(1);
    });

    it('supports only case-level label', function () {
        $reflector = new ReflectionClass(TestEnum::class);

        // Class should not have Label attribute.
        expect($reflector->getAttributes(Label::class))->toHaveCount(0);

        // Case should have Label attribute.
        $constant = $reflector->getReflectionConstant('Success');
        $attributes = $constant->getAttributes(Label::class);
        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->label)->toBe('Success');
    });

    it('supports class-level and multiple metadata', function () {
        $reflector = new ReflectionClass(TestEnum::class);
        $attributes = $reflector->getAttributes(Metadata::class);

        expect($attributes)->toHaveCount(2)
            ->and($attributes[0]->newInstance()->metadata)->toBe(['version' => '1.0'])
            ->and($attributes[1]->newInstance()->metadata)->toBe(['category' => 'test']);
    });

    it('supports case-level and multiple metadata', function () {
        $reflector = new ReflectionClass(TestEnum::class);
        $constant = $reflector->getReflectionConstant('Success');
        $attributes = $constant->getAttributes(Metadata::class);

        expect($attributes)->toHaveCount(2)
            ->and($attributes[0]->newInstance()->metadata)->toBe(['severity' => 'success'])
            ->and($attributes[1]->newInstance()->metadata)->toBe(['httpCode' => 200]);
    });
});
