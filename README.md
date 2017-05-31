request-hooks
-------------

Modify Laravel application state for feature testing by using query parameters.

##How it works

**Create a hook**<br />
Here's an example hook class that logs in a user if the test_login query string is set. That means if your feature testing, anytime you call a url like yourapp.dev/dashboard?test_login=true, the user will be logged in before the request is handled.

```
<?php

namespace App\RequestHooks;

use Illuminate\Http\Request;
use App\User;
use Incraigulous\RequestHooks\Contracts\RequestHook;

class Login implements RequestHook
{
    /**
     * @var Request
     */
    private $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Should the hook fire?
     * @return bool
     */
    public function shouldHandle()
    {
        if (!$this->request->test_login) return false;
        if (auth()->check()) return false;
        return true;
    }

    /**
     * Do whatever action the hook does
     */
    public function handle()
    {
        $user = user::first();
        auth()->login($user);
    }
}
```

**Register your hook**<br />

in config/requestHooks.php:
```
return [
    /**
     * Which app.env environments should be considered testing environments by the request-hooks test middleware?
     */
    'testEnvironments' => ['development', 'testing', 'staging', 'local'],

    /**
     * Register your request hooks
     */
    'hooks' => [
        \App\RequestHooks\Login::class
    ]
];
```

Installation
------------
```
composer require incraigulous/request-hooks
```

Register the service provider:
```
'providers' => [
   ...,
   Incraigulous\RequestHooks\RequestHooksServiceProvider::class,
   ,,.,
]
```

Register the middleware as global moddleware in the http kernel:

```
$middleware => [
   ...,
   Incraigulous\RequestHooks\TestingMiddleware::class
   ,,.,
]
```

Alternatively, you could extend `Incraigulous\RequestHooks\TestingMiddleware` or write your own if you need custom functionality. 

Configuration
-------------
**testEnvironments:** An array of environment names (see the app.env configuration setting) that hooks should fire in.<br />
**hooks:** Register your hook classes. 

