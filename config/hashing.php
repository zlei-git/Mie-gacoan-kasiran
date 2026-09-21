<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default hash driver that will be used to hash
    | passwords for your application. By default, the bcrypt algorithm is
    | used; however, you are free to change this to any option you like.
    |
    */

    'driver' => 'bcrypt',

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options for when passwords are
    | hashed using the Bcrypt algorithm. This will allow you to control
    | the amount of time it takes to hash a given password solve.
    |
    */

    'bcrypt' => [
        'rounds' => max(4, (int) (env('BCRYPT_ROUNDS') ?: 12)),
        'verify' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options for when passwords are
    | hashed using the Argon algorithm. These will allow you to control
    | the amount of time and memory it takes to hash a given password.
    |
    */

    'argon' => [
        'memory' => 65536,
        'threads' => 1,
        'time' => 4,
        'verify' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Rehash On Login
    |--------------------------------------------------------------------------
    |
    | Setting this option to true will allow Laravel to automatically rehash
    | passwords as users authenticate, ensuring their security stretches
    | with the latest options for work factor and hash algorithms.
    |
    */

    'rehash_on_login' => true,

];
