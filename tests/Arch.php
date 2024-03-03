<?php

describe('Arch', function () {
    test('facades')
        ->expect('Iteks\Support\Facades\Enum')
        ->toOnlyUse([
            'Illuminate\Support\Facades\Facade',
            'Iteks\Support\Services\EnumService',
        ]);

    test('service providers')
        ->expect('Iteks\Support\EnumServiceProvider')
        ->toOnlyUse([
            'Illuminate\Support\ServiceProvider',
            'Illuminate\Support\Str',
            'Iteks\Support\Facades\Enum',
            'Iteks\Support\Macros\Str',
            'Iteks\Support\Services\BackedEnumService',
            'Iteks\Support\Services\EnumService',
            'Iteks\Support\Services\HasAttributesService',
        ]);
})->group('arch');
