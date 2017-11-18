<?php
namespace Module\CliFoundation\Services;

use Module\CliFoundation\Console\ConsoleRequest;
use Module\CliFoundation\Interfaces\iConsoleRequest;
use Poirot\Ioc\Container\Service\aServiceContainer;


class ServiceConsoleRequest
    extends aServiceContainer
{
    /** @var string Service Name */
    protected $name = 'ConsoleRequest';


    /**
     * Create Service
     *
     * @return iConsoleRequest
     */
    function newService()
    {
        if (! isset($_SERVER['argv']) ) {
            $errorDescription = (ini_get('register_argc_argv') == false)
                ? "Cannot create Console\\Request because PHP ini option 'register_argc_argv' is set Off"
                : 'Cannot create Console\\Request because $_SERVER["argv"] is not set for unknown reason.';

            throw new \RuntimeException($errorDescription);
        }

        $args = $_SERVER['argv'];


        // Extract first param assuming it is the script name
        $scriptName = null;
        if (count($args) > 0)
            $scriptName = array_shift($args);


        // Next Offset in args considered as Command
        $command = null;
        if (count($args) > 0)
            $command = array_shift($args);


        $consoleRequest = new ConsoleRequest([
            'script_name' => $scriptName,
            'command'     => $command,
            'args'        => $args,
        ]);

        return $consoleRequest;
    }
}
