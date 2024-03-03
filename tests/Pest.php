<?php

uses()->beforeEach(function () {
    // Create a fresh copy of the application for each test.
    $app = \Illuminate\Foundation\Application::getInstance();

    // // Manually register the package's service provider.
    $app->register(\Iteks\Support\EnumServiceProvider::class);

    // Boot the application.
    $app->boot();
})->in('Facades');
