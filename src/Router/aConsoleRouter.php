<?php
namespace Module\CliFoundation\Router;

use Module\CliFoundation\Interfaces\iCommand;
use Module\CliFoundation\Interfaces\iConsoleRequest;
use Poirot\Std\ConfigurableSetter;


abstract class aConsoleRouter
    extends ConfigurableSetter
{
    /**
     * Match with Request
     *
     * - on match extract request params and merge
     *   into default params
     *
     * !! don`t change request object attributes
     *
     * @param iConsoleRequest $request
     *
     * @return iCommand|false
     */
    abstract function match(iConsoleRequest $request);
}
