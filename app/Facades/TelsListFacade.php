<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;
// use App\Facades;
/**
 * @see \Illuminate\View\Factory
 */
class TelsListFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'TelsListHandler';
    }
}

?>