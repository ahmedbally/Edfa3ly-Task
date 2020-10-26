<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => 'Createcart',

    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value determines the "version" your application is currently running
    | in. You may want to follow the "Semantic Versioning" - Given a version
    | number MAJOR.MINOR.PATCH when an update happens: https://semver.org.
    |
    */

    'version' => app('git.version'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. This can be overridden using
    | the global command line "--env" option when calling commands.
    |
    */

    'env' => 'development',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [
        App\Providers\AppServiceProvider::class,
    ],
    'default_currency'=>'USD',
    'init_products'=>[
        [
            'name'=>'T-shirt',
            'price'=>'10.99'
        ],
        [
            'name'=>'Pants',
            'price'=>'14.99'
        ],
        [
            'name'=>'Jacket',
            'price'=>'19.99'
        ],
        [
            'name'=>'Shoes',
            'price'=>'24.99'
        ]
    ],
    'init_currencies'=>[
        [
            'currency'=>'USD',
            'symbol'=>'$',
            'position'=>'left',
            'value'=>1,
        ],
        [
            'currency'=>'EGP',
            'symbol'=>'e£',
            'position'=>'right',
            'value'=>15.74,
        ],
    ],
    'init_offers'=>[
        [
            'on'=>'Shoes',
            'value'=>10,
            'percentage'=>true,
            'rules'=>[]
        ],
        [
            'on'=>'Jacket',
            'value'=>50,
            'percentage'=>true,
            'rules'=>[
                'T-shirt'=>2,
            ]
        ],
    ],
    'tax'=>14,
];
