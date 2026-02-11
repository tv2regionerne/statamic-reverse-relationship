<?php

namespace Tv2regionerne\StatamicReverseRelationship;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp' => __DIR__ . '/../routes/cp.php',
    ];

    protected $fieldtypes = [
        Fieldtypes\ReverseRelationship::class,
    ];

    protected $vite = [
        'input' => [
            'resources/js/addon.js',
        ],
    ];
}
