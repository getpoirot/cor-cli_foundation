<?php
namespace Module\CliFoundation\Events\MatchRequest;

use Module\CliFoundation\Interfaces\iCommand;
use Module\CliFoundation\Router\ConsoleRouter;
use Poirot\Application\aSapi;
use Poirot\Application\Exception\ErrorRouteNotMatch;
use Poirot\Events\Listener\aListener;
use Module\CliFoundation\Interfaces\iConsoleRequest;


class MatchReqCommandListener
    extends aListener
{
    /**
     * @param aSapi $sapi
     * @return array
     */
    function __invoke($sapi = null, $command = null)
    {
        if ($command !== null)
            // Nothing to Do!! Command Recognized.
            return;


        $services = $sapi->services();

        /** @var iConsoleRequest $consoleRequest */
        $consoleRequest = $services->get('ConsoleRequest');
        /** @var ConsoleRouter $consoleRouter */
        $consoleRouter  = $services->get('ConsoleRouter');

        /** @var iCommand $command */
        if (false === $command = $consoleRouter->match($consoleRequest))
            throw new ErrorRouteNotMatch(sprintf(
                'Command (%s) not match.'
                , $consoleRequest->getCommand()
            ));


        return [
            'command' => $command,
        ];
    }
}
