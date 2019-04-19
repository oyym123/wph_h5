<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function register()
    {
        $this->app->resolving(EncryptCookies::class, function ($object) {
            // need check the ip in whitelist
            $object->disableFor('token');
        });
    }


}
