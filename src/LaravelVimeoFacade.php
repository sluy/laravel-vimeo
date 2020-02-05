<?php

namespace Vientodigital\LaravelVimeo;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Vientodigital\LaravelVimeo\Skeleton\SkeletonClass
 */
class LaravelVimeoFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-vimeo';
    }
}
