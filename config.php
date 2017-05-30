<?php

return [
    /**
     * Which app.env environments should be considered testing environments by the request-hooks test middleware?
     */
    'testEnvironments' => ['development', 'testing', 'staging', 'local'],

    /**
     * Register your request hooks
     */
    'hooks' => [
        // /App\RequestHooks\Login::class,
        // /App\RequestHooks\Logout::class
    ]
];