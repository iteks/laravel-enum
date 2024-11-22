<?php

namespace Tests\Unit\Attributes;

use Iteks\Attributes\Description;
use Iteks\Attributes\Id;
use Iteks\Attributes\Label;
use Iteks\Attributes\Metadata;
use ReflectionClass;

#[Description('A collection of test statuses')] // Class-level description
#[Metadata(['version' => '1.0', 'category' => 'test'])] // Class-level metadata
enum TestEnum: int
{
    #[Description('Operation completed successfully')]
    #[Id(1)]
    #[Label('Success')]
    #[Metadata(['severity' => 'success', 'httpCode' => 200])]
    case Success = 200;

    #[Description('Operation failed')]
    #[Id(2)]
    #[Label('Error')]
    #[Metadata(['severity' => 'error'])]
    case Error = 500;
}

describe('Attribute Capabilities', function () {
    it('supports class-level description', function () {
        $reflector = new ReflectionClass(TestEnum::class);
        $attributes = $reflector->getAttributes(Description::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->description)->toBe('A collection of test statuses');
    });

    it('supports case-level description', function () {
        $reflector = new ReflectionClass(TestEnum::class);
        $constant = $reflector->getReflectionConstant('Success');
        $attributes = $constant->getAttributes(Description::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->description)->toBe('Operation completed successfully');
    });

    it('supports only case-level id', function () {
        $reflector = new ReflectionClass(TestEnum::class);

        // Class should not have Id attribute
        expect($reflector->getAttributes(Id::class))->toHaveCount(0);

        // Case should have Id attribute
        $constant = $reflector->getReflectionConstant('Success');
        $attributes = $constant->getAttributes(Id::class);
        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->id)->toBe(1);
    });

    it('supports only case-level label', function () {
        $reflector = new ReflectionClass(TestEnum::class);

        // Class should not have Label attribute
        expect($reflector->getAttributes(Label::class))->toHaveCount(0);

        // Case should have Label attribute
        $constant = $reflector->getReflectionConstant('Success');
        $attributes = $constant->getAttributes(Label::class);
        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->label)->toBe('Success');
    });

    it('supports class-level metadata', function () {
        $reflector = new ReflectionClass(TestEnum::class);
        $attributes = $reflector->getAttributes(Metadata::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->metadata)->toBe(['version' => '1.0', 'category' => 'test']);
    });

    it('supports case-level metadata', function () {
        $reflector = new ReflectionClass(TestEnum::class);
        $constant = $reflector->getReflectionConstant('Success');
        $attributes = $constant->getAttributes(Metadata::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->newInstance()->metadata)->toBe(['severity' => 'success', 'httpCode' => 200]);
    });
});
