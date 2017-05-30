<?php

namespace Incraigulous\RequestHooks;

use Closure;

/**
 * Run request hooks if we're in a testing environment.
 *
 * This can be added to your global middleware, or extended for custom functionality.
 *
 * Runs
 * Class TestingMiddleware
 * @package Incraigulous\Http\Middleware
 */
class TestingMiddleware
{
    /**
     * Is this a test environment?
     * @return bool
     */
    public function isTestEnv()
    {
        return in_array(config('app.env'), config('requestHooks.testEnvironments'));
    }

    /**
     * Initialize the hooks
     */
    public function initHooks()
    {
        foreach(config('requestHooks.hooks') as $hooks) {
            $hooks = new $hooks(request());
            if ($hooks->shouldHandle()) {
                $hooks->handle();
            }
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isTestEnv()) {
            $this->initHooks();
        }

        return $next($request);
    }
}
